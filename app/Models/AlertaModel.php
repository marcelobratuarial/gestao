<?php

namespace App\Models;

use CodeIgniter\Model;

class AlertaModel extends Model
{
	protected $table = 'alertas';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $useTimestamps = true;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';
	protected $allowedFields = [
		'codeEmpresa',
		'codeUsuario',
		'mensagem',
		'status',
	];
}
