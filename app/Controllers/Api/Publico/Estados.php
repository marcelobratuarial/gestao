<?php

namespace App\Controllers\Api\Publico;

use App\Controllers\ApiBaseController;
use App\Models\EstadosModel;

use CodeIgniter\API\ResponseTrait;

class Estados extends ApiBaseController
{

	use ResponseTrait;

	public function index()
	{
		$estadosModel = new EstadosModel();
		$estados = $estadosModel->findAll();
		return $this->respond($estados, 200);
	}
}
