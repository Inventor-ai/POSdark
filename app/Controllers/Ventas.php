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
  protected $enabled  = 'Disponibles';
  protected $disabled = 'Eliminadas';
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

  public function index($activo = 1)
  {
    $dataModel = $this->dataModel
                      ->select('folio, total, nombre, compras.id, compras.activo, compras.fecha_alta')
                      ->join('usuarios', 'usuarios.id = compras.usuario_id')
                      ->where('compras.activo', $activo)
                      ->findAll();
    $dataWeb   = [
       'title'   => "$this->items ".strtolower($activo == 1 ? $this->enabled : $this->disabled),
       'item'    => $this->item,
       'path'    => $this->module,
       'onOff'   => $activo,
       'switch'  => $activo == 0 ? $this->enabled : $this->disabled,
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
    $dataWeb = $this->getDataSet( 
        "$this->item - Nueva", //"Agregar $this->item", //
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
    $compra_id = $this->request->getPost('compra_id');
    $total     = $this->request->getPost('total');
    // echo '<script> console.log("datos: ", '. json_encode($datos) .');
    //                console.log("total: ", '. json_encode($total) .');
    //                console.log("compra_id: ", '. json_encode($compra_id) .');
    //       </script>';
    $session = session();
    // $session->usuario_id;
    $resultadoId = $this->dataModel->insertaCompra($compra_id, $total, $session->usuario_id);
    // $this->tempModel = new ComprasTemporalModel(); // Si es local, ¿Para qué una variable de clase?
    $tempModel = new ComprasTemporalModel();
    // $detalleModel = new ComprasDetalleModel();
    if ($resultadoId) {
        $resultadoCompra = $tempModel->porCompra($compra_id);
        $detalleModel  = new ComprasDetalleModel();
        $articuloModel = new ArticulosModel();
        foreach ($resultadoCompra as $row) {
          $detalleModel->save([
            'compra_id'   => $resultadoId, 
            'articulo_id' => $row['articulo_id'], 
            'nombre'      => $row['nombre'], 
            'cantidad'    => $row['cantidad'], 
            'precio'      => $row['precio']
          ]);
          $articuloModel->actualizaStock($row['articulo_id'], $row['cantidad']);
        }
        $tempModel->eliminarCompra($compra_id);
    }
    // return redirect()->to(base_url().'/articulos');
    return redirect()->to(base_url()."/compras/muestraCompraPDF/$resultadoId");
  }

  public function muestraCompraPDF($compra_id)
  {
    $data['compra_id'] = $compra_id;
    echo view('/includes/header');
    echo view('compras/ver_compra_pdf', $data);
    echo view('/includes/footer');
  }

  public function generaCompraPdf($compra_id)
  {
    $signo  = "$ ";
    $datosCompra  = $this->dataModel->where('id', $compra_id)->first();
    $detalleModel = new ComprasDetalleModel();
    // $detalleModel->select('*');
    // $detalleModel->select('compra_id, articulo_id, nombre, cantidad, precio');
    // $detalleCompra = $detalleModel->where('compra_id', $compra_id)->findAll();
    $detalleCompra = $detalleModel->articulos($compra_id);
    $userModel = new UsersModel();
    // var_dump($datosCompra['usuario_id']);
    $dataUser  = $userModel->usuario( $datosCompra['usuario_id'] );
    // var_dump($dataUser);
    // var_dump($compra_id);
    // var_dump($detalleCompra);
    // return;
    $session = session();
    $pdf = new \FPDF('P', 'mm', 'letter');
    // ob_start();    
    $pdf->AddPage();
    $pdf->setMargins(10, 10, 10); //
    $pdf->setTitle('Compra');     //
    $pdf->SetFont('Arial','B', 10);
    $pdf->Cell(195, 5,'Entrada de productos', 0, 1, 'C');
    $pdf->SetFont('Arial','', 9);
    // $pdf->image( base_url() . "/assets/img/armyStoreMx.jpg", 170, 6, 23, 23, 'JPG');
    // $img = 'https://static.wixstatic.com/media/cb0763_b933a7cf090a4889821743cd56b86c33~mv2.png/v1/fit/w_2500,h_1330,al_c/cb0763_b933a7cf090a4889821743cd56b86c33~mv2.png';
    $img = $session->tiendaLogo;
    $pdf->image( $img , 170, 6, 23, 23, 'PNG');
    // $pdf->Cell(5, 5, str_repeat(' ', 0). "$session->tiendaNombre", 1, 1, 'L');
    $pdf->Cell(65, 5, "$session->tiendaNombre", 0, 0, 'L');
    $pdf->Cell(67, 5, utf8_decode ("Elaborada por: $dataUser->usuario / $dataUser->nombre"), 0, 1, 'C');
    $pdf->Cell(5, 5, utf8_decode ("Dirección: $session->tiendaDireccion"), 0, 1, 'L');
    $pdf->Cell(5, 5, "Fecha y hora: ". $datosCompra['fecha_alta'], 0, 0, 'L');
    $pdf->Ln(7);
    $pdf->SetFont('Arial','B', 8);
    // $pdf->SetFillColor(0, 0, 0);        // Color del fondo (Negro)
    $pdf->SetFillColor(83, 105, 84);        // Color del fondo (Negro)
    // $pdf->SetTextColor(255, 255, 255);  // Color del texto (Blanco)
    $pdf->SetTextColor(255, 255, 255);  // Color del texto (Blanco)
    //         Width, Height, Text, Border, LF, Alignment, Background
    $pdf->Cell(190, 5, "Detalle de productos", 1, 1, 'C', 1);
    $pdf->SetTextColor(0, 0, 0);  // Color del texto (Negro)
    // $pdf->Cell(196, 5, "Detalle de productos", 1, 1, 'C');
    $pdf->Cell(8, 5, "No", 1, 0, 'L');
    $pdf->Cell(25, 5, utf8_decode ("Código"), 1, 0, 'L');
    $pdf->Cell(77, 5, "Nombre", 1, 0, 'L');
    $pdf->Cell(25, 5, "Precio", 1, 0, 'L');
    $pdf->Cell(25, 5, "Cantidad", 1, 0, 'L');
    $pdf->Cell(30, 5, "Importe", 1, 1, 'L');
    $pdf->SetFont('Arial','', 8);
    $num    = 0;
    // $total  = 0;
    $piezas = 0;
    foreach ($detalleCompra as $row) {
      $num++;
      $precio  = number_format($row['precio'], 2, '.', ',');
      $importe = number_format($row['precio'] * $row['cantidad'], 2, '.', ',');
      $piezas += $row['cantidad'];
      // $total  += $row['precio'] * $row['cantidad'];
      $pdf->Cell(8, 5, $num, 1, 0, 'R');
      $pdf->Cell(25, 5, utf8_decode ($row['codigo']), 1, 0, 'L');
      $pdf->Cell(77, 5, utf8_decode ($row['nombre']), 1, 0, 'L');
      $pdf->Cell(25, 5, "$signo$precio" , 1, 0, 'R');
      $pdf->Cell(25, 5,  $row['cantidad'] , 1, 0, 'C');
      $pdf->Cell(30, 5, "$signo$importe", 1, 1, 'R');  
    }
    $pdf->Cell(112, 5, '', 0, 0, 'R');
    $pdf->Cell( 23, 5, 'Totales:', 0, 0, 'C');
    $pdf->Cell( 25, 5, number_format($piezas, 0, '.', ','), 1, 0, 'C');
    $pdf->Cell( 30, 5, $signo . number_format($datosCompra['total'], 2, '.', ','), 1, 1, 'R');
    // $pdf->Cell(196, 5, $signo . number_format($datosCompra['total'], 2, '.', ','), 1, 1, 'R');
    $this->response->setHeader('Content-Type', 'application/pdf');
    // $pdf->Output();
    $pdf->Output('compra_pdf.pdf', "I");
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