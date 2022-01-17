<?php


function code()
{

	$letras = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'X', 'W', 'Z');

	$code = $letras[rand(0, 22)] . date('yj') . $letras[rand(0, 22)] . $letras[rand(0, 22)] . date('ns') . $letras[rand(0, 22)] . date('z');

	return $code;
}
// function checkAuth()
// {
// 	helper('jwt');
// 	$result = (object) dataToken($_SESSION['accessToken']);
// }
function checkAuth()
{
	$session = \Config\Services::session();
	helper('jwt');
	if (dataToken($session->accessToken)) {

		//logado

	} else {

		$uri = current_url(true);
		if ($uri->getSegment(1) != "login") {
			echo '<meta http-equiv="refresh" content="0; URL=\'' . base_url('login') . ' \'"/>';
		}
	}
}

function permissao($acesso, $redirect = false)
{
	if (isset($_SESSION['usuarioPerfil'])) :
		$perfil = $_SESSION['usuarioPerfil'];
		if (isset($_SESSION['usuarioPermissoes']) || $perfil->tipo == 'superadmin') :
			$permissoes = $_SESSION['usuarioPermissoes'];

			if ($perfil->tipo == 'superadmin' || ($perfil->tipo == 'admin' && $acesso != 'superadmin')) :
				$return = true;
			elseif ($permissoes) :
				$return = (in_array($acesso, $permissoes)) ? true : false;
			else :
				$return = false;
			endif;
		endif;
	else :
		$return = false;
	endif;

	if ($redirect) :
		if ($return == false) :
			setSwal('error', 'Ops!', 'Você não tem permissão para acessar a página solicitada');
			echo '<script>location.href="' . base_url('dashboard') . '"</script>';
		endif;
	else :
		return $return;
	endif;
}

function template($page, $data = NULL)
{

	if (isset($_SESSION['usuarioCode'])) :

		$data['USR'] = dataToken($_SESSION['accessToken'])['token'];

		echo view('template/v1/header', $data);

		echo view('template/v1/body-before', $data);

		echo view($page, $data);

		echo view('template/v1/body-after', $data);

		echo view('template/v1/footer', $data);
	endif;
}

function listScript($data)
{
	// Lista scripts js Array ou Objeto
	$html = "";
	if (is_array($data) || is_object($data)) :
		foreach ($data as $js) :
			$html .= '<script src="' . base_url($js) . '"></script>';
		endforeach;
	endif;
	return $html;
}


function resumo($string, $chars)
{
	if (strlen($string) > $chars)
		return substr($string, 0, $chars) . '...';
	else
		return $string;
}



function v($data)
{
	echo "<pre>";
	echo var_dump($data);
	echo "</pre>";
}

function vd($data)
{
	echo "<pre>";
	echo var_dump($data);
	echo "</pre>";
	die();
}

/**
 * Função responsavel por definir a url de redirecionamento.
 * Definir ?current_url= no action do form.
 * @param string $default
 * Parametro default informa para onde redirecionar caso não tenha um GET current_url
 * @return string
 */
function backUrl($default = null)
{

	// new  \CodeIgniter\HTTP\Request;

	$request = \Config\Services::request();
	$previous_url = $request->getGet('current_url');
	$previous_url = $previous_url ? $previous_url : base_url($default);

	return $previous_url;
}
function nl2p($string)
{
	$paragraphs = '';

	foreach (explode("\n", $string) as $line) {
		if (trim($line)) {
			$paragraphs .= '<p>' . $line . '</p>';
		}
	}

	return $paragraphs;
}
function inTime($time)
{
	// Exibe a data como no exemplo: 1 dia atrás
	$now = strtotime(date('m/d/Y H:i:s'));
	$time = strtotime($time);
	$diff = $now - $time;

	$seconds = $diff;
	$minutes = round($diff / 60);
	$hours = round($diff / 3600);
	$days = round($diff / 86400);
	$weeks = round($diff / 604800);
	$months = round($diff / 2419200);
	$years = round($diff / 29030400);

	if ($seconds <= 60)
		$return = "1 min atrás";
	else if ($minutes < 60)
		$return = $minutes == 1 ? '1 min atrás' : $minutes . ' min atrás';
	else if ($hours < 24)
		$return = $hours == 1 ? '1 hrs atrás' : $hours . ' hrs atrás';
	else if ($days <= 6)
		$return = $days == 1 ? '1 dia atras' : $days . ' dias atrás';
	else if ($weeks <= 4)
		$return = $weeks == 1 ? '1 semana atrás' : $weeks . ' semanas atrás';
	else if ($months <= 12)
		$return = $months == 1 ? '1 mês atrás' : $months . ' meses atrás';
	else
		$return = $years == 1 ? '1 ano atrás' : $years . ' anos atrás';

	return '<span class="p-2" data-bs-toggle="tooltip" data-bs-title="' . date('d/m/Y H:i:s', $time) . '">' . $return . '</span>';
}

