<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfiguracionesModel extends Model 
{
  protected $table      = 'configuraciones';
  protected $primaryKey = 'id';

  protected $useAutoIncrement = true;

  protected $returnType     = 'array';
  protected $useSoftDeletes = false;
  protected $useSoftUpdates = false;
  protected $useSoftCreates = false;
  protected $allowedFields = ['nombre', 'valor'];

  protected $useTimestamps = false;
  // protected $createdField  = 'fecha_alta';
  // protected $updatedField  = 'fecha_edit';
//   protected $deletedField  = 'deleted_at';

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;
}
