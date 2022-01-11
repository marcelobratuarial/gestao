<?php

namespace App\Models;

use CodeIgniter\Model;


class VendaModel extends Model
{

    protected $table      = 'venda';

    protected $primaryKey = 'code';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $allowedFields = [
        'code',
        'codeEmpresa',
        'codeFilial',
        'codeUsuario',
        'codeProposta',
        'codeStatus',
        'camposExtras',
        'vencimento'
    ];

    protected $beforeInsert = ['code'];

    protected function code(array $data)
    {
        $data['data']['code'] = code();
        return $data;
    }
}
