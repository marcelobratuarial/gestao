<?php

namespace App\Models;

use CodeIgniter\Model;

class AssinaturaModel extends Model
{
	protected $table = 'assinatura_eletronica';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $useTimestamps = true;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';
	protected $allowedFields = [
		'code_empresa',
		'code_contrato',
		'identificador_usuario',
		'nomecompleto',
		'tipo_assinatura',
		'perfil',
		'status',
		'data_nascimento',
		'ip_Address',
		'email',
		'camposExtras'
	];
}
