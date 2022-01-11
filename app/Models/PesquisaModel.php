<?php

namespace App\Models;
use CodeIgniter\Model;

class PesquisaModel extends Model {

	protected $table = 'pesquisa';

	protected $primaryKey = 'code';

	protected $returnType = 'object';
	protected $useSoftDeletes = true;

	protected $useTimestamps = true;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';

	protected $allowedFields = ['code','codeEmpresa','codeCategoria','nome','descricao','status'];

}
