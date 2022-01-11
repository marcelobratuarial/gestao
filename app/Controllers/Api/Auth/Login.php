<?php

namespace App\Controllers\Api\Auth;

use App\Controllers\ApiBaseController;
use App\Models\PerfilModel;
use App\Models\UsuarioModel;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use ReflectionException;

class Login extends ApiBaseController
{
    /**
     * Register a new user
     * @return Response
     * @throws ReflectionException
     */
    public function register()
    {
    }

    /**
     * Authenticate Existing User
     * @return Response
     */
    public function index()
    {


        $rules = [
            'login' => 'required',
            'password' => 'required|min_length[6]|max_length[255]|validateUser[login, password]'
        ];

        $errors = [
            'password' => [
                'validateUser' => 'Os dados de acesso estão incorretos'
            ]
        ];


        $input = $this->getRequestInput($this->request);

        if (!$this->validateRequest($input, $rules, $errors)) {
            return $this
                ->getResponse(
                    [
                        'success' => false,
                        'messages' => $this->validator->getErrors()
                    ],
                    ResponseInterface::HTTP_BAD_REQUEST

                );
        }
        return $this->getJWTForUser($input['login']);
    }

    private function getJWTForUser(
        string $login,
        int $responseCode = ResponseInterface::HTTP_OK
    ) {
        try {
            $usuarioModel = new UsuarioModel();
            $perfilModel = new PerfilModel();

            $user = $usuarioModel->where('cpf', base64_encode($login))->orWhere('email', $login)->first();
            $perfil = $perfilModel->where('code', $user->perfil)->first();

            $user->perfilTipo = $perfil ? $perfil->tipo : 'default';
            $user->perfilNome = $perfil ? $perfil->nome : 'Sem perfil';
            unset($user->password);

            $this->session->set('access_token', getSignedJWTForUser($user));

            return $this
                ->getResponse(
                    [
                        'success' => true,
                        'access_token' => getSignedJWTForUser($user)
                    ]
                );
        } catch (Exception $exception) {
            return $this
                ->getResponse(
                    [
                        'success' => false,
                        'error' => $exception->getMessage(),
                    ],
                    $responseCode
                );
        }
    }
}
