<?php

namespace App\Controllers;

use App\Models\AssinaturaModel;
use App\Models\LeadModel;
use App\Models\StatusHistoricoModel;
use App\Models\PropostaModel;

class Proposta extends BaseController
{
	public function index()
	{
		$data['tituloPagina'] = "Propostas";
		$data['subtituloPagina'] = "Lista";

		$propostaModel = new PropostaModel();
		$propostaModel->where('codeEmpresa', CODEEMPRESA);
		if (!permissao('ver_propostas')) :
			$propostaModel->where('codeUsuario', $this->session->usuarioCode);
		endif;
		$data['propostas'] = myJsonDecode($propostaModel->findAll());

		// $data['status'] = new StatusModel();
		$data['status'] = getStatus('proposta');

		$colunas = array(
			'code' => '#REF',
			'codeUsuario' => 'Responsável',
			'codeProduto' => 'Produto',
			'nome' => 'Nome',
			'email' => 'Email',
			'telefone' => 'Telefone'
		);



		$data['colunas'] = $colunas;

		$data['camposExtras'] = null;


		return template('modules/proposta/index', $data);
	}
	public function gerar($codeLead = null)
	{
		$data['code'] = $codeLead;
		$data['tituloPagina'] = "Proposta";
		$data['subtituloPagina'] = "Gerar";

		$leadModel = new LeadModel();
		$lead = $leadModel->where('code', $codeLead)->first();

		$data['lead'] = myJsonDecode($lead);
		$data['produto'] = getProduto($data['lead']->codeProduto);


		//Formulário padrão ou personalisado
		$path = $data['produto']->path;
		if ($path == 'default') :
			return template("modules/proposta/form", $data);
		else :
			$url = base_url("$path/proposta/dados/$codeLead");
			//dd($url);
			return redirect()->to($url);
		endif;
	}
	public function visualizar($codeProposta)
	{

		$data['code'] = $codeProposta;
		$data['tituloPagina'] = "Proposta";
		$data['subtituloPagina'] = "Gerar";

		$propostaModel = new PropostaModel();
		$data['proposta'] = $propostaModel->where('code', $codeProposta)->orderBy('created_at', 'DESC')->first();

		$data['produto'] = getProduto($data['proposta']->codeProduto);

		$data['d'] = json_decode($data['proposta']->dadosProposta, true);


		$data['status'] = getStatus('proposta', $data['proposta']->status);

		$statusHistoricoModel = new StatusHistoricoModel();
		$historico = $statusHistoricoModel->where('tabela', 'proposta')
			->like('codeRef', $codeProposta)
			->orderBy('id', 'desc')
			->findAll();


		$data['historico'] = $historico;

		//View padrão ou personalisado
		$path = $data['produto']->path;
		if ($path == 'default') :
			$data['include'] = "modules/proposta/proposta_view";
		else :
			$data['include'] = "custom/$path/proposta/proposta_view";
		endif;
		return template("modules/proposta/proposta_view", $data);
	}

	public function validade($code)
	{
		$propostaModel = new PropostaModel();
		$data['code'] = $code;
		$data['new_create'] = date('Y-m-d H:i:s');
		$propostaModel->save($data);

		$proposta = $propostaModel->where('code', $code)->first();

		addHistorico('proposta', $data['code'], $proposta->status, 'Proposta gerada - ' . $data['code']);
		setSwal('success', 'Tudo certo!', 'A proposta está válida novamente.');
		return redirect()->to(base_url('proposta/visualizar/' . $data['code']));
	}


