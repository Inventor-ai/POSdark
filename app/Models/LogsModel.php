<?php

namespace App\Models;

use CodeIgniter\Model;

class LogsModel extends Model 
{
  protected $table      = 'log';
  protected $primaryKey = 'id';

  protected $useAutoIncrement = true;

  protected $returnType     = 'array';
  protected $useSoftDeletes = false;
  protected $allowedFields = [
    'usuario_id', 'evento', 'ip', 'detalles'
  ];

  protected $useTimestamps = true;
  protected $createdField  = 'fecha';
  protected $updatedField  = '';
//   protected $deletedField  = 'deleted_at';

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;
}
