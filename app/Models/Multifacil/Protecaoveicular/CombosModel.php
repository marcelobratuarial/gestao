<?php

namespace App\Models\Multifacil\Protecaoveicular;

use CodeIgniter\Model;


class CombosModel extends Model
{

    protected $DBGroup    = 'multifacil';

    protected $table      = 'combos_descricao';

    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $useTimestamps = false;

    protected $allowedFields = ['slug', 'titulo', 'descricao'];
}
