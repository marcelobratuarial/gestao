<?php

namespace App\Controllers\Motorhome\Protecaoveicular;

use App\Controllers\Motorhome\BaseController;
use App\Models\Motorhome\ProtecaoVeicular\CategoriaModel;
use App\Models\Motorhome\ProtecaoVeicular\TabelaModel;
use App\Models\Motorhome\ProtecaoVeicular\OpcionaisModel;


class Dashboard extends BaseController
{
	public function geraTabela()
	{
		$valores = "R$ 78.11
		R$ 81.67
		R$ 85.86
		R$ 90.04
		R$ 93.75
		R$ 97.45
		R$ 102.05
		R$ 105.92
		R$ 109.21
		R$ 146.66
		R$ 155.81
		R$ 161.02
		R$ 168.65
		R$ 164.10
		R$ 170.54
		R$ 176.55
		R$ 183.57
		
		";

		$tabelaModel = new TabelaModel();
		$ate = 4000;
		$valores = explode("\n", $valores);
		foreach ($valores as $k => $v) :
			$r = trim(str_replace('R$', '', $v));
			$r = str_replace(',', '', $r);
			if ($r) :
				$result[$k]['codeCategoria'] = 'B211RB948H243';
				$result[$k]['mensalidade'] = $r;
				$result[$k]['valor_ate'] =  $ate + $k * 1000;
				$result[$k]['valor_de'] = $k == 0 ? 1 : $result[$k]['valor_ate'] - 1000;
			endif;
		endforeach;
		foreach ($result as $r) :
			v($r);
			// $tabelaModel->insert($r);
		endforeach;
	}
	public function index()
	//LIST ALL
	{
		return redirect()->to(base_url($this->path . "/categorias"));
	}
	public function categoria($display, $code = null)

	{
		if ($code == null) :
			$code = $display;
			return redirect()->to(base_url("$this->path/categoria/configuracoes/$code"));
		endif;
		$data['display'] = $display;
		$data['code'] = $code;
		$data['path'] = $this->path;
		$data['tituloPagina'] = "Proteção veicular";

		switch ($display):
			case "configuracoes":
				//pega os dados da categoria
				$categoriaModel = new CategoriaModel();
				$categoria = $categoriaModel->where('code', $code)->first();
				if ($categoria == null) :
					return redirect()->to(base_url("$this->path"));
				endif;
				$data['categoria'] = $categoria;
				$data['subtituloPagina'] = $categoria->titulo;
				break;
			case "tabela":
				//lista a tabela
				$tabelaModel = new TabelaModel();
				$tabela = $tabelaModel
					->where('codeCategoria', $code)
					->orWhere('codeCategoria', null)
					->orderBy('valor_de', 'ASC')
					->findAll();
				$data['tabela'] = $tabela;
				$data['subtituloPagina'] = 'Tabela';
				break;
			case 'opcionais':
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
				break;
		endswitch;



		return template("custom/$this->path/categoria/editar", $data);
	}

	public function save($tabela)
	{
		$post = $this->request->getPost();
		$post = array_filter($post);
		switch ($tabela):
			case "categoria":
				$model = new CategoriaModel();
				break;
			case "opcionais":
				$model = new OpcionaisModel();
				if ($post['options'][0]['titulo']) :
					$post['options'] = array_filter($post['options']);
					$post['options'] = json_encode(array_values($post['options']));
				else :
					unset($post['options']);
				endif;
				if ($post['tipo'] == 'oculto' || $post['tipo'] == 'checkbox') :
					$post['options'] = null;
				endif;
				$post['slug'] = slug($post['titulo']);
				break;
			case "tabela":
				$model = new TabelaModel();
				break;
		endswitch;

		//dd($post);
		if (isset($post['linha'])) :
			foreach ($post['linha'] as $k => $p) :
				$model->save($p);
			endforeach;
		else :
			$model->save($post);
		endif;
		setSwal('success', 'Tudo certo!', 'Dados salvos com sucesso.');
		return redirect()->back();
	}

	public function editar_opcional($id_opcional)
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
		$data['code'] = null;
		$data['path'] = $this->path;
		$data['tituloPagina'] = "Proteção veicular";
		$data['subtituloPagina'] = $opcional->titulo;
		return template("custom/$this->path/categoria/editar", $data);
	}



	public function adicionar_categoria()
	{
		$data['path'] = $this->path;
		$data['tituloPagina'] = "Proteção veicular";
		$data['subtituloPagina'] = "Categoria";

		return template("custom/$this->path/categoria/adicionar", $data);
	}
}
