<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ArticulosModel; // Replace It
use App\Models\UnidadesModel;
use App\Models\CategoriasModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Articulos extends BaseController {
  protected $item     = 'Artículo'; 
  protected $items    = 's';
  protected $enabled  = 'Disponibles';
  protected $disabled = 'Eliminados';
  protected $insert   = 'insertar';
  protected $update   = 'actualizar';
  protected $xlsFile  = 'helloWorld.xlsx';
  protected $carrier  = [];
  protected $module;
  protected $imgsPath;
  protected $dataModel;

  public function __construct(){
    $search           = explode(',',"á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ");
    $replaceBy        = explode(',',"a,e,i,o,u,ni,A,E,I,O,U,NI");
    $this->items      = $this->item.$this->items;
    $this->module     = strtolower(str_replace($search, $replaceBy, $this->items));
    $this->imgsPath   = WRITEPATH . "../public/images/$this->module";
    $this->dataModel  = new ArticulosModel();
    $this->unidades   = new UnidadesModel();
    $this->categorias = new CategoriasModel();
  }

  public function index($activo = 1) {
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

  private function setDataSet() {
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
      'filesSelected' => json_encode($_FILES)
      // 'filesSelected' => json_encode($this->request->getFileMultiple('images'))
      // 'filesSelected' => $this->request->getFileMultiple('images')
      // 'imgs'          => $this->request->getPost('imgs'),
      // 'remove'        => $this->request->getPost('remove'),
      // 'fotos'         => $this->request->getPost('fotos'),
        // 'activo'        => $this->request->getPost('activo')
    ];
    echo '<script>
       console.log("setDataSet:", '. json_encode($dataSet) .' );
    </script>';
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

    return $dataSet;
  }

  private function imgThumbNail($path, $file, $size = 50, $sufix = '_tn.')  // Ok
  { // https://codeigniter.com/user_guide/libraries/images.html
    // $size  = 50; //75; // 100; // 
    \Config\Services::image()
       ->withFile("$path/$file")
       ->fit($size, $size, 'center')
       ->save("$path/".str_replace(".", $sufix, $file));
  }

  private function imgWaterMark($path, $file, $text = '', $sufix = "_wm.") 
  { // https://codeigniter.com/user_guide/libraries/images.
    // var_dump(base_url('assets/fonts/comic.ttf')); // fail
    // var_dump(APPPATH); // 'C:\wamp64\www\posCI4\app\'
    // *********** Config section - Begin ***************
    $fontPath = APPPATH . '../public/assets/fonts/ALGER.TTF';
    $fontPath = APPPATH . '../public/assets/fonts/COOPBL.TTF';
    $fontPath = APPPATH . '../public/assets/fonts/comic.ttf';
    $fontPath = APPPATH . '../public/assets/fonts/lucon.ttf';
    // *********** Config section - Begin ***************
    $fontSize = 20;
    $opacity  = 0.1;  // 0.1 - 0.9              // Config
    $shdwDisp = true; // false;                 // Config
    $shdwDist = 2;    // 10; // px              // Config
    $hAlign   = 'center';                       // Config
    $vAlign   = 'middle'; // 'top' // 'bottom'  // Config
    // *********** Config section - End   ***************
    \Config\Services::image('imagick')
       ->withFile("$path/$file")
    // ->text('Copyright 2017 My Photo Co', [
       ->text($text, [
           'color'        => '#4c9', //  '#fff', //
           'opacity'      => $opacity, //  0.5, //
           'withShadow'   => $shdwDisp,
           'shadowOffset' => $shdwDist,
          //  'withShadow' => false,
           'hAlign'       => $hAlign,
           'vAlign'       => $vAlign, // 'bottom', // 'top', //
          //  'fontSize'   => 20 // Src - Fail?
          //  'fontPath'   => 'https://fonts.googleapis.com/css2?family=Pacifico&family=Permanent+Marker&family=Roboto+Slab:wght@600&display=swap',  // fail
          //  'fontPath'   => 'C:\Windows\Fonts\comic.ttf', // Ok
           'fontPath'     => $fontPath,
           'fontSize'     => $fontSize
    ])->save("$path/".str_replace(".", $sufix, $file));
  }

  public function imgResize($path, $file, $width, $height, $sufix = "_th.") {
    \Config\Services::image('imagick')
    ->withFile("$path/$file")
    // ->resize(200, 100, true, 'height')
    ->resize($width, $height, true, 'auto')
    ->save("$path/".str_replace(".", $sufix, $file));
  }

  private function getValidate($method = "post") {
    $id = $_POST['id'];
    echo '<script>
      console.log("Agregar - dataSet:", '. json_encode($_POST) .' );
      console.log("Agregar - files:", '. json_encode($_FILES) .' );
    </script>';
    $rules = [
       'codigo'        => [
          'rules'  => "required".($id == '' ? "|is_unique[$this->module.codigo]":""),
          'errors' => [
             'required'  => "DEBE proporcionarse el código|{field}",
             'is_unique' => "¡El código DEBE ser único! ¡Está repetido!|{field}"
          ]
       ],
       'nombre'        => [
          'rules'  => "required".($id == '' ? "|is_unique[$this->module.nombre]":""),
          'errors' => [
            'required'  => "Debe proporcionarse el {field}|{field}",
            'is_unique' => "¡Nombre del $this->item repetido! ¡DEBE ser ÚNICO!|{field}"
            ]
       ],
       'precio_venta'  => [
          'rules'  => 'required|decimal',
          'errors' => [
             'required' => 'El precio de venta es indispensable|{field}'
          ]
       ],
       'existencias'   => [
          'rules'  => 'required|numeric',
          'errors' => [
             'required' => 'Proporcionar las existencias es indispensable|{field}',
             'numeric'  => 'Debe proporcionarse un nùmero positivo|{field}'
          ]
       ],
       'id_unidad'     => [
          'rules'  => 'required',
          'errors' => [
             'required' => 'DEBE elegirse una unidad|{field}'
          ]
       ],
       'id_categoria'  => [
          'rules'  => 'required',
          'errors' => [
             'required' => 'DEBE elegirse una categoría|{field}'
          ]
       ],
       'stock_minimo'  => [
          'rules'  => 'required|is_natural_no_zero',
          'errors' => [
             'required' => 'Proporcionar el Stock mínimo es indispensable.|{field}',
             'is_natural_no_zero' => 'El stock mìnimo DEBE ser un cifra mayor a cero|{field}'
          ]
       ],
       'inventariable' => [
          'rules'  => 'required',
          'errors' => [
             'required' => 'DEBE seleccionarse una opción.|{field}'
          ]
       ],
       'precio_compra' => [
          'rules'  => 'required|decimal',
          'errors' => [
             'required' => 'Falta proporcionar el precio de compra|{field}',
             'decimal'  => 'El precio de compra DEBE ser una cifra mayor a cero con o sin punto decimal|{field}'
          ]
       ],
    ];
    // var_dump($rules);
    // Validar que:
    //  El precio de venta sea mayor que el de compra
    //  por lo menos, x $ / %, ó ?...
    // return ($this->request->getMethod() == $method &&
    //         $this->validate($rules) );
    return ($method == "post" && $this->validate($rules));
  }

  /** 
  // *** Fotos - Inicio
  public function photosLoaded() {
    $path  = "C:/wamp64/www/posCI4/public/images/articulos/1"; // Ok - Try WRITABLE dir
    $size  = 50; //75; // 100; // 
    $path  = "C:/wamp64/www/posCI4/public/images/articulos/2"; // Ok - Try WRITABLE dir
    $file  = "foto3";
    $ext   = "jpg";

    var_dump ($this->isfile("$path/$file.$ext"));
    var_dump("$path/$file.$ext");
    var_dump(is_file("$path/$file.$ext"));
    var_dump(is_file("http://192.168.1.65/posci4/public/images/articulos/1/foto4.jpg")); // Fail
  }

  public function galleryPhotos($id)
  {
    if ($imagefile = $this->request->getFiles()) {
       foreach($imagefile['fotos'] as $img) {
         if ($img->isValid() && ! $img->hasMoved()) {
           $newName = $img->getRandomName();
           $img->move(WRITEPATH . 'uploads', $newName);
         }
       }
    }
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
    } 
    else {
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
  public function isFile($file) {
    $f = pathinfo($file, PATHINFO_EXTENSION);
    var_dump($f);
    var_dump(strlen($f));
    return (strlen($f) > 0) ? true : false;
  }
  */

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
    echo view('/includes/header');
    echo view("$this->module/form", $dataWeb);
    echo view('/includes/footer');
  }

  public function insertar()
  {
    $dataWeb = $this->setDataSet();
    // echo '<script>
    //    console.log("insertar:", '. json_encode($dataWeb) .' );
    // </script>';
    if ($this->getValidate( $this->request->getMethod() )) {
        // Validar Fotos:
        //   Cantidad: Array.lengh < 11
        //   Tamaño (Bytes) 
        //   Resolución?
        // echo "dataWeb 0 ";
        // var_dump($dataWeb); // Ya fue validado
        $uploaded = $this->request->getFileMultiple('images'); // Ok
        // $arranged = $this->request->getPost('imgs');    // Orden de las fotos
        // var_dump($uploaded);
        // var_dump(isset($uploaded));
        // var_dump(isset($arranged));
        // var_dump($arranged);
        $idTmp = '';
        if (isset($uploaded)) {
            $idTmp = uniqid();
            $mdOk  = mkdir( "$this->imgsPath/$idTmp", 0777, true); // Crea directorio TEMPORAL ANTES de cargar fotos
            // if ($mdOk) {
            //     // Tal vez condicionar la carga de fotos...
            // }
            $dataWeb = $this->getPhotoData($dataWeb, $this->photosDriver($idTmp));
        }
        // var_dump($dataWeb);
        $this->dataModel->save($dataWeb);        // Ok
        if (isset($uploaded)) {
          /// Quizá sea más conveniente
          //    Crear otro campo en la tabla para el nombre del directorio destino
          //    Guardar  nombre del directorio -ahora temporal- en nuevo campo de la tabla
          $id = $this->dataModel->getIdOfCode($dataWeb['codigo']);
          rename ("$this->imgsPath/$idTmp", "$this->imgsPath/$id");
        }
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
    $this->carrier = [];
    $dataWeb = $this->getDataSet( 
        "$this->item - Editando...",
        $this->module,
        $this->update, //
        'post',
        $validation,
        $dataModel
    );
    echo view('/includes/header');
    echo view("$this->module/form", $dataWeb);  // Ok - 
    // echo view("$this->module/formEdit", $dataWeb); // Demo - Testing only
    echo view('/includes/footer');
  }

  private function photosDriver($id)  
  {
    $path = "$this->imgsPath/$id";
    $remove = $this->request->getPost('remove');
    $album = [];
    if (isset($remove)) 
       foreach ($remove as $key => $file) 
          array_map( 'unlink', glob("$path/".str_replace(".", "*.", $file)) );
    $imgFiles = $this->request->getFileMultiple('images');
    if (isset($imgFiles)) {
      $filesLoaded = [];
      $text        = Usuarios::getSettingValue('tienda_nombre');
      foreach ($imgFiles as $key => $file) {
        if ($file->getSize()) { // Validar el tamaño máximo
              // // Get the file's basename
    
              // echo "<br>getRandomName(): ". $file->getRandomName();
              // // echo "<br>originalName(): ". $file->originalName();
              // echo "<br>getBasename(): ". $file->getBasename();
              // echo "<br>guessExtension(): ". $file->guessExtension();
              // echo "<br>getMimeType(): ". $file->getMimeType();
              // // Get last modified time
              // echo "<br>getMTime(): ". $file->getMTime();
              // // Get the true real path
              // echo "<br>getRealPath(): ". $file->getRealPath();
              // // Get the file permissions
              // echo "<br>getPerms(): ". $file->getPerms();
              // var_dump($path);
              // var_dump($file);
              // // move_uploaded_file
              // // $file->move($path);
              // $text     = "ArmyStore.com"; // Leer de la configuración
              // $text     = Usuarios::getSettingValue('tienda_siglas');
            
              $nameSrc = $file->getName();
              $nameNew = $file->getRandomName();
              $file->move($path, $nameNew);
              $width   = 130;
              $height  = 65;
              $width   = $height;
              $this->imgResize($path, $nameNew, $width, $height);
              $this->imgThumbNail($path, $nameNew);
              $this->imgWaterMark($path, $nameNew, $text);
              $filesLoaded[$nameSrc] = $nameNew;
        }
        // else {
        //     echo "Omitido: $key";
        // }
        //   echo $file->getSize();
        //   echo "<br>";
        //   echo $key;
        //   var_dump($file);
      }    
      $album = $this->request->getPost('imgs');    // Orden de las fotos
      // var_dump($album);
      // foreach ($album as $key => $imgName) {
      //   if (isset($filesLoaded[$imgName])) {
      //       $album[$key] = $filesLoaded[$imgName];
      //   }
      // }
      foreach ($album as $key => $imgName)
        if (isset($filesLoaded[$imgName]))
            $album[$key] = $filesLoaded[$imgName];
      // var_dump($filesLoaded);
    } 
    else {
      $album = $this->request->getPost('imgs');    // Orden de las fotos
    }
    return $album;
  }

  public function getPhotoData($dataWeb, $album)
  {// Completar: $dataWeb con los campos: Foto, Fotos
    if (isset($album)) {
        $dataWeb['foto']  = str_replace(".", "_th.", $album[0]);
        $dataWeb['foto']  = str_replace(".", "_tn.", $album[0]);
        $dataWeb['fotos'] = implode('|', $album);
    } else {
        $dataWeb['foto']  = '';
        $dataWeb['fotos'] = $dataWeb['foto'];
    }
    return $dataWeb;
  }

  public function actualizar()
  {
    $id      = $this->request->getPost('id');
    $dataWeb = $this->setDataSet();
    if ($this->getValidate( $this->request->getMethod() )) {
        // Validar Fotos:
        //   Cantidad: Array.lengh < 11
        //   Tamaño (Bytes) 
        //   Resolución?
        // var_dump($dataWeb); // Ya fue validado
        $dataWeb = $this->getPhotoData($dataWeb, $this->photosDriver($id));
        $this->dataModel->update( $id, $dataWeb );
        return redirect()->to(base_url()."/$this->module");
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
      $filepath  = "images/barcodes/$text.png"; // Ok
      // $barCode   = new \Barcode();
      // $barCode->create( $filepath, $text, $size, $orientation, $code_type, $print, $sizefactor );
      $barCode->create( $filepath, $text, $size, $orientation, $code_type, $print );
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

}
// 1257 - 655