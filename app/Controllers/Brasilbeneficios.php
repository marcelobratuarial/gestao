<?php

namespace App\Controllers;

use App\Models\ProdutoModel;

class Brasilbeneficios extends BaseController

{
	public function index()

	{
		$data['tituloPagina'] = "Brasil Benefícios ";
		$data['subtituloPagina'] = "Produtos";

		$produto = new ProdutoModel();

		$data['produtos'] = $produto->where('codeEmpresa', CODEEMPRESA)->where('tipo',1)->findAll();


		return template('modules/brasilbeneficios/produtos', $data);
	}
	
	public function configuracao($code)

	{
		$data['tituloPagina'] = "Produto";
		$data['subtituloPagina'] = "Configurar";

		$produto = new ProdutoModel();

		$produto = $produto->where('code', $code)->where('codeEmpresa', CODEEMPRESA)->first();

		$data['produto'] = $produto;

		template('modules/brasilbeneficios/configurar', $data);
	}




}
