<?php

namespace App\Models;


use CodeIgniter\Model;


class EstadosModel extends Model
{
    protected $table      = 'form_estados';
    protected $primaryKey = 'id';
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
