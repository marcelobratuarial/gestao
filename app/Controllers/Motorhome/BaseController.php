<?php

namespace App\Controllers\Motorhome;

use App\Models\ProdutoModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class BaseController extends Controller
{
	protected $helpers = [
		'default',
		'plataforma',
		'alerts'
	];
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
		date_default_timezone_set('America/Sao_Paulo');
		// --------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		// --------------------------------------------------------------------
		// E.g.: $this->session = \Config\Services::session();


		$this->session = \Config\Services::session();

		// checa se esta logado
		$this->path = 'motorhome/protecaoveicular';
		$produtoModel = new ProdutoModel();
		$this->produto = $produtoModel->where('codeEmpresa', CODEEMPRESA)->where('path', $this->path)->first();

		if (!$this->produto) :
			setSwal('error', 'Produto não encontrado!', 'O produto que você tentou acessar não existe.');
			echo '<script>location.href="' . base_url('dashboard') . '"</script>';
		endif;

		checkAuth();
	}
}
