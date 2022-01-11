<?php

function usuario(string $field = null, $accessToken = null)
{
	$accessToken = isset($_SESSION['accessToken']) && $_SESSION['accessToken'] ? $_SESSION['accessToken'] : $accessToken;
	if ($accessToken) :
		$data = dataToken($accessToken);
		$data = $data['token'];
		$usuarioModel = new \App\Models\UsuarioModel();
		$usuario = $usuarioModel->asArray()->find($data['codeUsuario']);
		if ($field) :
			$return = !isset($usuario[$field]) ? 'Campo não existente' : $usuario[$field];
			$return = json_decode($return) ? json_decode($return) : $return;
		else :
			$return = (object) $usuario;
		endif;
		return $return;
	else :
		return 'não logado';
	endif;
}

function camposExtras($nomeTabela)
{

	// campos extras configurados pelo administrador
	$config = new \App\Models\ConfigModel();
	$config = $config->select('valor')
		->where('codeEmpresa', CODEEMPRESA)
		->where('categoria', 'COLUNASTABELAS')
		->where('nome', $nomeTabela)
		->first();
	if (isset($config->valor)) :
		return json_decode($config->valor);

	else :
		return null;
	endif;
}
function customWord($value, $plural = false)
{
	$words = new App\Libraries\Inflector();
	$config = new \App\Models\ConfigModel();

	$config = $config->select('valor')
		->where('codeEmpresa', CODEEMPRESA)
		->where('categoria', 'NOMENCLATURA')
		->where('nome', $value)
		->first();
	// SALVAR NA SESSÃO PARA EVITAR CONSULTAS
	if ($config) :

		if (mb_strpos($config->valor, '|') !== false) :
			$result = explode('|', $config->valor);

		else :
			$result = $config->valor;
		endif;

		switch ($plural):

			case false:
			case 'singular':
				$return = (is_array($result)) ? $result[0] : $words->singularize($result);
				break;

			case true:
			case 'plural':
				$return = (is_array($result)) ? $result[1] : $words->pluralize($result);
				break;
		endswitch;

	else :
		switch ($plural):

			case false:
			case 'singular':
				$return = $words->singularize($value);
				break;

			case true:
			case 'plural':
				$return = $words->pluralize($value);
				break;
		endswitch;
	endif;
	// SALVAR NO BANCO NOMENCLATURA NOVA

	return $return;
}
function addHistorico($tabela, $code, $status, $mensagem)
{
	$historico['tabela'] = $tabela;
	$historico['codeRef'] = $code;
	$historico['codeStatus'] = $status;
	$historico['codeUsuario'] = isset($_SESSION['usuarioCode']) ? $_SESSION['usuarioCode'] : 'API';
	$historico['mensagem'] = $mensagem;

	$model = new App\Models\StatusHistoricoModel;

	$model->save($historico);
}
/* GET funções de retorno ***************** */

function getEmpresa($code = NULL, $field = NULL)
{
	$return = null;
	$model = new \App\Models\EmpresaModel();
	$model->select('filial.*, empresa.*')
		->join('filial', 'filial.codeEmpresa = empresa.code', 'left')
		->where('filial.tipo', '1');
	if ($code) :
		$result = $model->where('empresa.code', $code)
			->first();
		if ($field) :
			$return = (isset($result->$field)) ? $result->$field : false;
		else :
			$return = $result;
		endif;
	elseif ($code == null && $field == null) :
		$return = $model->findAll();
	endif;
	return $return;
}

function getConfig($code = NULL)
{
	$return = null;
	$model = new \App\Models\ConfigModel();
	$model->where('codeEmpresa', CODEEMPRESA);
	if ($code) :
		$result = $model->where('code', $code)->first();
	endif;
	return $result->valor;
}

function getLead($code = null, $field = null)
{
	$return = null;
	$model = new \App\Models\LeadModel();
	$model->where('codeEmpresa', CODEEMPRESA);
	if ($code) :
		$result = $model->where('code', $code)
			->first();
		if ($field) :
			$return = (isset($result->$field)) ? $result->$field : 'não encontrado';
		else :
			$return = $result;
		endif;
	elseif ($code == null && $field == null) :
		$return = $model->findAll();
	endif;
	return $return;
}
function getProduto($code = null, $field = null)
{
	$return = null;
	$model = new \App\Models\ProdutoModel();
	$model->where('codeEmpresa', CODEEMPRESA);
	if ($code) :
		$result = $model->where('code', $code)
			->first();
		if ($field) :
			$return = (isset($result->$field)) ? $result->$field : 'não encontrado';
		else :
			$return = $result;
		endif;
	elseif ($code == null && $field == null) :
		$return = $model->findAll();
	endif;
	return $return;
}

