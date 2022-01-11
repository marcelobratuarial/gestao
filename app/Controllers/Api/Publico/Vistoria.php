<?php

namespace App\Controllers\Api\Publico;

use App\Controllers\ApiBaseController;
use App\Models\DocumentoInfoModel;
use App\Models\DocumentoModel;
use App\Models\PropostaModel;
use App\Models\UsuarioModel;
use App\Models\VistoriaInfoModel;
use App\Models\VistoriaModel;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use ReflectionException;

class Vistoria extends ApiBaseController
{
	/**
	 * Register a new user
	 * @return Response
	 * @throws ReflectionException
	 */
	public function info($code = null)
	{
		if ($code) :
			$proposta = getProposta($code);
			if ($proposta) :
				$filter['categoria'] = $this->request->getVar('categoria');
				$vistoriaInfoModel = new VistoriaInfoModel();
				$vistoriaInfoModel->where('codeEmpresa', CODEEMPRESA);

				if($filter['categoria'] != null):
					$vistoriaInfoModel->where('categoria', $filter['categoria']);
				endif;

				$result = $vistoriaInfoModel->findAll();
				$total_result = count($result);

				$etapa_video = 0;
				$solicita_video = 0;
				$vistoriacorrecao = 0;
				$result_pendencias = null;
						
					$propostaModel = new PropostaModel();
					$result_proposta = $propostaModel->where('code', $code)->first();

					if ($result_proposta) :
						if ($result_proposta->vistoria_video == 1) :
							$solicita_video = 1;
							$etapa_video = $total_result + 1;
						endif;
						if ($result_proposta->vistoria_correcao == 1) :
							$vistoriacorrecao = 1;
							$vistoriaModel = new VistoriaModel();
							$vistoriaModel->where('codeProposta', $code);
							$vistoriaModel->where('status', 2);
							$result_pendencias = $vistoriaModel->findAll();
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
				


				return $this->getResponse(
					[
						'success' => true,
						'data' => [
							'total_etapas' => $total_result,
							'dados_vistoria' => $result,
							'solicita_video' => $solicita_video,
							'video_adicional' => [
								'code_empresa' => CODEEMPRESA,
								'etapa' => $etapa_video,
								'titulo' => 'video complementar',
								'foto' => 'https://portal.crea-sc.org.br/wp-content/uploads/2017/11/imagem-indisponivel-para-produtos-sem-imagem_15_5.jpg',
								'instrucoes' => 'Gravar um video mostrando os pontos que foram reprovados via fotos.'
							],
							'vistoria_correcao' => $vistoriacorrecao,
							'correcoes' => $result_pendencias
						]
					],
					ResponseInterface::HTTP_OK
				);
			else:
				$return = $this->getResponse(
					[
						'success' => false,
						'data' => [
							'message' => "Proposta não encontrada."
						]
					],
					ResponseInterface::HTTP_NOT_FOUND
				);

			endif;
		else:
			$return = $this->getResponse(
				[
					'success' => false,
					'data' => [
						'message' => "Necessário informar um código de proposta"
					]
				],
				ResponseInterface::HTTP_NOT_FOUND
			);

		endif;
	}

	public function create()
	{
		$proposta = getProposta($this->request->getPost('codeProposta'));
		if ($proposta) :
			$files = $this->request->getFiles()['file'];

			foreach ($files as $etapa => $file) :

				if ($file->getSize() > 0) :
					$data["etapa"] = $etapa;
					$data["codeProposta"] = $proposta->code;
					$data["codeEmpresa"] = CODEEMPRESA;
					$data['status'] = 1;
					$data['motivo_rejeicao'] = null;
					$data['geolocalizacao'] = $this->request->getPost('geolocalizacao');

					$redirect_url = $this->request->getPost('redirect_url');
					

					$vistoriaModel = new VistoriaModel();
					$vistoria = $vistoriaModel->where('etapa', $data['etapa'])->where('codeProposta', $data['codeProposta'])->first();

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
							if (isset($vistoria['nomeArquivo'])) :
								if (file_exists('upload/' . $vistoria['nomeArquivo'])) :
									unlink('upload/' . $vistoria['nomeArquivo']);
								endif;
								$data['id'] = $vistoria['id'];
							endif;
						endif;
						if ($vistoriaModel->save($data)) :
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
							if (file_exists('upload/' . $vistoria['nomeArquivo'])) :
								unlink('upload/' . $vistoria['nomeArquivo']);
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
		if (isset($redirect_url) && $redirect_url) : 
			$return = json_decode($return->getBody(), true);
			return redirect()->to($redirect_url . '?m=' . $return['data']['message']);
		endif;
	}

}
