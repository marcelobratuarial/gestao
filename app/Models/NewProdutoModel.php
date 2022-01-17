<?php

namespace App\Models;

use CodeIgniter\Model;


class NewProdutoModel extends Model
{

    protected $table      = 'new_produto';

    protected $primaryKey = 'code';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $allowedFields = ['status', 'tipo', 'nome', 'code', 'valor', 'descricao', 'camposExtras', 'codeStatus', 'validade'];
}
