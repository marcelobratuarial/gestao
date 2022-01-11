<?php

namespace App\Models;
use CodeIgniter\Model;

class MeusProdutosModel extends Model {

	protected $table = 'meusprodutos';

	protected $primaryKey = 'code';

	protected $returnType = 'object';
	protected $useSoftDeletes = true;

	protected $useTimestamps = true;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';

	public function meusProdutos($codeEmpresa = NULL) {

		if ($codeEmpresa == NULL && isset($_SESSION['usuarioEmpresa'])) {

			return $this -> where('codeEmpresa', $_SESSION['usuarioEmpresa']) -> findAll();

		} else {

			return $this -> where('codeEmpresa', $codeEmpresa) -> findAll();

		}

	}

}
