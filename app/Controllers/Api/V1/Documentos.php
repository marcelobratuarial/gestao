<?php

namespace App\Controllers\Api\V1;

use App\Controllers\ApiBaseController;
use App\Models\DocumentoInfoModel;
use App\Models\DocumentoModel;
use App\Models\PropostaModel;
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
	public function info($code = null)
	{
		$dataToken = dataToken(getBearerToken($this->request));
		if ($dataToken) :

			$documentoInfoModel = new DocumentoInfoModel();
			$result = $documentoInfoModel->where('codeEmpresa', CODEEMPRESA)->findAll();
			$total_result = count($result);

			$documentocorrecao = 0;
			$result_pendencias = null;


			if ($code) :
				$propostaModel = new PropostaModel();
				$result_proposta = $propostaModel->where('code', $code)->first();
				if ($result_proposta) :
					if ($result_proposta->documento_correcao == 1) :
						$documentocorrecao = 1;
						$documentoModel = new DocumentoModel();
						$documentoModel->where('codeProposta', $code);
						$documentoModel->where('status', 2);
						$result_pendencias = $documentoModel->findAll();
					endif;
				else :
					return $this->getResponse(
						[
							'success' => false,
							'data' => [
								'message' => 'Nenhuma proposta encontrada com esse código!'
							]
						],
						ResponseInterface::HTTP_NOT_FOUND
					);
				endif;
			endif;


			return $this->getResponse(
				[
					'success' => true,
					'data' => [
						'total_etapas' => $total_result,
						'dados_documentos' => $result,
						'documento_correcao' => $documentocorrecao,
						'pendencias' => $result_pendencias
					]
				],
				ResponseInterface::HTTP_OK
			);
		endif;
	}

	public function create()
	{
		$dataToken = dataToken(getBearerToken($this->request));
		if ($dataToken) :
			$file = $this->request->getFile('file');
			if ($file->getSize() > 0) :
				$data["etapa"] = $this->request->getPost('etapa');
				$data["codeProposta"] = $this->request->getPost('codeProposta');
				$data['codeUsuario'] = $dataToken['token']['codeUsuario'];

				$vistoriaModel = new DocumentoModel();
				$vistoria = $vistoriaModel->where('etapa', $data['etapa'])->where('codeProposta', $data['codeProposta'])->first();

				$editImage = \Config\Services::image();
				$image = $file->getName();
				$temp = explode(".", $image);
				$extensao = strtolower(end($temp));

				if ($extensao != 'png' && $extensao != 'jpg' && $extensao != 'jpeg' && $extensao != 'pdf' && $extensao != 'bmp' && $extensao != 'avi' && $extensao != 'mpg' && $extensao != 'mpeg' && $extensao != 'wmv' && $extensao != 'mp4') {
					return $this->getResponse(
						[
							'success' => false,
							'data' => [
								'message' => "Formato inválido de arquivo enviado."
							]
						],
						ResponseInterface::HTTP_BAD_REQUEST
					);
				}

				$newfilename = $data["codeProposta"] . '-' . gerar_senha(10, false, true, false, false) . '.' . $extensao;

				if ($file->move("upload", $newfilename)) :
					$editImage->withFile('upload/' . $newfilename)
						->resize(1280, 1280, true, 'height')
						->save('upload/' . $newfilename);
					$data['nomeArquivo'] = $newfilename;
					if (isset($vistoria['nomeArquivo'])) :
						unlink('upload/' . $vistoria['nomeArquivo']);
						$data['id'] = $vistoria['id'];
					endif;
				endif;
				if ($vistoriaModel->save($data)) :

					return $this->getResponse(
						[
							'success' => true,
							'data' => [
								'message' => "Upload realizado com sucesso",
								'url' => "https://motorhome.brasilplataformas.com/upload/" . $data['nomeArquivo']
							]
						],
						ResponseInterface::HTTP_OK
					);
				else :
					return $this->getResponse(
						[
							'success' => false,
							'data' => [
								'message' => "Erro ao enviar arquivo."
							]
						],
						ResponseInterface::HTTP_BAD_REQUEST
					);
				endif;
			else :
				return $this->getResponse(
					[
						'success' => false,
						'data' => [
							'message' => "Necessário enviar um arquivo."
						]
					],
					ResponseInterface::HTTP_BAD_REQUEST
				);
			endif;

		else :
			return $this->getResponse(
				[
					'success' => false,
					'data' => [
						'message' => "Token Inválido"
					]
				],
				ResponseInterface::HTTP_UNAUTHORIZED
			);
		endif;
	}

	// public function show($code = null)
	// {
	// 	if ($code != null) {
	// 		$dataToken = dataToken(getBearerToken($this->request));
	// 		if ($dataToken) :

	// 			$documentoModel = new DocumentoModel();
	// 			$result = $documentoModel->where('codeProposta', $code)->first();

	// 			if ($result == null) {
	// 				return $this->getResponse(
	// 					[
	// 						'success' => false,
	// 						'data' => [
	// 							'message' => 'Nenhuma proposta encontrada com esse código...!'
	// 						]
	// 					],
	// 					ResponseInterface::HTTP_NOT_FOUND
	// 				);
	// 			} else {
	// 				return $this->getResponse(
	// 					[
	// 						'success' => true,
	// 						'data' => $result
	// 					],
	// 					ResponseInterface::HTTP_OK
	// 				);
	// 			}

	// 		endif;
	// 	} else {

	// 		return $this
	// 			->getResponse(
	// 				[
	// 					'success' => false,
	// 					'data' => [
	// 						'message' => 'É necessário informar um código!'
	// 					]
	// 				],
	// 				ResponseInterface::HTTP_BAD_REQUEST
	// 			);
	// 	}
	// }

	public function listar_por_proposta($code = null)
	{
		if ($code != null) {


			$dataToken = dataToken(getBearerToken($this->request));
			if ($dataToken) :

				$documentoModel = new DocumentoModel();
				$result = $documentoModel->where('codeProposta', $code)->findAll();

				if ($result == null) {
					return $this->getResponse(
						[
							'success' => false,
							'data' => [
								'message' => 'Nenhuma documento encontrada com esse código!'
							]
						],
						ResponseInterface::HTTP_NOT_FOUND
					);
				} else {
					return $this->getResponse(
						[
							'success' => true,
							'data' => $result
						],
						ResponseInterface::HTTP_OK
					);
				}

			endif;
		} else {

			return $this
				->getResponse(
					[
						'success' => false,
						'data' => [
							'message' => 'É necessário informar um código!'
						]
					],
					ResponseInterface::HTTP_BAD_REQUEST
				);
		}
	}
}
