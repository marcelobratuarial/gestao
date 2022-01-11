<?php

namespace App\Controllers;

use App\Models\LeadModel;
use App\Models\PropostaModel;
use App\Models\VendaModel;

class Dashboard extends BaseController
{
	public function index()
	{
		$data['leadPageLink'] = getEmpresa(CODEEMPRESA, 'leadPageLink');
		$data['usuario'] = myJsonDecode(usuario());

		$leadsModel = new LeadModel();
		$leads = $leadsModel->where('codeUsuario', usuario('code'))->findAll();
		$data['leads'] = count($leads);

		$leads = $leadsModel->where('codeUsuario', usuario('code'))->where('origem', 'landingPage')->findAll();
		$data['leadPageLink_leads'] = count($leads);

		$leads = $leadsModel->where('codeUsuario', usuario('code'))->where('origem', 'whatsapp')->findAll();
		$data['whatsapp_leads'] = count($leads);

		$leads = $leadsModel->where('codeUsuario', usuario('code'))->where('origem', 'telefone')->findAll();
		$data['telefone_leads'] = count($leads);

		$leads = $leadsModel->where('codeUsuario', usuario('code'))->where('origem', 'email')->findAll();
		$data['email_leads'] = count($leads);

		$leads = $leadsModel->where('codeUsuario', usuario('code'))->where('origem', 'pessoalmente')->findAll();
		$data['pessoalmente_leads'] = count($leads);

		$propostaModel = new PropostaModel();
		$propostas = $propostaModel->where('codeUsuario', usuario('code'))->notLike('code', "!_")->findAll();
		$data['propostas'] = count($propostas);

		$vendaModel = new VendaModel();
		$vendas = $vendaModel->where('codeUsuario', usuario('code'))->findAll();
		$data['vendas'] = count($vendas);

		if ($data['propostas'] != 0) :
			$data['conversao'] = number_format($data['vendas'] / $data['propostas'] * 100, 0, ',', '');
		else :
			$data['conversao'] = 0;
		endif;


		// $data['usuarios'] = count(getUsuario());
		// $data['clientes'] = count(getCliente());

		return template('modules/dashboard/index', $data);
	}
	public function dash()
	{
		return redirect()->to(base_url('dashboard'));
	}
}
