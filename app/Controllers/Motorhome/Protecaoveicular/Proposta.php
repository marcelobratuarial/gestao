<?php

namespace App\Controllers\Motorhome\Protecaoveicular;

use App\Controllers\Motorhome\BaseController;
use App\Models\LeadModel;
use App\Models\Motorhome\ProtecaoVeicular\CategoriaModel;
use App\Models\Motorhome\ProtecaoVeicular\OpcionaisModel;
use App\Models\PropostaModel;

class Proposta extends BaseController
{
	public function index()
	{
	}
	public function dados($codeLead = null)
	{

		$leadModel = new LeadModel();
		$lead = $leadModel->where('code', $codeLead)->first();
		if (!$lead) :
			setSwal('error', 'Ops!', 'Temos um problema, este lead não existe.');
			return redirect()->to(base_url('lead'));
		endif;

		$lead = myJsonDecode($lead, true);
		
		if (is_array($lead['camposExtras'])) :
			$lead = (object) array_merge($lead, $lead['camposExtras']);
		else :
			$lead = (object) $lead;
		endif;
		unset($lead->codeLead);
		// dd($lead);
		$data['lead'] = $lead;
		$data['tipo'] = null;
		$data['imp'] = null;

		$data['estados'] = getApi('estados', true);
		$data['code'] = $codeLead;
		$data['codeEmpresa'] = $_SESSION['usuarioEmpresa'];
		$data['codeUsuario'] = $_SESSION['usuarioCode'];
		$data['codeFilial'] = $_SESSION['usuarioFilial'];

		$categoriaModel = new CategoriaModel();
		$data['categorias'] = $categoriaModel->findAll();
		//$data['produto'] = getProduto($data['lead']->codeProduto);

		$data['tituloPagina'] = "Proposta";
		$data['subtituloPagina'] = "Gerar";
		$data['javaScriptSrc'] = ["custom/motorhome/js/fipeApi.js?r=" . code()];

		$data['path'] = $this->path;
		
		//Formulário padrão ou personalisado
		return template("custom/{$this->path}/proposta/form_data", $data);
	}
	public function opcionais($codeLead)
	{
		$post = $this->request->getPost();
		$post['cidade'] = esc($post['cidade']);

		if (!$post) :
			setSwal('error', 'Ops!', 'Temos um problema, faltam dados para gerar essa proposta.');
			return redirect()->to(base_url($this->path . '/proposta/dados/' . $codeLead));
		endif;

		if ($post['veiculo_tipo'] == 'carreta') :
			foreach ($post['tabela_carreta'] as $tc) :
				$dt['tabela_carreta'][] = json_decode($tc);
			endforeach;
			//$post['tabela_carreta'] = $dt['tabela_carreta'];
			unset($post['placa'], $post['veiculo_marca'], $post['veiculo_modelo'], $post['veiculo_ano'], $post['tabela']);
		endif;

		if (!$post['implemento_valor']) :
			unset($post['implemento_valor'], $post['implemento_nome']);
		endif;

		$post['userIf'] = base64_encode($post['userIf']);

		if (!isset($post['tabela']) && $post['veiculo_tipo'] != 'carreta') :
			$raw['tipo'] = $post['veiculo_tipo'];
			$raw['valor'] = $post['veiculo_valor'];
			$raw['implemento_valor'] = isset($post['implemento_valor']) ? $post['implemento_valor'] : null;

			$api = \Config\Services::curlrequest([
				'baseURI' => base_url($this->path) . '/api/',
				"headers" => [
					"Content-Type" => "application/json",
					"Accept" => "application/json",
					"Authorization" => "Bearer {$_SESSION['accessToken']}"
				]
			]);

			$tabela = json_decode($api->setBody(json_encode($raw))->post('tabela')->getBody());
			//dd($tabela);

			//$post['tabela'] = json_decode($post['tabela']);
			$post['tabela'] = $tabela;
		else :
			if ($post['veiculo_tipo'] != 'carreta') :
				$post['tabela'] = json_decode($post['tabela']);
			endif;
		endif;

		if (!isset($post['fipe']) && isset($post['veiculo_tipo']) && isset($post['veiculo_marca']) && isset($post['veiculo_modelo'])) :
			$fipe = file_get_contents('https://parallelum.com.br/fipe/api/v1/' . $post['veiculo_tipo'] . '/marcas/' . $post['veiculo_marca'] . '/modelos/' . $post['veiculo_modelo'] . '/anos/' . $post['veiculo_ano']);
			$post['fipe'] = json_decode($fipe, true);
		else :
			if (isset($post['veiculo_tipo']) && isset($post['veiculo_marca']) && isset($post['veiculo_modelo'])) :
				$post['fipe'] = json_decode($post['fipe'], true);
			endif;
		endif;

		$leadModel = new LeadModel();
		$lead = $leadModel->where('code', $codeLead)->first();

		$data['lead'] = myJsonDecode($lead);

		// dd($post);
		$codeCategoria = isset($post['tabela']) ? $post['tabela']->codeCategoria : $dt['tabela_carreta'][0]->codeCategoria;

		$opcionaisModel = new OpcionaisModel();
		$opcionais = $opcionaisModel->where('codeCategoria', $codeCategoria)
			->orWhere('codeCategoria', null)
			->orWhere('codeCategoria', '')
			->findAll();
		$categoriaModel = new CategoriaModel();
		$categoria = $categoriaModel->where('code', $codeCategoria)->first();

		$data['tabela'] = isset($post['tabela']) ? $post['tabela'] : null;
		$data['tabela_carreta'] = isset($post['tabela_carreta']) ? $post['tabela_carreta'] : null;
		$data['mensalidade'] = 0;

		$data['categoria'] = $categoria;
		$data['opcionais'] = $opcionais;
		$data['tituloPagina'] = "Proposta";
		$data['subtituloPagina'] = "Opcionais";
		$data['javaScriptSrc'] = ["custom/motorhome/js/fipeApi.js?r=" . code()];


		$data['post'] = json_encode($post);

		$data['path'] = $this->path;

		//Formulário padrão ou personalisado
		return template("custom/{$this->path}/proposta/form_opcionais", $data);
	}

