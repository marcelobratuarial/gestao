<?php

namespace App\Controllers\Api\Publico;

use App\Controllers\ApiBaseController;
use App\Models\LeadModel;
use App\Models\UsuarioModel;
use CodeIgniter\HTTP\ResponseInterface;

class Leads extends ApiBaseController
{
	public function create()
	{
		$model = new LeadModel();
		$json = (array) $this->request->getJSON();


		$data['codeUsuario'] = null; //opcional
		if (isset($json['codeUsuario'])) :
			$usuarioModel = new UsuarioModel();
			$usuario = $usuarioModel->where('md5(code)', $json['codeUsuario'])->orWhere('code', $json['codeUsuario'])->first();
			$data['codeUsuario'] = $usuario->code;
		endif;

		$data['code'] = code();
		$data['codeEmpresa'] = CODEEMPRESA;
		$data['codeProduto'] = $json['codeProduto']; // obrigatorio
		$data['origem'] = $json['origem']; // obrigatorio
		$data['nome'] = $json['nome']; // obrigatorio
		$data['email'] = $json['email']; // obrigatorio
		$data['telefone'] = soNumero($json['telefone']); // obrigatorio
		unset($json['nome'], $json['email'], $json['telefone'], $json['origem'], $json['codeProduto']);

		foreach ($json as $k => $v) :
			$data['camposExtras'][$k] = $v;
		endforeach;
		if (isset($data['camposExtras'])) :
			$data['camposExtras'] = json_encode($data['camposExtras']);
		endif;

		$model->insert($data);
		addHistorico('lead', $data['code'], 'inicial', 'Lead adicionado');
		return $this->getResponse(
			[
				'success' => true,
				'data' 	  => $data,
				'message' => 'Lead cadastrado com sucesso!'
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
					'data'    => $lead,
					'message' => 'Lead atualizado com sucesso!'
				],
				ResponseInterface::HTTP_OK
			);
		endif;
	}
}
