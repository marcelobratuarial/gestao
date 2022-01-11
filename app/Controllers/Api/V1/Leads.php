<?php

namespace App\Controllers\Api\V1;

use App\Controllers\ApiBaseController;
use App\Models\LeadModel;
use App\Models\StatusModel;
use App\Models\UsuarioModel;
use CodeIgniter\HTTP\ResponseInterface;

class Leads extends ApiBaseController
{
	public function index()
	{
		$model = new LeadModel();
		$result = $model->where('codeEmpresa', CODEEMPRESA)->findAll();


		return $this->getResponse(
			[
				'success' => true,
				'data' => $result
			],
			ResponseInterface::HTTP_OK
		);
	}

	public function minhas_leads()
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


			$leadModel = new LeadModel();

			$leadModel->select('lead.code, lead.nome, lead.email, lead.telefone, lead.origem, lead.codeStatus, status.nome as titleStatus, status.cor as corStatus, status.tipo as tipoStatus, lead.created_at, lead.observacoes, lead.camposExtras');
			$leadModel->where('lead.codeUsuario', $usuario->code);
			$leadModel->where('status.codeEmpresa', CODEEMPRESA);
			$leadModel->where('status.tabela', 'lead');
			$leadModel->join('status', 'status.code = lead.codeStatus', 'left');

			if ($filter['placa'] != null)
				$leadModel->like('lead.camposExtras', $filter['placa']);  

			if ($filter['nome'] != null)
				$leadModel->like('lead.nome', $filter['nome']);  

			if ($filter['status'] != null)
				$leadModel->where('lead.codeStatus', $filter['status']); 

			$result = $leadModel->findAll();

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
							'leads' => $return[$pagina]
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

	// api funcional

	public function create()
	{
		$model = new LeadModel();
		$json = (array) $this->request->getJSON();

		$data['code'] = code();
		$data['codeEmpresa'] = CODEEMPRESA;
		$data['codeProduto'] = $json['codeProduto'];
		$data['codeUsuario'] = isset($json['codeUsuario']) ? $json['codeUsuario'] : null;
		$data['origem'] = $json['origem'];
		$data['nome'] = $json['nome'];
		$data['email'] = $json['email'];
		$data['telefone'] = soNumero($json['telefone']);
		unset($json['nome'], $json['email'], $json['telefone'], $json['origem'], $json['codeProduto'], $json['codeUsuario']);

		foreach ($json as $k => $v) :
			$data['camposExtras'][$k] = $v;
		endforeach;
		if (isset($data['camposExtras'])) :
			$data['camposExtras'] = json_encode($data['camposExtras']);
		endif;

		$model->insert($data);
		return $this->getResponse(
			[
				'success' => true,
				'message' => 'Lead cadastrado com sucesso!',
				'data' => ['code' => $data['code']]
			],
			ResponseInterface::HTTP_OK
		);
	}

	public function update($code = null)
	{
		$model = new LeadModel();

		$lead = $model->asArray()->where('code', $code)->first();
		if ($lead) :
			$json = (array) $this->request->getJSON();

			unset($json['nome'], $json['email'], $json['telefone'], $json['origem'], $json['codeProduto']);

			$data['camposExtras'] = json_decode($lead['camposExtras'], true);
			foreach ($json as $k => $v) :
				$data['camposExtras'][$k] = $v;
			endforeach;

			$data['camposExtras'] = json_encode($data['camposExtras']);

			$model->update($code, $data);
			$lead['success'] = true;
			$lead['camposExtras'] = $data['camposExtras'];

			return $this->getResponse(
				[
					'success' => true,
					'message' => 'Lead atualizado com sucesso!'
				],
				ResponseInterface::HTTP_OK
			);
		endif;
	}

	public function list_status()
	{
		$dataToken = dataToken(getBearerToken($this->request));
		
		if ($dataToken) :
			
			$statusModel = new StatusModel();

			$statusModel->select('code, nome as titleStatus, cor as corStatus, tipo');
			$statusModel->where('codeEmpresa', CODEEMPRESA);
			$statusModel->where('tabela', 'lead');

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

	// api funcional
}
