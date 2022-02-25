<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\VentasModel;
use App\Models\VentasDetalleModel;
use App\Models\ComprasTemporalModel; // Parche dejado en el video
use App\Models\ArticulosModel;
use App\Models\UsersModel;

class Ventas extends BaseController
{
  protected $item     = 'Venta';
  protected $items    = 's';
  // protected $enabled  = 'Disponibles';
  // protected $disabled = 'Eliminadas';
  protected $carrier  = [];
  protected $module;
  protected $dataModel;

  public function __construct()
  {
    $this->items     = $this->item.$this->items;
    $this->module    = strtolower($this->items);
    $this->dataModel = new VentasModel();
  }

  private function getDataSet( // Ok No borrar
        $titulo    = '',  $ruta      = '',   $action = "", 
        $method = "post", $validador = null, $dataSet = [])
  {
    return [
      'title'      => $titulo,
      'path'       => $ruta,
      'action'     => $action,
      'method'     => $method,
      'validation' => $validador,
      'data'       => $dataSet
    ];
  }

  public function index()
  {
    $dataModel = $this->dataModel->obtener(1);
    /*
    $dataModel = $this->dataModel
                       ->select($campos)
    //  nombre, 
                      // ->select('folio, total, nombre, ventas.id, ventas.activo')
                      ->join('usuarios', 'usuarios.id = ventas.usuario_id')
                      ->where('ventas.activo', $activo)
                      ->findAll();
                      */
    // $activo
    $dataWeb   = [
      //  'title'   => "$this->items ".strtolower($activo == 1 ? $this->enabled : $this->disabled),
       'title'   => "$this->items ",
       'item'    => $this->item,
       'path'    => $this->module,
      //  'onOff'   => $activo,
      //  'switch'  => $activo == 0 ? $this->enabled : $this->disabled,
       'delete'  => 'eliminar',
       'recover' => 'recuperar',
       'data'    => $dataModel
    ];
    echo view('/includes/header');
    echo view("$this->module/list", $dataWeb);
    echo view('/includes/footer');
  }

  public function eliminar($id, $activo = 0)
  {
    $dataWeb = ['activo' => $activo];
    // $msg = "¡Eliminación exitosa!";
    $this->dataModel->update($id, $dataWeb);
    return redirect()->to(base_url()."/$this->module");
  }

  public function recuperar($id)
  {
    $this->eliminar($id, 1);
    return redirect()->to(base_url()."/$this->module/index/0");
  }

  public function venta()
  { 
    /*    */
    // if ( count ($this->carrier) > 0 ) {
    //      $dataSet    = $this->carrier['datos'];
    //      $validation = $this->carrier['validation'];
    //  } else { # Registro nuevo y en blanco
         $validation = null;
         $dataSet    = null;
        //  $dataSet    = $this->setDataSet();
        //  $dataSet['id'] = '';
    // }

    // $this->carrier = [];
    $session = session();
    $dataWeb = $this->getDataSet( 
        // "$this->item - Nueva", //"Agregar $this->item", //
        // "Caja # 69 - Nombre del usuario", //"Agregar $this->item", //
        "Caja $session->caja_id", //"Agregar $this->item", //
        "$this->module",
        'guarda',
        'post',
        $validation,
        $dataSet
    );
    echo view('/includes/header');
    echo view("$this->module/caja", $dataWeb);
    echo view('/includes/footer');
  }

