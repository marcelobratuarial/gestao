<?php

namespace App\Controllers\Motorhome\Protecaoveicular\Api;

use App\Models\Motorhome\ProtecaoVeicular\CategoriaModel;
use App\Models\Motorhome\ProtecaoVeicular\TabelaModel;
use CodeIgniter\RESTful\ResourceController;

class Tabela extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $tabelaModel = new TabelaModel();
        $categoriaModel = new CategoriaModel();

        $tipo = $this->request->getVar('tipo');


        $categoria = $categoriaModel->where('code', $tipo)->orWhere('apiRef', $tipo)->first();


        if ($categoria) :
            $codeCategoria = $categoria->code;

            //v($tipo);
            $valor = $this->request->getVar('valor');
            $valor = str_replace('R$', '', $valor);
            $valor = str_replace('.', '', $valor);
            $valor = trim(str_replace(',', '.', $valor));
            // dd($valor);

            $implemento = $this->request->getVar('implemento_valor');
            $implemento = str_replace('R$', '', $implemento);
            $implemento = str_replace('.', '', $implemento);
            $implemento = trim(str_replace(',', '.', $implemento));

            $valor = ($implemento) ? $valor + $implemento : $valor;

            $tabela = $tabelaModel
                ->select('*')
                ->where('codeCategoria', $codeCategoria)
                ->where('valor_de <=', $valor)
                ->where('valor_ate >=', $valor)
                ->first();


            if ($tabela) :
                $tabela->valor = $valor;
                //$_SESSION['tabela'] = $tabela;
                return $this->respond($tabela);
            else :
                $data['error'] = 'Infelizmente ainda não oferecemos proteção pra este veículo.';
                return $this->respond($data);
            endif;
        else :
            $data['error'] = 'Categoria não encontrada.';
            return $this->respond($data);
        endif;
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }
}
