<?php

namespace App\Models;

use CodeIgniter\Model;

class VentasDetalleModel extends Model 
{
  protected $table      = 'venta_detalle';
  protected $primaryKey = 'id';

  protected $useAutoIncrement = true;

  protected $returnType     = 'array';
  protected $useSoftDeletes = false;
  protected $allowedFields = [
     'venta_id', 'articulo_id', 'nombre', 'cantidad', 'precio'
  ];

  protected $useTimestamps = true;
  protected $createdField  = 'fecha_alta';
  protected $updatedField  = '';
  protected $deletedField  = '';
//   protected $deletedField  = 'deleted_at';

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;

  public function articulos($venta_id) // Datos ticket
  { // Devuelve detalles de los artículos vendidos
    $campos = 'articulos.codigo, venta_detalle.nombre,'
            . 'cantidad, precio';
    $this->select($campos)
         ->join('articulos', 'articulos.id = venta_detalle.articulo_id')
         ->where('venta_id', $venta_id);
    return $this->FindAll();
  }

  // Datos factura - Agregar join para unidades y demás
  public function conceptos($venta_id)
  { // Devuelve detalles de los artículos vendidos
    $campos = 'articulos.codigo, venta_detalle.nombre,'
            . 'cantidad, precio, venta_detalle.articulo_id';
    $this->select($campos)
         ->join('articulos', 'articulos.id = venta_detalle.articulo_id')
         ->where('venta_id', $venta_id);
    return $this->FindAll();
  }  

}

