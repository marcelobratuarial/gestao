<?php

namespace App\Controllers;

use App\Models\ConfigModel;
use App\Models\ConfigdefaultModel;
use App\Models\EmpresaModel;
use App\Models\StatusModel;

class Configuracao extends BaseController
{
	public function index()
	{
		$data['tituloPagina'] = "Configurações";

		return template('modules/config/index', $data);
	}

	public function api($action = null)
	{
		$empresaModel = new EmpresaModel();
		$empresa = $empresaModel->where('code', CODEEMPRESA)->first();

		if (!$action) :
			$data['empresa']  = $empresa;
			$data['tituloPagina'] = "Configurações";
			$data['subtituloPagina'] = 'API';

			return template('modules/config/api', $data);
		else :
			$update['apiKey'] = base64_encode(password_hash(CODEEMPRESA, PASSWORD_DEFAULT));
			$update['apiSecretKey'] = base64_encode(password_hash(CODEEMPRESA . $empresa->created_at, PASSWORD_DEFAULT));

			$empresaModel->update(CODEEMPRESA, $update);
			return redirect()->to(base_url('configuracao/api'));
		endif;
	}

	public function geral()
	{
		$data['tituloPagina'] = "Configurações";
		$data['subtituloPagina'] = 'Gerais';

		$model = new ConfigModel();

		$gerais = $model->where('codeEmpresa', $_SESSION['usuarioEmpresa'])
			->where('categoria', 'geral')
			->findAll();

		$data['gerais'] = $gerais;

		return template('modules/config/index', $data);
	}
	public function nomenclaturas()
	{
		$data['tituloPagina'] = "Configurações";
		$data['subtituloPagina'] = 'Nomenclaturas';

		$nomenclaturas = new ConfigModel();

		$nomenclaturas = $nomenclaturas->where('codeEmpresa', $_SESSION['usuarioEmpresa'])
			->where('categoria', 'NOMENCLATURA')
			->findAll();

		$data['nomenclaturas'] = $nomenclaturas;

		return template('modules/config/nomenclaturas', $data);
	}
	public function reset($categoria = NULL)
	{
		$config = new ConfigModel();

		$nomenclaturas = new ConfigdefaultModel();
		$nomenclaturas = $nomenclaturas->where('categoria', $categoria)
			->findAll();

		foreach ($nomenclaturas as $n) {

			$config->where('code', $n->code)
				->delete();
			$config->purgeDeleted();

			$config->save([
				'valor' => $n->valor,
				'nome' => $n->nome,
				'descricao' => $n->descricao,
				'categoria' => $n->categoria,
				'code' => $n->code,
				'codeEmpresa' => $_SESSION['usuarioEmpresa']
			]);
		}

		return redirect()->back();
	}
	public function salvar()
	{
		$model = new ConfigModel();

		foreach ($_POST as $code => $valor) {

			$model->where('codeEmpresa', $_SESSION['usuarioEmpresa'])
				->where('code', $code)
				->set([
					'valor' => $valor
				])
				->update();
		}

		return redirect()->back();
	}
	function updateColor()
	{
		$empresa = new EmpresaModel();
		$data['code'] = $_SESSION['usuarioEmpresa'];
		$data['cor'] = $_POST['cor'];
		$_SESSION['empresaCor'] = $_POST['cor'];
		$empresa->save($data);
	}
	function updateTheme()
	{
		$empresa = new EmpresaModel();
		$data['code'] = $_SESSION['usuarioEmpresa'];
		$data['tema'] = $_POST['theme'];
		$_SESSION['empresaTema'] = $_POST['theme'];
		$empresa->save($data);
	}
	function changeLogo()
	{
		if ($imagefile = $this->request->getFiles()) :
			$img = $imagefile['logo'];
			if ($img->isValid() && !$img->hasMoved()) :
				$newName = $img->getRandomName();
				$img->move('./assets/uploads/', $newName);
				/* */
				$empresa = new EmpresaModel();
				$data['code'] = $_SESSION['usuarioEmpresa'];
				$data['logo'] = $newName;
				$_SESSION['empresaLogo'] = $newName;
				$empresa->save($data);
			endif;
		endif;
	}
	function removeLogo()
	{
		$empresa = new EmpresaModel();
		$data['code'] = $_SESSION['usuarioEmpresa'];
		$data['logo'] = null;
		$_SESSION['empresaLogo'] = null;
		$empresa->save($data);

		return redirect()->back();
	}
	function changeIcone()
	{
		if ($imagefile = $this->request->getFiles()) :
			$img = $imagefile['icone'];
			if ($img->isValid() && !$img->hasMoved()) :
				$newName = $img->getRandomName();
				$img->move('./assets/uploads/', $newName);
				/* */
				$empresa = new EmpresaModel();
				$data['code'] = $_SESSION['usuarioEmpresa'];
				$data['icone'] = $newName;
				$_SESSION['empresaIcone'] = $newName;
				$empresa->save($data);
			endif;
		endif;
	}
	function removeIcone()
	{
		$empresa = new EmpresaModel();
		$data['code'] = $_SESSION['usuarioEmpresa'];
		$data['icone'] = null;
		$_SESSION['empresaIcone'] = null;
		$empresa->save($data);

		return redirect()->back();
	}
	function adicionarCampoExtra($tabela)
	{
		$extra = $this->request->getPost('extra');
		if (trim($extra)) :
			$model = new ConfigModel();
			$config = $model->where('codeEmpresa', $_SESSION['usuarioEmpresa'])
				->where('categoria', 'COLUNASTABELAS')
				->where('nome', $tabela)
				->first();

			$data['codeEmpresa'] = $_SESSION['usuarioEmpresa'];
			$data['categoria'] = 'COLUNASTABELAS';
			$data['nome'] = $tabela;


			if ($config) :
				$valor = json_decode($config->valor, true);
				$data['code'] = $config->code;
			endif;

			$valor[] = $extra;
			$data['valor'] = json_encode($valor);

			$model->save($data);

		endif;
		return redirect()->back();
	}
	function atualizarCampoExtra($tabela)
	{
		// REORDENAR CAMPOS
		$config = new ConfigModel();

		$new_valor = json_encode($_POST['novaOrdem']);

		$config = new ConfigModel();
		$config = $config->where('codeEmpresa', $_SESSION['usuarioEmpresa'])
			->where('categoria', 'COLUNASTABELAS')
			->where('nome', $tabela)
			->set('valor', $new_valor)
			->update();
	}
	function apagarCampoExtra($tabela, $campo)
	{
		$config = new ConfigModel();
		$config = $config->where('codeEmpresa', $_SESSION['usuarioEmpresa'])
			->where('categoria', 'COLUNASTABELAS')
			->where('nome', $tabela)
			->first();
		$valor = json_decode($config->valor);
		$key = array_search($campo, $valor);
		if ($key !== false) {
			unset($valor[$key]);
		}

		$new_valor = json_encode($valor);

		$config = new ConfigModel();
		$config = $config->where('codeEmpresa', $_SESSION['usuarioEmpresa'])
			->where('categoria', 'COLUNASTABELAS')
			->where('nome', $tabela)
			->set('valor', $new_valor)
			->update();

		return redirect()->back();
	}
	function adicionarStatus($tabela)
	{
		if (trim($_POST['nome'])) :

			$data['code'] = code();
			$data['codeEmpresa'] = $_SESSION['usuarioEmpresa'];
			$data['tabela'] = $tabela;
			$data['tipo'] = 2;
			$data['nome'] = $_POST['nome'];
			$data['cor'] = $_POST['cor'];

			$status = new StatusModel();
			$status->insert($data);

		endif;

		return redirect()->back();
	}
	function atualizarStatus($tabela)
	{
		$num = 1;
		foreach ($_POST['novaOrdem'] as $o) :

			$data['ordem'] = $num;

			$status = new StatusModel();
			$status->update($o, $data);
			$num++;
		endforeach;
	}
	function apagarStatus($tabela, $code)
	{
		$status = new StatusModel();
		$result = $status->where('code', $code)
			->first();

		if ($result->tipo == 2) :
			$status->delete($code);
		endif;

		return $code;
	}
}
