<?php

namespace App\Controllers\Motorhome\Protecaoveicular;

use App\Controllers\Motorhome\BaseController;
use App\Models\Motorhome\ProtecaoVeicular\CategoriaModel;
use App\Models\Motorhome\ProtecaoVeicular\TabelaModel;
use App\Models\Motorhome\ProtecaoVeicular\OpcionaisModel;


class Categoria extends BaseController
{

	public function _remap($code, $method = null, $id = null)
	{
		if ($method) :
			if ($id) :
				return $this->$method($id, $code);
			else :
				return $this->$method($code);
			endif;
		else :
			return redirect()->to(base_url($this->path . '/categoria/' . $code . '/configuracoes'));
		endif;
	}
	public function configuracoes($code = null)
	{
		$data['display'] = 'configuracoes';
		$data['code'] = $code;
		$data['path'] = $this->path;
		$data['tituloPagina'] = "Proteção veicular";

		//pega os dados da categoria
		$categoriaModel = new CategoriaModel();
		$categoria = $categoriaModel->where('code', $code)->first();
		if ($categoria == null) :
			return redirect()->to(base_url("$this->path"));
		endif;
		$data['categoria'] = $categoria;
		$data['subtituloPagina'] = $categoria->titulo;

		return template("custom/$this->path/categoria/editar", $data);
	}
	public function tabela($code = null)
	{
		$data['display'] = 'tabela';
		$data['code'] = $code;
		$data['path'] = $this->path;
		$data['tituloPagina'] = "Proteção veicular";

		//lista a tabela
		$tabelaModel = new TabelaModel();
		$tabela = $tabelaModel
			->where('codeCategoria', $code)
			->orWhere('codeCategoria', null)
			->orWhere('codeCategoria', '')
			->orderBy('valor_de', 'ASC')
			->findAll();
		$data['tabela'] = $tabela;
		$data['subtituloPagina'] = 'Tabela';

		return template("custom/$this->path/categoria/editar", $data);
	}
	public function opcionais($code = null)
	{
		$data['display'] = 'opcionais';
		$data['code'] = $code;
		$data['path'] = $this->path;
		$data['tituloPagina'] = "Proteção veicular";

		//lista a opcionais
		$opcionaisModel = new OpcionaisModel();
		$opcionais = $opcionaisModel
			->where('codeCategoria', $code)
			->orWhere('codeCategoria', null)
			->orderBy('titulo', 'ASC')
			->findAll();
		$data['opcionais']   = $opcionais;
		$data['subtituloPagina'] = 'Opcionais';
		//lista as categorias
		$categoriaModel = new CategoriaModel();
		$categorias = $categoriaModel->findAll();
		$data['categorias'] = $categorias;

		return template("custom/$this->path/categoria/editar", $data);
	}

	public function opcional($id_opcional, $code)
	{
		//lista as categorias
		$categoriaModel = new CategoriaModel();
		$categorias = $categoriaModel->findAll();
		$data['categorias'] = $categorias;

		// popular o opcional a ser editavel
		$opcionaisModel = new OpcionaisModel();
		$opcional = $opcionaisModel->where('id', $id_opcional)->first();
		$opcional = myJsonDecode($opcional);


		$data['opcional'] = $opcional;
		$data['display'] = 'opcional';
		$data['code'] = $code;
		$data['path'] = $this->path;
		$data['tituloPagina'] = "Proteção veicular";
		$data['subtituloPagina'] = $opcional->titulo;
		return template("custom/$this->path/categoria/editar", $data);
	}

}
