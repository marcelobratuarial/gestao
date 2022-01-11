<?php

namespace App\Models\Lider\Combos;

use CodeIgniter\Model;


class TabelaModel extends Model
{

    protected $DBGroup = 'lider';

    protected $table      = 'combos_tabela';

    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['codeCategoria', 'valor_de', 'valor_ate', 'planos', 'adesao', 'desconto'];

    protected $useTimestamps = false;

    protected $afterFind = ['jsonDecode'];

    protected function jsonDecode($data)
    {
        $array = false;
        if (is_array($data['data']) && isset($data['data'][0])) :
            if (is_array($data['data'][0])) :
                $array = true;
            endif;
            foreach ($data['data'] as $key => $values) :
                foreach ((object) $values as $k => $v) :
                    json_decode($v);
                    if (json_last_error() === JSON_ERROR_NONE) :
                        if (isset($data['data'][$key])) :
                            $data['data'][$key]->$k = json_decode($v, $array);
                        endif;
                    endif;
                endforeach;
                $data['data'][$key] = $array ? (array) $data['data'][$key] : (object) $data['data'][$key];
            endforeach;

        else :
            if (is_array($data['data'])) :
                $array = true;
            endif;
            $data['data'] = (object) $data['data'];
            foreach ($data['data'] as $k => $v) :
                json_decode($v);
                if (json_last_error() === JSON_ERROR_NONE) :
                    if (isset($data['data'])) :
                        $data['data']->$k = json_decode($v, $array);
                    endif;
                endif;
            endforeach;
            $data['data'] = $array ? (array) $data['data'] : (object) $data['data'];
        endif;
        return $data;
    }
}
