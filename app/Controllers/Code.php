<?php

namespace App\Controllers;


class Code extends BaseController
{

	public function index()
	{

		d(code());
	}

	public function apiKeys()
	{
		$encrypter = \Config\Services::encrypter();

		$data['apiKey'] = base64_encode($encrypter->encrypt(CODEEMPRESA, ['key' => 'New secret key', 'blockSize' => 100]));

		$data['apiSecretKey'] = base64_encode($encrypter->encrypt(CODEEMPRESA . date('Ymdhis')));

		dd($data);
	}
}
