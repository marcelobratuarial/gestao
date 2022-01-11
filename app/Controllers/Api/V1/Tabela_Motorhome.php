<?php

namespace App\Controllers\Api\V1;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Tabela_Motorhome extends ResourceController
{

    use ResponseTrait;

    function __construct()
    {
        $this->api = \Config\Services::curlrequest([
            "baseURI" => 'https://fipe.brasilplataformas.com.br/api/',
            "headers" => [
                "chave" => "$2y$10$8IAZn7HKq7QJWbh37N3GOOeRVv.sM9tcTLBRYwRuf2g98olRyqieW"
            ]
        ]);

        $result = json_decode($this->api->post('ConsultarTabelaDeReferencia')->getBody(), true);
        $this->codigoTabelaReferencia = $result[0]['Codigo'];

        $this->tipos = ['Basculante', 'Baú', 'Bi-caçamba', 'Boiadeiro', 'Camara Frigorifica', 'Camper', 'Carga Seca', 'Carroceria', 'Caçamba', 'Dolly', 'Graneleira', 'Munck', 'Prancha', 'Tanque', 'Terceiro eixo', 'Quarto eixo', 'Tora'];

        $uri = new \CodeIgniter\HTTP\URI(current_url());
        $categoriaURL = $uri->getSegment(4);
        if (!empty($categoriaURL) && $categoriaURL != 'implementos' && $categoriaURL != 'carretas') :
            $model = new \App\Models\Motorhome\ProtecaoVeicular\CategoriaModel();
            $this->categoria = $model->select('*')->where('code', $categoriaURL)->first();
            if ($this->categoria->implemento) :
                $this->categoria->implemento = true;
            else :
                $this->categoria->implemento = false;
            endif;
            if ($this->categoria->carreta) :
                $this->categoria->carreta = true;
            else :
                $this->categoria->carreta = false;
            endif;
        endif;
    }

    public function categorias()
    {
        $model = new \App\Models\Motorhome\ProtecaoVeicular\CategoriaModel();
        $categorias = $model->select('code, apiRef, titulo, implemento, agravo')->findAll();
        return $this->respond($categorias);
    }

    public function implementos()
    {
        return $this->respond($this->tipos);
    }

    public function carretas()
    {
        return $this->respond($this->tipos);
    }

    public function marcas()
    {
        // die('marcas');
        $categoria = $this->categoria->apiRef;
        $data['codigoTabelaReferencia'] = $this->codigoTabelaReferencia;

        switch ($categoria):
            case 'motorhome':
                $carreta = false;
                break;
            case 'carreta':
                $carreta = true;
                break;
            case 'motos':
                $data['codigoTipoVeiculo'] = 2;
                $result = json_decode($this->api->post('ConsultarMarcas', ['json' => $data])->getBody(), true);
                foreach ($result as $key => $value) :
                    $return[$key]['nome'] = ucfirst(strtolower($value['Label']));
                    $return[$key]['codigo'] = $value['Value'];
                endforeach;
                $carreta = false;
                break;
            case 'caminhoes':
                $data['codigoTipoVeiculo'] = 3;
                $result = json_decode($this->api->post('ConsultarMarcas', ['json' => $data])->getBody(), true);
                foreach ($result as $key => $value) :
                    $return[$key]['nome'] = ucfirst(strtolower($value['Label']));
                    $return[$key]['codigo'] = $value['Value'];
                endforeach;
                $carreta = true;
                break;
            case 'carros':
                $data['codigoTipoVeiculo'] = 1;
                $result = json_decode($this->api->post('ConsultarMarcas', ['json' => $data])->getBody(), true);
                foreach ($result as $key => $value) :
                    $return[$key]['nome'] = ucfirst(strtolower($value['Label']));
                    $return[$key]['codigo'] = $value['Value'];
                endforeach;
                $carreta = false;
                break;
        endswitch;

        $dt['marcas'] = $return;
        $dt['implementos'] = $this->categoria->implemento;
        $dt['carretas'] = $carreta ? true : false;
        return $this->respond($dt, 200);
    }
    public function modelos(int $marca)
    {
        // die('modelos');
        $categoria = $this->categoria->apiRef;
        $data['codigoTabelaReferencia'] = $this->codigoTabelaReferencia;
        switch ($categoria):
            case 'motos':
                $data['codigoTipoVeiculo'] = 2;
                break;
            case 'caminhoes':
                $data['codigoTipoVeiculo'] = 3;
                break;
            case 'carros':
                $data['codigoTipoVeiculo'] = 1;
                break;
        endswitch;
        $data['codigoMarca'] = $marca;

        $result = json_decode($this->api->post('ConsultarModelos', ['json' => $data])->getBody(), true);
        return $this->respond($result, 200);
    }


