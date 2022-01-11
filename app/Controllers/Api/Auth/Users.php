<?php

namespace App\Controllers\Api\Auth;

use App\Controllers\ApiBaseController;
use App\Models\UsuarioModel;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use ReflectionException;

class Users extends ApiBaseController
{
    /**
     * Register a new user
     * @return Response
     * @throws ReflectionException
     */
    public function forgot_password()
    {
        return $this
                ->getResponse(
                    [
                        'success' => true,
                        'message' => 'E-mail de alteração de senha enviado com sucesso.'    
                    ],
                    ResponseInterface::HTTP_OK
                );
    }

   
}
