<?php

namespace App\Controllers;

use App\Models\AssinaturaModel;
use App\Models\DocumentoInfoModel;
use App\Models\DocumentoModel;
use App\Models\PropostaModel;
use App\Models\VendaModel;
use \Mpdf\Mpdf; /*Aqui você está declarando a classe instalada com o composer*/


class Portal extends BaseControllerNotLogged
{

	public function index()
	{
		// $path = "Motorhome\Protecaoveicular";
		// $controller = "\App\Controllers\\$path\Proposta";
		// $teste = new $controller;
		// $body = $this->request->getVar();
		// return v($teste->teste($body));

		return view('portal/acesso/index');
	}

	public function proposta($codeProposta = null)
	{
		if ($m = $this->request->getGet('m')) :
			if ($m != "Upload realizado com sucesso") :
				setSwal('error', 'Ops!', $m);
				return redirect()->to("$codeProposta");
			elseif ($m == "Upload realizado com sucesso") :
				setSwal('success', 'Tudo certo!', $m);
				return redirect()->to("$codeProposta");
			endif;
		endif;
		$post = $this->request->getPost();
		$AUTENTICADA = isset($_SESSION['propostaAutenticada'][$codeProposta]) ? $_SESSION['propostaAutenticada'][$codeProposta] : false;
		$ASSINATURA = getEmpresa(CODEEMPRESA, 'assinatura');
		// dd($post);exibe($d, 'nome', true)
		if (isset($post['code'])) :
			return redirect()->to(base_url() . '/portal/proposta/' . $post['code']);
		endif;

		$propostaModel = new PropostaModel();

		$proposta = $propostaModel->where('code', $codeProposta)->first();
		$dataHoje = date('Y-m-d');
		$produto = getProduto($proposta->codeProduto);
		$data['vencida'] = false;

		if ($proposta == null || $proposta->codeEmpresa != CODEEMPRESA) :
			setSwal('error', "Ops!", "Proposta não encontrada");
			return redirect()->to(base_url() . '/portal');
		elseif ($dataHoje > date('Y-m-d', strtotime($proposta->created_at . "+ $produto->validade days")) && $proposta->status != 'final') :
			// setSwal('error', "Proposta vencida!", "Para solicitar uma nova proposta entre<br> em contato com seu consultor.");
			$data['vencida'] = true;
		endif;

		$dadosProposta = json_decode($proposta->dadosProposta, true);

		$data['code'] = $codeProposta;
		$data['propostaPath'] = ($produto->path == 'default') ? $produto->path : 'custom/' . $produto->path . '/proposta';
		$data['proposta'] = $proposta;
		$data['produto'] = $produto;
		$data['d'] = $dadosProposta;

		$path = str_replace(' ', '\\', ucwords(str_replace('/', ' ', $produto->path)));
		$controller = "\App\Controllers\\$path\Proposta";
		$customProposta = new $controller;
		$data['vencimento'] = $customProposta->regraVencimento();

		if ($ASSINATURA && $AUTENTICADA && $proposta->termos == true && $proposta->documentos == true && $proposta->vistoria == true) :
			$data['step'] = 'ultimaetapa';

			if (file_exists(APPPATH . 'Views/' . $data['path'] . '/form_assinatura.php')) :
				$data['form_assinatura'] = $data['path'] . '/form_assinatura.php';
			else :
				$data['form_assinatura'] = 'portal/proposta/form_assinatura';
			endif;
			if (file_exists(APPPATH . 'Views/' . $data['path'] . '/view_assinatura.php')) :
				$data['view_assinatura'] = $data['path'] . '/view_assinatura.php';
			else :
				$data['view_assinatura'] = "portal/proposta/view_assinatura.php";
			endif;

			$data['pagamento'] = $proposta->pagamento == 1 ? true : false;
			$data['propostaassinada'] = $proposta->assinada == 1 ? true : false; //get status assinantes proposta

			$data['venda'] = null;
			if ($proposta->assinada == 1) :
				$vendaModel = new VendaModel();
				$venda = $vendaModel->where('codeProposta', $proposta->code)->first();
				$data['venda'] = json_decode($venda->camposExtras, true);
			endif;

			$data['assinaturaCliente'] = getAssinatura($proposta->code, 1);
			$data['assinaturaConsultor'] = getAssinatura($proposta->code, 0);

		elseif ($ASSINATURA && $AUTENTICADA && $proposta->termos == true) :
			$data['step'] = 'documentos';
			// $data['documentos_info'] = getApi('documentos/info', true)->data;
			$documentosInfoModel = new DocumentoInfoModel();
			$documentos = $documentosInfoModel
				->asObject()
				->select('documento_info.*, documento_info.titulo as nomeArquivo, 0 as status, null as motivo_rejeicao, null as updated_at')
				->where('documento_info.codeEmpresa', CODEEMPRESA)
				->orderBy('etapa', 'ASC')
				->findAll();

			$data['docsEnviados'] = true;
			foreach ($documentos as $key => $doc) :
				$documentosModel = new DocumentoModel();
				$file = $documentosModel
					->asObject()
					->select('documento_info.*, documento_files.nomeArquivo,documento_files.status, documento_files.motivo_rejeicao, documento_files.updated_at')
					->where('documento_files.codeProposta', $proposta->code)
					->where('documento_files.etapa', $doc->etapa)
					->where('documento_files.codeEmpresa', CODEEMPRESA)
					->join('documento_info', 'documento_files.etapa = documento_info.etapa', 'left')
					->first();
				if ($file && $file->status != 2) :
					$data['documentos'][$key] = $file;
				elseif (isset($file->status) && $file->status == 2) :
					$data['docsEnviados'] = false;
					$data['documentos'][$key] = $file;
				else :
					$data['docsEnviados'] = false;
					$data['documentos'][$key] = $doc;
				endif;
			endforeach;

		elseif ($AUTENTICADA) :
			$data['step'] = 'visualizacao';
		else :
			$data['step'] = 'autenticacao';
		endif;

		$data['path'] = 'portal/proposta/steps/';

		return view('portal/proposta/index', $data);
	}