	public function gerar($codeLead)
	{

		$data['tituloPagina'] = "Proposta";
		$data['subtituloPagina'] = "Opcionais";

		$post = $this->request->getPost();
		if (!$post) :
			setSwal('error', 'Ops!', 'Temos um problema, faltam dados para gerar essa proposta.');
			return redirect()->to(base_url($this->path . '/proposta/dados/' . $codeLead));
		endif;
		if (!isset($post['opt'])) :
			$post['opt'] = array();
		endif;

		if (isset($post['json'])) :
			$json = json_decode($post['json'], true);
			$dados = array_merge($json, $post);
			unset($dados['json']);
		endif;

		// dd($dados);

		helper('custom_motorhome');

		$dadosProposta['valorTotal'] = 0;

		if (isset($dados['tabela_carreta'])) :
			foreach ($dados['tabela_carreta'] as $k => $b) :
				$dadosProposta['carreta'][$k] = json_decode($b, true);
				$dadosProposta['carreta'][$k]['tipo'] =  $dados['carreta_tipo'][$k];
				$dadosProposta['carreta'][$k]['placa'] =  $dados['carreta_placa'][$k];
				// $dadosProposta['carreta'][$k]['chassi'] =  $dados['carreta_chassi'][$k];
				$dadosProposta['carreta'][$k]['valor'] =  $dados['carreta_valor'][$k];
				if ($dadosProposta['carreta'][$k]['tipo'] == 'Basculante') :
					// MUDAR A COTA para 7%
					// $dadosProposta['carreta'][$k]['valor'] =  noMoney($dados['carreta_valor'][$k]) + (noMoney($dados['carreta_valor'][$k]) * 7 / 100);
				endif;
			endforeach;
			foreach ($dados['carreta_valor'] as $cv) :
				$dadosProposta['valorTotal'] = $dadosProposta['valorTotal'] + noMoney($cv);
			endforeach;
		endif;

		$dadosProposta['tabela'] = isset($dados['tabela']) ? $dados['tabela'] : null;
		$dadosProposta['nome'] = $dados['nome'];
		$dadosProposta['userIf'] = $dados['userIf'];
		$dadosProposta['email'] = $dados['email'];
		$dadosProposta['telefone'] = soNumero($dados['telefone']);
		$dadosProposta['cidade'] = $dados['cidade'];
		$dadosProposta['uf'] = $dados['uf'];
		$dadosProposta['placa'] = isset($dados['placa']) ? $dados['placa'] : null;
		$dadosProposta['veiculo_fipe'] = isset($dados['fipe']) ? $dados['fipe'] : null;
		$dadosProposta['codeCategoria'] = isset($dados['tabela']['codeCategoria']) ? $dados['tabela']['codeCategoria'] : $dadosProposta['carreta'][0]['codeCategoria'];
		// Categoria
		$categoriaModel = new CategoriaModel();
		$dadosProposta['categoria'] = $categoriaModel->asArray()->find($dadosProposta['codeCategoria']);
		// End Categoria
		$dadosProposta['veiculo_tipo'] = $dados['veiculo_tipo'];
		$dadosProposta['veiculo_marca'] = isset($dados['fipe']['Marca']) ? $dados['fipe']['Marca'] : null;
		$dadosProposta['veiculo_modelo'] = isset($dados['fipe']['Modelo']) ? $dados['fipe']['Modelo'] : null;
		$dadosProposta['veiculo_ano'] = isset($dados['fipe']['AnoModelo']) ? $dados['fipe']['AnoModelo'] : null;
		$dadosProposta['veiculo_combustivel'] = isset($dados['fipe']['Combustivel']) ? $dados['fipe']['Combustivel'] : null;
		$dadosProposta['veiculo_valor'] = isset($dados['veiculo_valor']) ? noMoney($dados['veiculo_valor']) : null;
		$dadosProposta['valorTotal'] = $dadosProposta['valorTotal'] + $dadosProposta['veiculo_valor'];
		$dadosProposta['fipe'] = isset($dados['fipe']['CodigoFipe']) ? $dados['fipe']['CodigoFipe'] : null;

		$dadosProposta['implemento_nome'] = isset($dados['implemento_nome']) ? $dados['implemento_nome'] : null;
		$dadosProposta['implemento_valor'] = isset($dados['implemento_valor']) ? $dados['implemento_valor'] : null;

		if ($dadosProposta['implemento_nome'] == 'Basculante') :
			// $dadosProposta['implemento_valor'] = noMoney($dadosProposta['implemento_valor']) + (noMoney($dadosProposta['implemento_valor']) * 7 / 100);
		endif;

		$dadosProposta['valorTotal'] = $dadosProposta['valorTotal'] + noMoney($dadosProposta['implemento_valor']);

		if (isset($dados['adesao'])) :

			$dados['adesao'] = str_replace('R$', '', $dados['adesao']);
			$dados['adesao'] = str_replace('.', '', $dados['adesao']);
			$dados['adesao'] = trim(str_replace(',', '.', $dados['adesao']));

			$dadosProposta['adesao'] = $dados['adesao'];
		endif;
		foreach ($dados['opt'] as $k => $b) :
			$dadosProposta['opcionais'][$k] = json_decode($b, true);
		endforeach;


		$data['proposta'] = (object) ['created_at' => date('Y-m-d H:i:s'), 'status' => 'inicial'];

		$data['produto'] = getProduto(getLead($codeLead, 'codeProduto'));

		$data['code'] = $codeLead;
		$data['path'] = $this->path;
		$data['d'] = $dadosProposta;

		// dd($dadosProposta);
		//Formulário padrão ou personalisado
		return template("custom/$this->path/proposta/form_proposta", $data);
	}


