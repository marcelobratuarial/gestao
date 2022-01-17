<?php

namespace App\Models;
use CodeIgniter\Model;


class ContatoModel extends Model
{

    protected $table      = 'contatos_new_empresa';

    protected $primaryKey = 'code';

    protected $allowedFields = ['code', 'codeEmpresa', 'nome', 'email', 'telefone', 'celular', 'whatsapp', 'notes'];

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


}