<?php

namespace App\Controllers\Motorhome\Protecaoveicular;

use App\Controllers\Motorhome\BaseController;
use App\Models\Motorhome\ProtecaoVeicular\CategoriaModel;


class Categorias extends BaseController
{
	public function index()
	//LIST ALL
	{
		$data['produto'] = $this->produto;
		$data['path'] = $this->path;
		$data['tituloPagina'] = "Proteção Veicular";
		$data['subtituloPagina'] = "Categorias";

		$model = new CategoriaModel();
		$categorias = $model->findAll();
		$data['categoria']   = $categorias;

		return template("custom/$this->path/categoria/listar", $data);
	}

	public function adicionar()
	{
		$data['path'] = $this->path;
		$data['tituloPagina'] = "Proteção veicular";
		$data['subtituloPagina'] = "Categoria";

		return template("custom/$this->path/categoria/adicionar", $data);
	}
}
