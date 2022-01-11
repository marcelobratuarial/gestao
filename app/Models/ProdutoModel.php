<?php

namespace App\Models;

use CodeIgniter\Model;


class ProdutoModel extends Model
{

    protected $table      = 'produto';

    protected $primaryKey = 'code';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $allowedFields = ['status', 'nome', 'code', 'assinaturaDados', 'assinaturaExtra'];
}
