<?php

namespace App\Models\Lider\Combos;

use CodeIgniter\Model;


class CombosModel extends Model
{

    protected $DBGroup    = 'lider';

    protected $table      = 'combos_descricao';

    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $useTimestamps = false;

    protected $allowedFields = ['slug', 'titulo', 'descricao'];
}
