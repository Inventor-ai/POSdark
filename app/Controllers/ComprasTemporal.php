<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ComprasTemporalModel;
use App\Models\ArticulosModel;

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
    $this->articulos = new ArticulosModel();
    // helper(['form']);
  }

  // public function insertar($articulo_id, $cantidad, $compra_id)  // Descartar
  public function insertar($articulo_id, $cantidad, $precio, $compra_id)
  {
    $error = '';
    $datos = [];
    $articulo = $this->articulos->where('id', $articulo_id)->first();
    if ($articulo) {
        $datosExiste = $this->dataModel->porIdArticuloCompraPrecio($compra_id, $articulo_id, $precio);
        if ($datosExiste) {
            $cantidad = $datosExiste->cantidad + $cantidad;
            $subtotal = $datosExiste->precio   * $cantidad;
            // Actualizar la tabla temporal? Si. Lo dice, pero no lo hace hasta 1:43:05
            $this->dataModel->actualizarArticuloCompra($compra_id, $articulo_id, $precio, 
                                                       $cantidad, $subtotal);
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
    // $res['datos'] = $this->cargaArticulos($compra_id); // Video
    $res          = $this->cargaArticulos($compra_id);
    $res['error'] = $error;
    echo json_encode($res);
  }

  public function cargaArticulos($compra_id)
  { // Hacer otra versión sin html que devuelva un json para procesar en el cliente
    $resultado = $this->dataModel->porCompra($compra_id);
    $filaTxt  = '';
    $filaNum  = 0;
    $subtotal = 0; // Procesar en el cliente
    foreach ($resultado as $row) {
      $filaNum++;
      $precio = $row['precio'];
      $params  = $row['articulo_id'].", '$compra_id', '$precio'";
      $filaTxt.= "<tr id='fila$filaNum'>";
      $filaTxt.= "<td> $filaNum </td>";
      $filaTxt.= "<td>".$row['codigo']  ."</td>";
      $filaTxt.= "<td>".$row['nombre']  ."</td>";
      $filaTxt.= "<td class='text-end'>". number_format ($row['precio'], 2, ".", "," )  ."</td>";
      $filaTxt.= "<td class='text-end'>". number_format ($row['cantidad'], 2, ".", "," )."</td>";
      $filaTxt.= "<td class='text-end'>". number_format ($row['subtotal'], 2, ".", "," )."</td>";
      // $filaTxt.= "<td><a onclick='eliminarArticulo($params)'>";  // No funciona
      // $filaTxt.= '<td><a onclick="eliminarArticulo('.$params.')">'; // Funciona Ok  1/2
      $filaTxt.= '<td><a onclick="eliminarArticulo('.$params.')"';     // Funciona Ok .5/2
      $filaTxt.= ' class="borrar">';                                   // Funciona Ok .5/2
      $filaTxt.= '<i class="fas fa-fw fa-trash"></i></a></td>';        // Funciona Ok  2/2
      // $filaTxt.= "<td><a onclick=\"eliminarArticulo(".$row['articulo_id'].", '$compra_id'". //
      //            ")\" class='borrar'><span class='fas fa-fw-fa-trash'></span></a></td>";    // 
      // $filaTxt.= "<td><a onclick=\"eliminarArticulo(".$row['articulo_id'] . ", '" . $compra_id . // cp ok
      //            "')\" class='borrar'><span class='fas fa-fw-fa-trash'></span></a></td>";        // cp ok
      // $filaTxt.= "</tr>".
      // $filaTxt.= "<td><a class=\"". /> // bug. No deberìa cerrar la etiqueta. S/todo si está comentada.
      $filaTxt.= "</tr>";
      $subtotal+=$row['subtotal'];
    }
    // var_dump($filaTxt);
    $resp['datos'] = $filaTxt;
    $resp['total'] = number_format($subtotal, 2, ".", ',');
    return $resp;
  }

  public function eliminar($articulo_id, $compra_id, $precio)
  // public function eliminar($articulo_id, $compra_id)
  {
    // $datosExiste = $this->dataModel->porIdArticuloCompra($compra_id, $articulo_id);
    $datosExiste = $this->dataModel->porIdArticuloCompra($compra_id, $articulo_id, $precio);
    if ($datosExiste) {
        if ($datosExiste->cantidad > 1) {
            $cantidad = $datosExiste->cantidad - 1;
            $subtotal = $cantidad * $datosExiste->precio;
            $this->dataModel->actualizarArticuloCompra($compra_id, $articulo_id, $datosExiste->precio, 
                                                       $cantidad, $subtotal);
        } else {
            $this->dataModel->eliminarArticuloCompra($compra_id, $articulo_id, $datosExiste->precio);
        }
        
    }
    $res          = $this->cargaArticulos($compra_id);
    $res['error'] = '';
    echo json_encode($res);

  }

  public function elimine($articulo_id, $compra_id, $precio)
  {
    var_dump($articulo_id);
    // var_dump($cantidad);
    var_dump($compra_id);
    var_dump($precio);
    $datosExiste = $this->dataModel->porIdArticuloCompra($compra_id, $articulo_id, $precio);
    var_dump($datosExiste);
    if ($datosExiste) {
      if ($datosExiste->cantidad) {
          $cantidad = $datosExiste->cantidad - 1;
          $subtotal = $cantidad * $datosExiste->precio;
      }
    }
    $res          = $this->cargaArticulos($compra_id);
    var_dump($res);
  }

}