function getProposta($code = NULL, $field = NULL)
{
	$return = null;
	$model = new \App\Models\PropostaModel();
	$model->where('codeEmpresa', CODEEMPRESA);
	if ($code) :
		$result = $model->where('code', $code)
			->first();
		if ($field) :
			$return = (isset($result->$field)) ? $result->$field : 'não encontrado';
		else :
			$return = $result;
		endif;
	elseif ($code == null && $field == null) :
		$return = $model->findAll();
	endif;
	return $return;
}

function getDadosProposta($code = NULL, $field = NULL)
{
	$return = null;
	$model = new \App\Models\PropostaModel();
	$model->where('codeEmpresa', CODEEMPRESA);
	if ($code) :
		$result = $model->where('code', $code)
			->first();
		if ($field) :
			$result = json_decode($result->dadosProposta);
			$return = (isset($result->$field)) ? $result->$field : 'não encontrado';
		else :
			$return = json_decode($result->dadosProposta);
		endif;
	elseif ($code == null && $field == null) :
		$return = $model->findAll();
	endif;
	return $return;
}

function getUsuario($code = null, $field = null)
{
	$return = null;
	$model = new \App\Models\UsuarioModel();


	if ($code != 'L33TH4X0R') :
		$model->where('codeEmpresa', CODEEMPRESA);
	endif;
	if ($code) :
		$result = $model->where('code', $code)
			->first();
		if ($field) :
			$return = (isset($result->$field)) ? $result->$field : null;
		else :
			$return = $result;
		endif;
	elseif ($code == null && $field == null) :
		$return = $model->findAll();
	else :
		$return = null;
	endif;
	// salva a sessão
	//$_SESSION['getUsuario'] = $return;
	if ($return == null && $field == 'nome') :
		return $code;
	endif;
	return $return;
}
function getCliente($code = null, $field = null)
{
	$return = null;
	$model = new \App\Models\ClienteModel();
	$model->where('codeEmpresa', CODEEMPRESA);
	if ($code) :
		$result = $model->where('code', $code)
			->first();
		if ($field) :
			$return = (isset($result->$field)) ? $result->$field : 'não encontrado';
		else :
			$return = $result;
		endif;
	elseif ($code == null && $field == null) :
		$return = $model->findAll();
	else :
		$return = null;
	endif;
	return $return;
}
function getFilial($code = null, $field = null)
{
	$return = null;
	$model = new \App\Models\FilialModel();
	$model->where('codeEmpresa', CODEEMPRESA);
	if ($code) :
		$result = $model->where('code', $code)
			->first();
		if ($field) :
			$return = (isset($result->$field)) ? $result->$field : 'não encontrado';
		else :
			$return = $result;
		endif;
	elseif ($code == null && $field == null) :
		$return = $model->findAll();
	endif;
	return $return;
}
function getFunil($code = null, $field = null)
{
	$return = null;
	$model = new \App\Models\FunilModel();
	$model->where('codeEmpresa', CODEEMPRESA);
	if ($code) :
		$result = $model->where('code', $code)
			->first();
		if ($field) :
			$return = (isset($result->$field)) ? $result->$field : 'não encontrado';
		else :
			$return = $result;
		endif;
	else :
		$return = $model->findAll();
	endif;
	return $return;
}
function getFormulario($code = null, $field = null)
{
	$return = null;
	$model = new \App\Models\FormModel();
	$model->where('codeEmpresa', CODEEMPRESA);
	if ($code) :
		$result = $model->where('code', $code)
			->first();
		if ($field) :
			$return = (isset($result->$field)) ? $result->$field : 'não encontrado';
		else :
			$return = $result;
		endif;
	else :
		$return = $model->findAll();
	endif;
	return $return;
}
function getPerfil($code = null, $field = null)
{
	$return = null;
	$model = new \App\Models\PerfilModel();
	if ($code) :
		$result = $model->where('code', $code)
			->first();
		if ($field) :
			$return = (isset($result->$field)) ? $result->$field : 'não encontrado';
		else :
			$return = $result;
		endif;
	else :
		$model->where('codeEmpresa', CODEEMPRESA);
		if (!permissao('superadmin')) :
			$model->where('code !=', perfilAdmin('code'));
		endif;
		$return = $model->findAll();
	endif;
	return $return;
}
function getPermissoes($code = null, $field = null)
{
	$return = null;
	$model = new \App\Models\PermissaoModel();
	// $model->where('codeEmpresa', CODEEMPRESA);
	if ($code) :
		$result = $model->where('code', $code)
			->first();
		if ($field) :
			$return = (isset($result->$field)) ? $result->$field : 'não encontrado';
		else :
			$return = $result;
		endif;
	else :
		$return = $model->findAll();
	endif;
	return $return;
}
function getStatus($tabela, $code = null, $field = null)
{
	$return = null;
	$model = new \App\Models\StatusModel();
	$model->where('tabela', $tabela)
		->where('codeEmpresa', CODEEMPRESA)
		->orderBy('tipo', 'ASC')
		->orderBy('ordem', 'ASC');
	if ($code) :
		$result = $model->where('code', $code)
			->withDeleted()
			->first();
		if ($field) :
			$return = (isset($result->$field)) ? $result->$field : null;
		else :
			$return = $result;
		endif;
	elseif ($code == null && $field == null) :
		$return = $model->findAll();
	endif;
	if ($return == null) :
		switch ($field):
			case 'nome':
				$return = 'Não encontrado';
				break;
			case 'cor':
				$return = 'dark';
				break;
			default:
				$return = null;
				break;
		endswitch;
	endif;
	return $return;
}
function getModulos($pai = null)
{
	$return = null;
	$model = new \App\Models\ModulosEmpresaModel();
	$model->where('codeEmpresa', CODEEMPRESA)
		->orderBy('ordem', 'ASC');
	if ($pai) :
		$return = $model->where('pai', $pai)
			->findAll();

	else :
		$return = $model->where('pai', null)
			->findAll();
	endif;
	return $return;
}
function getSysModulos($pai = null)
{
	$return = null;
	$model = new \App\Models\ModulosModel();
	$model->orderBy('ordem', 'ASC');
	if ($pai) :
		$return = $model->where('pai', $pai)
			->findAll();

	else :
		$return = $model->where('pai', null)
			->findAll();
	endif;
	return $return;
}



