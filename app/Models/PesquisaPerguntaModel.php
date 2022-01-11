<?php

namespace App\Models;
use CodeIgniter\Model;

class PesquisaPerguntaModel extends Model {

	protected $table = 'pesquisa_pergunta'; 

	protected $primaryKey = 'code';

	protected $returnType = 'object';
	protected $useSoftDeletes = true;

	protected $useTimestamps = true;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';

	protected $allowedFields = ['code','codeEmpresa','codePesquisa','pergunta','type','ordem'];

}
