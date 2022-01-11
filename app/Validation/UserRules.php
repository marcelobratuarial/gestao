<?php

namespace App\Validation;

use App\Models\UsuarioModel;
use Exception;

class UserRules
{
    public function validateUser(string $str, string $fields, array $data): bool
    {
        try {
            $model = new UsuarioModel();
            $user = $model->where('cpf', base64_encode($data['login']))->orWhere('email', $data['login'])->where('status', 1)->first();
            return password_verify($data['password'], $user->password);
        } catch (Exception $e) {
            return false;
        }
    }
}
