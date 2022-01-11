<?php

namespace App\Models;
use CodeIgniter\Model;

class PesquisaOpcaoModel extends Model {

	protected $table = 'pesquisa_opcao'; 

	protected $primaryKey = 'code';

	protected $returnType = 'object';
	protected $useSoftDeletes = true;

	protected $useTimestamps = true;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';

	protected $allowedFields = ['code','codeEmpresa','codePergunta','opcao'];

}
