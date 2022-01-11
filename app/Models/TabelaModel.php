<?php

namespace App\Models;
use CodeIgniter\Model;


class TabelaModel extends Model
{

    protected $table            = 'tabela';

    protected $primaryKey       = 'id';

    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $deletedField     = 'deleted_at';
	
	protected $allowedFields    = ['codeUsuario','tabela','campos','created_at','updated_at','deleted_at'];


}