<?php

namespace App\Models;
use CodeIgniter\Model;

class SuporteModel extends Model {

	protected $table = 'suporte';

	protected $primaryKey = 'code';

	protected $returnType = 'object';
	protected $useSoftDeletes = true;

	protected $useTimestamps = true;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';

	protected $allowedFields = ['code', 'tipo', 'assunto', 'mensagem', 'codeEmpresa', 'codeUsuario', 'codeSuporte', 'statusUsuario', 'statusSuporte', 'closed', 'deleted_at'];

}
