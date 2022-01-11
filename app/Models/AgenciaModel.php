<?php

namespace App\Models;
use CodeIgniter\Model;


class AgenciaModel extends Model
{

    protected $table      = 'agencia';

    protected $primaryKey = 'code';

	protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

	

}