	public function save($code = null)
	{

		$propostaModel = new PropostaModel();

		$code = ($code == null) ? $this->request->getPost('code') : $code;

		$data = $this->request->getPost();
		if (isset($data['obs']) && isset($data['codeStatus'])) :
			//salvar no historico e salvar o status
			$data['status'] = $data['codeStatus'];

			$dataHistorico['tabela'] = 'proposta';
			$dataHistorico['codeUsuario'] = usuario('code');
			$dataHistorico['codeStatus'] = $data['codeStatus'];
			$dataHistorico['codeRef'] = $code;
			$dataHistorico['mensagem'] = $data['obs'];


			$statusHistoricoModel = new StatusHistoricoModel();
			$statusHistoricoModel->insert($dataHistorico);
			// remover obs
			unset($data['obs'], $data['codeStatus']);
			if ($data['status'] == 'final') :
				// GERAR VENDA AO MUDAR STATUS PARA FINAL
				$vendaModel = new \App\Models\VendaModel();
				$venda['codeEmpresa'] = CODEEMPRESA;
				$venda['codeUsuario'] = $_SESSION['usuarioCode'];
				$venda['codeProposta'] = $code;
				$venda['codeStatus'] = 'inicial';
				$vendaModel->save($venda);
			endif;
			return json_encode($propostaModel->save($data));
		else :

			//GERAR NOVA PROPOSTA COM _NUM
			$proposta = $propostaModel->like('code', $code)->orderBy('created_at', 'DESC')->first();
			// dd($proposta);

			if ($proposta) :
				$pCode = explode('_', $proposta->code);
				$n = isset($pCode[1]) ? '_' . ($pCode[1] + 1) : null;
				$n = ($n == null) ? '_1' : $n;
				$propostaCode = $pCode[0] . $n;
			else :
				$propostaCode = $code;
			endif;

			$lead = getLead($code);
			$data = $this->request->getVar();
			$dadosProposta = json_decode($data['dadosProposta']);
			$data['code'] = $propostaCode;
			$data['codeEmpresa'] = CODEEMPRESA;
			$data['codeUsuario'] = $_SESSION['usuarioCode'];
			$data['codeProduto'] = $lead->codeProduto;
			$data['codigoSeguranca'] = substr($dadosProposta->telefone, -4);
			$data['email'] = $dadosProposta->email;
			//$data['codigo_email'] = gerar_senha(6, false, false, true, false);

			//SALVA A PROPOSTA
			$propostaModel->insert($data);


			// SE ATIVO MODULO DE ASSINATURA
			if (getEmpresa(CODEEMPRESA, 'assinatura') == 1) :
				$assinaturaModel = new AssinaturaModel();
				//assinatura consultor
				$assinaturaConsultor['code_empresa'] = $data['codeEmpresa'];
				$assinaturaConsultor['code_contrato'] = $data['code'];
				$assinaturaConsultor['identificador_usuario'] = getUsuario($data['codeUsuario'], 'cpf');
				$assinaturaConsultor['nomecompleto'] = getUsuario($data['codeUsuario'], 'nome');
				$assinaturaConsultor['tipo_assinatura'] = 0;  //0 assinar 1 testemunhar
				$assinaturaConsultor['perfil'] = 0;  //0 consultor  1 cliente
				$assinaturaConsultor['status'] = 1;  //0 pendente 1 assinado
				$assinaturaConsultor['ip_Address'] = $_SERVER['REMOTE_ADDR'];

				$assinaturaConsultor['email'] = getUsuario($data['codeUsuario'], 'email');
				$assinaturaModel->insert($assinaturaConsultor);

				//assinatura cliente
				$assinaturaCliente['code_empresa'] = $data['codeEmpresa'];
				$assinaturaCliente['code_contrato'] = $data['code'];
				$assinaturaCliente['tipo_assinatura'] = 0;  //0 assinar 1 testemunhar
				$assinaturaCliente['perfil'] = 1;  //0 consultor  1 cliente
				$assinaturaCliente['status'] = 0;  //0 pendente 1 assinado
				$assinaturaModel->insert($assinaturaCliente);
			endif;

			$dataLead['codeStatus'] = 'final';
			$dataLead['code'] = $data['code'];
			$leadModel = new LeadModel();
			//SALVA STATUS DO LEAD
			$leadModel->save($dataLead);

			addHistorico('lead', $data['code'], 'final', 'Proposta gerada - ' . $propostaCode);
			addHistorico('proposta', $data['code'], 'inicial', 'Proposta gerada - ' . $propostaCode);

			setSwal('success', 'Tudo certo!', 'Proposta salva com sucesso!');
			return redirect()->to(base_url('proposta/visualizar/' . $data['code']));
		endif;
	}
}