	public function visualizar($codeProposta)
	{
		$data['tituloPagina'] = "Proposta";
		$data['subtituloPagina'] = "Opcionais";

		$propostaModel = new PropostaModel();

		$proposta = $propostaModel->where('code', $codeProposta)->first();

		if (!$proposta) :
			setSwal('error', 'Ops!', 'Temos um problema, esta proposta não existe.');
			return redirect()->to(base_url('proposta'));
		endif;

		$data['code'] = $codeProposta;
		$data['path'] = $this->path;
		$data['proposta'] = $proposta;
		$data['dataProposta'] = $proposta->created_at;
		$data['dadosProposta'] = myJsonDecode($proposta->dadosProposta);

		// dd($data['dadosProposta']);

		return template("custom/{$this->path}/proposta/proposta_view", $data);
	}

	public function regraVencimento()
	{
		if (date('d') >= 1 && date('d') <= 15) :
			$data['vencimento'][0] = 10;
			if (date('d') >= 10 && date('d') <= 15) :
				$data['vencimento'][1] = 15;
			endif;
		elseif (date('d') >= 16 && date('d') <= 31) :
			$data['vencimento'][0] = 20;
			if (date('d') >= 25 && date('d') <= 31) :
				$data['vencimento'][1] = 25;
			endif;
		endif;
		return $data['vencimento'];
	}

