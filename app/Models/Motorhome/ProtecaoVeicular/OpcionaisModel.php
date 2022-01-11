<?php

namespace App\Models\Motorhome\ProtecaoVeicular;

use CodeIgniter\Model;


class OpcionaisModel extends Model
{

    protected $DBGroup        = 'motorhome';

    protected $table          = 'opcionais';

    protected $primaryKey     = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['codeCategoria', 'tipo', 'options', 'slug', 'titulo', 'descricao', 'valor', 'cota', 'cota_min'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
