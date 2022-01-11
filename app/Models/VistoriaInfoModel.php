<?php

namespace App\Models;

use CodeIgniter\Model;

class VistoriaInfoModel extends Model
{
	protected $table = 'vistoria_info';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $useTimestamps = true;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';
	protected $allowedFields = [
		'code_empresa',
		'etapa',
		'titulo',
		'foto',
		'instrucoes',
		'tipo_arquivo'
	];
}
