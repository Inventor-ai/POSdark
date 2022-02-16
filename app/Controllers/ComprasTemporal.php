<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ComprasTemporalModel;
use App\Models\ArticuloslModel;

class ComprasTemporal extends BaseController
{
  protected $item     = 'ComprasTemporal';
  protected $items    = 'ComprasTemporales';
  // protected $enabled  = 'Disponibles';
  // protected $disabled = 'Eliminadas';
  // protected $insert   = 'insertar';
  // protected $update   = 'actualizar';
  protected $carrier  = [];
  protected $module;
  protected $dataModel;
  protected $articulos;

  public function __construct()
  {
    $search          = explode(',',"á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ");
    $replaceBy       = explode(',',"a,e,i,o,u,ni,A,E,I,O,U,NI");
    // $this->items     = $this->item.$this->items; // Exámenes - No concatenate
    $this->module    = strtolower(str_replace($search, $replaceBy, $this->items));
    $this->dataModel = new ComprasTemporalModel();
    $this->articulos = new ArticuloslModel();
    // helper(['form']);
  }

  // public function insertar($articulo_id, $cantidad, $compra_id)  // Descartar
  public function insertar($articulo_id, $cantidad, $precio, $compra_id)
  {
    $error = '';
    $articulo = $this->articulos->where('id', $articulo_id)->first();
    if ($articulo) {
        $datosExiste = $this->dataModel->porIdArticuloCompra($articulo_id, $compra_id);
        if ($datosExiste) {
            $cantidad = $datosExiste->cantidad + $cantidad;
            $subtotal = $datosExiste->precio   * $cantidad;
            // Actualizar la tabla temporal? Si. Hasta el minuto 16 lo dice
            // $xx = $this->dataModel->porIdArticuloCompra($articulo_id, $compra_id);
            // $xx->update(
            //   ['folio' => $compra_id], 
            //   [
            //     #
            //   ]
            // );
            // $this->dataModel->update( $id, $dataWeb );

        } else {
            // $subtotal = $cantidad * $articulo['precio_compra']; // Descartar
            $subtotal = $cantidad * $precio;
            $this->dataModel->save([
             'folio'        => $compra_id,
             'articulo_id'  => $articulo_id,
             'codigo'       => $articulo['codigo'], // ??
             'nombre'       => $articulo['nombre'], // ??
             //  'precio'       => $articulo['precio_compra'],  // Error?
             'precio'       => $precio,
             'cantidad'     => $cantidad,
             'subtotal'     => $subtotal // ?? Tiene sentido?
            ]);
        }
    } else {
        $error = 'No existe el producto';
    }
    $res['error'] = $error;
    echo json_encode($res);
  }

}
