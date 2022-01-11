<?php

namespace App\Models;

use CodeIgniter\Model;

class PropostaModel extends Model
{
	protected $table = 'proposta';
	protected $primaryKey = 'code';
	protected $returnType = 'object';
	protected $useSoftDeletes = true;
	protected $useTimestamps = true;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';
	protected $allowedFields = [
		'codeEmpresa',
		'codeUsuario',
		'codeProduto',
		'codeFilial',
		'dadosProposta',
		'codigoSeguranca',
		'pagamento',
		'termos',
		'documentos',
		'vistoria',
		'assinada',
		'email',
		'status',
		'code',
		'deleted_at',
		'codigo_email',
		'new_create',
		'documento_correcao',
		'vistoria_correcao',
		'vistoria_video'
	];

	protected $afterFind = ['propostaDate'];
	protected function propostaDate(array $data)
	{
		// dd($data['data']);
		if (isset($data['data']) && $data['data']) :
			// dd($data);
			// $data['data']['created_at'] = (isset($data['data']['new_create'])) ? $data['data']['new_create'] : $data['data']['created_at'];
			if (is_array($data['data'])) :
				foreach ($data['data'] as $k => $d) :
					$data['data'][$k]->created_at = (isset($d->new_create)) ? $d->new_create : $d->created_at;
				endforeach;
			elseif (isset($data['data']->created_at)) :
				// dd($data);
				$data['data']->created_at = (isset($data['data']->new_create)) ? $data['data']->new_create : $data['data']->created_at;
			else :
			// dd($data);
			endif;
			// dd($data);
			return $data;
		else :
			return $data;
		endif;
	}
}
