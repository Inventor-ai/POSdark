<?php

namespace App\Models;

use CodeIgniter\Model;

class ArticulosModel extends Model 
{
  protected $table      = 'articulos';
  protected $primaryKey = 'id';

  protected $useAutoIncrement = true;

  protected $returnType     = 'array';
  protected $useSoftDeletes = false;
  protected $allowedFields = [
    'nombre', 'codigo', 'inventariable',
    'precio_venta', 'precio_compra',
    'existencias', 'stock_minimo',
    'id_unidad'  , 'id_categoria',
    'activo'  
  ];

  protected $useTimestamps = true;
  protected $createdField  = 'fecha_alta';
  protected $updatedField  = 'fecha_edit';
//   protected $deletedField  = 'deleted_at';

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;
}
