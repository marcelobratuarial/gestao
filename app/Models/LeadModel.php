<?php

namespace App\Models;

use CodeIgniter\Model;

class LeadModel extends Model
{
	protected $table = 'lead';
	protected $primaryKey = 'code';
	protected $returnType = 'object';
	protected $useSoftDeletes = true;
	protected $useTimestamps = true;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';
	protected $allowedFields = [
		'code',
		'codeEmpresa',
		'codeUsuario',
		'codeProduto',		
		'codeStatus',
		'nome',
		'email',
		'telefone',		
		'origem',
		'camposExtras',
		'ipAddress',
		'observacoes',
	];
	public function MeusLeads($status = 'all')
	{
		$db = \Config\Database::connect();
		$builder = $db->table('lead');
		// Todas as leads da empresa

		$builder->select('*');
		$builder->orderBy('created_at', 'DESC');

		$builder->groupStart();
		$builder->where('codeUsuario', $_SESSION['usuarioCode']);

		// if (permissao('leadsFilial')) :
		// 	foreach (json_decode($_SESSION['usuarioFilial']) as $filial) :
		// 		$builder->orWhere('codeFilial', $filial);
		// 	endforeach;
		// endif;

		if (permissao('leadsEmpresa')) :
			$builder->orWhere('codeEmpresa', $_SESSION['usuarioEmpresa']);
		endif;

		$builder->groupEnd();

		if ($status != 'all') :
			$builder->where('status', $status);
		endif;

		$query = $builder->get();
		return $query->getResult();
	}
}
