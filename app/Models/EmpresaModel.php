<?php

namespace App\Models;
use CodeIgniter\Model;


class EmpresaModel extends Model
{

    protected $table      = 'empresa';

    protected $primaryKey = 'code';

    protected $allowedFields = ['cor', 'logo', 'nome', 'icone', 'apiKey', 'apiSecretKey'];

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


}