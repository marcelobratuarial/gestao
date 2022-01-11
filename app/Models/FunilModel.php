<?php

namespace App\Models;
use CodeIgniter\Model;


class FunilModel extends Model
{

    protected $table      = 'funil';

    protected $primaryKey = 'code';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


    public function MeusFunis(){


		return $this->where('codeEmpresa',$_SESSION['usuarioEmpresa'])
						->findAll();
		

	}

}