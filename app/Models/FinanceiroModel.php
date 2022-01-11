<?php

namespace App\Models;
use CodeIgniter\Model;


class FinanceiroModel extends Model
{

    protected $table      = 'financeiro';

    protected $primaryKey = 'code';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


}