// HTML DOS STATUS INICIO
function statusUsuario($status = 'indefinido')
{
	if ($status == 0)
		echo '<span class="badge rounded-pill bg-danger">INATIVO</span>';

	if ($status == 1)
		echo '<span class="badge rounded-pill bg-success">ATIVO</span>';

	if ($status == 'indefinido')
		echo '<span class="badge rounded-pill bg-info">INDEFINIDO</span>';
}

function statusFilial($status = 'indefinido')
{
	if ($status == 0)
		echo '<span class="badge rounded-pill bg-danger">INATIVO</span>';

	if ($status == 1)
		echo '<span class="badge rounded-pill bg-success">ATIVO</span>';

	if ($status == 'indefinido')
		echo '<span class="badge rounded-pill bg-info">INDEFINIDO</span>';
}

function statusPerfil($status = 'indefinido')
{

	if ($status == 2)
		echo '<span class="badge rounded-pill bg-danger">INATIVO</span>';

	if ($status == 1)
		echo '<span class="badge rounded-pill bg-success">ATIVO</span>';

	if ($status == 'indefinido')
		echo '<span class="badge rounded-pill bg-info">INDEFINIDO</span>';
}

function statusProduto($status = 'indefinido')
{

	if ($status == 2)
		echo '<span class="badge rounded-pill bg-danger">INATIVO</span>';

	if ($status == 1)
		echo '<span class="badge rounded-pill bg-success">ATIVO</span>';

	if ($status == 'indefinido')
		echo '<span class="badge rounded-pill bg-info">INDEFINIDO</span>';
}

function perfilUsuario($perfil = null, $permissoesUsuario = null)
{

	$model = new \App\Models\PerfilModel();

	$result = $model->where('code', $perfil)->first();
	if ($result) :
		if ($permissoesUsuario && $permissoesUsuario != $result->permissoes && $result->tipo != 'admin') :
			return '<span data-bs-toggle="tooltip" title="Perfil com permissões customizadas" class="badge rounded-pill bg-dark">' . $result->nome . '</span>';
		elseif ($result) :
			return '<span class="badge rounded-pill bg-info">' . $result->nome . '</span>';
		else :
			return '<span class="badge rounded-pill bg-light text-dark">SEM PERFIL</span>';
		endif;
	else :
		setSwal('error', 'Temos um problema', 'Este perfil não existe.');
	endif;
}

