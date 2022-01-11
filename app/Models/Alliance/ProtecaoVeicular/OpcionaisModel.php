<?php

namespace App\Models\Alliance\ProtecaoVeicular;

use CodeIgniter\Model;


class OpcionaisModel extends Model
{

    protected $DBGroup        = 'alliance';

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
