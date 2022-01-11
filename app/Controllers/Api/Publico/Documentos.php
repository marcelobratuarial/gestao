<?php

namespace App\Controllers\Api\Publico;

use App\Controllers\ApiBaseController;
use App\Models\DocumentoInfoModel;
use App\Models\DocumentoModel;
use App\Models\UsuarioModel;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use ReflectionException;

class Documentos extends ApiBaseController
{
	/**
	 * Register a new user
	 * @return Response
	 * @throws ReflectionException
	 */
	public function info()
	{

		$documentoInfoModel = new DocumentoInfoModel();
		$result = $documentoInfoModel->where('codeEmpresa', CODEEMPRESA)->findAll();
		$total_result = count($result);

		return $this->getResponse(
			[
				'success' => true,
				'data' => [
					'total_etapas' => $total_result,
					'dados_documentos' => $result
				]
			],
			ResponseInterface::HTTP_OK
		);
	}

	public function create()
	{
		$proposta = getProposta($this->request->getPost('codeProposta'));
		if ($proposta) :
			$files = $this->request->getFiles()['file'];
			// v($files);
			foreach ($files as $etapa => $file) :
				// v($file);
				// die();
				if ($file->getSize() > 0) :
					$data["etapa"] = $etapa;
					$data["codeProposta"] = $proposta->code;
					$data["codeEmpresa"] = CODEEMPRESA;
					$data['status'] = 1;
					$data['motivo_rejeicao'] = null;
					$redirect_url = $this->request->getPost('redirect_url');
					// $data['codeUsuario'] = $dataToken['token']['codeUsuario'];

					$documentoModel = new DocumentoModel();
					$documento = $documentoModel->where('etapa', $data['etapa'])->where('codeProposta', $data['codeProposta'])->first();

					$editImage = \Config\Services::image();
					$image = $file->getName();
					$temp = explode(".", $image);
					$extensao = strtolower(end($temp));

					if ($extensao != 'png' && $extensao != 'jpg' && $extensao != 'jpeg' && $extensao != 'pdf' && $extensao != 'bmp' && $extensao != 'avi' && $extensao != 'mpg' && $extensao != 'mpeg' && $extensao != 'wmv' && $extensao != 'mp4') :
						$return = $this->getResponse(
							[
								'success' => false,
								'data' => [
									'message' => "Formato inválido de arquivo enviado."
								]
							],
							ResponseInterface::HTTP_BAD_REQUEST
						);
					else :

						$newfilename = $data["codeProposta"] . '-' . gerar_senha(10, false, true, false, false) . '.' . $extensao;

						if ($file->move("upload", $newfilename)) :
							$editImage->withFile('upload/' . $newfilename)
								->resize(1280, 1280, true, 'height')
								->save('upload/' . $newfilename);
							$data['nomeArquivo'] = $newfilename;
							if (isset($documento['nomeArquivo'])) :
								if (file_exists('upload/' . $documento['nomeArquivo'])) :
									unlink('upload/' . $documento['nomeArquivo']);
								endif;
								$data['id'] = $documento['id'];
							endif;
						endif;
						if ($documentoModel->save($data)) :
							$return = $this->getResponse(
								[
									'success' => true,
									'data' => [
										'message' => "Upload realizado com sucesso",
										'url' => base_url("/upload/" . $data['nomeArquivo'])
									]
								],
								ResponseInterface::HTTP_OK
							);
						else :
							if (file_exists('upload/' . $documento['nomeArquivo'])) :
								unlink('upload/' . $documento['nomeArquivo']);
							endif;
							$return = $this->getResponse(
								[
									'success' => false,
									'data' => [
										'message' => "Erro ao enviar arquivo."
									]
								],
								ResponseInterface::HTTP_BAD_REQUEST
							);
						endif;
					endif;
				else :
					$return = $this->getResponse(
						[
							'success' => false,
							'data' => [
								'message' => "Necessário enviar um arquivo."
							]
						],
						ResponseInterface::HTTP_BAD_REQUEST
					);
				endif;
			endforeach;
		else :
			$return = $this->getResponse(
				[
					'success' => false,
					'data' => [
						'message' => "Proposta inválida."
					]
				],
				ResponseInterface::HTTP_BAD_REQUEST
			);
		endif;
		if ($redirect_url) :
			$return = json_decode($return->getBody(), true);
			return redirect()->to($redirect_url . '?m=' . $return['data']['message']);
		else :
			return $return;
		endif;
	}
	//SHOW
	//Venda Propostas Lead Filtros
}
