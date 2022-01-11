<?php

namespace App\Controllers;

use App\Models\StatusModel;


class Status extends BaseController

{



	public function tabela($tabela)

	{

		foreach (getStatus($tabela) as $k => $s) :
			if ($s->code != 'final' || $tabela == 'proposta') :
				$data[$s->code] = $s->nome;
			endif;
		endforeach;

		return json_encode($data);
	}
}
