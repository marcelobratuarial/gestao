<?php

namespace App\Models;
use CodeIgniter\Model;

class PesquisaCategoriaModel extends Model {

	protected $table = 'pesquisa_categoria'; 

	protected $primaryKey = 'code';

	protected $returnType = 'object';
	protected $useSoftDeletes = true;

	protected $useTimestamps = true;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';

	protected $allowedFields = ['code','codeEmpresa','nome','descricao','status'];

}