  public function guarda()
  {
    $datos = $_POST;
    // var_dump($datos);
// *    $compra_id = $this->request->getPost('compra_id');
    $venta_id   = $this->request->getPost('venta_id');
    $total      = $this->request->getPost('total');
    $cliente_id = $this->request->getPost('cliente_id');
    $forma_pago = $this->request->getPost('forma_pago');
    // echo '<script> console.log("datos: ", '. json_encode($datos) .');
    //                console.log("total: ", '. json_encode($total) .');
    //                console.log("venta_id: ", '. json_encode($venta_id) .');
    //       </script>';
    // var_dump($datos);
    // return; 
    $session = session();
    // $session->usuario_id;
// *    $resultadoId = $this->dataModel->insertaCompra($venta_id, $total, $session->usuario_id);
    $resultadoId = $this->dataModel->insertaVenta($venta_id, $total, $session->usuario_id, 
                                                   $session->caja_id, 
                                                   $cliente_id,
                                                   $forma_pago);
    // $this->tempModel = new ComprasTemporalModel(); // Si es local, ¿Para qué una variable de clase?
    $tempModel = new ComprasTemporalModel();
    // $detalleModel = new ComprasDetalleModel();
    if ($resultadoId) {
// *        $resultadoCompra = $tempModel->porCompra($compra_id);
        $resultadoVenta = $tempModel->porCompra($venta_id);
// *        $detalleModel  = new ComprasDetalleModel();
        $detalleModel  = new VentasDetalleModel();
        $articuloModel = new ArticulosModel();
        foreach ($resultadoVenta as $row) {
          $detalleModel->save([
// *            'compra_id'   => $resultadoId, 
            'venta_id'   => $resultadoId, 
            'articulo_id' => $row['articulo_id'], 
            'nombre'      => $row['nombre'], 
            'cantidad'    => $row['cantidad'], 
            'precio'      => $row['precio']
          ]);
          // $articuloModel->actualizaStock($row['articulo_id'], $row['cantidad'] * -1 ); // Try my own
          $articuloModel->actualizaStock($row['articulo_id'], $row['cantidad'], '-'); // Video
        }
// *       $tempModel->eliminarCompra($compra_id);
       $tempModel->eliminarCompra($venta_id);
    }
    // return redirect()->to(base_url().'/articulos');
// *    return redirect()->to(base_url()."/compras/muestraCompraPDF/$resultadoId");
    return redirect()->to(base_url()."/ventas/muestraTicket/$resultadoId"); // Para probar
    // echo "¡Impresión del ticket de venta en desarrollo!";
  }

// *  public function muestraVentaPDF($compra_id)
  public function muestraTicket($venta_id)
  {
    $data['venta_id'] = $venta_id;
// *    $data['compra_id'] = $compra_id;
    echo view('/includes/header');
    echo view('ventas/ver_ticket', $data);
    echo view('/includes/footer');
  }

// *  public function generaTicket($compra_id)
  public function generaTicket($venta_id)
  {
    $signo  = "$ ";
// *    $datosCompra  = $this->dataModel->where('id', $compra_id)->first();
    $datosventa  = $this->dataModel->where('id', $venta_id)->first();
    $detalleModel = new VentasDetalleModel();
    // $detalleModel->select('*');
    $detalleVenta = $detalleModel->articulos($venta_id);
    $userModel = new UsersModel();
    // var_dump($datosventa['usuario_id']);
    $dataUser  = $userModel->usuario( $datosventa['usuario_id'] );
    $session = session();
    $pdf = new \FPDF('P', 'mm', array(80, 200));
    // ob_start();    
    $pdf->AddPage();
    $pdf->setMargins(5, 5, 1); //
    // $pdf->setTitle('Venta');     //
    $pdf->setTitle('Ticket');     //
    $pdf->SetFont('Arial','B', 9);
    // $pdf->Cell(70, 5,'Venta de productos', 0, 1, 'C');
    $tiendaNombre = utf8_decode (Usuarios::getSettingValue('tienda_nombre'));
    $pdf->Cell(70, 4, $tiendaNombre, 0, 1, 'C');
// *    $pdf->Cell(70, 5,$session->tiendaNombre, 0, 1, 'C');

    $pdf->SetFont('Arial','', 7);
    // $pdf->image( base_url() . "/assets/img/armyStoreMx.jpg", 170, 6, 23, 23, 'JPG');
    // $img = 'https://static.wixstatic.com/media/cb0763_b933a7cf090a4889821743cd56b86c33~mv2.png/v1/fit/w_2500,h_1330,al_c/cb0763_b933a7cf090a4889821743cd56b86c33~mv2.png';
    $img = Usuarios::getSettingValue('tienda_logo');
    $pdf->image( $img , 6, 6, 12, 12, 'PNG');
    // $pdf->Cell(5, 5, str_repeat(' ', 0). "$session->tiendaNombre", 1, 1, 'L');
    // $pdf->Cell(65, 5, "$session->tiendaNombre", 0, 0, 'L'); // De compras
    $pdf->Cell(80, 4, utf8_decode ("Venta por: $dataUser->usuario / $dataUser->nombre"), 0, 1, 'C');
    $domicilio = utf8_decode ("Dirección: ". Usuarios::getSettingValue('tienda_direccion'));
    $pdf->Cell(73, 3, "$domicilio", 0, 1, 'C');

    $pdf->Cell(72, 3, "Fecha y hora: ". $datosventa['fecha_alta'], 0, 1, 'C');

    $pdf->Cell(70, 3, "Ticket: ". $datosventa['folio'], 0, 0, 'C');

    $pdf->Ln(3);
    $pdf->SetFont('Arial','B', 7);
    // $pdf->SetFillColor(0, 0, 0);        // Color del fondo (Negro)
    //*$pdf->SetFillColor(83, 105, 84);        // Color del fondo (Negro)
    // $pdf->SetTextColor(255, 255, 255);  // Color del texto (Blanco)
    //*$pdf->SetTextColor(255, 255, 255);  // Color del texto (Blanco)
    //         Width, Height, Text, Border, LF, Alignment, Background
    //*$pdf->Cell(190, 5, "Detalle de productos", 1, 1, 'C', 1);
    // $pdf->SetTextColor(0, 0, 0);  // Color del texto (Negro)
    // $pdf->Cell(196, 5, "Detalle de productos", 1, 1, 'C');
    // $pdf->Cell(8, 5, "No", 1, 0, 'L');
    // $pdf->Cell(7, 5, utf8_decode ("Código"), 1, 0, 'L');
    $pdf->Cell(9, 5, "Cant.", 0, 0, 'L');
    $pdf->Cell(33, 5, "Nombre", 0, 0, 'L');
    $pdf->Cell(15, 5, "Precio", 0, 0, 'L');
    $pdf->Cell(15, 5, "Importe", 0, 1, 'L');
    $pdf->SetFont('Arial','', 7);
    $num    = 0;
    // $total  = 0;
    $piezas = 0;
    foreach ($detalleVenta as $row) {
      $num++;
      $precio  = number_format($row['precio'], 2, '.', ',');
      $importe = number_format($row['precio'] * $row['cantidad'], 2, '.', ',');
      $piezas += $row['cantidad'];
      // $total  += $row['precio'] * $row['cantidad'];
      // $pdf->Cell(8, 5, $num, 1, 0, 'R');
      // $pdf->Cell(25, 5, utf8_decode ($row['codigo']), 1, 0, 'L');
      $pdf->Cell(9, 3,  $row['cantidad'] , 0, 0, 'C');
      $pdf->Cell(33, 3, utf8_decode ($row['nombre']), 0, 0, 'L');
      $pdf->Cell(15, 3, "$signo$precio" , 0, 0, 'R');
      $pdf->Cell(15, 3, "$signo$importe", 0, 1, 'R');  
    }
    // $pdf->Cell(112, 3, '', 0, 0, 'R');
    $pdf->Cell( 9, 3, number_format($piezas, 0, '.', ','), 0, 0, 'C');
    $pdf->Cell( 21, 3, 'Totales:', 0, 0, 'C');
    $pdf->Cell( 42, 3, $signo . number_format($datosventa['total'], 2, '.', ','), 0, 1, 'R');
    $pdf->Ln(3);
    $ticketLeyenda = utf8_decode(Usuarios::getSettingValue('ticket_leyenda'));
    $pdf->Multicell( 72, 3, $ticketLeyenda, 0, 'C', 0);
    // $pdf->Cell(196, 5, $signo . number_format($datosventa['total'], 2, '.', ','), 1, 1, 'R');
    $this->response->setHeader('Content-Type', 'application/pdf');
    // $pdf->Output();
    $pdf->Output('ticket.pdf', "I");
    // ob_end_flush();    
  }

}


/*
  private function XsetDataSet()
  {
    return;
    $dataSet = [
      'nombre' => trim( $this->request->getPost('nombre') ),
      
    ];
    // Custom initialize section. Set default value by field
    if ($dataSet['nombre'] == '') $dataSet['nombre'] = '';    
    return $dataSet;
  }

  private function XgetValidate($method = "post")
  {
    return;
    // $rules = [
    //    'nombre' => 'required'
    // ];
    $rules = [
      'nombre' => [
         'rules' => 'required|is_unique[categorias.nombre]',
         'errors' => [
            'required'  => "Debe proporcionarse el {field}|{field}",
            'is_unique' => "¡Esta $this->item ya existe y DEBE ser ÚNICA!"
         ]
      ]
    ];
    return ($this->request->getMethod() == $method &&
            $this->validate($rules) );
  }
  

  private function XsetCarrier($dataWeb, $value = '', $key = 'id')
  {
    return;
    $dataWeb[$key] = $value;
    $this->carrier = [
      'validation' => $this->validator,
      'datos'      => $dataWeb
    ];
  }
*/