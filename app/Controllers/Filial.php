<?php

namespace App\Controllers;

use App\Models\FilialModel;
use App\Models\ConfigModel;
use App\Models\UsuarioModel;

class Filial extends BaseController
{
	public function index()
	{
		$data['tituloPagina'] = "Filial";
		$data['subtituloPagina'] = "Lista";

		$model = new FilialModel();

		$filiaisResult = $model->where('codeEmpresa', CODEEMPRESA)->FindAll();

		$colunas = array(
			'code' => '#REF',
			'nome' => 'Nome',
			'email' => 'E-mail',
			'telefone' => 'Telefone',
			'totalUsuarios' => 'Total Usuários'
		);

		foreach ($filiaisResult as $f) :
			$usuariosModel = new UsuarioModel();
			$usuarios = $usuariosModel->like('codeFilial', $f->code)->findAll();
			$f->totalUsuarios = count($usuarios);
			$filiais[] = $f;
		endforeach;

		// pega os campos extras da tabela Cliente
		if ($camposExtras = camposExtras('filial')) :

			foreach ($camposExtras as $ce) :

				$colunasExtras[slug($ce)] = $ce;
			endforeach;

		else :
			$colunasExtras = array();
		endif;

		$data['colunas'] = array_merge($colunas, $colunasExtras);

		$data['camposExtras'] = $camposExtras;

		$data['filiais'] = $filiais;

		return template('modules/filial/index', $data);
	}
	public function detalhe($codeFilial)
	{
		$data['tituloPagina'] = "Filial";
		$data['subtituloPagina'] = "Detalhes";

		// dados da filial
		$filial = new FilialModel();
		$filial = $filial->where('code', $codeFilial)
			->first();
		$data['filial'] = $filial;

		$data['camposExtras'] = camposExtras('filial');

		$data['tituloPagina'] = "Filial";
		$data['subtituloPagina'] = 'Detalhe';

		return template('modules/filial/detalhe', $data);
	}
	public function save()
	{
		$filialModel = new FilialModel();

		$post = $this->request->getPost();

		// campos padroes
		$post['nome'] = esc($post['nome']);
		$post['endereco'] = esc($post['endereco']);
		$post['telefone'] = esc($post['telefone']);
		$post['email'] = esc($post['email']);
		$post['status'] = 1;
		$post['tipo'] = 2;
		$post['codeEmpresa'] = CODEEMPRESA;

		$post['camposExtras'] = (isset($post['camposExtras'])) ? json_encode($post['camposExtras']) : json_encode(array());

		$filialModel->save($post);

		return redirect()->to(base_url('filial'));
	}
	public function adicionar()
	{
		$data['tituloPagina'] = 'Filial ';
		$data['subtituloPagina'] = 'Adicionar ';
		$data['camposExtras'] = camposExtras('filial');

		return template('modules/filial/adicionar', $data);
	}
	public function ativar($code)
	{
		$model = new FilialModel();
		$filial = $model->where('codeEmpresa', CODEEMPRESA)->where('code', $code)->first();
		if ($filial && permissao('status_filial') && $filial->tipo == 2) :
			$data['code'] = $code;
			$data['status'] = 1;
			$model->save($data);
		else :
			setSwal('error', 'Temos um problema', 'Você não tem permissão para executar essa ação.');
		endif;
		return redirect()->to(base_url('filial/detalhe/' . $code));
	}
	public function desativar($code)
	{
		$model = new FilialModel();
		$filial = $model->where('codeEmpresa', CODEEMPRESA)->where('code', $code)->first();
		if ($filial && permissao('status_filial') && $filial->tipo == 2) :
			$data['code'] = $code;
			$data['status'] = 2;
			$model->save($data);
		else :
			setSwal('error', 'Temos um problema', 'Você não tem permissão para executar essa ação.');
		endif;
		return redirect()->to(base_url('filial/detalhe/' . $code));
	}
	public function excluir($code)
	{
		$usuariosModel = new UsuarioModel();
		$usuarios = $usuariosModel->like('codeFilial', $code)->findAll();
		$totalUsuarios = count($usuarios);

		$filialModel = new FilialModel();
		$filial = $filialModel->where('codeEmpresa', CODEEMPRESA)->where('code', $code)->first();

		if ($totalUsuarios > 0 || $filial->tipo == 1) :
			setSwal('error', 'Temos um problema', 'Essa filial não pode ser excluída.');
		elseif ($filial && permissao('excluir_filial')) :
			setSwal('success', 'Tudo certo', 'Filial excluída com sucesso.');
			$filialModel->delete($code);
		else :
			setSwal('error', 'Temos um problema', 'Essa Filial não existe ou você não tem permissão para executar essa ação.');
		endif;
		return redirect()->to(base_url('filial'));
	}

	public function csvImport()
	{
		// Validação
		$input = $this->validate([
			'file' => 'uploaded[file]|max_size[file,1024]|ext_in[file,csv],'
		]);
		if (!$input) { // Não é valido
			$data['validation'] = $this->validator;
			setSwal('error', 'Ops!', 'Tipo de arquivo inválido.');
			return redirect()->to(base_url('filial'));
		} else { // É valido
			if ($file = $this->request->getFile('file')) {
				if ($file->isValid() && !$file->hasMoved()) {
					// Gera um nome aleatório
					$newName = $file->getRandomName();
					// Salva na pasta temp
					$file->move('../public/temp', $newName);
					// Lê o arquivo
					$file = fopen("../public/temp/" . $newName, "r");
					$i = 0;
					$numberOfFields = 1; // Total de campos
					$importData_arr = array();
					// Inicializa a importação
					while (($filedata = fgetcsv($file, 1000, ";")) !== FALSE) {
						$num = count($filedata);
						// Pula a primeira linha & e verifica o numero de campos
						if ($i > 0 && $num == $numberOfFields) {
							// Nome dos campos que devem existir - nome
							$importData_arr[$i]['codeEmpresa'] = CODEEMPRESA;
							$importData_arr[$i]['nome'] = $filedata[0];
						}
						$i++;
					}
					fclose($file);

					// Conexão com o banco
					$filialModel = new FilialModel();

					foreach ($importData_arr as $insertData) {
						## Insert
						$filialModel->insert($insertData);
					}
					// Mensagem de sucesso
					setSwal('success', 'Tudo certo', 'Cooperativas importadas com sucesso!');
				} else {
					// Mensagem de erro
					setSwal('error', 'Ops!', 'As cooperativas não foram importadas com sucesso.');
				}
			} else {
				// Mensagem de erro
				setSwal('error', 'Ops!', 'As cooperativas não foram importadas com sucesso.<br> Tipo de arquivo inválido.');
			}
			// Delete file
			unlink("../public/temp/$newName");
		}
		return redirect()->to(base_url('filial'));
	}
}
