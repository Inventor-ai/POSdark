<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\CategoriasModel;

class Categorias extends BaseController
{
  protected $item     = 'Categoria'; 
  protected $items    = 's';
  protected $enabled  = 'Disponibles';
  protected $disabled = 'Eliminadas';
  protected $insert   = 'insertar';
  protected $update   = 'actualizar';
  protected $carrier  = [];
  protected $module;
  protected $dataModel;

  public function __construct()
  {
    $search          = explode(',',"á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ"); // "á", "é", "í", "í", "í"
    $replaceBy       = explode(',',"a,e,i,o,u,ni,A,E,I,O,U,NI");
    $this->items     = $this->item.$this->items;

    $modulePath      = strtolower($this->items);
    // var_dump($search);
    // var_dump($modulePath);
    $modulePath          = str_replace($search, $replaceBy, $modulePath );
    // var_dump($modulePath);
    str_replace($search, $replaceBy, $modulePath );
    $this->module    = str_replace($search, $replaceBy, $modulePath );
    $this->dataModel = new CategoriasModel();
  }

  // método innecesario (D)escartado)
  public function eliminados()
  {
    $this->index(0);
    //  echo "donas";
  }
  
   
  public function index($activo = 1)
  {
    $dataModel = $this->dataModel
                      ->where('activo', $activo)
                      ->findAll();
    $dataWeb   = [
       // 'titulo' => 'Categorias - Listado', //'Lista de Categorias', //
       // 'titulo'   => "$this->items ".strtolower($activo == 1 ? $this->enabled : $this->disabled),
       'title'   => "$this->items ".strtolower($activo == 1 ? $this->enabled : $this->disabled),
       'item'    => $this->item,
       'path'    => "$this->module",
       'onOff'   => $activo,
       'switch'  => $activo == 0 ? $this->enabled : $this->disabled,
       'delete'  => 'eliminar',
       'recover' => 'recuperar',
       'data'    => $dataModel
    ];
    echo view('/includes/header');
    //  echo view('Categorias/Categorias', $dataWeb);
    //  echo view("$this->module/$this->module", $dataWeb);
    // var_dump( $this->module);
    echo view("$this->module/list", $dataWeb);
    echo view('/includes/footer');
    //  var_dump($dataWeb);
  }

  private function getDataSet( 
        $titulo    = '',  $ruta      = '',   $action = "", 
        $method = "post", $validador = null, $dataSet = [])
  {
    //   $id = ($action == $this->insert ? '' : $dataSet['id']);
      // $edit
    return [
      // 'titulo'     => "$this->item - Agregando...",
      'title'      => $titulo,
      // 'ruta'       => "$this->module",
      'path'       => $ruta,
      // 'action'     => "insertar",
      'action'     => $action,
      // 'method'     => 'post',
      'method'     => $method,
      // 'validation' => $this->validator,
      'validation' => $validador,
      // 'datos'      => $dataSet,
      'data'       => $dataSet
    //   'data'       => ['id'           => $dataSet['id'],
    //                    'nombre'       => $dataSet['nombre'],
    //                    'nombre_corto' => $dataSet['nombre_corto']
    //                   ]
    ];
  }

  private function getValidate($method = "post")
  {
    $rules = [
        'nombre'       => 'required'
    ];
    return ($this->request->getMethod() == $method &&
            $this->validate($rules) );
 
  }

  public function agregar()
  { 
      /*
       $dataWeb = [
         // 'titulo' => 'Unidad - Agregando...', //'Agregar unidad', //
         'titulo' => "$this->item - Agregando...", //"Agregar $this->item", //
         'ruta'   => "$this->module",
         'action' => "insertar",
         'method' => 'post',
         'datos'  => ['id'           => '',
                      'nombre'       => '',
                      'nombre_corto' => ''
                     ]
       ];
      */

    if ( count ($this->carrier) > 0 ) {
         $dataSet    = $this->carrier['datos'];
         $validation = $this->carrier['validation'];
     } else { # Registro nuevo y en blanco
         $validation = null;
         $dataSet = ['id'           => '',
                     'nombre'       => '',
                     'nombre_corto' => ''
         ];
    }
    $this->carrier = [];
    $dataWeb = $this->getDataSet( 
        "$this->item - Agregando...", //"Agregar $this->item", //
        "$this->module",
        $this->insert,
        'post',
        $validation,
        $dataSet
     ); 

    echo view('/includes/header');
    //   echo view("$this->module/nuevo", $dataWeb);
    echo view("$this->module/form", $dataWeb);
    echo view('/includes/footer');        
  }

