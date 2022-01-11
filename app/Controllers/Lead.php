<?php


namespace App\Controllers;

use App\Models\LeadModel;
use App\Models\StatusHistoricoModel;

class Lead extends BaseController
{
	public function index()
	{
		permissao('lead', true);
		$data['tituloPagina'] = "Leads";
		$data['subtituloPagina'] = "Lista";

		$leads = new LeadModel();

		$leads->where('codeEmpresa', CODEEMPRESA);
		if (!permissao('ver_leads')) :
			$leads->where('codeUsuario', $this->session->usuarioCode);
		endif;
		$data['leads'] = $leads->findAll();

		// $data['status'] = new StatusModel();
		$data['status'] = getStatus('lead');

		$colunas = array(
			'code' => '#REF',
			'nome' => 'Nome',
			'email' => 'E-mail',
			'telefone' => 'Telefone',
			'codeProduto' => 'Produto'
		);
		if (permissao('ver_leads')) :
			$colunas['codeUsuario'] = 'Responsável';
		endif;

		if ($camposExtras = camposExtras('lead')) :

			foreach ($camposExtras as $ce) :
				$colunasExtras[slug($ce)] = ucfirst($ce);
			endforeach;

		else :
			$colunasExtras = array();
		endif;

		$data['colunas'] = array_merge($colunas, $colunasExtras);

		$data['camposExtras'] = $camposExtras;

		return template('modules/lead/lista', $data);
	}
	public function adicionar()
	{

		$data['tituloPagina'] = "Leads";
		$data['subtituloPagina'] = "Adicionar";


		return template('modules/lead/adicionar', $data);
	}
	public function detalhe($codeLead)
	{
		$data['tituloPagina'] = "Leads";
		$data['subtituloPagina'] = "Detalhe";

		$leads = new LeadModel();

		$result = $leads->where('code', $codeLead)
			->where('codeEmpresa', CODEEMPRESA)
			->first();

		if (!$result) :
			setSwal('error', 'Ops!', 'Lead não encontrado');
			return redirect()->to(base_url('lead'));
		endif;

		$statusHistoricoModel = new StatusHistoricoModel();
		$historico = $statusHistoricoModel->where('tabela', 'lead')
			->like('codeRef', $codeLead)
			->orderBy('id', 'desc')
			->findAll();

		$data['lead'] = $result;
		$data['historico'] = $historico;

		return template('modules/lead/detalhe', $data);
	}

	public function save()
	{
		$model = new LeadModel();
		$redirect = true;
		$data = $this->request->getPost();
		$proposta = isset($data['proposta']) ? true : false;
		unset($data['proposta']);

		if (isset($data['obs']) && isset($data['codeStatus'])) :
			//salvar no historico
			$dataHistorico['tabela'] = 'lead';
			$dataHistorico['codeUsuario'] = $_SESSION['usuarioCode'];
			$dataHistorico['codeStatus'] = $data['codeStatus'];
			$dataHistorico['codeRef'] = $data['code'];
			$dataHistorico['mensagem'] = $data['obs'];


			$historicoLead = new StatusHistoricoModel();
			$historicoLead->insert($dataHistorico);
			// remover obs
			unset($data['obs']);
			$redirect = (isset($data['redirect'])) ? $data['redirect'] : false;
			unset($data['redirect']);
		endif;


		if (isset($data['codeFilial'])) :
			$data['codeFilial'] = json_encode($data['codeFilial']);
		endif;

		if (isset($data['camposExtras'])) :
			$data['camposExtras'] = json_encode($data['camposExtras']);
		endif;

		if (isset($data['code'])) :
			$action = 'update';
		else :
			$action = 'insert';
			$data['tipo'] = 2;
			$data['codeEmpresa'] = $_SESSION['usuarioEmpresa'];
			$data['code'] = code();
		endif;

		if ($action == 'insert') :
			$model->insert($data);
			addHistorico('lead', $data['code'], 'inicial', 'Lead adicionado');
			setSwal('success', 'Tudo certo!', 'Lead adicionado com sucesso.');

		elseif ($action == 'update') :
			$model->save($data);
			setSwal('success', 'Tudo certo!', 'O lead foi atualizado.');
		endif;
		if ($redirect) :
			if ($proposta) :
				return redirect()->to(base_url('proposta/gerar/' . $data['code']));
			else :
				return redirect()->to(base_url('lead/detalhe/' . $data['code']));
			endif;
		endif;
	}
}
