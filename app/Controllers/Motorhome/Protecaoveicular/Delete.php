<?php

namespace App\Controllers\Motorhome\Protecaoveicular;

use App\Controllers\Motorhome\BaseController;
use App\Models\Motorhome\ProtecaoVeicular\CategoriaModel;
use App\Models\LidMotorhomeer\ProtecaoVeicular\TabelaModel;
use App\Models\Motorhome\ProtecaoVeicular\OpcionaisModel;


class Delete extends BaseController
{

	public function categoria($primaryKey)
	{
		$model = new CategoriaModel();
		$model->delete($primaryKey);
		setSwal('success', 'Tudo certo!', 'Categoria excluída com sucesso.');
		return redirect()->to(base_url($this->path . '/categorias'));
	}

	public function opcional($primaryKey)
	{
		$model = new OpcionaisModel();
		$opcional = $model->find($primaryKey);
		$model->delete($primaryKey);
		setSwal('success', 'Tudo certo!', 'Opcional excluído com sucesso.');
		return redirect()->to(base_url($this->path . '/categoria/' . $opcional->codeCategoria . '/opcionais'));
	}
	public function tabela($primaryKey)
	{
		$model = new TabelaModel();
		$model->delete($primaryKey);
		setSwal('success', 'Tudo certo!', 'Tabela salva com sucesso.');
		return redirect()->back();
	}
}
