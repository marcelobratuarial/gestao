<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\ProdutoModel;


class BaseControllerNotLogged extends Controller
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

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.: $this->session = \Config\Services::session();
		
		$this->session = \Config\Services::session();

		
	

		
	}
	
	
	
	
}
