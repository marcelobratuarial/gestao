<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class UsuarioModel extends Model
{

    protected $table      = 'usuario';

    protected $primaryKey = 'code';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $allowedFields = ['code', 'codeEmpresa', 'codeFilial', 'nome', 'userIf', 'email', 'telefone', 'password', 'password_reset', 'leadPageLink', 'perfil', 'permissoes', 'status', 'camposExtras', 'deleted_at'];


    protected $beforeInsert = ['code', 'encryptFields'];
    protected $beforeUpdate = ['encryptFields'];

    protected $afterInsert = ['addLogInsert'];
    protected $afterUpdate = ['addLogUpdate'];

    protected function addLogUpdate($data)
    {
        $usuario = usuario();
        if (isset($usuario->nome)) :
            $message = $usuario->nome . "[$usuario->code]";
            $message .= !isset($data['id'][1]) ? " - Editou o usuário: " . $data['id'][0] : " - Editou os usuários: " . json_encode($data['id']);
            $n = 0;
            foreach ($data['data'] as $key => $value) :
                $message .= "\n#$n Campo: '$key' -> Valor: '$value'";
                $n++;
            endforeach;
            log_message('alert', $message);
        endif;
    }
    protected function addLogInsert($data)
    {
        $usuario = usuario();
        $message = $usuario->nome . "[$usuario->code]";
        $message .=  " - Criou o usuário: " . $data['id'];
        $n = 0;
        foreach ($data['data'] as $key => $value) :
            $message .= "\n#$n Campo: '$key' -> Valor: '$value'";
            $n++;
        endforeach;
        log_message('alert', $message);
    }

    protected function code(array $data)
    {
        $data['data']['code'] = code();
        return $data;
    }
    protected function encryptFields(array $data)
    {
        //Encripta CPF
        if (isset($data['data']['telefone'])) :
            $data['data']['telefone'] = soNumero($data['data']['telefone']);
        endif;

        //Encripta CPF
        if (isset($data['data']['userIf'])) :
            $cpf = soNumero($data['data']['userIf']);
            unset($data['data']['userIf']);
            $data['data']['cpf'] = base64_encode($cpf);
        endif;

        //Encripta SENHA
        if (isset($data['data']['password'])) :
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        endif;

        return $data;
    }


    public function findUserByCPF(string $cpf)
    {
        $user = $this
            ->asArray()
            ->where(['cpf' => base64_encode($cpf)])
            ->first();

        if (!$user)
            throw new Exception('Usuário não encontrado');

        return $user;
    }
}
