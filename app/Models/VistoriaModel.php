<?php

namespace App\Models;

use CodeIgniter\Model;

class VistoriaModel extends Model
{
	protected $table = 'vistoria_files';
	protected $primaryKey = 'id';
	protected $returnType = 'array';
	protected $useSoftDeletes = false;
	protected $useTimestamps = true;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';
	protected $allowedFields = [
		'etapa',
		'codeEmpresa',
		'codeUsuario',
		'codeProposta',
		'nomeArquivo',
		'status',
		'motivo_rejeicao',
		'geolocalizacao'
	];
}
