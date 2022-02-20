<?php

namespace App\Models;

use CodeIgniter\Model;

class ComprasDetalleModel extends Model 
{
  protected $table      = 'compras_detalle';
  protected $primaryKey = 'id';

  protected $useAutoIncrement = true;

  protected $returnType     = 'array';
  protected $useSoftDeletes = false;
  protected $allowedFields = [
     'compra_id', 'articulo_id', 'nombre', 'cantidad', 'precio'
  ];

  protected $useTimestamps = true;
  protected $createdField  = 'fecha_alta';
  protected $updatedField  = '';
  // protected $updatedField  = 'fecha_edit'; // Fail. updated_at field needed
//   protected $deletedField  = 'deleted_at';

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;

  public function articulos($compra_id)
  {
    $campos = 'articulos.codigo, compras_detalle.nombre,'
            . 'cantidad, precio';
    $this->select($campos)
         ->join('articulos', 'articulos.id = compras_detalle.articulo_id')
         ->where('compra_id', $compra_id);
    return $this->FindAll();
  }

}
