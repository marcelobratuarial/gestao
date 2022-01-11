<?php

use App\Models\UsuarioModel;
use Config\Services;
use Firebase\JWT\JWT;

function getJWTFromRequest($authenticationHeader): string
{
    if (is_null($authenticationHeader)) { //JWT is absent
        throw new Exception('Missing or invalid JWT in request');
    }
    //JWT is sent from client in the format Bearer XXXXXXXXX
    return explode(' ', $authenticationHeader)[1];
}

function validateJWTFromRequest(string $encodedToken)
{
    $key = Services::getSecretKey();
    $decodedToken = JWT::decode($encodedToken, $key, ['HS256']);
    $userModel = new UsuarioModel();
    $userModel->where('code', $decodedToken->codeUsuario)->first();
}

function getSignedJWTForUser(object $user)
{
    $issuedAtTime = time();
    //$tokenTimeToLive = getenv('JWT_TIME_TO_LIVE');
    $tokenExpiration = strtotime(date('Y-m-d') . ' + 1 year');
    $payload = [
        'codeUsuario' => $user->code,
        'codeEmpresa' => $user->codeEmpresa,
        'codePerfil' => $user->perfil,
        'tipoPerfil' => $user->perfilTipo,
        'nomePerfil' => $user->perfilNome,
        'roles' => $user->permissoes,
        'iat' => $issuedAtTime,
        'exp' => $tokenExpiration,
    ];

    $jwt = JWT::encode($payload, Services::getSecretKey());
    return $jwt;
}
function getBearerToken($request)
{
    $authHeader = $request->getHeader("Authorization");
    $authHeader = $authHeader->getValue();
    $token = str_replace('Bearer ', '', $authHeader);
    return $token;
}

function dataToken(string $encodedToken = null)
{

    if ($encodedToken) {

        $key = Services::getSecretKey();
        // return JWT::decode($encodedToken, $key, ['HS256']);  
        try {
            $decodejwt = (array) JWT::decode($encodedToken, $key, array('HS256'));
            $output['token'] = $decodejwt;
            $output['success'] = true;
            $output['code'] = 200;
        } catch (\Firebase\JWT\ExpiredException $e) {
            $output['success'] = false;
            $output['errors'][] = 'Token expirado';
            $output['code'] = 401;
        }
        return $output;
    }
}
