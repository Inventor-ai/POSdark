<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ArticulosModel; // Replace It
use App\Models\UnidadesModel;
use App\Models\CategoriasModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Articulos extends BaseController
{
  protected $item     = 'Artículo'; 
  protected $items    = 's';
  protected $enabled  = 'Disponibles';
  protected $disabled = 'Eliminados';
  protected $insert   = 'insertar';
  protected $update   = 'actualizar';
  protected $xlsFile  = 'helloWorld.xlsx';
  protected $carrier  = [];
  protected $module;
  protected $dataModel;

  public function __construct()
  {
    $search           = explode(',',"á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ");
    $replaceBy        = explode(',',"a,e,i,o,u,ni,A,E,I,O,U,NI");
    $this->items      = $this->item.$this->items;
    $this->module     = strtolower(str_replace($search, $replaceBy, $this->items));
    $this->dataModel  = new ArticulosModel();
    $this->unidades   = new UnidadesModel();
    $this->categorias = new CategoriasModel();
  }

  public function indexOk()  // Demo
  {
    // $dataWeb = ['data' => "Productos demo"];
    $dataWeb = ['data' => "$this->module demo Ok!!<br>"];
    echo view('/includes/header');
    echo view("$this->module/list", $dataWeb);
    echo view('/includes/footer');
  }

  public function index($activo = 1)
  {
    // $dataModel = $this->dataModel
    //                   ->where('activo', $activo)
    //                   ->findAll();
    $dataModel = $this->dataModel->indexList($activo);
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
    echo view('/includes/modal/carousel');
    echo view('/includes/footer');
  }

  private function getDataSet( 
        $titulo    = '',  $ruta      = '',   $action = "", 
        $method = "post", $validador = null, $dataSet = [])
  {
    $unidades   = $this->unidades->where('activo', 1)->findAll();
    $categorias = $this->categorias->where('activo', 1)->findAll();
    return [
      'title'      => $titulo,
      'path'       => $ruta,
      'action'     => $action,
      'method'     => $method,
      'validation' => $validador,
      'data'       => $dataSet,
      // Main ^  Customized v
      'unidades'   => $unidades,
      'categorias' => $categorias
    ];      
  }

  // private function setDataSet(Request $request)
  private function setDataSet()
  {
    $dataSet = [
        // 'id'            => $this->request->getPost('id'),
      'codigo'        => $this->request->getPost('codigo'),
      'nombre'        => $this->request->getPost('nombre'),
      'precio_venta'  => $this->request->getPost('precio_venta'),
      'precio_compra' => $this->request->getPost('precio_compra'),
      'existencias'   => $this->request->getPost('existencias'),
      'stock_minimo'  => $this->request->getPost('stock_minimo'),
      'inventariable' => $this->request->getPost('inventariable'),
      'id_unidad'     => $this->request->getPost('id_unidad'),
      'id_categoria'  => $this->request->getPost('id_categoria'),
      'fotos'         => $this->request->getPost('fotos'),
      'imgs'          => $this->request->getPost('imgs'),
        // 'activo'        => $this->request->getPost('activo')
    ];
    // Custom initialize section. Set default value by field
    if ($dataSet['codigo']        == '') $dataSet['codigo']        = '';
    if ($dataSet['nombre']        == '') $dataSet['nombre']        = '';
    if ($dataSet['id_unidad']     == '') $dataSet['id_unidad']     = '';
    if ($dataSet['id_categoria']  == '') $dataSet['id_categoria']  = '';
    if ($dataSet['precio_venta']  == '') $dataSet['precio_venta']  = 0.00;
    if ($dataSet['precio_compra'] == '') $dataSet['precio_compra'] = 0.00;
    if ($dataSet['existencias']   == '') $dataSet['existencias']   = 0;
    if ($dataSet['stock_minimo']  == '') $dataSet['stock_minimo']  = 0;
    if ($dataSet['inventariable'] == '') $dataSet['inventariable'] = 1;
    if ($dataSet['fotos']         == '') $dataSet['fotos']  = 0;
    $this->photosLoaded();
    return $dataSet;
  }

  // *** Fotos - Inicio
  public function photosLoaded() {}

  public function galleryPhotos($id)
  {
    // var_dump($_GET);
    // var_dump($_POST);
    $fotos = glob("images/articulos/$id/*.*");
    echo count($fotos);
    return;
    var_dump($fotos);
    var_dump($id);
    // foreach (glob("images/articulos/$id/*.*") as $nombre_fichero) {
    foreach ($fotos as $nombre_fichero) {
      echo '<a href="'. base_url($nombre_fichero) . '" target="_blank">' 
           . base_url($nombre_fichero) . '</a>' . filesize($nombre_fichero)."<br>";
      // echo "Tamaño de $nombre_fichero " . filesize($nombre_fichero) . "<br>";
    }
    return;

    if ($imagefile = $this->request->getFiles()) {
       foreach($imagefile['fotos'] as $img) {
         if ($img->isValid() && ! $img->hasMoved()) {
           $newName = $img->getRandomName();
           $img->move(WRITEPATH . 'uploads', $newName);
         }
       }
    }
  }

  public function XtestFile()
  {
    return view("$this->module/viewer");
  }
  
    function XuploadImage() {         
      helper(['form', 'url']);
      // $database = \Config\Database::connect();
      // $db = $database->table('profile');    
      $file = $this->validate([
          'file' => [
              'uploaded[file]',
              'mime_in[file,image/png,image/jpg,image/jpeg]',
              'max_size[file,4096]',
          ]
      ]);
      print_r($file);
      var_dump($file);
      if (!$file) {
          print_r('Wrong file type selected');
      } else {
          $imageFile = $this->request->getFile('file');
          $imageFile->move(WRITEPATH . 'uploads');    
          $data = [
             'ile_name'  => $imageFile->getName(),
             'file_type' => $imageFile->getClientMimeType()
          ];
          // $save = $db->insert($data);
          print_r('Image uploaded correctly!');
          var_dump($data);
          print_r($data);
        }
    }
  // *** Fotos - Fin

  private function getValidate($method = "post")
  {
    $rules = [
      //  'id'            => 'required',
       'codigo'        => 'required',
       'nombre'        => 'required',
       'precio_venta'  => 'required|decimal',
       'existencias'   => 'required|numeric',
       'id_unidad'     => 'required',
       'id_categoria'  => 'required',
       'stock_minimo'  => 'required|is_natural_no_zero',
       'inventariable' => 'required',
       'precio_compra' => 'required|decimal'
      //  'activo'        => 'required'
    ];
    // Validar que:
    //  El precio de venta sea mayor que el de compra
    //  por lo menos, x $ / %, ó ?...
    // return ($this->request->getMethod() == $method &&
    //         $this->validate($rules) );
    return ($method == "post" && $this->validate($rules));
  }

  private function setCarrier($dataWeb, $value = '', $key = 'id')
  {
    $dataWeb[$key] = $value;
    $this->carrier = [
      'validation' => $this->validator,
      'datos'      => $dataWeb
    ];
  }

  public function mostrar($id)
  {
    $dataModel = $this->dataModel
                      ->where('id', $id)
                      ->first();
    $dataWeb = $this->getDataSet( 
        "$this->item - Detalle",
        "$this->module",
        "",
        '',
        null,
        $dataModel
    );                  
    echo view('/includes/header');
    echo view("$this->module/detail", $dataWeb);
    echo view('/includes/footer');
  }

  // ++++++++++++++++++++++++++++++++++++++++
  public function agregar()
  { 
    if ( count ($this->carrier) > 0 ) {
         $dataSet    = $this->carrier['datos'];
         $validation = $this->carrier['validation'];
     } else { # Registro nuevo y en blanco
         $validation = null;
         $dataSet    = $this->setDataSet();
         $dataSet['id'] = '';
    }
    // $this->carrier = [];
    $dataWeb = $this->getDataSet( 
        "$this->item - Agregando...", //"Agregar $this->item", //
        "$this->module",
        $this->insert,
        'post',
        $validation,
        $dataSet
    );
    // foreach (glob("*.*") as $nombre_fichero) {
    //   echo "Tamaño de $nombre_fichero " . filesize($nombre_fichero) . "\n";
    // }
    $lista = glob("images/articulos/*.*");
    echo '<script>
      console.log("Agregar - dataSet:", '. json_encode($dataSet) .' );
      console.log("Agregar - dataWeb:", '. json_encode($dataWeb) .' );
      console.log("Agregar - lista:", '. json_encode($lista) .' );
    </script>';
    echo view('/includes/header');
    echo view("$this->module/form", $dataWeb);
    echo view('/includes/footer');
  }

  public function insertar()
  {
    $dataWeb = $this->setDataSet();
    echo '<script>
       console.log("insertar:", '. json_encode($dataWeb) .' );
    </script>';
    if ($this->getValidate( $this->request->getMethod() )) {
        // $msg = "Insercci´n";
        $this->dataModel->save($dataWeb);
        return redirect()->to(base_url()."/$this->module");
    }
    $this->setCarrier($dataWeb, '');
    $this->agregar();
  }

  public function editar($id)
  {
    if ( count ($this->carrier) > 0 ) {
         $dataModel  = $this->carrier['datos'];
         $validation = $this->carrier['validation'];
     } else { # Registro nuevo y en blanco
         $validation = null;
         $dataModel  = $this->dataModel
                            ->where('id', $id)
                            ->first();
    }
    // $this->carrier = [];
    $dataWeb = $this->getDataSet( 
        "$this->item - Editando...", //"Editar $this->item", //
        $this->module,
        $this->update, //
        'post',        //'put', //
        $validation,
        $dataModel
    );
    echo view('/includes/header');
    echo view("$this->module/form", $dataWeb);
    echo view('/includes/footer');
  }

  private function photos01($imgs = [])
  {
    echo "Processing " . count($imgs);
    foreach ($imgs as $img) {
      var_dump($img);
    }
  }

  public function actualizar()
  {
    // $texto = 'foto0.png|foto1.jpg|foto2.jpeg|foto3.png|foto4.jpg|foto5.jpeg|foto6.png|foto7.jpg|foto8.jpeg|foto9.png';
    // var_dump($texto);
    // print_r (explode ("|", $texto));

    $id      = $this->request->getPost('id');
    $dataWeb = $this->setDataSet();
    // **** 0
    $this->photos01($_POST['imgs']);
    var_dump($_POST);
    var_dump($_FILES);
    var_dump($dataWeb);
    return;
    // **** 1
    if ($this->getValidate( $this->request->getMethod() )) {
        // $msg = "¡Actualización exitosa!";
        $this->dataModel->update( $id, $dataWeb );
        return redirect()->to(base_url()."/$this->module");
        // develop Only - delete it
    }
    $this->setCarrier($dataWeb, $id);
    $this->editar($id);
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
    //   return $this->eliminar($id, 1);
    $this->eliminar($id, 1);
    return redirect()->to(base_url()."/$this->module/index/0");
  }

  public function buscarPorCodigo($codigo)
  {
    //
    $campos = 'id, codigo, existencias, nombre, precio_compra';
    $datos  = $this->dataModel->select($campos)
                              ->where('codigo', $codigo)
                              ->where('activo', 1)
                              ->get()->getRow();
    $res = [];
    if ($datos) {
       $res['datos']  = $datos;
       $res['existe'] = true;
       $res['error']  = '';
      } else {
       $res['error']  = '¡No existe el código!';
       $res['existe'] = false;
    }
    echo json_encode($res);
  }

  public function autocompleteData()
  {
    $returnData = [];
    $valor = $this->request->getGet('term');
    $datos = $this->dataModel->like('codigo', $valor)
                             ->where('activo', 1)
                             ->findAll();
    foreach ($datos as $row) {
      $data['id']    = $row['id'];
      $data['value'] = $row['codigo'];
      $data['label'] = $row['codigo'].' - '. $row['nombre'];
      $returnData[]  = $data;
    }
    return json_encode($returnData);
  }
  
  public function generaBarras()
  {
    $pdf = new \FPDF('P', 'mm', 'letter');
    $pdf->AddPage();
    $pdf->SetMargins(10, 1, 10);
    $pdf->SetTitle( utf8_decode ("Códigos de barras"));
    $items = $this->dataModel->codeList();
    // // For demonstration purposes, get pararameters that are passed in through $_GET or set to the default value
    // $filepath = (isset($_GET["filepath"])?$_GET["filepath"]:"");
    // $text = (isset($_GET["text"])?$_GET["text"]:"0");
    // $size = (isset($_GET["size"])?$_GET["size"]:"20");
    // $orientation = (isset($_GET["orientation"])?$_GET["orientation"]:"horizontal");
    // $code_type = (isset($_GET["codetype"])?$_GET["codetype"]:"code128");
    // $print = (isset($_GET["print"])&&$_GET["print"]=='true'?true:false);
    // $sizefactor = (isset($_GET["sizefactor"])?$_GET["sizefactor"]:"1");

    // // This function call can be copied into your project and can be made from anywhere in your code
    // barcode( $filepath, $text, $size, $orientation, $code_type, $print, $sizefactor );
    $barCode     = new \Barcode();
    $size        = "20";
    $orientation = "horizontal";
    // $code_type   = "code39";
    $code_type   = "code128";
    $print       = true;
    $sizefactor  = "1";
    $i = 0;
    forEach ($items as $item ) {
      //
      $i++;
      $text      = $item['codigo'];
      // $filepath  = WRITEPATH . "../public/images/barcodes/$text.png"; // Ok 
      $filepath  = "images/barcodes/$text.png"; // Ok
      // $barCode   = new \Barcode();
      // $barCode->create( $filepath, $text, $size, $orientation, $code_type, $print, $sizefactor );
      $barCode->create( $filepath, $text, $size, $orientation, $code_type, $print );
      // $img = $filepath;
      // $pdf->image($filepath);  // Ok
      $pdf->image( $filepath, 10 , 15 * $i , 40.7, 15, 'PNG');
      $pdf->SetFont('Arial','', 7);  
      $pdf->Cell( 40, 2, '', 0, 1, 'L');
      $pdf->SetFont('Arial','', 15);      
      $pdf->Cell( 45, 13, '', 0, 0, 'L');
      $pdf->Cell( 50, 13, $item['nombre'], 0, 1, 'L');
      unlink($filepath);
    }
    $this->response->setHeader('Content-Type', 'application/pdf');
    $pdf->Output('listaCodigos.pdf', "I");    
  }

  private function showReport($dataWeb)
  {
    echo view('/includes/header');
    echo view('/includes/showRpt', $dataWeb);
    echo view('/includes/footer');
  }

  public function muestraCodigos()
  {
    $dataWeb   = [
      'path'   => $this->module,
      'report' => 'generaBarras'
    ];
    $this->showReport($dataWeb);
  }

  public function mostrarMinimos()
  {
    $dataWeb   = [
      'path'   => $this->module,
      'report' => 'listarMinimos'
    ];
    $this->showReport($dataWeb);
  }

  public function listarMinimos ()
  {
    $pdf = new \FPDF('P', 'mm', 'letter');
    $pdf->AddPage();
    $pdf->SetMargins(10, 1, 10);
    $pdf->SetTitle( utf8_decode ("Resurtir"));
    $pdf->SetFont('Arial','B', 10);
    $img = Usuarios::getSettingOf('tienda_logo');
    $pdf->image( $img , 10, 10, 20, 20, 'PNG');
    $pdf->Cell( 0, 5, utf8_decode ('Reporte de artículos con stock mínimo'), 0, 1, 'C');
    $pdf->Ln(20);
    $pdf->Cell(40, 5, utf8_decode ('Código'), 1, 0, 'C');
    $pdf->Cell(85, 5, utf8_decode ('Nombre'), 1, 0, 'C');
    $pdf->Cell(30, 5, utf8_decode ('Existencias'), 1, 0, 'C');
    $pdf->Cell(30, 5, utf8_decode ('Stock mínimo'), 1, 1, 'C');
    $pdf->SetFont('Arial','', 10);
    $items = $this->dataModel->listarMinimos();
    /**/
    $i = 0;
    forEach ($items as $item ) {
      $i++;
      $pdf->Cell( 40, 5, $item['codigo'], 1, 0, 'L');
      $pdf->Cell( 85, 5, utf8_decode ($item['nombre']), 1, 0, 'L');
      $pdf->Cell( 30, 5, $item['existencias'], 1, 0, 'C');
      $pdf->Cell( 30, 5, ($item['stock_minimo']), 1, 1, 'C');
    }
    $this->response->setHeader('Content-Type', 'application/pdf');
    $pdf->Output('resurtir.pdf', "I");
  }

  public static function getValueOf($fieldName, $id)
  {
    $dataModel = new ArticulosModel();
    return $dataModel->select($fieldName)->where('id', $id)->first()[$fieldName];
  }

  public function rptMinExcel()
  {
    $this->minimos(); // Genera el archivo, lo guarda y cierra
    return redirect()->to(base_url($this->xlsFile)); // Descarga el archivo
  }

  public function minimos()
  { // Investigar ajuste del ancho de celdas, negritas, centrado, formato de número...
    $spreadsheet = new Spreadsheet();
    $spreadsheet->getProperties()
        ->setCreator('Punto de venta WEB')
        ->setLastModifiedBy('Punto de venta WEB')
        ->setTitle('Relación de artículos a resurtir')
        ->setSubject('Formato para resurtir artículos')
        ->setDescription('Relación de artículos que están en sus niveles mínimos o agotados.')
        ->setKeywords('artículos inventario resurtir')
        ->setCategory('Artículos stock min');

    $sheet = $spreadsheet->getActiveSheet();
    
    $sheet->setCellValue('A1', 'Num')
          ->setCellValue('B1', 'Código')
          ->setCellValue('C1', 'Nombre')
          ->setCellValue('D1', 'Stock mínimo')
          ->setCellValue('E1', 'Existencias')
          ->setCellValue('F1', 'Compra');
    $items = $this->dataModel->listarMinimos();
    $i = 1;
    forEach ($items as $item ) {
      $i++;
      $sheet->setCellValue("A$i", $i-1)
      ->setCellValue("B$i", $item['codigo'])
      ->setCellValue("C$i", $item['nombre'])
      ->setCellValue("D$i", $item['stock_minimo'])
      ->setCellValue("E$i", $item['existencias']);
    }
    $writer = new Xlsx($spreadsheet);
    $writer->save($this->xlsFile);
  }

  public function minimosTest ()
  {
    /*
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    $sheet->setCellValue('A1', 'Hello World !');
    
    $writer = new Xlsx($spreadsheet);
    $archivo = 'helloWorld.xlsx';
    $writer->save($archivo);
    */

    // require __DIR__ . '/../Header.php';
    
    // $helper->log('Create new Spreadsheet object');
    // $spreadsheet = new \PHPspSheet\Spreadsheet();
    // $spreadsheet = new \PHPspSheet\Spreadsheet();
    $spreadsheet = new Spreadsheet();
    
   
    // Set document properties
    // $helper->log('Set document properties');
    $spreadsheet->getProperties()
        ->setCreator('Maarten Balliauw')
        ->setLastModifiedBy('Maarten Balliauw')
        ->setTitle('PhpSpreadsheet Test Document')
        ->setSubject('PhpSpreadsheet Test Document')
        ->setDescription('Test document for PhpSpreadsheet, generated using PHP classes.')
        ->setKeywords('office PhpSpreadsheet php')
        ->setCategory('Test result file');
    
    // Add some data
    // $helper->log('Add some data');
    $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Hello')
        ->setCellValue('B2', 'world!')
        ->setCellValue('C1', 'Hello')
        ->setCellValue('D2', 'world!');
    
    // Miscellaneous glyphs, UTF-8
    $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A4', 'Miscellaneous glyphs')
        ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');
    
    $spreadsheet->getActiveSheet()
        ->setCellValue('A8', "Hello\nWorld");
    $spreadsheet->getActiveSheet()
        ->getRowDimension(8)
        ->setRowHeight(-1);
    $spreadsheet->getActiveSheet()
        ->getStyle('A8')
        ->getAlignment()
        ->setWrapText(true);
    
    $value = "-ValueA\n-Value B\n-Value C";
    $spreadsheet->getActiveSheet()
        ->setCellValue('A10', $value);
    $spreadsheet->getActiveSheet()
        ->getRowDimension(10)
        ->setRowHeight(-1);
    $spreadsheet->getActiveSheet()
        ->getStyle('A10')
        ->getAlignment()
        ->setWrapText(true);
    $spreadsheet->getActiveSheet()
        ->getStyle('A10')
        ->setQuotePrefix(true);
    
    // Rename worksheet
    // $helper->log('Rename worksheet');
    $spreadsheet->getActiveSheet()
        ->setTitle('Simple');
    
    // Save
    // $helper->write($spreadsheet, __FILE__, ['Xlsx', 'Xls', 'Ods']);
    $writer = new Xlsx($spreadsheet);
    $writer->save($this->xlsFile);
  }

/*
  // Ok - Blank old
  // public function rptMinExcelOk()
  // {
  //   $dataWeb   = [
  //     'path'   => $this->module,
  //     'report' => "minimos"
  //   ];
  //   echo view('/includes/header');
  //   echo view('/includes/showRpt', $dataWeb);
  //   echo view('/includes/footer');
  //   return redirect()->to(base_url($archivo)); // Descarga el archivo
  //   // echo "Mover esta rutina a una vista en formato de lista <br>";
  //   // echo "Comenzar por artículos escasos. (Orden de resurtido) <br>";

  //   // return redirect()->to(base_url("helloWorld.xlsx"));
  //   // echo "Donas";
  //   // return redirect()->to(base_url("$this->module/excelDone"));
  // }

  // public function excelDone()
  // {
  //   echo "excel generado y descargado <br>";
    // echo "excel generado en: <br>";
    // echo __DIR__ . "\\$archivo<br>";
    // echo "descargar desde: <br>";
    // echo base_url($archivo) . "<br>";
  // }
*/

}
