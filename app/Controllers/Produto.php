<?php

namespace App\Controllers;

use App\Models\ProdutoModel;

class Produto extends BaseController

{
	public function index()

	{
		$data['tituloPagina'] = "Produto";
		$data['subtituloPagina'] = "Lista";

		$produto = new ProdutoModel();

		$data['produtos'] = $produto->where('codeEmpresa', CODEEMPRESA)->findAll();

		// colunas que estarão disponiveis para exibição
		$data['colunas'] = array(
			'code' => '#REF',
			'nome' => 'Nome',
			'descricao' => 'Descrição',
			'tipo' => 'Tipo',
		);

		// pega os campos extras da tabela Cliente
		if ($camposExtras = camposExtras('produto')) :

			foreach ($camposExtras as $ce) :

				$colunasExtras[slug($ce)] = $ce;
			endforeach;

		else :
			$colunasExtras = array();
		endif;

		//$data['colunas'] = array_merge($colunas, $colunasExtras);

		$data['camposExtras'] = $camposExtras;


		return template('modules/produto/index', $data);
	}



	public function detalhe($code)

	{
		$data['tituloPagina'] = "Produto";
		$data['subtituloPagina'] = "Detalhe";
		
		

		$produto = new ProdutoModel();

		$produto = $produto->where('code', $code)->where('codeEmpresa', CODEEMPRESA)->first();
		if (!$produto) :
			setSwal('error', 'Ops!', 'Produto não encontrado');
			return redirect()->to(base_url('produto'));
		endif;

		if ($produto->tipo == 2) :
			return redirect()->to(base_url($produto->path));
		endif;
		$data['produto'] = $produto;

		template('modules/produto/index', $data);
	}



	public function adicionar()

	{
		$data['tituloPagina'] = "Produto";
		$data['subtituloPagina'] = "Adicionar";

		template('modules/produto/adicionar', $data);
	}

	public function contratar()

	{

		$data['tituloPagina'] = "Produto";
		$data['subtituloPagina'] = "Contratar";

		$model = new ProdutoModel();
		$data['produtos'] = $model->FindAll();

		template('modules/produto/contratar', $data);
	}

	public function configuracao($code)

	{
		$data['tituloPagina'] = "Produto";
		$data['subtituloPagina'] = "Configurar";

		$produto = new ProdutoModel();

		$produto = $produto->where('code', $code)->where('codeEmpresa', CODEEMPRESA)->first();
		if (!$produto) :
			setSwal('error', 'Ops!', 'Produto não encontrado');
			return redirect()->to(base_url('produto'));
		endif;

		$data['produto'] = $produto;

		// pega os campos extras da tabela Cliente
		if ($camposExtras = camposExtras('produto')) :

			foreach ($camposExtras as $ce) :

				$colunasExtras[slug($ce)] = $ce;
			endforeach;

		else :
			$colunasExtras = array();
		endif;

		//$data['colunas'] = array_merge($colunas, $colunasExtras);

		$data['camposExtras'] = $camposExtras;


		template('modules/produto/configurar', $data);
	}

	public function save()
	{
		$post = $this->request->getPost();
		v($post);

		$produtoModel = new ProdutoModel();
		if ($produtoModel->save($post)) :
			setSwal('success', 'Tudo certo!', 'Salvo com sucesso.');
			return redirect()->to(base_url('produto/configuracao/' . $post['code']));
		else :
			setSwal('error', 'Ops!', 'Temos um problema.');
			return redirect()->to(base_url('produto'));
		endif;
	}

	public function ativar($code)
	{
		//verificar se é admin
		$model = new ProdutoModel();
		$produto = $model->where('codeEmpresa', CODEEMPRESA)
			->where('code', $code)
			->first();

		if ($produto && permissao('statusProduto')) :
			$data['code'] = $code;
			$data['status'] = 1;
			$model->save($data);

		else :
			setSwal('error', 'Temos um problema', 'Você não tem permissão para executar essa ação.');
		endif;
		return redirect()->to(base_url('produto/configuracao/' . $code));
	}
	public function desativar($code)
	{
		//verificar se é admin
		$model = new ProdutoModel();
		$produto = $model->where('codeEmpresa', CODEEMPRESA)
			->where('code', $code)
			->first();
		if ($produto && permissao('statusProduto')) :
			$data['code'] = $code;
			$data['status'] = 2;
			$model->save($data);

		else :
			setSwal('error', 'Temos um problema', 'Você não tem permissão para executar essa ação.');
		endif;
		return redirect()->to(base_url('produto/configuracao/' . $code));
	}
}
