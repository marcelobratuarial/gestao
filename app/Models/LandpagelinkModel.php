<?php

namespace App\Models;

use CodeIgniter\Model;

class LandpagelinkModel extends Model {

	protected $table = 'landpage_link';

	protected $primaryKey = 'code';

	protected $returnType = 'object';
	protected $useSoftDeletes = true;

	protected $useTimestamps = true;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';

	    protected $allowedFields = ['code','destino','destinoValor','destinoPosicao','codeLandpage','url','status'];

}
