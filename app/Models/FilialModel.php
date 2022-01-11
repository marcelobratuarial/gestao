<?php

namespace App\Models;

use CodeIgniter\Model;


class FilialModel extends Model
{

    protected $table      = 'filial';

    protected $primaryKey = 'code';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $allowedFields = ['nome', 'endereco', 'status', 'telefone', 'email', 'camposExtras', 'codeEmpresa'];

    protected $beforeInsert = ['code'];

    protected function code(array $data)
    {
        if (!isset($data['data']['code'])) :
            $data['data']['code'] = code();
        endif;
        return $data;
    }
}
