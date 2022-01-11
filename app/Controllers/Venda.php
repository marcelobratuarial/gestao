<?php

namespace App\Controllers;

use App\Models\StatusModel;
use App\Models\VendaModel;
use App\Models\ConfigModel;


class Venda extends BaseController

{


	public function index()

	{

		$data['tituloPagina'] = "Vendas";
		$data['subtituloPagina'] = "Lista";

		$vendaModel = new VendaModel();
		$vendaModel->where('codeEmpresa', CODEEMPRESA);
		if (!permissao('ver_vendas')) :
			$vendaModel->where('codeUsuario', $_SESSION['usuarioCode']);
		endif;
		$data['vendas'] = $vendaModel->findAll();

		$data['status'] = getStatus('venda');

		$colunas = [
			'code' => '#REF',
			'nome' => 'Nome',
			'produto' => 'Produto'
		];


		// pega os campos extras da tabela Cliente
		if ($camposExtras = camposExtras('venda')) :

			foreach ($camposExtras as $ce) :

				$colunasExtras[slug($ce)] = $ce;

			endforeach;
		else :
			$colunasExtras = array();
		endif;

		$data['colunas'] = array_merge($colunas, $colunasExtras);


		$data['camposExtras'] = $camposExtras;

		return template('modules/venda/index', $data);
	}



	public function detalhe($codeLead)

	{
		$data['tituloPagina'] = "Venda";
		$data['subtituloPagina'] = "Detalhe";

		$vendas = new VendaModel();

		$data['status'] = new StatusModel();

		$data['venda'] = $vendas->minhasVendas();

		return template('modules/venda/detalhe', $data);
	}
}
