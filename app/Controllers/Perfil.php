<?php

namespace App\Controllers;

use App\Models\PerfilModel;
use App\Models\PermissaoModel;
use App\Models\UsuarioModel;

class Perfil extends BaseController
{

	public function index()
	{
		$data['tituloPagina'] = "Perfil";
		$data['subtituloPagina'] = "Lista";

		$model = new PerfilModel();

		$perfis = $model->select('*, (select count(usuario.code) from usuario where usuario.perfil = perfil.code and usuario.codeEmpresa = perfil.codeEmpresa) as totalUsuarios')->where('codeEmpresa', $_SESSION['usuarioEmpresa'])->FindAll();

		$data['perfis'] = $perfis;

		$colunas = array(
			'code' => '#REF',
			'nome' => 'Nome',
			'totalUsuarios' => 'Total Usuários'
		);

		if ($camposExtras = camposExtras('lead')) :

			foreach ($camposExtras as $ce) :
				$colunasExtras[slug($ce)] = ucfirst($ce);
			endforeach;

		else :
			$colunasExtras = array();
		endif;

		$data['colunas'] = array_merge($colunas, $colunasExtras);

		$data['camposExtras'] = $camposExtras;

		return template('modules/perfil/index', $data);
	}

	public function detalhe($codePerfil)
	{
		$data['tituloPagina'] = "Perfil";
		$data['subtituloPagina'] = "Detalhe";

		$perfil = new PerfilModel();

		$result = $perfil->where('code', $codePerfil)->First();

		$data['perfil'] = $result;

		return template('modules/perfil/detalhe', $data);
	}

	public function adicionar()
	{

		$model = new PermissaoModel();
		$data['permissoes'] = $model->findAll();

		$data['tituloPagina'] = "Perfil";
		$data['subtituloPagina'] = "Adicionar";

		return template('modules/perfil/adicionar', $data);
	}

	public function save()
	{

		$model = new PerfilModel();

		$data = $this->request->getPost();
		if (isset($data['code'])) :
			$action = 'update';
		else :
			$data['code'] = code();
			$action = 'insert';
			$perfil = $model->where('nome', $data['nome'])->where('codeEmpresa', $_SESSION['usuarioEmpresa'])->first();
			if ($perfil) :
				setSwal('error', 'Ops!', 'Já existe um perfil com este nome.');
				return redirect()->to(base_url('perfil'));
			endif;
		endif;

		$data['codeEmpresa'] = $_SESSION['usuarioEmpresa'];
		$data['permissoes'] = (isset($data['permissoes'])) ? json_encode($data['permissoes']) : null;

		if ($action == 'insert') :
			$model->insert($data);
			setSwal('success', 'Tudo certo!', 'Perfil adicionado com sucesso.');
		elseif ($action == 'update') :
			$model->save($data);
			setSwal('success', 'Tudo certo!', 'O perfil foi atualizado.');
		endif;
		return redirect()->to(base_url('perfil/detalhe/' . $data['code']));
	}

	public function changeStatus($code, $status)
	{
		$model = new PerfilModel();
		$data['code'] = $code;
		$data['status'] = ($status == 1) ? 2 : 1;
		$model->save($data);
		return redirect()->to(base_url('perfil'));
	}


	public function excluir($code)
	{
		$usuariosModel = new UsuarioModel();
		$usuarios = $usuariosModel->where('perfil', $code)->findAll();
		$totalUsuarios = count($usuarios);

		$perfilModel = new PerfilModel();
		$perfil = $perfilModel->where('codeEmpresa', CODEEMPRESA)->where('code', $code)->first();

		if ($totalUsuarios > 0 || $perfil->tipo == 1) :
			setSwal('error', 'Temos um problema', 'Esse perfil não pode ser excluído.');
		elseif ($perfil && permissao('excluir_perfil')) :
			setSwal('success', 'Tudo certo', 'Perfil excluído com sucesso.');
			$perfilModel->delete($code);
		else :
			setSwal('error', 'Temos um problema', 'Esse Perfil não existe ou você não tem permissão para executar essa ação.');
		endif;
		return redirect()->to(base_url('perfil'));
	}
}
