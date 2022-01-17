<?php

namespace App\Models;
use CodeIgniter\Model;


class NewEmpresaModel extends Model
{

    protected $table      = 'new_empresa';

    protected $primaryKey = 'code';

    protected $allowedFields = ['code', 'codeStatus', 'codeUsuario', 'cnpj', 'razao_social', 'email', 'telefone', 'cep', 'logradouro', 'numero', 'complemento', 'cidade', 'uf', 'icone', 'apiKey', 'apiSecretKey'];

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


}