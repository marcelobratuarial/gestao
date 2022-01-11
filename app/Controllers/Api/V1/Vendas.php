<?php

namespace App\Controllers\Api\V1;

use App\Controllers\ApiBaseController;
use App\Models\leadModel;
use App\Models\PropostaModel;
use App\Models\StatusModel;
use App\Models\UsuarioModel;
use App\Models\VendaModel;
use CodeIgniter\HTTP\ResponseInterface;

class Vendas extends ApiBaseController
{
	
	public function minhas_vendas()
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


			$vendaModel = new VendaModel();

			$vendaModel->select('venda.code, venda.codeUsuario, venda.codeProposta, venda.vencimento, venda.codeStatus, status.nome as titleStatus, status.cor as corStatus, status.tipo as tipoStatus, venda.created_at, proposta.termos, proposta.documentos, proposta.vistoria, proposta.assinada, venda.camposExtras');
			$vendaModel->where('venda.codeUsuario', $usuario->code);
			$vendaModel->where('status.codeEmpresa', CODEEMPRESA);
			$vendaModel->where('status.tabela', 'venda');
			$vendaModel->join('status', 'status.code = venda.codeStatus', 'left');
			$vendaModel->join('proposta', 'proposta.code = venda.codeProposta', 'left');

			if ($filter['placa'] != null)
				$vendaModel->like('venda.camposExtras', $filter['placa']);  

			if ($filter['nome'] != null)
				$vendaModel->like('venda.camposExtras', $filter['nome']); 

			if ($filter['status'] != null)
				$vendaModel->where('venda.codeStatus', $filter['status']); 

			$result = $vendaModel->findAll();

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
							'vendas' => $return[$pagina]
						]
					],
					ResponseInterface::HTTP_OK
				);
			else :
				return $this->getResponse(
					[
						'success' => true,
						'data'=> null,
						'message' => 'Nenhum resultado encontrado.'
					],
					ResponseInterface::HTTP_OK
				);
			endif;
		endif;
	}


	public function show($code)
	{
		if($code){ 
				$dataToken = dataToken(getBearerToken($this->request));
				$usuarioModel = new UsuarioModel();
				if($dataToken):
					$usuario = $usuarioModel->find($dataToken['token']['codeUsuario']);

					$vendaModel = new VendaModel();
					$vendaModel->where('codeUsuario', $usuario->code);
					$result = $vendaModel->where('code', $code)->first();

					if($result == null){
						return $this->getResponse(
							[
								'success' => false,
								'data' => [
									'message' => 'Nenhuma venda encontrada com esse código!'
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

	public function list_status()
	{
		$dataToken = dataToken(getBearerToken($this->request));
		
		if ($dataToken) :
			
			$statusModel = new StatusModel();

			$statusModel->select('code, nome as titleStatus, cor as corStatus, tipo');
			$statusModel->where('codeEmpresa', CODEEMPRESA);
			$statusModel->where('tabela', 'vendas');

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
	
}
