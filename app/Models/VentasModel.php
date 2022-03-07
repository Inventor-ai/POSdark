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

  public function obtener($activo = 1)
  {
    $this->select('ventas.*, usr.usuario AS cajero, cte.nombre AS cliente');
    $this->join('usuarios AS usr', 'usr.id = ventas.usuario_id'); // INNER JOIN
    $this->join('clientes AS cte', 'cte.id = ventas.cliente_id'); // INNER JOIN
    $this->where('ventas.activo', $activo);
    $this->orderBy('ventas.fecha_alta', 'DESC');
    return $this->findAll();
    // Bloque para depuración del query
    // $datos = $this->findAll();
    // print_r ($this->getLastQuery());
    // return $datos;
  }
  
  public function conteoDelDia($fecha)
  {
    $filtro = "activo = 1 AND DATE(fecha_alta) = '$fecha'";
    return $this->where($filtro)->countAllResults();
  }

  public function totalDelDia($fecha)
  {
    $this->select("SUM(total) AS totalVentas");
    $filtro = "activo = 1 AND DATE(fecha_alta) = '$fecha'";
    return $this->where($filtro)->first();
    // return $this->where($filtro)->findAll();
    // return $this->where($filtro)->getRow();
  }
  
}
