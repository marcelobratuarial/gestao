<?php

namespace App\Controllers\Api\V1;

use App\Controllers\ApiBaseController;
use App\Models\UsuarioModel;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use ReflectionException;

class Financeiro extends ApiBaseController
{
    /**
     * Register a new user
     * @return Response
     * @throws ReflectionException
     */
    public function resumo()
    {
        $data_inicio = $this->request->getVar('data_inicio');
        $data_fim = $this->request->getVar('data_inicio');
        if($data_inicio || $data_fim){
            if($data_inicio == '01/2020' && $data_fim='12/2020'){
                return $this
                ->getResponse(
                    [
                        'success' => true,
                        'data' => [
                            'total_cotacoes' => 10,
                            'taxa_conversao' => 90,
                            'total_vendas' => 9
                        ]    
                        ],
                        ResponseInterface::HTTP_OK
                );
            }
            else{
                return $this
                ->getResponse(
                    [
                        'success' => true,
                        'data' => [
                            'total_cotacoes' => 0,
                            'taxa_conversao' => 0,
                            'total_vendas' => 0
                        ]    
                        ],
                        ResponseInterface::HTTP_OK
                );
            }
            
        }
        else{

            return $this
                ->getResponse(
                    [
                        'success' => true,
                        'data' => [
                            "total_adesoes" => 0,
                            "valor_total_adesoes"=> 0,
                            "adesoes" => [
                              "code"=> 0,
                              "data_adesao"=>"string",
                              "placa"=> "string",
                              "valor_adesao"=> 0,
                              "link"=> "string"
                            ]
                        ]
                    ],
                        ResponseInterface::HTTP_OK
                );
        }
        
    }

   
}