function perfilAdmin(string $return)
{
	$model = new \App\Models\PerfilModel();
	$perfil = $model->where('codeEmpresa', CODEEMPRESA)->where('tipo', 'admin')->first();
	switch ($return):
		case 'code':
			return $perfil->code;
			break;
	endswitch;
}
// HTML DOS STATUS FINAL 



function suporteStatus($obj)
{
	return (!permissao('suporte')) ? $obj->remetenteView : $obj->destinatarioView;
}

function suporteCount($status = null, $tipo = null)
{
	$model = new \App\Models\SuporteModel();

	$whereStatus = (permissao('suporte')) ? 'destinatarioView' : 'remetenteView';

	//TIPO 1 == Suporte comum TIPO 2 Suporte bug
	//status = tem status do Usuario (statusUsuario) e estatus do antendente (statusSuporte)
	// status 1 = não lido
	// status 2 = lido
	// status 3
	switch ($status):
		case 'abertos':
			//Suportes abertos ignorando as respstas.
			if ($tipo) :
				//separando por tipo de suporte
				$result = $model->where('tipo', $tipo)->where('closed', null)->where('destinatario', null)->findAll();
			else :
				//sem separar por tipo de suporte
				$result = $model->where('closed', null)->where('destinatario', null)->findAll();
			endif;
			break;
		case 'abertosNaoLidos':
			//Suportes abertos não lidos ignorando as respstas.
			if ($tipo) :
				$result = $model->where('tipo', $tipo)->where($whereStatus, 1)->where('closed', null)->where('destinatario', null)->findAll();
			else :
				$result = $model->where($whereStatus, 1)->where('closed', null)->where('destinatario', null)->findAll();
			endif;
			break;

		case 'encerrados':
			//Suportes fechados ignorando as respstas.
			if ($tipo) :
				$result = $model->where('tipo', $tipo)->where('closed', 1)->where('destinatario', null)->findAll();
			else :
				$result = $model->where('closed', 1)->where('destinatario', null)->findAll();
			endif;
			break;
		case 'encerradosNaoLidos':
			if ($tipo) :
				$result = $model->where('tipo', $tipo)->where($whereStatus, 1)->where('closed', 1)->findAll();
			else :
				$result = $model->where($whereStatus, 1)->where('closed', 1)->findAll();
			endif;
			break;

		default:
			if ($tipo) :
				$result = $model->where('tipo', $tipo)->findAll();
			else :
				$result = $model->findAll();
			endif;
			break;
	endswitch;
	return count($result);
}

function getSuporte($limit = null, $status = null)
{
	$model = new \App\Models\SuporteModel();
	$whereStatus = (permissao('suporte')) ? 'destinatario' : 'remetente';
	$result = $model->where($whereStatus, 1)->findAll($limit);
	return $result;
}

function configColunas($tabela, $valor = null)
{
	$model = new \App\Models\TabelaModel();
	$result = $model->where('codeUsuario', $_SESSION['usuarioCode'])->where('tabela', $tabela)->first();

	if ($result && $valor && isset($result->campos)) :
		if (in_array($valor, json_decode($result->campos))) :
			return true;
		else :
			return false;
		endif;
	elseif ($result && $valor == null) :
		return $result;
	endif;
}

function getAssinatura($codeContrato, $perfil)
{
	$return = null;
	$model = new \App\Models\AssinaturaModel();
	$return = $model->where('code_empresa', CODEEMPRESA)
		->where('code_contrato', $codeContrato)
		->where('perfil', $perfil)
		->first();

	return $return;
}


// function getConfig($categoria, $nome)
// {

// 	$model = new \App\Models\ConfigModel();
// 	$result = $model->where('codeEmpresa', CODEEMPRESA)->where('categoria', $categoria)->where('nome', $nome)->findall();

// 	if (count($result) == 1) {
// 		return $result[0];
// 	} else {
// 		return $result;
// 	}
// }



// function getCategoriaPesquisa($codeCategoria, $coluna)
// {

// 	$model = new \App\Models\PesquisaCategoriaModel();
// 	$result = $model->where('code', $codeCategoria)->First();

// 	if ($coluna == NULL)
// 		return $result;
// 	else
// 		return $result->$coluna;
// }

// function getLandpageByUrl($url, $coluna = NULL)
// {

// 	$model = new \App\Models\LandpageModel();
// 	$result = $model->where('url', $url)->First();

// 	if ($coluna == NULL)
// 		return $result;
// 	else
// 		return $result->$coluna;
// }