  // private function setDataSet(Request $request)
  private function setDataSet()
  {
    return [
      'nombre'       => $this->request->getPost('nombre'),
      'nombre_corto' => $this->request->getPost('nombre_corto')
    ];
  }

  public function insertar()
  {
    // $dataWeb = [
    //    'nombre'       => $this->request->getPost('nombre'),
    //    'nombre_corto' => $this->request->getPost('nombre_corto')
    // ];
    $dataWeb = $this->setDataSet();
    // $rules = [
    //    'nombre'       => 'required',
    //    'nombre_corto' => 'required'
    // ];

    // if ($this->request->getMethod() == "post" &&
    //     $this->validate($rules) ) {
    if ($this->getValidate( $this->request->getMethod() )) {
        $msg = "Insercci´n";
        $this->dataModel->save($dataWeb); // Ok
        //   return redirect()->to(base_url().'/Categorias');
        return redirect()->to(base_url()."/$this->module");
    }
     // else {

        //   $data = [
        //     'titulo'     => "$this->item - Agregando...",
        //     'ruta'       => "$this->module",
        //     'action'     => "insertar",
        //     'method'     => 'post',
        //     'validation' => $this->validator,
        //     'datos'      => ['id'           => '',
        //                      'nombre'       => $dataWeb['nombre'],
        //                      'nombre_corto' => $dataWeb['nombre_corto']
        //                 ]
        //   ];

        $this->carrier = [
           'validation' => $this->validator,
           'datos'      => ['id'           => '',
                            'nombre'       => $dataWeb['nombre'],
                            'nombre_corto' => $dataWeb['nombre_corto']
                       ]
        ];
        //   echo count($this->carrier);
        //   var_dump($this->carrier);
        $this->agregar();
        return;
        // * * * * * * * * * * * * * * * * * * * * * * * * * * * *          
          /*
          $data        = $this->getDataSet( 
            $titulo    = "$this->item - Agregando...", //"Agregar $this->item", //
            $ruta      = "$this->module",
            // $action    = "insertar",
            $action    = $this->insert,
            $method    = 'post',
            $validador = null,
            $dataSet   = ['id'           => '',
                          'nombre'       => '',
                          'nombre_corto' => ''
                         ]
          );
          */

          echo view('/includes/header');
          echo view("$this->module/form", $data);
          echo view('/includes/footer');          
     //   }
        // * * * * * * * * * * * * * * * * * * * * * * * * * * * *
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
    /*
    $dataWeb   = [
        // 'titulo' => 'Unidad - Editando...', //'Editar unidad', //
       'titulo' => "$this->item - Editando...", //"Editar $this->item", //
       'ruta'   => "$this->module",
       'action' => "actualizar",
       'method' => 'post', //'put', //
       'datos'  => $dataModel
    ];
    */

    // 
    // $validation = null;
    $dataWeb = $this->getDataSet( 
        "$this->item - Editando...", //"Editar $this->item", //
        "$this->module",
        $this->update,//
        'post',  //'put', //
        $validation,
        $dataModel
    );
    echo view('/includes/header');
    //   echo view("$this->module/editar", $dataWeb);
    echo view("$this->module/form", $dataWeb);
    echo view('/includes/footer');
  }

  public function actualizar()
  {
    $id      = $this->request->getPost('id');
    // $dataWeb = [
    //   'nombre'       => $this->request->getPost('nombre'),
    //   'nombre_corto' => $this->request->getPost('nombre_corto')
    // ];
    $dataWeb = $this->setDataSet();
    if ($this->getValidate( $this->request->getMethod() )) {
        $msg = "¡Actualización exitosa!";
        $this->dataModel->update( $id, $dataWeb );
        return redirect()->to(base_url()."/$this->module");
    }
    $this->carrier = [
      'validation' => $this->validator,
      'datos'      => ['id'           => $id,
                       'nombre'       => $dataWeb['nombre'],
                       'nombre_corto' => $dataWeb['nombre_corto']
                      ]
    ];
    $this->editar($id);
    return;
  }

    public function eliminar($id, $activo = 0)
    {
      $dataWeb = ['activo' => $activo];
      $msg = "¡Eliminación exitosa!";
      $this->dataModel->update($id, $dataWeb);
      return redirect()->to(base_url()."/$this->module");
    }

    public function recuperar($id)
    {
    //   return $this->eliminar($id, 1);
      $this->eliminar($id, 1);
      return redirect()->to(base_url()."/$this->module/index/0");
  }

}
