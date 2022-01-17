<?php

namespace App\Controllers\Motorhome\Protecaoveicular;

use App\Controllers\Motorhome\BaseController;
use App\Models\Motorhome\ProtecaoVeicular\CategoriaModel;
use App\Models\Motorhome\ProtecaoVeicular\TabelaModel;
use App\Models\Motorhome\ProtecaoVeicular\OpcionaisModel;


class Save extends BaseController
{
	public function categoria()
	{
		return $this->configuracoes();
	}
	public function configuracoes()
	{
		$post = $this->request->getPost();

		$model = new CategoriaModel();

		$model->save($post);

		setSwal('success', 'Tudo certo!', 'Categoria salva com sucesso.');
		return redirect()->to(base_url($this->path . '/categorias'));
	}

	public function opcionais()
	{
		$post = $this->request->getPost();

		//$post = array_filter($post);

		$model = new OpcionaisModel();
		if ($post['options'][0]['titulo']) :
			$post['options'] = array_filter($post['options']);
			$post['options'] = json_encode(array_values($post['options']));
		else :
			unset($post['options']);
		endif;
		if ($post['tipo'] == 'oculto' || $post['tipo'] == 'checkbox') :
			$post['options'] = null;
		endif;
		$post['slug'] = slug($post['titulo']);

		//dd($post);
		$model->save($post);
		setSwal('success', 'Tudo certo!', 'Opcionais salvos com sucesso.');
		return redirect()->back();
	}
	public function tabela()
	{
		$post = $this->request->getPost();
		$post = array_filter($post);

		$model = new TabelaModel();

		//dd($post);
		if (isset($post['linha'])) :
			foreach ($post['linha'] as $k => $p) :
				$model->save($p);
			endforeach;
		else :
			$model->save($post);
		endif;
		setSwal('success', 'Tudo certo!', 'Tabela salva com sucesso.');
		return redirect()->back();
	}

	public function importar_tabela($codeCategoria)
	{
		// Validação
		$input = $this->validate([
			'file' => 'uploaded[file]|max_size[file,1024]|ext_in[file,csv],'
		]);
		if (!$input) { // Não é valido
			$data['validation'] = $this->validator;
			return view('users/index', $data);
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
					$numberOfFields = 5; // Total de campos
					$importData_arr = array();
					// Inicializa a importação
					while (($filedata = fgetcsv($file, 1000, ";")) !== FALSE) {
						$num = count($filedata);
						// Pula a primeira linha & e verifica o numero de campos
						if ($i > 0 && $num == $numberOfFields) {
							// Nome dos campos que devem existir - valor_de, valor_ate, mensalidade, cota_participativa, cota_min
							$importData_arr[$i]['codeCategoria'] = $codeCategoria;
							$importData_arr[$i]['valor_de'] = noMoney($filedata[0]);
							$importData_arr[$i]['valor_ate'] = noMoney($filedata[1]);
							$importData_arr[$i]['mensalidade'] = noMoney($filedata[2]);
							$importData_arr[$i]['cota_participativa'] = $filedata[3];
							$importData_arr[$i]['cota_min'] = noMoney($filedata[4]);
						}
						$i++;
					}
					fclose($file);

					// Conexão com o banco
					$tabelaModel = new TabelaModel();

					// Deleta os itens existentes da Categoria na tabela
					$tabelaModel->where('codeCategoria', $codeCategoria)->delete();

					foreach ($importData_arr as $insertData) {
						## Insert
						$tabelaModel->insert($insertData);
					}
					// Mensagem de sucesso
					setSwal('success', 'Tudo certo', 'Tabela importada com sucesso!');
				} else {
					// Mensagem de erro
					setSwal('error', 'Ops!', 'A tabela não foi importada com sucesso.');
				}
			} else {
				// Mensagem de erro
				setSwal('error', 'Ops!', 'A tabela não foi importada com sucesso.<br> Tipo de arquivo inválido.');
			}
			// Delete file
			unlink("../public/temp/$newName");
		}
		return redirect()->to(base_url($this->path . '/categoria/' . $codeCategoria . '/tabela'));
	}
}