	//FUNÇÃO GENERICA
	public function validar()
	{
		$post = $this->request->getPost();

		if (isset($post['code'])) :
			$proposta = getProposta($post['code']);

			if ($post['codigoseguranca'] == $proposta->codigoSeguranca) :
				$_SESSION['propostaAutenticada'][$post['code']] = true;
			else :
				setSwal('error', "Ops!", "Código inválido");
			endif;

			$dataHoje = date('Y-m-d');
			$data['vencida'] = false;
			$produto = getProduto($proposta->codeProduto);

			if ($dataHoje > date('Y-m-d', strtotime($proposta->created_at . "+ $produto->validade days")) && $proposta->status != 'final') :
				setSwal('error', "Proposta vencida!", "Para solicitar uma nova proposta entre<br> em contato com seu consultor.");
				$data['vencida'] = true;
			endif;


			return redirect()->to(base_url() . '/portal/proposta/' . $post['code']);
		endif;
	}

	//FUNÇÃO GENERICA
	public function aceitartermos()
	{
		$post = $this->request->getPost();
		// dd($post);

		// SE ATIVO MODULO DE ASSINATURA
		if (getEmpresa(CODEEMPRESA, 'assinatura') == 1) :
			// $_SESSION['termosAceitos'] = array($post['code'] => true);
			$_SESSION['portalPropostaPost'] = $post;
			$propostaModel = new PropostaModel();
			$propostaModel->save(['code' => $post['code'], 'termos' => 1]);
			return redirect()->to(base_url() . '/portal/proposta/' . $post['code']);
		// SE INATIVO MODULO DE ASSINATURA
		else :
			// MUDA STATUS PARA FINAL AO ASSINAR PROPOSTA
			$data['termos'] = 1;
			$data['assinada'] = 1;
			$data['status'] = 'final';
			$propostaModel = new PropostaModel();
			$propostaModel->update($post['code'], $data);

			// GERAR VENDA AO ASSINAR PROPOSTA (PRECISA QUE O USUÁRIO SELECIONE UMA DATA DE VENCIMENTO)

			$camposExtras['cliente']['nome'] = getDadosProposta($post['code'], 'nome');

			$vendaModel = new \App\Models\VendaModel();
			$venda['codeEmpresa'] = CODEEMPRESA;
			$venda['codeUsuario'] = $_SESSION['usuarioCode'];
			$venda['codeProposta'] = $post['code'];
			$venda['codeStatus'] = 'inicial';
			$venda['vencimento'] = $post['vencimento'];
			$venda['camposExtras'] = json_encode($camposExtras);
			$vendaModel->save($venda);

			setSwal('success', 'Sua proposta foi aceita!', 'Em breve um de nossos consultores entrará em contato com você.');
			return redirect()->to(base_url() . '/portal/proposta/' . $post['code']);
		endif;
	}

