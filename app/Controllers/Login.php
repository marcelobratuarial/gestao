<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Login extends BaseController
{
	public function index()
	{
		$dataToken = isset($_COOKIE['BPToken']) ? dataToken($_COOKIE['BPToken']) : null;
		if (isset($dataToken['success']) && $dataToken['success']) :
			return redirect()->to(base_url('login/auth'));
		endif;
		return view('modules/login/index');
	}
	public function auth()
	{

	
		
		if (!isset($_COOKIE['BPToken'])) :
			$post = $this->request->getBody();

			$api = \Config\Services::curlrequest();

			$return = $api->setBody($post)->request('POST', base_url('api/auth/login'), ['http_errors' => false]);

			$data = json_decode($return->getBody());
			$status = $return->getStatusCode();

			if ($data->success === false) :
				setSwal('error', 'Temos um problema!', $data->messages->password);
				return redirect()->to('/login');
			endif;
			$token = $data->access_token;
		else :
			$token = $_COOKIE['BPToken'];
		endif;
		$dataToken = dataToken($token);
		// dd($dataToken);

		$usuarioModel = new UsuarioModel();
		$result = $usuarioModel->find($dataToken['token']['codeUsuario']);

	
		
		if ($dataToken['success']) :
		
			$this->session->set('accessToken', $token);
			setcookie('BPToken', $token, strtotime(date('Y-m-d') . ' + 1 year'), '/');

			$_SESSION['usuarioNome'] = $result->nome;

			$_SESSION['usuarioCode'] = $result->code;

			$_SESSION['usuarioPermissoes'] = json_decode($result->permissoes, true);

			$_SESSION['usuarioEmpresa'] = CODEEMPRESA;

			$_SESSION['usuarioFilial'] = $result->codeFilial;

			$_SESSION['usuarioPerfil'] = getPerfil($result->perfil);

			$_SESSION['usuarioLogged'] = true;

			$_SESSION['empresaCor'] = NULL;

			$_SESSION['empresaLogo'] = LOGOEMPRESA;

			$_SESSION['empresaIcone'] = NULL;

			$_SESSION['empresaNome'] = NOMEEMPRESA;

		
			return redirect()->to(base_url());
		else :
			setSwal('error', 'Ops!', $data->messages->password);
			return redirect()->to(base_url('login'));
		endif;
	}
	// public function auth()
	// {
	// 	$modelUsuario = new LoginModel();
	// 	$empresaModel = new EmpresaModel();

	// 	$result = $modelUsuario->where('email', $_POST['email'])
	// 		->where('status', 1)
	// 		->first();

	// 	if ($result) :
	// 		if (password_verify($_POST['password'], $result->password)) :
	// 			$password = true;
	// 		else :
	// 			$password = false;
	// 		endif;

	// 		// salvar na sessao
	// 		if ($password) :

	// 			$_SESSION['usuarioNome'] = $result->nome;

	// 			$_SESSION['usuarioCode'] = $result->code;

	// 			$_SESSION['usuarioPermissoes'] = $result->permissoes;

	// 			$_SESSION['usuarioEmpresa'] = CODEEMPRESA;

	// 			$_SESSION['usuarioFilial'] = $result->codeFilial;

	// 			$_SESSION['usuarioPerfil'] = $result->perfil;

	// 			$_SESSION['usuarioLogged'] = true;

	// 			$_SESSION['empresaCor'] = NULL;

	// 			$_SESSION['empresaLogo'] = LOGOEMPRESA;

	// 			$_SESSION['empresaIcone'] = NULL;

	// 			$_SESSION['empresaNome'] = NOMEEMPRESA;

	// 			$accessCode = md5($result->code . date('ymdhis'));
	// 			$_SESSION['api']['accessCode'][$accessCode] = $result;

	// 			if(CODEEMPRESA == null):
	// 				return redirect()->to(base_url('superadmin/empresa'));
	// 			endif;

	// 			return redirect()->to(base_url());
	// 		else :
	// 			setSwal('error', 'Temos um problema', 'O Usuário e/ou senha informados estão incorretos');
	// 			return redirect()->to(base_url('login'));
	// 		endif;
	// 	else :
	// 		setSwal('error', 'Temos um problema', 'O Usuário e/ou senha informados estão incorretos');
	// 		return redirect()->to(base_url('login'));
	// 	endif;
	// }
	public function logout()
	{
		if (isset($_COOKIE['BPToken'])) :
			setcookie('BPToken', false, -1, '/');
			unset($_COOKIE['BPToken']);
		endif;
		session_destroy();

		return redirect()->to(base_url());
	}
	public function recuperarSenha()
	{
		return view('modules/login/recuperar');
	}
}
