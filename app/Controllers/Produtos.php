<?php

namespace App\Controllers;

use App\Models\NewEmpresaModel;
use App\Models\NewProdutoModel;

use App\Models\ContatoModel;
use App\Models\StatusHistoricoModel;
use App\Models\StatusModel;

class Produtos extends BaseController
{

	///ME CHAMAR PRA MOSTRAR COMO FAZ/FUNCIONA OS CAMPOS EXTRAS

	public function index()
	{
		$data['tituloPagina'] =  ucfirst(customWord('produto', true));
		
		$data['subtituloPagina'] = "Lista";

		$produtos = new NewProdutoModel();

		$data['produtos'] = $produtos->findAll();
		// print_r($data);exit;
		$data['status'] = new StatusModel();

		// colunas que estarão disponiveis para exibição
		$colunas  = array('code' => '#REF', 'nome' => 'Nome', 'valor' => 'Valor', 'validade' => "Validade");

		$camposExtras = [];
		// pega os campos extras da tabela Cliente
		if ($camposExtras = camposExtras('produto')) :

			foreach ($camposExtras as $ce) :

				$colunasExtras[slug($ce)] = $ce;

			endforeach;
		else :
			$colunasExtras = array();
		endif;

		$data['colunas'] = array_merge($colunas, $colunasExtras);



		$data['camposExtras'] = $camposExtras;
		// print_r($data);exit;
		return template('modules/produtos/index', $data);
	}

	public function detalhe($codeProduto)
	{

		$data['tituloPagina'] = "Produtos";
		$data['subtituloPagina'] = "Detalhes";

		$produtos = new NewProdutoModel();

		$result = $produtos->where('code', $codeProduto)
			// ->where('codeEmpresa', CODEEMPRESA)
			->first();

		if (!$result) :
			setSwal('error', 'Ops!', 'Produto não encontrado');
			return redirect()->to(base_url('produtos'));
		endif;
		// dd($result);

		// $statusHistoricoModel = new StatusHistoricoModel();
		// $historico = $statusHistoricoModel->where('tabela', 'empresa')
		// 	->like('codeRef', $codeEmpresa)
		// 	->orderBy('id', 'desc')
		// 	->findAll();
		// $data['historico'] = $historico;
		// $data['estados'] = getApi('estados', true);
		// print_r($data);exit;
		$data['produtos'] = $result;

		return template('modules/produtos/detalhe', $data);
	}

	public function adicionar()
	{

		$data['tituloPagina'] = ucfirst(customWord('produto', false));
		$data['subtituloPagina'] = "Adicionar";
		
		$data['estados'] = getApi('estados', true);
		return template('modules/produtos/adicionar', $data);
	}

	public function save()
	{

		$model = new NewProdutoModel();

		$data = $this->request->getPost();
		if (isset($data['code'])) :
			$action = 'update';
		else :
			$data['code'] = code();
			$data['codeUsuario'] = $_SESSION['usuarioCode'];
			$data['codeStatus'] = 'inicial';
			$action = 'insert';
			// $usuario = $model->where('cnpj', $data['cnpj'])->first();
			// if ($usuario) :
			// 	setSwal('error', 'Ops!', 'Este cnpj já foi cadastrado em outra conta.');
			// 	return redirect()->to(base_url('empresa/adcionar'));
			// endif;
		endif;

		// print_r($action);exit;

		// $data['codeEmpresa'] = $_SESSION['usuarioEmpresa'];
		if(isset($data['camposExtras'])) {
			$data['camposExtras'] = json_encode($data['camposExtras']);
		}
		// echo "<pre>";
		// print_r($data);
		// exit;
		if ($action == 'insert') :
			$model->insert($data);
			// addHistorico('produtos', $data['code'], 'inicial', 'Produto criado.');
			setSwal('success', 'Tudo certo!', 'Produto adicionado com sucesso.');
		elseif ($action == 'update') :
			$model->save($data);
			
			if ((isset($data['obs']) && !empty($data['obs'])) && isset($data['codeStatus'])) :
				//salvar no historico
				$dataHistorico['tabela'] = 'produtos';
				$dataHistorico['codeUsuario'] = $_SESSION['usuarioCode'];
				$dataHistorico['codeStatus'] = $data['codeStatus'];
				$dataHistorico['codeRef'] = $data['code'];
				$dataHistorico['mensagem'] = $data['obs'];


				$historicoLead = new StatusHistoricoModel();
				$historicoLead->save($dataHistorico);
				// remover obs
				unset($data['obs']);
				
			endif;
			setSwal('success', 'Tudo certo!', 'O produto foi atualizada.');
		endif;
		$redirect = (isset($data['redirect'])) ? $data['redirect'] : base_url('produtos/detalhe/'.$data['code']);
		unset($data['redirect']);
		return redirect()->to($redirect);
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
