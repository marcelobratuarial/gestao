<?php

namespace App\Models\Multifacil\Protecaoveicular;

use CodeIgniter\Model;


class TabelaModel extends Model
{

    protected $DBGroup = 'multifacil';

    protected $table      = 'combos_tabela';

    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['codeCategoria', 'valor_de', 'valor_ate', 'bronze', 'prata', 'ouro', 'diamante', 'adesao', 'desconto'];

    protected $useTimestamps = false;
}
