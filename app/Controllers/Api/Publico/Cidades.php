<?php

namespace App\Controllers\Api\Publico;

use App\Models\CidadesModel;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Cidades extends ResourceController
{

	use ResponseTrait;

	public function index()
	{
	}
	public function show($id = null)
	{		
		$cidadesModel = new CidadesModel();
		$cidades = $cidadesModel->where('uf', $id)->findAll();
		return $this->respond($cidades, 200);
	}
}
