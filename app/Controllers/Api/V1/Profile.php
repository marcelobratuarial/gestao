<?php

namespace App\Controllers\Api\V1;

use App\Controllers\ApiBaseController;
use App\Models\EmpresaModel;
use App\Models\UsuarioModel;
use App\Models\VistoriaInfoModel;
use App\Models\VistoriaModel;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use ReflectionException;

class Profile extends ApiBaseController
{
    /**
     * Register a new user
     * @return Response
     * @throws ReflectionException
     */
    public function info()
    {
        $dataToken = dataToken(getBearerToken($this->request));
		if($dataToken):

			$usuarioModel = new UsuarioModel();
			$usuario = $usuarioModel->find($dataToken['token']['codeUsuario']);

			$empresaModel = new EmpresaModel();
			$empresa= $empresaModel->find($usuario->codeEmpresa);




			return $this->getResponse(
				[
					'success' => true,
					'data' => [
						'codeEmpresa' => $usuario->codeEmpresa, 
						'cpf' => base64_decode($usuario->cpf),
						'nome' => $usuario->nome,
						'email' => $usuario->email,
						'telefone' => $usuario->telefone,
						'leadPageLink' => $empresa->leadPageLink.'?u='.md5($usuario->code)
					]
				],
				ResponseInterface::HTTP_OK
			);
		endif; 

 } 

}