function slug($variavel)
{
	$variavel_limpa = strtolower(preg_replace("/[^a-zA-Z0-9-]/", "-", strtr(utf8_decode(trim($variavel)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")));
	return $variavel_limpa;
}

function soNumero($str)
{
	return preg_replace("/[^0-9]/", "", $str);
}

function mask($val, $mask)
{
	$maskared = '';
	$k = 0;
	for ($i = 0; $i <= strlen($mask) - 1; $i++) {
		if ($mask[$i] == '#') {
			if (isset($val[$k]))
				$maskared .= $val[$k++];
		} else {
			if (isset($mask[$i]))
				$maskared .= $mask[$i];
		}
	}
	return $maskared;
}

function telMask($val, $whatsapp = false)
{
	$val = soNumero($val);
	if (strlen($val) == 11) :
		$return = mask($val, '(##) #####-####');
	elseif (strlen($val) == 10) :
		$return = mask($val, '(##) ####-####');
	else :
		return false;
	endif;
	if ($whatsapp) :
		return '<a href="https://wa.me/' . $val . '">' . $return . '</a>';
	else :
		return $return;
	endif;
}



// ver onde esta usando isso
// function firstExplode($array)
// {

// 	if (mb_strpos($array, ',') == true) {
// 		$array = explode(',', $array);
// 		return $array[0];
// 	} else {
// 		return $array;
// 	}
// }

function getPerguntaPesquisa($codePergunta, $coluna)
{

	$model = new \App\Models\PesquisaPerguntaModel();
	$result = $model->where('code', $codePergunta)->First();

	if ($coluna == NULL)
		return $result;
	else
		return $result->$coluna;
}


function getOpcaoPesquisa($codePergunta)
{

	$model = new \App\Models\PesquisaOpcaoModel();
	$result = $model->where('codePergunta', $codePergunta)->findAll();
	return $result;
}


function getPesquisa($codePesquisa, $coluna)
{

	$model = new \App\Models\PesquisaModel();
	$result = $model->where('code', $codePesquisa)->First();

	if ($coluna == NULL)
		return $result;
	else
		return $result->$coluna;
}


function getPesquisaCategoria($codeCategoria, $coluna)
{

	$model = new \App\Models\PesquisaCategoriaModel();
	$result = $model->where('code', $codeCategoria)->First();

	if ($coluna == NULL)
		return $result;
	else
		return $result->$coluna;
}

function myJsonDecode($object, $array = false)
{
	if (!$array) :
		if (is_string($object)) :
			$object = (json_decode($object)) ? json_decode($object) : $object;
		elseif (is_array($object)) :
			$object = (object) $object;
		endif;
		if (is_object($object)) :
			foreach ($object as $k => $a) :
				$object->$k = myJsonDecode($object->$k);
			endforeach;
		endif;
		return $object;
	else :
		if (is_string($object)) :
			$object = (json_decode($object, true)) ? json_decode($object, true) : $object;
		elseif (is_object($object)) :
			$object = (array) $object;
		endif;
		if (is_array($object)) :
			foreach ($object as $k => $a) :
				$object[$k] = myJsonDecode($object[$k], true);
			endforeach;
		endif;
		return $object;
	endif;
}


function money($value, $R = true)
{
	if ($R) :
		return 'R$ ' . number_format($value, 2, ',', '.');
	else :
		return number_format($value, 2, ',', '.');
	endif;
}
function noMoney($value)
{
	$value = str_replace('R$', '', $value);
	$value = strpos($value, ',') ? str_replace('.', '', $value) : $value;
	$value = trim(str_replace(',', '.', $value));
	return floatval($value);
}

function exibe($lead, $myField, $array = false)
{
	$return = null;
	$lead = $array ? (object) $lead : (object) $lead;
	if (isset($lead->$myField)) :
		return $lead->$myField;
	else :
		foreach ($lead as $myField => $value) :
			if (is_object($value)) :
				$return = exibe($value, $myField);
			endif;
		endforeach;
		return $return;
	endif;
}

function getApi($request, $public = false)
{
	// if($request == 'tabela-motorhome/implementos') {

	// 	$a = json_decode(file_get_contents(FCPATH .'content/tabela-referencia.json'));
	// 	return $a;
	// }
	// exit;
        
	if ($public) :
		// echo base_url('api/publico');exit;
		$api = \Config\Services::curlrequest([
			'baseURI' => base_url('api/publico') . '/',
			"headers" => [
				"Accept" => "application/json"
			]
		]);
		// var_dump($api->get($request));exit;
		return json_decode($api->get($request)->getBody());
	else :
		$api = \Config\Services::curlrequest();
		$return = $api->request('GET', base_url('api/v1/' . $request), ['headers' => ['Authorization' => "Bearer {$_SESSION['accessToken']}"]])->getBody();
		return json_decode($return);
	endif;
}

function gerar_senha($tamanho, $maiusculas, $minusculas, $numeros, $simbolos)
{
	$ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; // $ma contem as letras maiúsculas
	$mi = "abcdefghijklmnopqrstuvyxwz"; // $mi contem as letras minusculas
	$nu = "0123456789"; // $nu contem os números
	$si = "!@#$%¨&*()_+="; // $si contem os símbolos

	$senha = '';

	if ($maiusculas) {
		// se $maiusculas for "true", a variável $ma é embaralhada e adicionada para a variável $senha
		$senha .= str_shuffle($ma);
	}

	if ($minusculas) {
		// se $minusculas for "true", a variável $mi é embaralhada e adicionada para a variável $senha
		$senha .= str_shuffle($mi);
	}

	if ($numeros) {
		// se $numeros for "true", a variável $nu é embaralhada e adicionada para a variável $senha
		$senha .= str_shuffle($nu);
	}

	if ($simbolos) {
		// se $simbolos for "true", a variável $si é embaralhada e adicionada para a variável $senha
		$senha .= str_shuffle($si);
	}

	// retorna a senha embaralhada com "str_shuffle" com o tamanho definido pela variável $tamanho
	return substr(str_shuffle($senha), 0, $tamanho);
}
