<?php

namespace App\Models;

use CodeIgniter\Model;

class VentasModel extends Model 
{
  protected $table      = 'ventas';
  protected $primaryKey = 'id';

  protected $useAutoIncrement = true;

  protected $returnType     = 'array';
  protected $useSoftDeletes = false;
  protected $allowedFields = [
    'folio',   'total',      'usuario_id', 
    'caja_id', 'cliente_id', 'forma_pago',
    'activo'
  ];

  protected $useTimestamps = true;
  protected $createdField  = 'fecha_alta';
  protected $updatedField  = '';
  // protected $updatedField  = 'fecha_edit'; // Fail. updated_at field needed
//   protected $deletedField  = 'deleted_at';

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;

  public function insertaVenta($venta_id, $total,      $usuario_id,
                               $caja_id,  $cliente_id, $forma_pago)
  {
    $this->insert([
      'folio'      => $venta_id,
      'total'      => preg_replace('/[\$,]/', "", $total ), // to prevent formatted number
      'usuario_id' => $usuario_id,
      'caja_id'    =>  $caja_id,
      'cliente_id' =>  $cliente_id,
      'forma_pago' => $forma_pago
    ]);
    return $this->insertID();
  }
}
