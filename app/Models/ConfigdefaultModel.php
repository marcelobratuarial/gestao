<?php

namespace App\Models;


use CodeIgniter\Model;


class ConfigdefaultModel extends Model
{
    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    
    protected $table      = 'config_padrao';

    protected $primaryKey = 'id';


}