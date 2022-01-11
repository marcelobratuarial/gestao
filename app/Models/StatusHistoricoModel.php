<?php

namespace App\Models;

use CodeIgniter\Model;

class StatusHistoricoModel extends Model
{
	protected $table = 'status_historico';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $useTimestamps = false;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';
	protected $allowedFields = [
		'tabela',
		'codeRef',
		'codeUsuario',
		'codeStatus',
		'mensagem'
	];
}