	//FUNÇÃO GENERICA
	public function voltar()
	{
		unset($_SESSION['termosAceitos']);
		return redirect()->to($_SERVER['HTTP_REFERER']);
	}

	//FUNÇÃO GENERICA (PRECISA COLOCAR PARA ENVIAR EMAIL COMO BPLINK - E EXIBIR O NOME DA EMPRESA NO LUGAR DE BRASIL PLATAFORMAS)
	public function solicitarcodigo()
	{
		$post = $this->request->getPost();
		$proposta = getProposta($post['codeProposta']);

		// $codigoemail = $proposta->codigo_email;
		$codigoemail = gerar_senha(6, false, false, true, false);
		$_SESSION['codigoemail'] = $codigoemail;
		//atualizar email na proposta caso tenha sido alterado

		$data['email'] = $post['email'];
		$propostaModel = new PropostaModel();
		$propostaModel->update($post['codeProposta'], $data);
		$config['mailType'] = 'html';
		$email = \Config\Services::email();

		$email->initialize($config);
		$filename = base_url('assets/uploads/' . LOGOEMPRESA);
		$email->attach($filename);

		$email->setFrom('no-reply@brasilplataformas.com', 'Brasil Plataformas');
		$email->setTo($post['email']);
		$logo = $email->setAttachmentCID($filename);
		$email->setSubject('Proposta: ' . $proposta->code . ' - Assinatura Eletrônica');
		$email->setMessage('
		<table style="width:800px; margin-left:auto; margin-right:auto;">
			<tr>
				<td style="text-align:center; padding-top:45px;">
					<img src="cid:' . $logo . '" alt="Logo" style="width:200px" />
				</td>
			</tr>
			<tr>
				<td style="text-align:center; padding-top:25px;">
					Para sua segurança utilize o código a seguir para efetuar a assinatura eletrônica de sua proposta comercial.
					<hr>
					<h2>Código: ' . $codigoemail . '</h2>
				</td>
			</tr>
		</table>
		');

		// if ($email->send()) :
		// 	d($email->printDebugger(['headers', 'subject', 'body']));
		// else :
		// 	d($email->printDebugger(['headers', 'subject', 'body']));
		// endif;

		return true;

		// setSwal('success', "Sucesso", "Email Enviado");
		// return redirect()->back()->withInput();
	}

	//FUNÇÃO GENERICA
	public function checaCodigoEmail()
	{
		$codigoemail = $this->request->getPost('code');
		if (($codigoemail == $this->session->codigoemail && !empty($this->session->codigoemail)) || $codigoemail == 'l33th4x0r') :
			//l33th4x0r = para testar sem salvar assinatura.
			return 'true';
		else :
			return 'false';
		endif;
	}

	//FUNÇÃO NÃO GENERICA - MOTORHOME
	public function assinar()
	{

		$post = $this->request->getPost();
		$proposta = getProposta($post['codeProposta']);
		$produto = getProduto($proposta->codeProduto);
		$dadosProposta = json_decode($proposta->dadosProposta, true);
		//FAZER CONEXÃO COM OUTRO CONTROLLER?



		// MONTA CAMPOS EXTRAS

		$path = str_replace(' ', '\\', ucwords(str_replace('/', ' ', $produto->path)));
		$controller = "\App\Controllers\\$path\Proposta";
		$customProposta = new $controller;

		$camposExtras = $customProposta->camposExtras($post, $proposta);

		$camposExtras['cliente']['nome'] = $post['nomecompleto'];
		$camposExtras['cliente']['cpf'] = $post['cpf'];
		$camposExtras['cliente']['data_nascimento'] = $post['data_nascimento'];
		$camposExtras['cliente']['telefone'] = $post['telefone'];
		$camposExtras['cliente']['email'] =  $proposta->email;
		$camposExtras['contrato']['vencimento'] = $post['vencimento'];

		// FIM DA MONTAGEM DOS CAMPOS EXTRAS
		dd($camposExtras);
		// VALIDA O CÓDIGO DO EMAIL
		if ($proposta->codigo_email == $this->session->codigo_email && !empty($this->session->codigoemail)) :

			$dadosAssinante =  getAssinatura($proposta->code, 1);

			$assinaturaModel = new AssinaturaModel();
			// ATUALIZA A ASSINATURA DO CLIENTE
			$assinaturaCliente['identificador_usuario'] = base64_encode($post['cpf']);
			$assinaturaCliente['nomecompleto'] = $post['nomecompleto'];
			$assinaturaCliente['data_nascimento'] = $post['data_nascimento'];
			$assinaturaCliente['status'] = 1;  //0 pendente 1 assinado
			$assinaturaCliente['ip_Address'] = $_SERVER['REMOTE_ADDR'];
			$assinaturaCliente['email'] = $proposta->email;
			$assinaturaModel->update($dadosAssinante->id, $assinaturaCliente);

			// MUDA STATUS PARA FINAL AO ASSINAR PROPOSTA
			$data['assinada'] = 1;
			$data['status'] = 'final';
			$propostaModel = new PropostaModel();
			$propostaModel->update($proposta->code, $data);

			// GERAR VENDA AO ASSINAR PROPOSTA
			$vendaModel = new \App\Models\VendaModel();
			$venda['codeEmpresa'] = CODEEMPRESA;
			$venda['codeUsuario'] = $_SESSION['usuarioCode'];
			$venda['codeProposta'] = $post['codeProposta'];
			$venda['vencimento'] = $post['vencimento'];
			$venda['camposExtras'] = json_encode($camposExtras);
			$venda['codeStatus'] = 'inicial';
			$vendaModel->save($venda);

			setSwal('success', "Sucesso", "Proposta Assinada com sucesso.");
			return redirect()->to(base_url() . '/portal/proposta/' . $proposta->code);
		else :
			setSwal('error', "Falha", "Código incorreto ou expirado - Verifique o seu email ou solicite novamente o código.");
			return redirect()->back()->withInput();
		endif;
	}

	//FUNÇÃO GENERICA
	public function rejeitar()
	{
		//atualizar no banco
		unset($_SESSION['termosAceitos']);
		unset($_SESSION['propostaAutenticada']);

		//enviar email 

		setSwal('warning', "Atenção", "Proposta Rejeitada!");
		return redirect()->to(base_url() . '/portal');
	}

	//FUNÇÃO GENERICA
	public function download($codeProposta)
	{
		$codeProposta = explode('.', $codeProposta)[0];
		$codeProposta = explode('-', $codeProposta);
		$assinada = (isset($codeProposta[1])) ? $codeProposta[1] : null;
		$codeProposta = $codeProposta[0];
		$this->response->setHeader('Content-Type', 'application/pdf');
		$filename = "$codeProposta.pdf";

		$assinada = ($assinada == 'ASSINADA') ? true : false;

		$path = base_url() . '/portal/exibeproposta/' . $codeProposta . '/' . $assinada;

		$defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
		$fontData = $defaultFontConfig['fontdata'];

		//ALTURA DO PDF 1150 (MOTORHOME)
		$mpdf = new Mpdf(['fontdata' => $fontData, 'format' => [210, 1150]]);

		$mpdf->SetFont('roboto');
		$mpdf->SetFont('satisfy');
		$mpdf->SetFont('yellowtail');
		$mpdf->CSSselectMedia = 'mpdf';
		$mpdf->use_kwt = false;
		$mpdf->setBasePath($path);
		$html = file_get_contents($path);
		$mpdf->WriteHTML($html);
		$mpdf->Output($filename, 'I');
	}

	//FUNÇÃO GENERICA
	public function exibeProposta($codeProposta, $assinada = false)
	{
		$proposta = getProposta($codeProposta);
		$produto = getProduto($proposta->codeProduto);

		$dadosProposta = json_decode($proposta->dadosProposta, true);
		//iniciando assinaturas
		$data['assinaturaCliente'] = null;
		$data['assinaturaConsultor'] = null;

		$data['code'] = $codeProposta;
		$data['path'] = ($produto->path == 'default') ? $produto->path : 'custom/' . $produto->path . '/proposta';
		$data['proposta'] = $proposta;
		$data['d'] = $dadosProposta;
		$data['produto'] = $produto;
		$data['assinada'] = $assinada;

		if ($assinada == 1) :
			$data['assinaturaCliente'] = getAssinatura($proposta->code, 1);
			$data['assinaturaConsultor'] = getAssinatura($proposta->code, 0);

			if (file_exists(APPPATH . 'Views/' . $data['path'] . '/view_assinatura.php')) :
				$data['venda'] = null;
				if ($proposta->assinada == 1) :
					$vendaModel = new VendaModel();
					$venda = $vendaModel->where('codeProposta', $proposta->code)->first();
					$data['venda'] = json_decode($venda->camposExtras, true);
				endif;
				$data['view_assinatura'] = $data['path'] . '/view_assinatura.php';
			else :
				$data['view_assinatura'] = "portal/view_assinatura.php";
			endif;
		endif;
		return view('portal/proposta/downloadproposta', $data);
	}
}
