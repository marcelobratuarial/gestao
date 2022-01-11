<?php

namespace App\Controllers;

use App\Models\LoginModel;
use App\Models\EmpresaModel;
use App\Models\ProdutoModel;
use App\Models\AgenciaModel;
use App\Models\FilialModel;
use App\Models\PerfilModel;
use App\Models\StatusModel;
use App\Models\UsuarioModel;

class Superadmin extends BaseController
{

	public function empresa()
	{
		$model = new EmpresaModel();

		$data['empresas'] = $model->findAll();

		$data['tituloPagina'] = "Superadmin";
		$data['subtituloPagina'] = "Empresas";
		return template('modules/superadmin/empresa', $data);
	}

	public function adicionar_empresa()
	{
		$model = new EmpresaModel();

		$data['empresas'] = $model->findAll();

		$data['tituloPagina'] = "Superadmin";
		$data['subtituloPagina'] = "Empresas";
		return template('modules/superadmin/adicionar-empresa', $data);
	}

	public function save_empresa()
	{

		$post = $this->request->getPost();

		// create empresa
		$empresaModel = new EmpresaModel();
		$insert['nome'] = $post['nome'];
		$insert['dominio'] = $post['dominio'];
		$insert['slug'] = explode('.', $post['dominio'])[0];
		$insert['status'] = 1;
		$insert['code'] = code();
		$empresa['code'] = $insert['code'];
		// insert
		echo "<script>console.log('Criando empresa...')</script>";
		d($insert);
		$empresaModel->protect(false)->insert($insert);

		echo "<script>console.log('Empresa criada.')</script>";
		// find (ATUALIZAR EMPRESA)
		// $empresa = (array) $empresaModel->where('code', $insert['code'])->first();
		// echo "<script>console.log('Atualizando empresa...')</script>";
		// $data['apiKey'] = base64_encode(password_hash($empresa['code'], PASSWORD_DEFAULT));
		// $data['apiSecretKey'] = base64_encode(password_hash($empresa['code'] . $empresa['created_at'], PASSWORD_DEFAULT));
		// update
		// d($data);
		// $empresaModel->update($empresa['code'], $data);

		echo "<script>console.log('Empresa atualizada.')</script>";

		echo "<script>console.log('Criando filial...')</script>";
		// create filial
		$filialModel = new FilialModel();
		$filial['code'] = code();
		$filial['codeEmpresa'] = $empresa['code'];
		$filial['nome'] = "Matriz";
		$filial['endereco'] = $post['endereco_filial'];
		$filial['email'] = $post['email_filial'];
		$filial['telefone'] = $post['telefone_filial'];
		$filial['status'] = 1;
		$filial['tipo'] = 1;
		// insert
		d($filial);
		$filialModel->insert($filial);
		echo "<script>console.log('Filial criada.')</script>";

		echo "<script>console.log('Criando perfil...')</script>";
		// create admin perfil
		$perfilModel = new PerfilModel();
		$perfil['code'] = code();
		$perfil['codeEmpresa'] = $empresa['code'];
		$perfil['nome'] = 'Administrador do sistema';
		$perfil['permissoes'] = json_encode(array('admin'));
		$perfil['tipo'] = 'admin';
		// insert
		d($perfil);
		$perfilModel->insert($perfil);
		echo "<script>console.log('Perfil criado.')</script>";

		echo "<script>console.log('Criando status...')</script>";
		// create status
		$statusModel = new StatusModel();

		$k = 0; // lead inicial
		$status[$k]['tabela'] = 'lead';
		$status[$k]['code'] = 'inicial';
		$status[$k]['tipo'] = 1;
		$status[$k]['nome'] = 'Aguardando';
		$status[$k]['cor'] = 'transparent';
		$status[$k]['codeEmpresa'] = $empresa['code'];
		$k = 1; // lead final
		$status[$k]['tabela'] = 'lead';
		$status[$k]['code'] = 'final';
		$status[$k]['tipo'] = 3;
		$status[$k]['nome'] = 'Proposta gerada';
		$status[$k]['cor'] = 'success';
		$status[$k]['codeEmpresa'] = $empresa['code'];
		$k = 2; // proposta incial
		$status[$k]['tabela'] = 'proposta';
		$status[$k]['code'] = 'inicial';
		$status[$k]['tipo'] = 1;
		$status[$k]['nome'] = 'Aguardando';
		$status[$k]['cor'] = 'transparent';
		$status[$k]['codeEmpresa'] = $empresa['code'];
		$k = 3; // proposta final
		$status[$k]['tabela'] = 'proposta';
		$status[$k]['code'] = 'final';
		$status[$k]['tipo'] = 3;
		$status[$k]['nome'] = 'Proposta aceita';
		$status[$k]['cor'] = 'success';
		$status[$k]['codeEmpresa'] = $empresa['code'];
		$k = 4; // venda incial
		$status[$k]['tabela'] = 'venda';
		$status[$k]['code'] = 'inicial';
		$status[$k]['tipo'] = 1;
		$status[$k]['nome'] = 'Aguardando pagamento';
		$status[$k]['cor'] = 'transparent';
		$status[$k]['codeEmpresa'] = $empresa['code'];
		$k = 5; // venda final
		$status[$k]['tabela'] = 'venda';
		$status[$k]['code'] = 'final';
		$status[$k]['tipo'] = 3;
		$status[$k]['nome'] = 'Venda concluída';
		$status[$k]['cor'] = 'success';
		$status[$k]['codeEmpresa'] = $empresa['code'];
		// insert
		foreach ($status as $s) :
			d($s);
			$statusModel->insert($s);
		endforeach;
		echo "<script>console.log('Status criados.')</script>";

		echo "<script>console.log('Criando usuário...')</script>";
		// create user
		$userModel = new UsuarioModel();
		$user['codeEmpresa'] = $empresa['code'];
		$user['codeFilial'] = json_encode(array($filial['code']));
		$user['cpf'] = $post['userIf'];
		$user['nome'] = $post['nome_usuario'];
		$user['email'] = $post['email_usuario'];
		$user['telefone'] = $post['telefone_usuario'];
		$user['password'] = date('dmy');
		$user['perfil'] = $perfil['code'];
		$user['permissoes'] = $perfil['permissoes'];
		$user['status'] = 1;
		d($user);
		$userModel->insert($user);
		echo "<script>console.log('Usuário criado.')</script>";

		// die();
		setSwal('success', 'Tudo certo!', 'Empresa adicionada com sucesso.');
		return redirect()->to(base_url('login/logout'));
	}

	public function beneficios()
	{

		$model = new ProdutoModel();
		$data['produtos'] = $model->FindAll();

		$data['tituloPagina'] = "Superadmin";
		$data['subtituloPagina'] = "Benefícios Brasil Atuarial";


		return template('modules/superadmin/beneficios', $data);
	}

	public function agencia()
	{

		$model = new AgenciaModel();
		$data['produtos'] = $model->FindAll();

		$data['tituloPagina'] = "Superadmin";
		$data['subtituloPagina'] = "Agência";


		return template('modules/superadmin/agencia', $data);
	}

	public function selecionarEmpresa($code)
	{
		$empresaModel = new EmpresaModel();
		$empresa = $empresaModel->where('code', $code)->first();
		return redirect()->to($empresa->dominio);
	}

	public function logout()
	{
		session_destroy();

		return redirect()->to(base_url());
	}

	public function recuperarSenha()
	{

		return view('modules/login/recuperar');
	}
}
