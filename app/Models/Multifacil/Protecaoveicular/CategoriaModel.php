<?php

namespace App\Models\Multifacil\Protecaoveicular;

use CodeIgniter\Model;


class CategoriaModel extends Model
{

    protected $DBGroup    = 'multifacil';

    protected $table      = 'combos_categoria';

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
