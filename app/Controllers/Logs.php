<?php


namespace App\Controllers;

class Logs extends BaseController
{
	public function _remap($date = null)

	{

		if (!permissao('admin')) :
			setSwal('error', 'Acesso restrito', 'Você não tem permissão para acessar essa página.');
			return redirect()->to(base_url('dashboard'));
		endif;
		if ($date == 'index') :
			return redirect()->to(base_url("logs/" . date('Y-m-d')));
		endif;

		$date = str_replace('_', '-', $date);
		helper('filesystem');
		$data['tituloPagina'] = "Logs";
		$data['subtituloPagina'] = date('d/m/Y', strtotime($date));

		$path = APPPATH . "../writable/logs/log-$date.log";
		//$file = new \CodeIgniter\Files\File($path);
		$data['date'] = $date;
		if (file_exists($path)) :
			$data['file'] = file_get_contents($path);
		elseif ($date != date('Y-m-d')) :
			setSwal('info', 'Não encontrado.', 'Não existem logs para a data informada.');
			return redirect()->to(base_url("logs/" . date('Y-m-d')));
		else :
			setSwal('info', 'Não encontrado.', 'Não tem logs hoje.');
			return redirect()->to(base_url("dashboard"));
		endif;

		return template('modules/logs/index', $data);
	}
}
