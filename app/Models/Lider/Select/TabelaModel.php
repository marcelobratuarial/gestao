<?php

namespace App\Models\Lider\Select;

use CodeIgniter\Model;


class TabelaModel extends Model
{

    protected $DBGroup = 'lider';

    protected $table      = 'select_tabela';

    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['codeCategoria', 'valor_de', 'valor_ate', 'completo', 'colisaopp', 'colisaopt', 'roubofurto', 'incendio', 'adesao', 'desconto'];

    protected $useTimestamps = false;
}
