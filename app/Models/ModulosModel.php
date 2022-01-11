<?php

namespace App\Models;

use CodeIgniter\Model;

class ModulosModel extends Model {

	protected $table = 'modulo';

	protected $primaryKey = 'code';

	protected $returnType = 'object';
	protected $useSoftDeletes = true;

	protected $useTimestamps = true;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';
	
	protected $allowedFields = ['code', 'icone', 'ordem', 'nome', 'pai'];


}