    public function anosModelo(int $marca, int $modelo)
    {
        // die('anosModelo');
        $categoria = $this->categoria->apiRef;
        $data['codigoTabelaReferencia'] = $this->codigoTabelaReferencia;
        switch ($categoria):
            case 'motos':
                $data['codigoTipoVeiculo'] = 2;
                break;
            case 'caminhoes':
                $data['codigoTipoVeiculo'] = 3;
                break;
            case 'carros':
                $data['codigoTipoVeiculo'] = 1;
                break;
        endswitch;
        $data['codigoMarca'] = $marca;
        $data['codigoModelo'] = $modelo;

        $result = json_decode($this->api->post('ConsultarAnoModelo', ['json' => $data])->getBody(), true);
        foreach ($result as $k => $r) :
            if (isset($r['Value'])) :
                $c = explode('-', $r['Value']);
                switch (end($c)):
                    case 1:
                        $combustivel = 'Gasolina';
                        break;
                    case 2:
                        $combustivel = 'Alcool';
                        break;
                    case 3:
                        $combustivel = 'Diesel';
                        break;
                endswitch;
                $return[$k]['Ano'] = $r['Label'] == 32000 ? '0km' : $r['Label'];
                $return[$k]['Combustivel'] = $combustivel;
            else :
                return $this->respond(['success' => false, 'message' => 'não encontrado'], 404);
            endif;
        endforeach;
        return $this->respond($return, 200);
    }


    public function modeloPorAno(int $marca, string $ano, string $combustivel)
    {
        // die('modeloPorAno');
        $categoria = $this->categoria->apiRef;
        $ano = $ano == '0km' ? 32000 : $ano;
        $data['codigoTabelaReferencia'] = $this->codigoTabelaReferencia;
        switch ($categoria):
            case 'motos':
                $data['codigoTipoVeiculo'] = 2;
                break;
            case 'caminhoes':
                $data['codigoTipoVeiculo'] = 3;
                break;
            default:
                $data['codigoTipoVeiculo'] = 1;
                break;
        endswitch;
        switch ($combustivel):
            case 'alcool':
            case 'Alcool':
                $data['codigoTipoCombustivel'] = 2;
                $data['ano'] = $ano . '-' .  $data['codigoTipoCombustivel'];
                break;
            case 'diesel':
            case 'Diesel':
                $data['codigoTipoCombustivel'] = 3;
                $data['ano'] = $ano . '-' .  $data['codigoTipoCombustivel'];
                break;
            default:
                $data['codigoTipoCombustivel'] = 1;
                $data['ano'] = $ano . '-' .  $data['codigoTipoCombustivel'];
                break;
        endswitch;
        $data['codigoMarca'] = $marca;
        $data['anoModelo'] = $ano;

        $result = json_decode($this->api->post('ConsultarModelosAtravesDoAno', ['json' => $data])->getBody(), true);
        return $this->respond($result, 200);
    }

