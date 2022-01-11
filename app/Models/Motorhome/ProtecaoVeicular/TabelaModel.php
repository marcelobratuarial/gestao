<?php

namespace App\Models\Motorhome\ProtecaoVeicular;

use CodeIgniter\Model;


class TabelaModel extends Model
{

    protected $DBGroup = 'motorhome';

    protected $table      = 'tabela';

    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['codeCategoria', 'valor_de', 'valor_ate', 'mensalidade', 'cota_participativa', 'cota_min'];

    protected $useTimestamps = false;
}
