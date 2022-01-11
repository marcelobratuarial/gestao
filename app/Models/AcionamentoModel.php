<?php

namespace App\Models;
use CodeIgniter\Model;


class AcionamentoModel extends Model
{

    protected $table      = 'acionamento';

    protected $primaryKey = 'code';

	protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


	public function meusAcionamentos(){


		    return $this->where('codeEmpresa',$_SESSION['usuarioEmpresa'])
						->findAll();
        

	}
	

}