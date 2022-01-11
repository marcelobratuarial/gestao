<?php

namespace App\Models;


use CodeIgniter\Model;


class CidadesModel extends Model
{
    protected $table      = 'form_cidades';
    protected $primaryKey = 'id';
    protected $returnType     = 'object';
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
