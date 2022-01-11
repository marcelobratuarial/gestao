<?php

namespace App\Controllers;

use App\Models\ModulosModel;
use App\Models\ModulosEmpresaModel;

class Modulo extends BaseController {
	public function index() {
		$data['tituloPagina'] = "Modulos";
		$data['subtituloPagina'] = "Lista";
		
		return template('modules/modulo/index', $data);
	}
	public function save() {
		$model = new ModulosModel();
		$data = $this->request->getPost();
		$data['code'] = slug($data['nome']);
		$data['nome'] = ucfirst($data['nome']);
		$data['pai'] = ($data['pai'] != '') ? $data['pai'] : null;
		$model->insert($data);
		return redirect()->to(base_url('modulo'));
	}
	public function update() {
		$modulosEmpresa = new ModulosEmpresaModel();
		$modulosPadrao = new ModulosModel();
		$data = $this->request->getPost();
		$mEmpresa = $modulosEmpresa->where('code', $data['code'])
			->first();
		$mPadrao = $modulosPadrao->where('code', $data['code'])
			->first();
		if ($mEmpresa) :
			$modulosEmpresa->save($data);
		
		elseif ($mPadrao) :
			$modulosPadrao->save($data);
		
		else :
			echo "não encontrado";
		
		endif;
	}
	public function saveIcon() {
		$model = new ModulosModel();
		$data = $this->request->getPost();
		$model->save($data);
	}
	public function order($tipo) {
		switch ($tipo) {
			case 'padrao':
				$model = new ModulosModel();
				break;
			case 'empresa':
				$model = new ModulosEmpresaModel();
				break;
		}
		
		$post = $this->request->getPost();
		v($post);
		$num = 1;
		foreach ($post['novaOrdem'] as $d) :
			$data['code'] = str_replace('CD#', '', $d);
			$data['ordem'] = $num;
			$model->save($data);
			$num ++;
		endforeach
		;
	}
	public function status($code, $tipo) {
		$model = new ModulosEmpresaModel();
		
		$data['code'] = $code;
		switch ($tipo) {
			case 'ativar':
				$data['status'] = 1;
				break;
			case 'desativar':
				$data['status'] = 2;
				break;
		}
		
		$model->save($data);
		return redirect()->to(base_url('modulo'));
	}
	public function insert() {
		$padrao = new ModulosModel();
		$model = new ModulosEmpresaModel();
		$post = $this->request->getPost();
		$codeEmpresa = $_SESSION['usuarioEmpresa'];
		
		if ($post['pai']) :
			// Verficar se já existe o modulo pai criado para a empresa
			$mEmpresa = $model->where('codeEmpresa', $codeEmpresa)
				->where('codeModulo', $post['pai'])
				->first();
			if (is_object($mEmpresa)) :
				echo 'modulo pai já existe';
			
			else :
				echo 'modulo pai não existe';
				
				$mPadrao = $padrao->where('code', $post['pai'])
					->first();
				
				$data['code'] = code();
				$data['codeEmpresa'] = $codeEmpresa;
				$data['codeModulo'] = $mPadrao->code;
				$data['pai'] = $mPadrao->pai;
				$data['nome'] = $mPadrao->nome;
				$data['icone'] = $mPadrao->icone;
				$data['ordem'] = $mPadrao->ordem;
				
				$model->insert($data);
				echo v($data);
			endif;
		endif;
		
			// Verficar se já existe o modulo criado para a empresa
		$mEmpresa = $model->where('codeEmpresa', $codeEmpresa)
			->where('codeModulo', $post['code'])
			->first();
		if (is_object($mEmpresa)) :
			echo 'modulo já existe';
		
		else :
			echo 'modulo não existe';
			$mPadrao = $padrao->where('code', $post['code'])
				->first();
			
			$data['code'] = code();
			$data['codeEmpresa'] = $codeEmpresa;
			$data['codeModulo'] = $mPadrao->code;
			$data['pai'] = $mPadrao->pai;
			$data['nome'] = $mPadrao->nome;
			$data['icone'] = $mPadrao->icone;
			$data['ordem'] = $mPadrao->ordem;
			
			$model->insert($data);
			
			echo v($data);
		endif;
	}
}

