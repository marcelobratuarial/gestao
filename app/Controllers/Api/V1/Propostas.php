<?php

namespace App\Controllers\Api\V1;

use App\Controllers\ApiBaseController;
use App\Models\AssinaturaModel;
use App\Models\leadModel;
use App\Models\PropostaModel;
use App\Models\StatusModel;
use App\Models\UsuarioModel;
use CodeIgniter\HTTP\ResponseInterface;

class Propostas extends ApiBaseController
{

	public function minhas_propostas()
	{
		$dataToken = dataToken(getBearerToken($this->request));
		$usuarioModel = new UsuarioModel();
		if ($dataToken) :
			$usuario = $usuarioModel->find($dataToken['token']['codeUsuario']);

			$qtdItens = $this->request->getVar('qtd_itens');
			$pagina = $this->request->getVar('pagina');
			$filter['placa'] = $this->request->getVar('filter_placa');
			$filter['nome'] = $this->request->getVar('filter_nome');
			$filter['status'] = $this->request->getVar('filter_status');
			$qtdItens = ($qtdItens) ? $qtdItens : 10;
			$pagina = ($pagina) ? $pagina : 1;


			$propostaModel = new PropostaModel();

			$propostaModel->select('proposta.code, proposta.codeUsuario, proposta.status, status.nome as titleStatus, status.cor as corStatus, status.tipo as tipoStatus, proposta.created_at, proposta.termos, proposta.documentos, proposta.vistoria, proposta.assinada, proposta.dadosProposta');
			$propostaModel->where('proposta.codeUsuario', $usuario->code);
			$propostaModel->where('status.codeEmpresa', CODEEMPRESA);
			$propostaModel->where('status.tabela', 'proposta');
			$propostaModel->join('status', 'status.code = proposta.status', 'left');

			if ($filter['placa'] != null)
				$propostaModel->like('proposta.dadosProposta', $filter['placa']);  

			if ($filter['nome'] != null)
				$propostaModel->like('proposta.dadosProposta', $filter['nome']); 

			if ($filter['status'] != null)
				$propostaModel->where('proposta.status', $filter['status']); 

			$result = $propostaModel->findAll();

			$n = 1;
			$p = 1;
			foreach ($result as $value) :
				if ($n == $qtdItens) :
					$return[$p][$n - 1] = $value;
					$p = $p + 1;
					$n = 1;
				elseif ($n < $qtdItens) :
					$return[$p][$n - 1] = $value;
					$n++;
				endif;
			endforeach;


			if (isset($return[$pagina])) :
				return $this->getResponse(
					[
						'success' => true,
						'data' => [
							'total' => count($result),
							'qtd_itens' => $qtdItens,
							'pagina' => $pagina,
							'filters' => $filter,
							'propostas' => $return[$pagina]
						]
					],
					ResponseInterface::HTTP_OK
				);
			else :
				return $this->getResponse(
					[
						'success' => true,
						'message' => 'Nenhum resultado encontrado.'
					],
					ResponseInterface::HTTP_OK
				);
			endif;
		endif;
	}

	
	
	public function show($code)
	{
		//JOIN STATUS
		if($code){ 
				$dataToken = dataToken(getBearerToken($this->request));
				$usuarioModel = new UsuarioModel();
				if($dataToken):
					$usuario = $usuarioModel->find($dataToken['token']['codeUsuario']);

					$propostaModel = new PropostaModel();
					$propostaModel->where('codeUsuario', $usuario->code);
					$result = $propostaModel->where('code', $code)->first();




					$propostaModel->select('proposta.code, proposta.codeUsuario, proposta.status, status.nome as titleStatus, status.cor as corStatus, status.tipo as tipoStatus, proposta.created_at, proposta.termos, proposta.documentos, proposta.vistoria, proposta.assinada, proposta.dadosProposta');
					$propostaModel->where('proposta.codeUsuario', $usuario->code);
					$propostaModel->where('status.codeEmpresa', CODEEMPRESA);
					$propostaModel->where('status.tabela', 'proposta');
					$propostaModel->join('status', 'status.code = proposta.status', 'left');

					$result = $propostaModel->where('proposta.code', $code)->first();


					if($result == null){
						return $this->getResponse(
							[
								'success' => false,
								'data' => [
									'message' => 'Nenhuma proposta encontrada com esse código!'
								]    
							],
							ResponseInterface::HTTP_NOT_FOUND
                		);
					}
					else{
						return $this->getResponse(
							[
								'success' => true,
								'data' => $result
							],
							ResponseInterface::HTTP_OK
						);
					}
					
				endif; 
        }
        else{

            return $this
                ->getResponse(
                    [
						'success' => false,
                        'data' => [
                            'message' => 'É necessário informar um código!'
                        ]    
                        ],
                        ResponseInterface::HTTP_BAD_REQUEST
                );
        }
        
	}

