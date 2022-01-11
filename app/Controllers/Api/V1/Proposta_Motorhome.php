<?php

namespace App\Controllers\Api\V1;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Proposta_Motorhome extends ResourceController
{

    use ResponseTrait;

    public function save()
    {
        helper(['jwt', 'text', 'plataforma']);
        $dataToken = dataToken(getBearerToken($this->request));

        $usuarioModel = new \App\Models\UsuarioModel();
        $usuario = $usuarioModel->find($dataToken['token']['codeUsuario']);

        $raw = $this->request->getVar();
        $raw->code = explode('_', $raw->code)[0];
        $propostaModel = new \App\Models\PropostaModel();
        $proposta = $propostaModel->like('code', $raw->code)->orderBy('created_at', 'DESC')->first();
        $raw->code = isset($proposta->code) ? increment_string($proposta->code) : $raw->code;

        $assinaturaModel = new \App\Models\AssinaturaModel();
        //assinatura consultor		
        $assinaturaConsultor['code_contrato'] = $raw->code;
        $assinaturaConsultor['identificador_usuario'] = ($usuario->cpf) ? $usuario->cpf : null;
        $assinaturaConsultor['nomecompleto'] = $usuario->nome;
        $assinaturaConsultor['tipo_assinatura'] = 0;  //0 assinar 1 testemunhar
        $assinaturaConsultor['perfil'] = 0;  //0 consultor  1 cliente
        $assinaturaConsultor['status'] = 1;  //0 pendente 1 assinado
        $assinaturaConsultor['ip_Address'] = $_SERVER['REMOTE_ADDR'];
        $assinaturaConsultor['code_empresa'] = CODEEMPRESA;
        $assinaturaConsultor['email'] = $usuario->email;

        //assinatura cliente
        $assinaturaCliente['code_empresa'] = CODEEMPRESA;
        $assinaturaCliente['code_contrato'] = $raw->code;
        $assinaturaCliente['tipo_assinatura'] = 0;  //0 assinar 1 testemunhar
        $assinaturaCliente['perfil'] = 1;  //0 consultor  1 cliente
        $assinaturaCliente['status'] = 0;  //0 pendente 1 assinado

        $data['code'] = $raw->code;
        $data['codeEmpresa'] = CODEEMPRESA;
        $data['codeUsuario'] = $usuario->code;
        $data['codeProduto'] = $raw->codeProduto;
        $data['codigoSeguranca'] = substr($raw->telefone, -4);
        $data['codigo_email'] = strtoupper(random_string('alnum', 6));
        $data['email'] = $raw->email;
        unset($raw->code);
        $data['dadosProposta'] = json_encode($raw);

        $propostaModel = new \App\Models\PropostaModel();
        $propostaModel->insert($data);
        $proposta = $propostaModel->find($data['code']);
        if ($proposta) :
            $assinaturaModel->insert($assinaturaCliente);
            $assinaturaModel->insert($assinaturaConsultor);
            $leadModel = new \App\Models\LeadModel();
            $leadModel->update($data['code'], ['status' => 'final']);
            addHistorico('lead', $data['code'], 'final', 'Proposta gerada - ' . $data['code']);
            addHistorico('proposta', $data['code'], 'inicial', 'Proposta gerada - ' . $data['code']);

            return $this->respondCreated([
                'success' => true,
                'message' => 'Proposta cadastrada com sucesso!',
                'data' => $proposta
            ]);
        else :
            return $this->fail([
                'success' => false,
                'message' => 'Proposta não foi cadastrada com sucesso!',
                'data' => $proposta
            ], 400);
        endif;
    }
}
