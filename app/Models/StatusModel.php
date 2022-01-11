<?php

namespace App\Models;

use CodeIgniter\Model;

class StatusModel extends Model {

	protected $table = 'status';

	protected $primaryKey = 'code';

	protected $returnType = 'object';
	protected $useSoftDeletes = true;

	protected $useTimestamps = true;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';

	protected $allowedFields = ['code', 'nome', 'cor', 'codeEmpresa', 'tabela', 'tipo', 'ordem'];

	public function getStatus($code, $field = 'nome') {
		//Retorna um status
		$return = $this -> where('code', $code) -> first();
		return $return -> $field;
	}

	public function MeusStatus($tabela) {

		//Todas as status da empresa

		return $this -> where('codeEmpresa', $_SESSION['usuarioEmpresa']) -> where('tabela', $tabela) -> orderBy('tipo', 'ASC') -> orderBy('ordem', 'ASC') -> findAll();
	}

}
