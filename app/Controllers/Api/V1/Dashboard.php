<?php

namespace App\Controllers\Api\V1;

use App\Controllers\ApiBaseController;
use App\Models\AlertaModel;
use App\Models\PropostaModel;
use App\Models\UsuarioModel;
use App\Models\VendaModel;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use ReflectionException;

class Dashboard extends ApiBaseController
{
    /**
     * Register a new user
     * @return Response
     * @throws ReflectionException
     */

    public function resumo()
    {
        $filtro_data = $this->request->getVar('data');

        $usuarioModel = new UsuarioModel();
        $dataToken = dataToken(getBearerToken($this->request));
        if($dataToken):
            $usuario = $usuarioModel->find($dataToken['token']['codeUsuario']);

            $modelPropostas = new PropostaModel();   
            $modelPropostas->where('codeUsuario', $usuario->code);
            if ($filtro_data != null):
                $modelPropostas->where('created_at', $filtro_data);
            endif;
            $totalCotacoes = count($modelPropostas->findAll());
            
            $modelConversao = new PropostaModel();   
            $modelConversao->where('codeUsuario', $usuario->code);
            $modelConversao->where('assinada', 1);
            if ($filtro_data != null):
                $modelConversao->where('created_at', $filtro_data);
            endif;
            $totalConversao = count($modelConversao->findAll());
        
            $modelVendas = new VendaModel();
            $modelVendas->where('codeUsuario', $usuario->code);
            if ($filtro_data != null):
                $modelConversao->where('created_at', $filtro_data);
            endif;
            $totalVendas = count($modelVendas->findAll());

        
            return $this->getResponse(
                [
                    'success' => true,
                    'data' => [
                        'total_cotacoes' => $totalCotacoes,
                        'taxa_conversao' => $totalConversao,
                        'total_vendas' => $totalVendas
                    ]
                ],
                ResponseInterface::HTTP_OK
            );
        endif;
    }

    
    public function alertas()
    {
        $dataToken = dataToken(getBearerToken($this->request));
        $usuarioModel = new UsuarioModel();
		if($dataToken):
            $usuario = $usuarioModel->find($dataToken['token']['codeUsuario']);
			
			$qtdItens = $this->request->getVar('qtd_itens');
			$pagina = $this->request->getVar('pagina');
			$qtdItens = ($qtdItens) ? $qtdItens : 10;
			$pagina = ($pagina) ? $pagina : 1;

			$alertaModel = new AlertaModel();
			$result = $alertaModel->where('codeUsuario', $usuario->code)->findAll();
			$total_result = count($result);

			$result = $alertaModel->where('codeUsuario', $usuario->code)->findAll($qtdItens, $pagina - 1);

			return $this->getResponse(
				[
					'success' => true,
					'data' => [
						'total' => $total_result,
						'qtd_itens' => $qtdItens,
						'pagina' => $pagina,
						'alertas' => $result
					]
				],
				ResponseInterface::HTTP_OK
			);
		endif;
    }

   
}
