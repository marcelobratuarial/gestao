<?php

namespace App\Models\Lider\Select;

use CodeIgniter\Model;


class CategoriaModel extends Model
{

    protected $DBGroup    = 'lider';

    protected $table      = 'select_categoria';

    protected $primaryKey = 'code';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $allowedFields = ['apiRef', 'titulo', 'descricao', 'beneficio', 'agravo', 'cabecalho', 'rodape'];

    protected function code(array $data)
    {
        $data['data']['code'] = code();
        return $data;
    }

    protected $beforeInsert = ['code'];
}
