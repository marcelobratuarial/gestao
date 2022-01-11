<?php

namespace App\Models\Alliance\ProtecaoVeicular;

use CodeIgniter\Model;


class TabelaModel extends Model
{

    protected $DBGroup = 'alliance';

    protected $table      = 'tabela';

    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['codeCategoria', 'valor_de', 'valor_ate', 'mensalidade', 'cota_participativa', 'cota_min', 'adesao'];

    protected $useTimestamps = false;
}
