<?php

namespace App\Models;


use CodeIgniter\Model;


class ConfigModel extends Model
{
    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    
    protected $table      = 'config';

    protected $primaryKey = 'id';

	protected $allowedFields = ['categoria','valor','code','codeEmpresa','nome'];
    
    protected $beforeInsert = ['code'];

    protected function code(array $data)
    {
        $data['data']['code'] = code();
        return $data;
    }

}