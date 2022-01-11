<?php

namespace App\Controllers\Api\Publico;

use App\Controllers\ApiBaseController;
use App\Models\EmpresaModel;
use App\Models\LeadModel;
use App\Models\UsuarioModel;
use CodeIgniter\HTTP\ResponseInterface;

class LeadPageLink extends ApiBaseController
{
	public function create()
	{
		$model = new UsuarioModel();
		$json = (array) $this->request->getJSON();

		$usuario = $model->where('md5(code)', $json['codeUsuario'])->first();

		$data['leadPageLink'] = $usuario->leadPageLink + 1;

		$data['code'] = $usuario->code;
		if ($model->save($data)) :
			return $this->getResponse(
				[
					'success' => true,
					'data' 	  => $data,
					'message' => 'Acesso atualizado com sucesso!'
				],
				ResponseInterface::HTTP_OK
			);
			else:
			    	return $this->getResponse(
				[
					'success' => false,
					'data' 	  => $data,
					'message' => 'Acesso não foi atualizado com sucesso!'
				],
				ResponseInterface::HTTP_OK
			);
		endif;
	}
}
