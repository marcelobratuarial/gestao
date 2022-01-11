<?php

namespace App\Models;

use CodeIgniter\Model;

class ModulosEmpresaModel extends Model {

	protected $table = 'modulos_empresa';

	protected $primaryKey = 'code';

	protected $returnType = 'object';
	protected $useSoftDeletes = true;

	protected $useTimestamps = true;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';
	
	protected $allowedFields = ['code','codeEmpresa','codeModulo', 'icone', 'ordem', 'nome', 'pai', 'status'];

}
