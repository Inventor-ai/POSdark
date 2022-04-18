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
  protected $imgsPath;
  protected $dataModel;

  public function __construct()
  {
    $search           = explode(',',"á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ");
    $replaceBy        = explode(',',"a,e,i,o,u,ni,A,E,I,O,U,NI");
    $this->items      = $this->item.$this->items;
    $this->module     = strtolower(str_replace($search, $replaceBy, $this->items));
    $this->imgsPath   = WRITEPATH . "../public/images/$this->module";
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
      // 'imgs'          => $this->request->getPost('imgs'),
      // 'remove'        => $this->request->getPost('remove'),
      // 'fotos'         => $this->request->getPost('fotos'),
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
    // if ($dataSet['remove']        == '') $dataSet['remove'] = [];
    return $dataSet;
  }

/** 
  public function isFile($file) {
    $f = pathinfo($file, PATHINFO_EXTENSION);
    var_dump($f);
    var_dump(strlen($f));
    return (strlen($f) > 0) ? true : false;
  }
*/

  private function imgThumbNail($path, $file, $size  = 50, $sufix = '_tn.')  // Ok
  { // https://codeigniter.com/user_guide/libraries/images.html
    // $size  = 50; //75; // 100; // 
    \Config\Services::image()
       ->withFile("$path/$file")
         //  ->fit(100, 100, 'center')  // Ok
       ->fit($size, $size, 'center')
          //  ->save("$path/tn_$file");
          //  ->save("$path/$file");
       ->save("$path/".str_replace(".", $sufix, $file));
  }
  // https://codeigniter.com/user_guide/libraries/images.
  private function imgWaterMark($path, $file, $text = '', $sufix = "_wm.") {
    // var_dump(base_url('assets/fonts/comic.ttf')); // fail
    // var_dump(APPPATH); // 'C:\wamp64\www\posCI4\app\'
    // *********** Config section - Begin ***************
    // $fontPath = APPPATH . '../public/assets/fonts/CURLZ___.TTF';
    // $fontPath = APPPATH . '../public/assets/fonts/RubikWetPaint-Regular.ttf';
    // $fontPath = APPPATH . '../public/assets/fonts/Creepster-Regular.ttf';
    // $fontPath = APPPATH . '../public/assets/fonts/Yellowtail-Regular.ttf';
    // $fontPath = APPPATH . '../public/assets/fonts/Nosifer-Regular.ttf';
    // $fontPath = APPPATH . '../public/assets/fonts/Molle-Italic.ttf';
    $fontPath = APPPATH . '../public/assets/fonts/ALGER.TTF';
    $fontPath = APPPATH . '../public/assets/fonts/COOPBL.TTF';
    $fontPath = APPPATH . '../public/assets/fonts/comic.ttf';
    $fontPath = APPPATH . '../public/assets/fonts/lucon.ttf';

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
          //  'color'      => '#fff',
           'color'        => '#4c9',
          //  'opacity'    => 0.5,
           'opacity'      => $opacity,
           'withShadow'   => $shdwDisp,
           'shadowOffset' => $shdwDist,
          //  'withShadow' => false,
           'hAlign'       => $hAlign,
          //  'vAlign'     => 'bottom',
          //  'vAlign'     => 'top',
           'vAlign'       => $vAlign,
          //  'fontSize'   => 20 // Src - Fail?
          //  'fontPath'   => 'https://fonts.googleapis.com/css2?family=Pacifico&family=Permanent+Marker&family=Roboto+Slab:wght@600&display=swap',  // fail
          //  'fontPath'   => 'C:\Windows\Fonts\comic.ttf',
           'fontPath'     => $fontPath,
           'fontSize'     => $fontSize
    // ])->save("$path/wm_$file");
    // ])->save("$path/$file");
    ])->save("$path/".str_replace(".", $sufix, $file));
  }

  public function imgResize($path, $file, $width, $height, $sufix = "_th.")
  {
    \Config\Services::image('imagick')
    // ->withFile('/path/to/image/mypic.jpg')
    ->withFile("$path/$file")
    // ->resize(200, 100, true, 'height')
    ->resize($width, $height, true, 'auto')
    // ->save('/path/to/new/image.jpg');
    // ->save("$path/th_$file");
    // ->save("$path/$file");
    ->save("$path/".str_replace(".", $sufix, $file));
  }

  // private function loadFiles($path, $file, $ext) {
  // private function loadFiles()  // usar uniqid() para id
  /** 
  private function loadFiles($id) {
    $imgFiles = $this->request->getFileMultiple('images');
    var_dump(WRITEPATH); // 'C:\wamp64\www\posCI4\writable\' (length=30)
    $path    = WRITEPATH . "../public/images/$this->module/$id";
    $imgsLst = [];
    foreach ($imgFiles as $key => $file) {
      if ($file->getSize()) { // Validar el tamaño máximo
          // Get the file's basename

          echo "<br>getRandomName(): ". $file->getRandomName();
          // echo "<br>originalName(): ". $file->originalName();
          echo "<br>getBasename(): ". $file->getBasename();
          echo "<br>guessExtension(): ". $file->guessExtension();
          echo "<br>getMimeType(): ". $file->getMimeType();
          // Get last modified time
          echo "<br>getMTime(): ". $file->getMTime();
          // Get the true real path
          echo "<br>getRealPath(): ". $file->getRealPath();
          // Get the file permissions
          echo "<br>getPerms(): ". $file->getPerms();
          var_dump($path);
          var_dump($file);
          // move_uploaded_file
          // $file->move($path);
          $text     = "ArmyStore.com"; // Leer de la configuración
          $nameSrc  = $file->getName();
          $nameNew  = $file->getRandomName();
          echo "<br>getName(): ". $nameSrc;
          // $ext      = $file->guessExtension();
          
          // var_dump($ext);
          var_dump($text);
          $file->move($path, $nameNew);
          $this->imgThumbNail($path, $nameNew);
          $this->imgWaterMark($path, $nameNew, $text);
          $width  = 130;
          $height =  65;
          $width  = $height;
          $this->imgResize($path, $nameNew, $width, $height);
          $imgsLst[$nameSrc] = $nameNew;
      } else {
        echo "Omitido: $key";
      }
      echo $file->getSize();
      echo "<br>";
      echo $key;
      var_dump($file);
    }
    var_dump($imgFiles);
    return $imgsLst;
  }
  */

  /**
  // *** Fotos - Inicio
  public function photosLoaded() {
    $text  = 'ArmyStore';
    $file  = "foto3";
    $file  = "foto2";
    $file  = "foto1";
    $file  = "foto4";
    $ext   = "jpg";

    // $file  = "foto0";
    // $ext   = "png";

    $path  = "C:/wamp64/www/posCI4/public/images/articulos/1"; // Ok - Try WRITABLE dir
    $size  = 50; //75; // 100; // 
    
    // $text  = 'Copyright 2017 My Photo Co';

    
    // images/articulos/2
    // $path  = "C:/wamp64/www/posCI4/public/images/articulos/2"; // Ok - Try WRITABLE dir
    // $file  = "foto1";
    // $file  = "foto2";
    // $file  = "foto3";
    // $ext   = "jpg";

    // var_dump ($this->isfile("$path/$file.$ext"));
    // var_dump("$path/$file.$ext");
    // var_dump(is_file("$path/$file.$ext"));
    // var_dump(is_file("http://192.168.1.65/posci4/public/images/articulos/1/foto4.jpg")); // Fail

    $this->imgThumbNail($path, $file.$ext);
    $this->imgWaterMark($path, $file.$ext, $text);
    
    echo "<br>PhotoLoaded";
  }

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
  */

  /*
  public function testRename() // test ok - done -clear
  {
    // $pathA = WRITEPATH . "../public/images/$this->module/1b";
    // $pathB = WRITEPATH . "../public/images/$this->module/1";
    // echo rename ($pathA, $pathB) ? "Exito" : "Falló";
    $id = "xx";  // Edit
    // $id = "";    // New
    $rules = [
      //  'id'            => 'required',
      //  'codigo'        => [
      //     'rules'  => "required|is_unique[$this->module.codigo]",
      //     'errors' => [
      //        'required'  => "DEBE proporcionarse el código|{field}",
      //        'is_unique' => "¡El código DEBE ser único! ¡Está repetido!|{field}"
      //     ]
      //  ],
      //  'codigo'        => [
      //     'rules'  => "required".(isset($id)?"":"|is_unique[$this->module.codigo]"),
      //     'errors' => [
      //        'required'  => "DEBE proporcionarse el código|{field}",
      //        'is_unique' => "¡El código DEBE ser único! ¡Está repetido!|{field}"
      //     ]
      //  ],
      //  'nombre'        => [
      //     'rules'  => "required".(isset($id)?"":"|is_unique[$this->module.nombre]"),
      //     'errors' => [
      //       'required'  => "Debe proporcionarse el {field}|{field}",
      //       'is_unique' => "¡Nombre del $this->item repetido! ¡DEBE ser ÚNICO!|{field}"
      //       ]
      //  ],
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
      //  'activo'        => 'required'
    ];
    var_dump($rules);
  }
  */

  private function getValidate($method = "post")
  {
    $id = $_POST['id'];
    echo '<script>
      console.log("Agregar - dataSet:", '. json_encode($_POST) .' );
      // console.log("Agregar - dataSet:", '. json_encode($_POST) .' );
    </script>';
    $rules = [
      //  'id'            => 'required',
      //  'codigo'        => [
      //     'rules'  => "required|is_unique[$this->module.codigo]",
      //     'errors' => [
      //        'required'  => "DEBE proporcionarse el código|{field}",
      //        'is_unique' => "¡El código DEBE ser único! ¡Está repetido!|{field}"
      //     ]
      //  ],
      //  'nombre'        => [
      //     'rules'  => "required|is_unique[$this->module.nombre]",
      //     'errors' => [
      //       'required'  => "Debe proporcionarse el {field}|{field}",
      //       'is_unique' => "¡Nombre del $this->item repetido! ¡DEBE ser ÚNICO!|{field}"
      //       ]
      //  ],
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
      //  'activo'        => 'required'
    ];
    // var_dump($rules);
    /*
    $rules = [
      'nombre' => [
         'rules' => 'required|is_unique[categorias.nombre]',
         'errors' => [
            'required'  => "Debe proporcionarse el {field}|{field}",
            'is_unique' => "¡Esta $this->item ya existe y DEBE ser ÚNICA!"
         ]
      ]
    ];
    */
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
    // $lista = glob("images/articulos/*.*");
    // echo '<script>
    //   // console.log("Agregar - dataSet:", '. json_encode($dataSet) .' );
    //   // console.log("Agregar - dataWeb:", '. json_encode($dataWeb) .' );
    //   // console.log("Agregar - lista:", '. json_encode($lista) .' );
    // </script>';
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
        // $msg = "Insercci´n";
        // *
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
        // $path = ; // necesaria para
        //   crear el directorio TEMPORAL ANTES de cargar las fotos
        //   Cambiar el nombre del directorio para aspciarlo al id prod.
        $idTmp = '';
        if (isset($uploaded)) {
            $idTmp = uniqid();
            $mdOk  = mkdir( "$this->imgsPath/$idTmp", 0777, true);
            if ($mdOk) {
                // Tal vez condicionar la carga de fotos...
            }
            /*
            $album = $this->photosDriver($idTmp);
            // var_dump(isset($album));
            // var_dump($album);
            if (isset($album))
                $dataWeb = $this->getPhotoData($dataWeb, $album);
            */
            $dataWeb = $this->getPhotoData($dataWeb, $this->photosDriver($idTmp));
        }
        // echo "dataWeb 1 ";
        // var_dump($dataWeb);
        /**
        // Completar: $dataWeb con los campos
        //   Foto 
        //   Fotos
        **/
        // if (isset($album)) {
        //     $dataWeb['foto']  = str_replace(".", "_th.", $album[0]);
        //     $dataWeb['foto']  = str_replace(".", "_tn.", $album[0]);
        //     $dataWeb['fotos'] = implode('|', $album);
        // }
        // $dataWeb = $this->getPhotoData($dataWeb, $this->photosDriver($id));  // Ok ?
        $this->dataModel->save($dataWeb);        // Ok
        // $id = $this->db->insert_id();         // Fail
        // $id = $this->dataModel->insert_id();  // 
        // $id = $this->dataModel->insert_id;    // 
        // $path = "$this->imgsPath/$id"; // necesaria para
        //   crear el directorio TEMPORAL ANTES de cargar las fotos
        //   Cambiar el nombre del directorio para aspciarlo al id prod.
        if (isset($uploaded)) {
          /// Quizá sea más conveniente
          //    Crear otro campo en la tabla para el nombre del directorio destino
          //    Guardar  nombre del directorio -ahora temporal- en nuevo campo de la tabla
          $id = $this->dataModel->getIdOfCode($dataWeb['codigo']);  // 
          // var_dump($idTmp);
          // var_dump($id);
          // echo "insertar() idTmp ($idTmp) = > id: ($id)";
          rename ("$this->imgsPath/$idTmp", "$this->imgsPath/$id");
        }        
        // return;
        return redirect()->to(base_url()."/$this->module");
    }
    $this->setCarrier($dataWeb, '');
    $this->agregar();
  }

  // public function testRen() - Done -Clear
  // {
  //   $id    = "13";
  //   $idTmp = "625c9437c64a6";
  //   echo rename ("$this->imgsPath/$idTmp", "$this->imgsPath/$id") ? "Exito" : "Falló";
  // }

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
    echo view("$this->module/form", $dataWeb);  // Ok - 
    // echo view("$this->module/formEdit", $dataWeb); // Demo - Testing only
    echo view('/includes/footer');
  }

  /*
  private function textDel($id) // test it - ok - Done - Clear
  {
    echo $id;
    $file ="foto6.jpg";
    echo str_replace(".", "*.", $file);
    var_dump("$this->imgsPath/$id/$file");
    
    echo "realpath<br>";
    $fileG = realpath("$this->imgsPath/$id/$file");
    var_dump($fileG);
    var_dump( glob($fileG) );

    // $fileG = realpath("$this->imgsPath/$id/".str_replace(".", "*.", $file));
    $fileG = str_replace(".", "*.", $file);
    $fileG = "$this->imgsPath/$id/".str_replace(".", "*.", $file);
    // $fileG = realpath ("$this->imgsPath/$id/".str_replace(".", "*.", $file));
    var_dump($fileG);
    var_dump( glob($fileG) );
    var_dump( glob("$this->imgsPath/$id/".str_replace(".", "*.", $file)) );
    var_dump (array_map( 'realpath', glob("$this->imgsPath/$id/".str_replace(".", "*.", $file)) ));

    array_map( 'unlink', glob("$this->imgsPath/$id/".str_replace(".", "*.", $file)) );
    
    // $fileG = str_replace(".", "*.", $fileG);
    // var_dump($fileG);

    // var_dump("$this->imgsPath/$id/".str_replace(".", "*.", $file));
    // var_dump(realpath("$this->imgsPath/$id/".str_replace(".", "*.", $file)));
    // unlink ($fileG);
    // unlink ("$this->imgsPath/$id/".str_replace(".", "*.", $file));
  }
  */

  /* */
  private function photosDriver($id)
  
  { // Al insertar renombrar $idTmp por nuevo $id
    // get 
    $path = "$this->imgsPath/$id";
    $remove = $this->request->getPost('remove');
    $album = [];
    if (isset($remove)) 
       foreach ($remove as $key => $file) 
          array_map( 'unlink', glob("$path/".str_replace(".", "*.", $file)) );

    // **** 0
    // $this->photos01($_POST['imgs']);
    // var_dump($_POST);
    // var_dump($_FILES);
    // 'fotos'         => $this->request->getPost('fotos'),   // Fotos con nombres finales segùn orden
    // $fotos = implode("|", $_FILES);
    // var_dump($fotos);

    // *0
    $imgFiles = $this->request->getFileMultiple('images');
      // var_dump(WRITEPATH); // 'C:\wamp64\www\posCI4\writable\' (length=30)
      // $path    = WRITEPATH . "../public/images/$this->module/$id";
    if (isset($imgFiles)) {
      # code...
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
            
              $nameSrc  = $file->getName();
              $nameNew  = $file->getRandomName();
              // echo "<br>getName(): ". $nameSrc;
              // $ext      = $file->guessExtension();
              
              // var_dump($ext);
              // var_dump($text);
              $file->move($path, $nameNew);
              $this->imgThumbNail($path, $nameNew);
              // $this->imgThumbNail($path, str_replace(".", "_tn.", $nameNew));
              $this->imgWaterMark($path, $nameNew, $text);
              // $this->imgWaterMark($path, str_replace(".", "_wm.", $nameNew), $text);
              $width  = 130;
              $height =  65;
              $width  = $height;
              $this->imgResize($path, $nameNew, $width, $height);
              // $this->imgResize($path, str_replace(".", "_th.", $nameNew), $width, $height);
              // $imgsLst[$nameSrc] = $nameNew;
              // $filesLoaded[$file->getName()] = $nameNew;
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
      foreach ($album as $key => $imgName) {
        // echo "<br>$imgName: ";
        // echo isset($filesLoaded[$imgName]) ? $filesLoaded[$imgName]: " .F.";
        if (isset($filesLoaded[$imgName])) {
            $album[$key] = $filesLoaded[$imgName];
            // $imgName = $filesLoaded[$imgName];
            // echo "-> $imgName <-";
        }
      }
      // var_dump($filesLoaded);
    } 
    else {
      $album = $this->request->getPost('imgs');    // Orden de las fotos
    }
      // var_dump($imgFiles);
    // return $imgsLst; // Fotos
    // *1
    // $filesLoaded = $this->loadFiles($id);
    // $imgsLst

    // var_dump( $album );
    return $album;
    /*
    echo "After renamed ";
    $dataWeb['fotos'] = implode('|', $album);
    var_dump( $dataWeb['fotos']);

    // if ($dataSet['fotos']         == '') $dataSet['fotos']  = 0;
    $dataSet['fotos'] = implode("|", $dataSet['imgs']); // Enviar a ???
    // $fotos = implode("|", $dataWeb['imgs']);
    // var_dump($fotos);
    $this->photosLoaded();
    // **** 1
        // Cargar fotos del producto $id
        // Crear marcas de agua
        // Crear tumbnails
        // Crear miniaturas
        // Completar: $dataWeb con los campos
        //   Foto 
        //   Fotos
    echo "Processing " . count($imgs);
    foreach ($imgs as $img) {
      var_dump($img);
    }
    */
  }
  /**/

  public function getPhotoData($dataWeb, $album)
  {
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
    // $texto = 'foto0.png|foto1.jpg|foto2.jpeg|foto3.png|foto4.jpg|foto5.jpeg|foto6.png|foto7.jpg|foto8.jpeg|foto9.png';
    // var_dump($texto);
    // print_r (explode ("|", $texto));
    $id      = $this->request->getPost('id');
    $dataWeb = $this->setDataSet();
    if ($this->getValidate( $this->request->getMethod() )) {
        // Validar Fotos:
        //   Cantidad: Array.lengh < 11
        //   Tamaño (Bytes) 
        //   Resolución?
        // var_dump($dataWeb); // Ya fue validado
        // $album = $this->photosDriver($id); // Devolver valores para
        
        // Completar: $dataWeb con los campos
        //   Foto 
        //   Fotos
        // $dataWeb['foto']  = str_replace(".", "_tn.", $album[0]);
        // $dataWeb['foto']  = str_replace(".", "_th.", $album[0]);
        // $dataWeb['fotos'] = implode('|', $album);
        $dataWeb = $this->getPhotoData($dataWeb, $this->photosDriver($id));
        // if (isset($album)) {
        //   $dataWeb['foto']  = str_replace(".", "_th.", $album[0]);
        //   $dataWeb['foto']  = str_replace(".", "_tn.", $album[0]);
        //   $dataWeb['fotos'] = implode('|', $album);
        // }
        // echo "2 save ";
        // var_dump( $dataWeb );
        // return;
        // $msg = "¡Actualización exitosa!";
        $this->dataModel->update( $id, $dataWeb );
        return redirect()->to(base_url()."/$this->module"); // Ok

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