	public function create()
	{
		$propostaModel = new PropostaModel();
		$usuarioModel = new UsuarioModel();
		$assinaturaModel = new AssinaturaModel();
		$leadModel = new LeadModel();

		$dataToken = dataToken(getBearerToken($this->request));
		
		if($dataToken):
			$usuario = $usuarioModel->find($dataToken['token']['codeUsuario']);

			$json = (array) $this->request->getJSON();

			$data['code'] = $json['code'];
			$data['codeEmpresa'] = CODEEMPRESA;
			$data['codeProduto'] = $json['codeProduto'];
			$data['codeUsuario'] = $usuario->code;

			$data['codigoSeguranca'] = substr($json['telefone'], -4);
			$data['codigo_email'] = gerar_senha(6, false, false, true, false);
			$data['email'] = $json['email'];

			$data['status'] = "inicial"; 
			$data['pagamento'] = 2; // 2 inativo
			$data['assinada'] = 0; // 0 ainda nao assinada

			unset($json['code'], $json['codeProduto'], $json['telefone'], $json['email']);

			foreach ($json as $k => $v) :
				$data['dadosProposta'][$k] = $v;
			endforeach;
			if (isset($data['dadosProposta'])) :
				$data['dadosProposta'] = json_encode($data['dadosProposta']);
			endif;

			// valida o codigo da proposta unico
			$existeProposta = $propostaModel->like('code', $data['code'])->orderBy('created_at', 'DESC')->first();
			
			if(!$existeProposta):
				$propostaModel->insert($data);

			else:
				$pCode = explode('_', $existeProposta->code);
				$n = isset($pCode[1]) ? '_' . ($pCode[1] + 1) : null;
				$n = ($n == null) ? '_1' : $n;
				$data['code'] = $pCode[0] . $n;
				$propostaModel->insert($data);
			endif;
				
			//busca proposta inserida
			$dadosProposta = getProposta($data['code']);

			//assinatura consultor		
			$assinaturaConsultor['code_contrato'] = $dadosProposta->code;
			$assinaturaConsultor['identificador_usuario'] = getUsuario($dadosProposta->codeUsuario, 'cpf');
			$assinaturaConsultor['nomecompleto'] = getUsuario($dadosProposta->codeUsuario, 'nome');
			$assinaturaConsultor['tipo_assinatura'] = 0;  //0 assinar 1 testemunhar
			$assinaturaConsultor['perfil'] = 0;  //0 consultor  1 cliente
			$assinaturaConsultor['status'] = 1;  //0 pendente 1 assinado
			$assinaturaConsultor['ip_Address'] = $_SERVER['REMOTE_ADDR'];
			$assinaturaConsultor['code_empresa'] = $dadosProposta->codeEmpresa;
			$assinaturaConsultor['email'] = getUsuario($dadosProposta->codeUsuario, 'email');

			$assinaturaModel->insert($assinaturaConsultor);

			//assinatura cliente
			$assinaturaCliente['code_empresa'] = $dadosProposta->codeEmpresa;
			$assinaturaCliente['code_contrato'] = $dadosProposta->code;
			$assinaturaCliente['tipo_assinatura'] = 0;  //0 assinar 1 testemunhar
			$assinaturaCliente['perfil'] = 1;  //0 consultor  1 cliente
			$assinaturaCliente['status'] = 0;  //0 pendente 1 assinado
			$assinaturaModel->insert($assinaturaCliente);

			$dataLead['codeStatus'] = 'final';
			$dataLead['code'] = $dadosProposta->code;
			
			$leadModel->save($dataLead);

			addHistorico('lead', $dadosProposta->code, 'final', 'Proposta gerada - ' . $dadosProposta->code);
			addHistorico('proposta', $dadosProposta->code, 'inicial', 'Proposta gerada - ' . $dadosProposta->code);

			//enviar email de confirmação

			return $this->getResponse(
				[
					'success' => true,
					'message' => 'Proposta cadastrada com sucesso!'
				],
				ResponseInterface::HTTP_CREATED
			);
		endif;
	}



	public function update($code)
	{
		
		return $this->getResponse(
			[
				'success' => true,
				'messages'=> 'Proposta editada com sucesso!'
			],
			ResponseInterface::HTTP_OK
		);
	}

	public function list_status()
	{
		$dataToken = dataToken(getBearerToken($this->request));
		
		if ($dataToken) :
			
			$statusModel = new StatusModel();

			$statusModel->select('code, nome as titleStatus, cor as corStatus, tipo');
			$statusModel->where('codeEmpresa', CODEEMPRESA);
			$statusModel->where('tabela', 'proposta');

			$result = $statusModel->findAll();


				return $this->getResponse(
					[
						'success' => true,
						'data' => $result
					],
					ResponseInterface::HTTP_OK
				);
			
		endif;
	}

	public function listar_propostas_com_vistoria()
	{
		$dataToken = dataToken(getBearerToken($this->request));
		
		if ($dataToken) :
			
			$filter['status'] = $this->request->getVar('filter_status');

			$propostaModel = new PropostaModel();
			$propostaModel->where('codeEmpresa', CODEEMPRESA);

			if ($filter['status'] != null)
			$propostaModel->where('proposta.status', $filter['status']); 
			$propostaModel->join('vistoria_files', 'proposta.code = vistoria_files.codeProposta', 'inner');


			$result = $propostaModel->findAll();


				return $this->getResponse(
					[
						'success' => true,
						'data' => $result
					],
					ResponseInterface::HTTP_OK
				);
			
		endif;
	}

	public function listar_propostas_com_documentos()
	{
		$dataToken = dataToken(getBearerToken($this->request));
		
		if ($dataToken) :
			
			$filter['status'] = $this->request->getVar('filter_status');

			$propostaModel = new PropostaModel();
			$propostaModel->where('codeEmpresa', CODEEMPRESA);

			if ($filter['status'] != null)
			$propostaModel->where('proposta.status', $filter['status']); 
			$propostaModel->join('documento_files', 'proposta.code = documento_files.codeProposta', 'inner');


			$result = $propostaModel->findAll();


				return $this->getResponse(
					[
						'success' => true,
						'data' => $result
					],
					ResponseInterface::HTTP_OK
				);
			
		endif;
	}

}
