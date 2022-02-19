<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ComprasModel;
use App\Models\ComprasDetalleModel;
use App\Models\ComprasTemporalModel;
use App\Models\ArticulosModel;

class Compras extends BaseController
{
  protected $item     = 'Compra'; // Examen
  protected $items    = 's';         // Exámenes
  // protected $enabled  = 'Disponibles';
  // protected $disabled = 'Eliminadas';
  // protected $insert   = 'insertar';
  // protected $update   = 'actualizar';
  protected $carrier  = [];
  protected $module;
  protected $dataModel;
  // protected $tempModel;

  public function __construct()
  {
    $search          = explode(',',"á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ");
    $replaceBy       = explode(',',"a,e,i,o,u,ni,A,E,I,O,U,NI");
    $this->items     = $this->item.$this->items; // Exámenes - No concatenate
    $this->module    = strtolower(str_replace($search, $replaceBy, $this->items));
    $this->dataModel = new ComprasModel();    
    // helper(['form']);
  }

  private function setDataSet()
  {
    return;
    $dataSet = [
      'nombre' => trim( $this->request->getPost('nombre') ),
      
    ];
    // Custom initialize section. Set default value by field
    if ($dataSet['nombre'] == '') $dataSet['nombre'] = '';    
    return $dataSet;
  }

  private function getValidate($method = "post")
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
  
  private function getDataSet( 
        $titulo    = '',  $ruta      = '',   $action = "", 
        $method = "post", $validador = null, $dataSet = [])
  {
    // return;
    return [
      'title'      => $titulo,
      'path'       => $ruta,
      'action'     => $action,
      'method'     => $method,
      'validation' => $validador,
      'data'       => $dataSet
    ];
  }

  private function setCarrier($dataWeb, $value = '', $key = 'id')
  {
    return;
    $dataWeb[$key] = $value;
    $this->carrier = [
      'validation' => $this->validator,
      'datos'      => $dataWeb
    ];
  }

  public function index($activo = 1)
  {
    $dataModel = $this->dataModel
                      ->where('activo', $activo)
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

  public function nueva()
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
    // echo view("$this->module/form");
    echo view("$this->module/form", $dataWeb);
    echo view('/includes/footer');
  }

  public function guarda()
  {
    $datos = $_POST;
    var_dump($datos);
    $compra_id = $this->request->getPost('compra_id');
    $total     = $this->request->getPost('total');
    echo '<script> console.log("datos: ", '. json_encode($datos) .');
                   console.log("total: ", '. json_encode($total) .');
                   console.log("compra_id: ", '. json_encode($compra_id) .');
          </script>';
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
  }

  public function muestraCompraPDF($compra_id)
  {
    $data['compra_id'] = $compra_id;
    echo view('/includes/header');
    echo view('compras/ver_compra_pdf', $data);
    // echo view('compras/ver_compra_pdf');
    echo view('/includes/footer');
  }

  public function generaCompraPdf($compra_id)
  {
    $datosCompra  = $this->dataModel->where('id', $compra_id)->first();
    $detalleModel = new ComprasDetalleModel();
    // $detalleModel->select('*');
    $detalleModel->select('compra_id, articulo_id, nombre, cantidad, precio');
    $detalleCompra = $detalleModel->where('compra_id', $compra_id)->findAll();
    echo "sss: $compra_id";
    
    var_dump($datosCompra);
    var_dump($detalleCompra);
    $session = session();
    // var_dump($session->)
    var_dump($session->tiendaNombre);
    var_dump($session->tiendaDireccion);
    var_dump($session->ticketLeyenda);
    var_dump($session);

    $pdf = new \FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(40,10,'¡Hola, Mundo!');
    $this->response->setHeader('Content-Type', 'application/pdf');
    $pdf->Output();

    // $pdf = new \FPDF('P', 'mm', 'letter');
    // $pdf->AddPage();
    // $pdf->SetMargins(10,10,10);
    // $pdf->SetFont('Arial', 'B', 10);
    // $pdf->SetTitle("Compra");
    // $pdf->Output('compra_pdf.pdf', "I");



    
    // $pdf->SetFont('Arial','B',16);
    // $pdf->Cell(40,10,'¡Hola, Mundo!');
    // $pdf->Output();
  }


}
