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

  protected $useTimestamps = false;
  // protected $useTimestamps = true; // Fail. updated_at field needed
  protected $createdField  = 'fecha_alta';
  // protected $updatedField  = 'fecha_edit'; 
//   protected $deletedField  = 'deleted_at';

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;

  // public function insertaCompra($compra_id, $total, $usuario_id)
  // {
  //   $this->compras->insert([
  //     'folio'      => $compra_id,
  //     'total'      => $total,
  //     'usuario_id' => $usuario_id
  //   ]);
  //   return $this->insertID();
  // }

}
