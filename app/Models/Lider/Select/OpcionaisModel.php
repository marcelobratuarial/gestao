<?php

namespace App\Models\Lider\Select;

use CodeIgniter\Model;


class OpcionaisModel extends Model
{

    protected $DBGroup        = 'lider';

    protected $table          = 'select_opcionais';

    protected $primaryKey     = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['codeCategoria', 'tipo', 'options', 'slug', 'titulo', 'descricao', 'valor', 'cota', 'cota_min', 'obrigatorio'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