	public function camposExtras($post, $proposta)
	{

		$dadosProposta = $proposta->dadosProposta;
		$produto = getProduto($proposta->codeProduto);
		$mensalidade = 0;

		$camposExtras['cliente']['uf'] = $post['uf'];
		$camposExtras['cliente']['cidade'] = $post['cidade'];
		$camposExtras['cliente']['bairro'] = $post['bairro'];
		$camposExtras['cliente']['cep'] = $post['cep'];
		$camposExtras['cliente']['endereco'] = $post['endereco'];
		$camposExtras['cliente']['numero'] = $post['numero'];
		$camposExtras['cliente']['complemento'] = $post['complemento'];

		$camposExtras['veiculo'][0]['categoria']['code'] = $dadosProposta['categoria']['code'];
		$camposExtras['veiculo'][0]['categoria']['nome'] = $dadosProposta['categoria']['titulo'];
		$camposExtras['veiculo'][0]['categoria']['beneficios'] = $dadosProposta['categoria']['beneficio'];
		if (isset($post['veiculo'])) :
			$camposExtras['veiculo'][0]['placa'] = $post['veiculo'][0]['placa'];
			$camposExtras['veiculo'][0]['renavam'] = $post['veiculo'][0]['renavam'];
			$camposExtras['veiculo'][0]['chassi'] = $post['veiculo'][0]['chassi'];
			$camposExtras['veiculo'][0]['marca'] = $dadosProposta['veiculo_marca'];
			$camposExtras['veiculo'][0]['modelo'] = $dadosProposta['veiculo_modelo'];
			$camposExtras['veiculo'][0]['ano'] = $dadosProposta['veiculo_ano'];
			$camposExtras['veiculo'][0]['combustivel'] = $dadosProposta['veiculo_combustivel'];
			$camposExtras['veiculo'][0]['valor'] = $dadosProposta['veiculo_valor'];
			$camposExtras['veiculo'][0]['data_fipe'] = $dadosProposta['veiculo_fipe']['MesReferencia'];
			$camposExtras['veiculo'][0]['fipe'] = $dadosProposta['fipe'];
			$camposExtras['veiculo'][0]['mensalidade'] = $dadosProposta['tabela']['mensalidade'];
			$camposExtras['veiculo'][0]['cota_participativa'] = $dadosProposta['tabela']['cota_participativa'];
			$camposExtras['veiculo'][0]['cota_min'] = $dadosProposta['tabela']['cota_min'];
			if ($dadosProposta['implemento_nome'] && $dadosProposta['implemento_valor']) :
				$camposExtras['veiculo'][0]['implemento']['tipo'] = $dadosProposta['implemento_nome'];
				$camposExtras['veiculo'][0]['implemento']['valor'] = $dadosProposta['implemento_valor'];
			endif;
			$mensalidade = $mensalidade + $dadosProposta['tabela']['mensalidade'];
		endif;
		if (isset($dadosProposta['carreta'])) :
			foreach ($dadosProposta['carreta'] as $key => $carreta) :
				$temp[$key]['tipo'] = $carreta['tipo'];
				$temp[$key]['valor'] = $carreta['valor'];
				$temp[$key]['placa'] = $carreta['placa'];
				$temp[$key]['chassi'] = $post['carreta'][$key]['chassi'];
				$temp[$key]['renavam'] = $post['carreta'][$key]['renavam'];
				$temp[$key]['mensalidade'] = exibe($carreta, 'mensalidade', true);
				$mensalidade = $mensalidade + $temp[$key]['mensalidade'];
			endforeach;
			$camposExtras['veiculo'][0]['carreta'] = $temp;
		endif;
		$camposExtras['contrato']['adesao'] = $dadosProposta['adesao'];
		if (isset($dadosProposta['opcionais'])) :
			$camposExtras['contrato']['opcionais'] = $dadosProposta['opcionais'];
		endif;
		$camposExtras['contrato']['mensalidade'] = $mensalidade;
		$camposExtras['contrato']['compromisso'] = $produto->assinaturaExtra;
		$camposExtras['contrato']['rodape'] = $dadosProposta['categoria']['rodape'];

		return $camposExtras;
	}
}