    public function completa(int $marca, int $modelo, string $ano, string $combustivel)
    {
        // {
        //     "Adesao" : 1000,
        //     "Cliente" : {
        //         "CodeLead" : "123456987",
        //         "Nome" : "Leonardo",
        //         "CPF" : "10851649696",
        //         "Email" : "leomaciel@msn.com",
        //         "Telefone" : "31996082166",
        //         "Cidade" : "Matozinhos",
        //         "UF" : "MG"
        //     },
        //     "Implemento": {
        //         "Tipo": "basculante",
        //         "Valor": "100000"
        //     },
        //     "Carreta": [
        //         {
        //             "Valor": 150000.00,
        //             "Tipo": "basculante"
        //         },
        //         {
        //             "Valor": 250000,
        //             "Tipo": "Prancha"
        //         }
        //     ],
        //     "Opcionais": [
        //         {
        //             "Slug": "cobertura-para-terceiros",
        //             "Opcao": 2
        //         },
        //         {
        //             "Slug": "protecao-para-para-brisa"
        //         }
        //     ]
        // }

        $mensalidadeTotal = 0;

        $categoria = $this->categoria->apiRef;
        $ano = $ano == '0km' ? 32000 : $ano;
        $data['codigoTabelaReferencia'] = $this->codigoTabelaReferencia;
        switch ($categoria):
            case 'motos':
                $data['codigoTipoVeiculo'] = 2;
                break;
            case 'caminhoes':
                $data['codigoTipoVeiculo'] = 3;
                break;
            default:
                $data['codigoTipoVeiculo'] = 1;
                break;
        endswitch;
        switch ($combustivel):
            case 'alcool':
                $data['codigoTipoCombustivel'] = 2;
                $data['ano'] = $ano . '-' .  $data['codigoTipoCombustivel'];
                break;
            case 'diesel':
                $data['codigoTipoCombustivel'] = 3;
                $data['ano'] = $ano . '-' .  $data['codigoTipoCombustivel'];
                break;
            default:
                $data['codigoTipoCombustivel'] = 1;
                $data['ano'] = $ano . '-' .  $data['codigoTipoCombustivel'];
                break;
        endswitch;
        $data['codigoMarca'] = $marca;
        $data['codigoModelo'] = $modelo;
        $data['anoModelo'] = $ano;

        helper('default');

        $return = json_decode($this->api->post('ConsultarValorComTodosParametros', ['json' => $data])->getBody(), true);

        $rawVeiculo = $this->request->getVar('Veiculo');

        $result['Veiculo']['Categoria'] = $this->categoria->code;
        $result['Veiculo']['Tipo'] = ucfirst(strtolower($categoria));
        $result['Veiculo']['Marca'] = $return['Marca'];
        $result['Veiculo']['Modelo'] = $return['Modelo'];
        $result['Veiculo']['AnoModelo'] = $return['AnoModelo'] == '32000' ? '0km' : $return['AnoModelo'];
        $result['Veiculo']['Combustivel'] = ucfirst(strtolower($combustivel));
        $result['Veiculo']['MesReferencia'] = trim($return['MesReferencia']);
        $result['Veiculo']['CodigoFipe'] = $return['CodigoFipe'];
        $result['Veiculo']['Valor'] = $return['Valor'];
        $result['Veiculo']['Valor'] = number_format(noMoney($return['Valor']), 2, '.', '');
        $result['Veiculo']['Placa'] = isset($rawVeiculo->Placa) ? $rawVeiculo->Placa : null;
        $result['Veiculo']['Chassi'] = isset($rawVeiculo->Chassi) ? $rawVeiculo->Chassi : null;
        $result['Veiculo']['Renavam'] = isset($rawVeiculo->Renavam) ? $rawVeiculo->Renavam : null;


        $rawImplemento = $this->request->getVar('Implemento');

        if ($this->categoria->implemento) :
            if ($rawImplemento) :
                $result['Veiculo']['Implemento'] = array();
                $result['Veiculo']['Implemento']['Valor'] = isset($rawImplemento->Valor) ? $rawImplemento->Valor : null;;
                $result['Veiculo']['Implemento']['Tipo'] = isset($rawImplemento->Tipo) ? $rawImplemento->Tipo : null;;
            endif;
        endif;

        if ($this->categoria->implemento && $rawImplemento) :
            $valor = $result['Veiculo']['Valor'] + $rawImplemento->Valor;
        else :
            $valor = $result['Veiculo']['Valor'];
        endif;
        $tabelaModel = new \App\Models\Motorhome\ProtecaoVeicular\TabelaModel();
        $tabela = $tabelaModel
            ->select('*')
            ->where('codeCategoria', $this->categoria->code)
            ->where('valor_de <=', $valor)
            ->where('valor_ate >=', $valor)
            ->first();
        $tabela->mensalidade = $tabela->mensalidade + $tabela->mensalidade * $this->categoria->agravo / 100;
        $tabela->mensalidade = number_format($tabela->mensalidade, 2, '.', '');
        $mensalidadeTotal = $mensalidadeTotal + $tabela->mensalidade;
        $result['Veiculo']['Mensalidade'] = $tabela->mensalidade;
        $result['Veiculo']['CotaParticipativa'] = $tabela->cota_participativa;
        $result['Veiculo']['CotaMinima'] = number_format($tabela->cota_min, 2, '.', '');

        $result['Veiculo']['Adesao'] = $this->request->getVar('Adesao');

        $rawCarreta = $this->request->getVar('Carreta');
        if ($this->categoria->carreta) :
            $result['Carreta'] = true;
            if ($rawCarreta) :
                $result['Carreta'] = array();
                foreach ($rawCarreta as $key => $rawCarreta) :
                    $result['Carreta'][$key]['Valor'] = isset($rawCarreta->Valor) ? $rawCarreta->Valor : null;
                    $result['Carreta'][$key]['Tipo'] = isset($rawCarreta->Tipo) ? strtolower($rawCarreta->Tipo) : null;
                    $result['Carreta'][$key]['Placa'] = isset($rawCarreta->Placa) ? $rawCarreta->Placa : null;
                    $result['Carreta'][$key]['Chassi'] = isset($rawCarreta->Chassi) ? $rawCarreta->Chassi : null;
                    $result['Carreta'][$key]['Renavam'] = isset($rawCarreta->Renavam) ? $rawCarreta->Renavam : null;
                    $categoriaModel = new \App\Models\Motorhome\ProtecaoVeicular\CategoriaModel();
                    $categoria = $categoriaModel->where('apiRef', 'carreta')->first();
                    $tabela_carreta = $tabelaModel
                        ->select('*')
                        ->where('codeCategoria', $categoria->code)
                        ->where('valor_de <=', $result['Carreta'][$key]['Valor'])
                        ->where('valor_ate >=', $result['Carreta'][$key]['Valor'])
                        ->first();
                    $result['Carreta'][$key]['Mensalidade'] = number_format($tabela_carreta->mensalidade, 2, '.', '');

                    $mensalidadeTotal = $mensalidadeTotal + $result['Carreta'][$key]['Mensalidade'];
                    if ($result['Carreta'][$key]['Tipo'] == 'basculante') :
                        $result['Carreta'][$key]['CotaParticipativa'] = 7;
                        $result['Carreta'][$key]['CotaMinima'] = number_format(7000, 2, '.', '');
                    else :
                        $result['Carreta'][$key]['CotaParticipativa'] = $tabela_carreta->cota_participativa;
                        $result['Carreta'][$key]['CotaMinima'] = number_format($tabela_carreta->cota_min, 2, '.', '');
                    endif;
                    $result['Carreta'][$key]['Tabela'] = $tabela_carreta;
                endforeach;
            endif;
        endif;
        unset($result['Combustivel']);


        $rawOpcionais = $this->request->getVar('Opcionais');
        if ($rawOpcionais) :
            $opcionaisModel = new \App\Models\Motorhome\ProtecaoVeicular\OpcionaisModel();
            $opcionaisModel
                // ->groupStart()
                ->where('codeCategoria', $this->categoria->code)
                ->orWhere('codeCategoria', null)
                ->orWhere('codeCategoria', '');
            // ->groupEnd();
            foreach ($rawOpcionais as $key => $opt) :
                $opcionaisModel->where('slug', $opt->Slug);
                //ADICIONAR CAMPO OBRIGATÓRIO
                $select[$opt->Slug] = isset($opt->Opcao) ? $opt->Opcao : null;
            endforeach;
            $opcionais = $opcionaisModel->findAll();


            // SE EXISTE UM POST COM AS OPCOES ESCOLHIDAS
            ## Só exibe as opções escolhidas (completas)

            $opcao = array();
            foreach ($opcionais as $key => $opt) :
                $result['Opcionais'][$key]['Titulo'] = $opt->titulo;
                $result['Opcionais'][$key]['Slug'] = $opt->slug;
                if ($opt->tipo == 'select') :
                    $opcao = json_decode($opt->options)[$select[$opt->slug]];
                    $result['Opcionais'][$key]['Descricao'] = trim($opt->descricao) . ' - ' . $opcao->titulo;
                    $result['Opcionais'][$key]['Valor'] = $opcao->valor;
                    $result['Opcionais'][$key]['CotaParticipativa'] = $opcao->cota;
                    $result['Opcionais'][$key]['CotaMinima'] = $opcao->cota_min;
                    $result['Opcionais'][$key]['Tipo'] = 'Select';
                else :
                    $result['Opcionais'][$key]['Descricao'] = trim($opt->descricao);
                    $result['Opcionais'][$key]['Valor'] = $opt->valor;
                    $result['Opcionais'][$key]['CotaParticipativa'] = $opt->cota;
                    $result['Opcionais'][$key]['CotaMinima'] = $opt->cota_min;
                    $result['Opcionais'][$key]['Tipo'] = 'Checkbox';
                endif;

                $mensalidadeTotal = $mensalidadeTotal + $result['Opcionais'][$key]['Valor'];
            endforeach;
            $opcionaisNovo = $result['Opcionais'];

        else :
            // SE NAO EXISTE O POST
            ## Exibe todas opções (completas)
            $opcionaisModel = new \App\Models\Motorhome\ProtecaoVeicular\OpcionaisModel();
            $opcionais = $opcionaisModel
                ->where('codeCategoria', $this->categoria->code)
                ->orWhere('codeCategoria', null)
                ->orWhere(
                    'codeCategoria',
                    ''
                )->findAll();
            foreach ($opcionais as $key => $opt) :
                $result['Opcionais'][$key]['Titulo'] = $opt->titulo;
                $result['Opcionais'][$key]['Slug'] = $opt->slug;
                $result['Opcionais'][$key]['Descricao'] = $opt->descricao;
                $result['Opcionais'][$key]['Tipo'] = $opt->tipo;
                if ($opt->tipo == 'select') :
                    $result['Opcionais'][$key]['Opcoes'] = json_decode($opt->options, true);
                else :
                    $result['Opcionais'][$key]['Valor'] = $opt->valor;
                    $result['Opcionais'][$key]['CotaParticipativa'] = $opt->cota;
                    $result['Opcionais'][$key]['CotaMinima'] = $opt->cota_min;
                endif;
                $result['Opcionais'][$key]['Obrigatorio'] = $opt->obrigatorio == null ? false : true;
            endforeach;
            $opcionaisNovo = [];
        endif;
        $rawCliente = $this->request->getVar('Cliente');
        //Não precisar dos campos somente do codeLead
        $code = isset($rawCliente->CodeLead) ? $rawCliente->CodeLead : null;
        if ($code == null) :
            return $this->respond([
                'success' => false,
                'message' => 'Código do lead nulo.'
            ], 404);
        endif;

        $leadsModel = new \App\Models\LeadModel();
        $lead = $leadsModel->find($code);
        if (!isset($lead->code)) :
            return $this->respond([
                'success' => false,
                'message' => 'Código do lead inválido.'
            ], 404);
        endif;
        $lead->camposExtras = is_string($lead->camposExtras) ? json_decode($lead->camposExtras) : null;

        $propostaModel = new \App\Models\PropostaModel();
        $proposta = $propostaModel->like('code', $code)->orderBy('created_at', 'DESC')->first();

        helper('text');
        $code = isset($proposta->code) ? increment_string($proposta->code) : $code;

        if (isset($result['Veiculo']['Implemento'])) :
            $implemento_nome = $result['Veiculo']['Implemento']['Tipo'];
            $implemento_valor = money($result['Veiculo']['Implemento']['Valor'], true);
        else :
            $implemento_nome = null;
            $implemento_valor = null;
        endif;

        if (isset($result['Carreta']) && is_array($result['Carreta'])) :
            foreach ($result['Carreta'] as $k => $crta) :
                $carretas[$k] = (array) $crta['Tabela'];
                // "id": "5030",
                // "codeCategoria": "B2113JR907D255",
                // "valor_de": "49001.00",
                // "valor_ate": "50000.00",
                // "mensalidade": "217.3",
                // "cota_participativa": "4",
                // "cota_min": "4000",
                // "valor": "R$ 50.000,00",
                // "tipo": "Quarto eixo",
                // "placa": "hes5951"

                $carretas[$k]['mensalidade'] = number_format($carretas[$k]['mensalidade'] + $carretas[$k]['mensalidade'] * $this->categoria->agravo / 100, 2);
                $carretas[$k]['valor'] = money($crta['Valor'], true);
                $carretas[$k]['tipo'] = $crta['Tipo'];
                $carretas[$k]['placa'] = $crta['Placa'];
            endforeach;
        else :
            $carretas = null;
        endif;
        $valorTotal = isset($result['Veiculo']['Implemento']) ? $result['Veiculo']['Valor'] + $result['Veiculo']['Implemento']['Valor'] : $result['Veiculo']['Valor'];

        $return = [
            'code' => $code,
            'codeProduto' => $this->request->getVar('CodeProduto') ? $this->request->getVar('CodeProduto') : $lead->codeProduto,
            'valorTotal' => floatval(number_format($valorTotal, 2, '.', '')),
            'tabela' => $tabela,
            'nome' => isset($rawCliente->Nome) ? $rawCliente->Nome : $lead->nome,
            'userIf' => isset($rawCliente->CPF) ? $rawCliente->CPF : (isset($lead->camposExtras->cpf) ? $lead->camposExtras->cpf : null),
            'email' => isset($rawCliente->Email) ? $rawCliente->Email : $lead->email,
            'telefone' => isset($rawCliente->Telefone) ? $rawCliente->Telefone : $lead->telefone,
            'cidade' => isset($rawCliente->Cidade) ? $rawCliente->Cidade : (isset($lead->camposExtras->cidade) ? $lead->camposExtras->cidade : null),
            'uf' => isset($rawCliente->UF) ? $rawCliente->UF : (isset($lead->camposExtras->uf) ? $lead->camposExtras->uf : null),
            'placa' => $result['Veiculo']['Placa'],
            'veiculo_fipe' => [
                'Valor' => $return['Valor'],
                'Marca' => $return['Marca'],
                'Modelo' => $return['Modelo'],
                'AnoModelo' => $return['AnoModelo'],
                'Combustivel' => $return['Combustivel'],
                'CodigoFipe' => $return['CodigoFipe'],
                'MesReferencia' => $return['MesReferencia'],
                'TipoVeiculo' => $return['TipoVeiculo'],
                'SiglaCombustivel' => $return['SiglaCombustivel'],
            ],
            'codeCategoria' => $result['Veiculo']['Categoria'],
            'categoria' => $this->categoria,
            'veiculo_tipo' => $this->categoria->apiRef,
            'veiculo_marca' => $result['Veiculo']['Marca'],
            'veiculo_modelo' => $result['Veiculo']['Modelo'],
            'veiculo_ano' => $result['Veiculo']['AnoModelo'],
            'veiculo_combustivel' => $result['Veiculo']['Combustivel'],
            'veiculo_valor' => floatval(number_format($result['Veiculo']['Valor'], 2, '.', '')),
            'fipe' => $result['Veiculo']['CodigoFipe'],

            'implemento_nome' => $implemento_nome,
            'implemento_valor' => $implemento_valor,


            'carreta' => $carretas,


            'adesao' => $result['Veiculo']['Adesao'],
            'opcionais' => [],

            'mensalidadeTotal' => $mensalidadeTotal,
            'opcionaisNovo' => $opcionaisNovo,
        ];
        unset($return['categoria']->implemento);
        unset($return['categoria']->carreta);

        foreach ($result['Opcionais'] as $opt) :
            if ($opt['Tipo'] == 'Checkbox') :
                $return['opcionais'][$opt['Slug']] = $opt['Valor'];
            elseif ($opt['Tipo'] == 'Select') :
                $return['opcionais'][$opt['Slug']] = [
                    'titulo' => explode(' - ', $opt['Descricao'])[1],
                    'valor' => $opt['Valor'],
                    'cota' => $opt['CotaParticipativa'],
                    'cota_min' => $opt['CotaMinima'],
                ];
            endif;
        endforeach;


        return $this->respond($return, 200);
    }
    //NOVA
    public function nova(int $marca, int $modelo, string $ano, string $combustivel)
    {
        // api/publico/tabela-motorhome/codeCategoria/codeMarca/codeModelo/ano/combustivel
        // die('completa');
        $categoria = $this->categoria->apiRef;
        $ano = $ano == '0km' ? 32000 : $ano;
        $data['codigoTabelaReferencia'] = $this->codigoTabelaReferencia;
        switch ($categoria):
            case 'motos':
                $data['codigoTipoVeiculo'] = 2;
                break;
            case 'caminhoes':
                $data['codigoTipoVeiculo'] = 3;
                break;
            default:
                $data['codigoTipoVeiculo'] = 1;
                break;
        endswitch;
        switch ($combustivel):
            case 'alcool':
                $data['codigoTipoCombustivel'] = 2;
                $data['ano'] = $ano . '-' .  $data['codigoTipoCombustivel'];
                break;
            case 'diesel':
                $data['codigoTipoCombustivel'] = 3;
                $data['ano'] = $ano . '-' .  $data['codigoTipoCombustivel'];
                break;
            default:
                $data['codigoTipoCombustivel'] = 1;
                $data['ano'] = $ano . '-' .  $data['codigoTipoCombustivel'];
                break;
        endswitch;
        $data['codigoMarca'] = $marca;
        $data['codigoModelo'] = $modelo;
        $data['anoModelo'] = $ano;

        helper('default');

        $return = json_decode($this->api->post('ConsultarValorComTodosParametros', ['json' => $data])->getBody(), true);

        $rawVeiculo = $this->request->getVar('Veiculo');

        $result['Veiculo']['Categoria'] = $this->categoria->code;
        $result['Veiculo']['Tipo'] = ucfirst(strtolower($categoria));
        $result['Veiculo']['Marca'] = $return['Marca'];
        $result['Veiculo']['Modelo'] = $return['Modelo'];
        $result['Veiculo']['AnoModelo'] = $return['AnoModelo'] == '32000' ? '0km' : $return['AnoModelo'];
        $result['Veiculo']['Combustivel'] = ucfirst(strtolower($combustivel));
        $result['Veiculo']['MesReferencia'] = trim($return['MesReferencia']);
        $result['Veiculo']['CodigoFipe'] = $return['CodigoFipe'];
        $result['Veiculo']['Valor'] = $return['Valor'];
        $result['Veiculo']['Valor'] = number_format(noMoney($return['Valor']), 2, '.', '');
        $result['Veiculo']['Placa'] = isset($rawVeiculo->Placa) ? $rawVeiculo->Placa : null;
        $result['Veiculo']['Chassi'] = isset($rawVeiculo->Chassi) ? $rawVeiculo->Chassi : null;
        $result['Veiculo']['Renavam'] = isset($rawVeiculo->Renavam) ? $rawVeiculo->Renavam : null;


        $rawImplemento = $this->request->getVar('Implemento');

        if ($this->categoria->implemento) :
            if ($rawImplemento) :
                $result['Veiculo']['Implemento'] = array();
                $result['Veiculo']['Implemento']['Valor'] = isset($rawImplemento->Valor) ? $rawImplemento->Valor : null;;
                $result['Veiculo']['Implemento']['Tipo'] = isset($rawImplemento->Tipo) ? $rawImplemento->Tipo : null;;
            endif;
        endif;

        if ($this->categoria->implemento && $rawImplemento) :
            $valor = $result['Veiculo']['Valor'] + $rawImplemento->Valor;
        else :
            $valor = $result['Veiculo']['Valor'];
        endif;
        $tabelaModel = new \App\Models\Motorhome\ProtecaoVeicular\TabelaModel();
        $tabela = $tabelaModel
            ->select('*')
            ->where('codeCategoria', $this->categoria->code)
            ->where('valor_de <=', $valor)
            ->where('valor_ate >=', $valor)
            ->first();


        if (!isset($tabela->mensalidade)) :
            return $this->respond([
                'success' => false,
                'message' => 'Infelizmente ainda não oferecemos proteção pra este veículo.'
            ], 404);
        endif;

        $result['Veiculo']['Mensalidade'] = number_format($tabela->mensalidade, 2, '.', '');
        $result['Veiculo']['CotaParticipativa'] = $tabela->cota_participativa;
        $result['Veiculo']['CotaMinima'] = number_format($tabela->cota_min, 2, '.', '');




        $rawCarreta = $this->request->getVar('Carreta');
        if ($this->categoria->carreta) :
            $result['Carreta'] = true;
            if ($rawCarreta) :
                $result['Carreta'] = array();
                foreach ($rawCarreta as $key => $rawCarreta) :
                    $result['Carreta'][$key]['Valor'] = isset($rawCarreta->Valor) ? $rawCarreta->Valor : null;
                    $result['Carreta'][$key]['Tipo'] = isset($rawCarreta->Tipo) ? $rawCarreta->Tipo : null;
                    $result['Carreta'][$key]['Placa'] = isset($rawCarreta->Placa) ? $rawCarreta->Placa : null;
                    $result['Carreta'][$key]['Chassi'] = isset($rawCarreta->Chassi) ? $rawCarreta->Chassi : null;
                    $result['Carreta'][$key]['Renavam'] = isset($rawCarreta->Renavam) ? $rawCarreta->Renavam : null;
                    $categoriaModel = new \App\Models\Motorhome\ProtecaoVeicular\CategoriaModel();
                    $categoria = $categoriaModel->where('apiRef', 'carreta')->first();
                    $tabela = $tabelaModel
                        ->select('*')
                        ->where('codeCategoria', $categoria->code)
                        ->where('valor_de <=', $result['Carreta'][$key]['Valor'])
                        ->where('valor_ate >=', $result['Carreta'][$key]['Valor'])
                        ->first();
                    $result['Carreta'][$key]['Mensalidade'] = number_format($tabela->mensalidade, 2, '.', '');
                    if ($result['Carreta'][$key]['Tipo'] == 'basculante') :
                        $result['Carreta'][$key]['CotaParticipativa'] = 7;
                        $result['Carreta'][$key]['CotaMinima'] = number_format(7000, 2, '.', '');
                    else :
                        $result['Carreta'][$key]['CotaParticipativa'] = $tabela->cota_participativa;
                        $result['Carreta'][$key]['CotaMinima'] = number_format($tabela->cota_min, 2, '.', '');
                    endif;
                endforeach;
            endif;
        endif;
        unset($result['Combustivel']);


        $rawOpcionais = $this->request->getVar('Opcionais');
        if ($rawOpcionais) :
            $opcionaisModel = new \App\Models\Motorhome\ProtecaoVeicular\OpcionaisModel();
            $opcionaisModel
                // ->groupStart()
                ->where('codeCategoria', $this->categoria->code)
                ->orWhere('codeCategoria', null)
                ->orWhere('codeCategoria', '');
            // ->groupEnd();
            foreach ($rawOpcionais as $key => $opt) :
                $opcionaisModel->where('slug', $opt->Slug);
                //ADICIONAR CAMPO OBRIGATÓRIO
                $select[$opt->Slug] = isset($opt->Opcao) ? $opt->Opcao : null;
            endforeach;
            $opcionais = $opcionaisModel->findAll();


            // SE EXISTE UM POST COM AS OPCOES ESCOLHIDAS
            ## Só exibe as opções escolhidas (completas)

            $opcao = array();
            foreach ($opcionais as $key => $opt) :
                $result['Opcionais'][$key]['Titulo'] = $opt->titulo;
                if ($opt->tipo == 'select') :
                    $opcao = json_decode($opt->options)[$select[$opt->slug]];
                    $result['Opcionais'][$key]['Descricao'] = trim($opt->descricao) . ' - ' . $opcao->titulo;
                    $result['Opcionais'][$key]['Valor'] = $opcao->valor;
                    $result['Opcionais'][$key]['CotaParticipativa'] = $opcao->cota;
                    $result['Opcionais'][$key]['CotaMinima'] = $opcao->cota_min;
                else :
                    $result['Opcionais'][$key]['Descricao'] = trim($opt->descricao);
                    $result['Opcionais'][$key]['Valor'] = $opt->valor;
                    $result['Opcionais'][$key]['CotaParticipativa'] = $opt->cota;
                    $result['Opcionais'][$key]['CotaMinima'] = $opt->cota_min;
                endif;

            endforeach;

        else :
            // SE NAO EXISTE O POST
            ## Exibe todas opções (completas)
            $opcionaisModel = new \App\Models\Motorhome\ProtecaoVeicular\OpcionaisModel();
            $opcionais = $opcionaisModel
                ->where('codeCategoria', $this->categoria->code)
                ->orWhere('codeCategoria', null)
                ->orWhere(
                    'codeCategoria',
                    ''
                )->findAll();
            foreach ($opcionais as $key => $opt) :
                $result['Opcionais'][$key]['Titulo'] = $opt->titulo;
                $result['Opcionais'][$key]['Slug'] = $opt->slug;
                $result['Opcionais'][$key]['Descricao'] = $opt->descricao;
                $result['Opcionais'][$key]['Tipo'] = $opt->tipo;
                if ($opt->tipo == 'select') :
                    $result['Opcionais'][$key]['Opcoes'] = json_decode($opt->options, true);
                else :
                    $result['Opcionais'][$key]['Valor'] = $opt->valor;
                    $result['Opcionais'][$key]['CotaParticipativa'] = $opt->cota;
                    $result['Opcionais'][$key]['CotaMinima'] = $opt->cota_min;
                endif;
                $result['Opcionais'][$key]['Obrigatorio'] = $opt->obrigatorio == null ? false : true;
            endforeach;
        endif;


        return $this->respond($result, 200);
    }
    //FIM NOVA
}
