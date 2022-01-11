<?php

namespace App\Controllers\Api\V1;

use App\Controllers\ApiBaseController;
use App\Models\UsuarioModel;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use ReflectionException;

class Usuarios extends ApiBaseController
{
	/**
	 * Register a new user
	 * @return Response
	 * @throws ReflectionException
	 */
	public function show($id = null)
	{
		$dataToken = dataToken(getBearerToken($this->request));
		if ($dataToken) :

			$usuarioModel = new UsuarioModel();
			$usuario = $usuarioModel->select('nome, email, telefone')->find($id);
			$usuario->leadPageLink = getEmpresa(CODEEMPRESA, 'leadPageLink') . '?u=' . md5($id);
			return $this->getResponse(
				[
					'success' => true,
					'data' => $usuario
				],
				ResponseInterface::HTTP_OK
			);
		endif;
	}
}
