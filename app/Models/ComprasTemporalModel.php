<?php

namespace App\Models;

use CodeIgniter\Model;

class ComprasTemporalModel extends Model 
{
  protected $table      = 'compras_temporal';
  protected $primaryKey = 'id';

  protected $useAutoIncrement = true;

  protected $returnType     = 'array';
  protected $useSoftDeletes = false;
  protected $allowedFields = [
    'folio', 'articulo_id', 'codigo', 'nombre', 'cantidad', 'precio', 'subtotal',
  ];

  protected $useTimestamps = false;
  // protected $createdField  = 'fecha_alta';
  // protected $updatedField  = 'fecha_edit';
//   protected $deletedField  = 'deleted_at';

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;

  public function porIdArticuloCompraPrecio($folio, $articulo_id, $precio)
  {
    $campos = '*';
    // $this->select($campos);
    $this->where('folio', $folio);
    $this->where('articulo_id', $articulo_id);
    $this->where('precio', $precio);
    return $this->get()->getRow();
  }

  public function porIdArticuloVenta($folio, $articulo_id)
  // public function porIdArticuloCompra($folio, $articulo_id, $precio)
  {
    $campos = '*';
    // $this->select($campos);
    $this->where('folio', $folio);
    $this->where('articulo_id', $articulo_id);
    // $this->where('precio', $precio);
    return $this->get()->getRow();
  }

  public function porCompra($folio)
  {
    // $campos = '*';
    // $this->select($campos);
    $this->where('folio', $folio);
    // return $this->get(); // Devuelve objeto
    return $this->findAll();  // Devuelve arreglo
  }

  public function actualizarArticuloCompra($folio, $articulo_id, $precio, $cantidad, $subtotal)
               // actualizarArticuloCompra($folio, $articulo_id,          $cantidad, $subtotal)
  {
    $this->set('cantidad', $cantidad);
    $this->set('subtotal', $subtotal);
    $this->where('folio', $folio);
    $this->where('articulo_id', $articulo_id);
    $this->where('precio', $precio);
    $this->update();
  }

  // public function actualizarArticuloCompra($folio, $articulo_id, $precio, $cantidad, $subtotal)
  public function actualizarArticuloVenta($folio, $articulo_id, $cantidad, $subtotal)
  {
    $this->set('cantidad', $cantidad);
    $this->set('subtotal', $subtotal);
    $this->where('folio', $folio);
    $this->where('articulo_id', $articulo_id);
    $this->update();
  }

  public function eliminarArticuloCompra($folio, $articulo_id, $precio)
  {
    $this->where('folio', $folio);
    $this->where('articulo_id', $articulo_id);
    $this->where('precio', $precio);
    $this->delete();
  }

  public function eliminarCompra($folio)
  {
    $this->where('folio', $folio);
    $this->delete();
  }



}
