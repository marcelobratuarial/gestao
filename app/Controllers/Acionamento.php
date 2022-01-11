<?php

namespace App\Controllers;

use App\Models\AcionamentoModel;
use App\Models\StatusModel;


class Acionamento extends BaseController

{

		
	public function index()

	{
		$data['tituloPagina'] = "Acionamentos";
		$data['subtituloPagina'] = "Lista";
		
		$model = new AcionamentoModel();

        $data['acionamentos'] = $model->meusAcionamentos();
		
		$data['status'] = getStatus('acionamento');
		

		$colunas = array('code'=>'#REF','created_at'=>'Data' , 'codeCliente'=>'Cliente', 'codeStatus'=>'Status' );

		// pega os campos extras da tabela Cliente
		if ($camposExtras = camposExtras('acionamento')) :

			foreach ($camposExtras as $ce) :

				$colunasExtras[slug($ce)] = $ce;

			endforeach;
		else :
			$colunasExtras = array();
		endif;

		$data['colunas'] = array_merge($colunas, $colunasExtras);

		$data['camposExtras'] = $camposExtras;
		

		return template('modules/acionamento/index',$data);

	}

	

	public function detalhe($codeAcionamento)

	{
		$data['tituloPagina'] = "Pesquisa";
		$data['subtituloPagina'] = "Detalhe";
		
		$model = new AcionamentoModel();


		$result = $model->where('code',$codeAcionamento)
					->findAll();


        $data['acionamento'] = $result[0];
		

		return template('modules/acionamento/detalhe',$data);


	}

	


}

