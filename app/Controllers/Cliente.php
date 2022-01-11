<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\StatusModel;

class Cliente extends BaseController
{

	///ME CHAMAR PRA MOSTRAR COMO FAZ/FUNCIONA OS CAMPOS EXTRAS

	public function index()
	{
		$data['tituloPagina'] =  ucfirst(customWord('cliente', true));
		$data['subtituloPagina'] = "Lista";

		$cliente = new ClienteModel();

		$data['cliente'] = $cliente->where('codeEmpresa', $_SESSION['usuarioEmpresa'])->findAll();

		$data['status'] = new StatusModel();

		// colunas que estarão disponiveis para exibição
		$colunas  = array('code' => '#REF', 'nome' => 'Nome', 'email' => 'E-mail', 'telefone' => 'Telefone', 'codeFilial' => 'Filial', 'perfil' => 'Perfil');

		// pega os campos extras da tabela Cliente
		if ($camposExtras = camposExtras('cliente')) :

			foreach ($camposExtras as $ce) :

				$colunasExtras[slug($ce)] = $ce;

			endforeach;
		else :
			$colunasExtras = array();
		endif;

		$data['colunas'] = array_merge($colunas, $colunasExtras);



		$data['camposExtras'] = $camposExtras;

		return template('modules/cliente/index', $data);
	}

	public function detalhe($code)
	{

		$data['tituloPagina'] = ucfirst(customWord('cliente', false));
		$data['subtituloPagina'] = "Detalhe";

		$model = new ClienteModel();

		$result = $model->where('code', $code)->findAll();

		$data['cliente'] = $result[0];

		return template('modules/cliente/detalhe', $data);
	}

	public function adicionar()
	{

		$data['tituloPagina'] = ucfirst(customWord('cliente', false));
		$data['subtituloPagina'] = "Adicionar";

		return template('modules/cliente/adicionar', $data);
	}

	public function save()
	{

		$model = new ClienteModel();

		$data = $this->request->getPost();
		if (isset($data['code'])) :
			$action = 'update';
		else :
			$data['code'] = code();
			$action = 'insert';
			$usuario = $model->where('cpf', $data['cpf'])->first();
			if ($usuario) :
				setSwal('error', 'Ops!', 'Este cpf já foi cadastrado em outra conta.');
				return redirect()->to(base_url('cliente/adcionar'));
			endif;
		endif;

		$data['codeEmpresa'] = $_SESSION['usuarioEmpresa'];
		$data['camposExtras'] = json_encode($data['camposExtras']);

		if ($action == 'insert') :
			$model->insert($data);
			setSwal('success', 'Tudo certo!', 'Cliente adicionado com sucesso.');
		elseif ($action == 'update') :
			$model->update($data);
			setSwal('success', 'Tudo certo!', 'O cliente foi atualizado.');
		endif;
		return redirect()->to(base_url('cliente'));
	}

	public function colunas()
	{

		$model = new ClienteModel();

		$colunas = "";

		foreach ($_POST['colunas'] as $k => $v) {

			$colunas .= $k . ",";
		}

		$coluna = 'tabela' . $_POST['tabela'];

		$model->where('code', $_SESSION['usuarioCode'])->set([$coluna => $colunas])->update();

		return redirect()->to(base_url('cliente'));
	}

	public function filtroRapido($tabela, $condicao, $valor)
	{

		$_SESSION['filtro' . ucfirst($tabela)] = array($condicao => $valor);

		return redirect()->to(base_url($tabela));
	}

	public function removerFiltro($tabela)
	{

		unset($_SESSION['filtro' . ucfirst($tabela)]);

		return redirect()->to(base_url($tabela));
	}
}
