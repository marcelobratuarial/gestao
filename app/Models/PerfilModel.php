<?php

namespace App\Models;

use CodeIgniter\Model;

class PerfilModel extends Model {

	protected $table = 'perfil';

	protected $primaryKey = 'code';

	protected $returnType = 'object';
	protected $useSoftDeletes = true;

	protected $useTimestamps = true;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';

	protected $allowedFields = ['code', 'codeEmpresa', 'nome', 'permissoes', 'status', 'tipo'];

}
