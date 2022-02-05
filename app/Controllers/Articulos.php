<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ArticulosModel; // Replace It
use App\Models\UnidadesModel;
use App\Models\CategoriasModel;

class Articulos extends BaseController
{
    protected $item     = 'Articulo'; 
    protected $items    = 's';
    protected $enabled  = 'Disponibles';
    protected $disabled = 'Eliminados';
    protected $insert   = 'insertar';
    protected $update   = 'actualizar';
    protected $carrier  = [];
    protected $module;
    protected $dataModel;
  
    public function __construct()
    {
      $search           = array(explode(',',"á,é,í,ó,ú,ñ")[0]); // "á", "é", "í", "í", "í"
      $replaceBy        = array(explode(',',"a,e,i,o,u,ni")[0]);
      $this->items      = $this->item.$this->items;
      $this->module     = str_replace($search, $replaceBy, strtolower($this->items));
      $this->dataModel  = new ArticulosModel();
      $this->unidades   = new UnidadesModel();
      $this->categorias = new CategoriasModel();
    }

    public function indexOk()  // Demo
    {
      // $dataWeb = ['data' => "Productos demo"];
      $dataWeb = ['data' => "$this->module demo<br>"];
      echo view('/includes/header');
      echo view("$this->module/list", $dataWeb);
      echo view('/includes/footer');
    }

    public function index($activo = 1)
    {
      $dataModel = $this->dataModel
                        ->where('activo', $activo)
                        ->findAll();
      $dataWeb   = [
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
      echo view("$this->module/list", $dataWeb);
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
        'unidades'   => $unidades,
        'categorias' => $categorias
      ];
    }
  
    private function getValidate($method = "post")
    {
      $rules = [
         'id'            => 'required',
         'codigo'        => 'required',
         'nombre'        => 'required',
         'precio_venta'  => 'required',
         'precio_compra' => 'required',
         'existencias'   => 'required',
         'stock_minimo'  => 'required',
         'inventariable' => 'required',
         'id_unidad'     => 'required',
         'id_categoria'  => 'required'
        //  'activo'        => 'required'
      ];

      return ($this->request->getMethod() == $method &&
              $this->validate($rules) );
    }
  
    public function agregar()
    {
      
      if ( count ($this->carrier) > 0 ) {
           $dataSet    = $this->carrier['datos'];
           $validation = $this->carrier['validation'];
           echo '
           <script>
             console.log("Insertar - Agregar:", '. json_encode($dataSet) .' );
           </script>
          ';
       } else { # Registro nuevo y en blanco
           $validation = null;
           $dataSet = [
              'id'            => '',
              'codigo'        => '',
              'nombre'        => '',
              'precio_venta'  => '',
              'precio_compra' => '',
              'existencias'   => '',
              'stock_minimo'  => '',
              'inventariable' => '',
              'id_unidad'     => '',
              // 'id_unidad'     => '',
              'id_categoria'  => '',
              'activo'        => ''   
           ];
           echo '
           <script>
             console.log("Nuevo:", '. json_encode($dataSet) .' );
           </script>
          ';
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
      
      echo '
      <script>
        console.log("Agregar - dataSet:", '. json_encode($dataSet) .' );
        console.log("Agregar - dataWeb:", '. json_encode($dataWeb) .' );
      </script>
     ';

  
      echo view('/includes/header');
      echo view("$this->module/form", $dataWeb);
      echo view('/includes/footer');        
    }

    // private function setDataSet(Request $request)
    private function setDataSet()
    {
      return [
        'id'            => $this->request->getPost('id'),
        'codigo'        => $this->request->getPost('codigo'),
        'nombre'        => $this->request->getPost('nombre'),
        'precio_venta'  => $this->request->getPost('precio_venta'),
        'precio_compra' => $this->request->getPost('precio_compra'),
        'existencias'   => $this->request->getPost('existencias'),
        'stock_minimo'  => $this->request->getPost('stock_minimo'),
        'inventariable' => $this->request->getPost('inventariable'),
        'id_unidad'     => $this->request->getPost('id_unidad'),
        'id_categoria'  => $this->request->getPost('id_categoria'),
        'activo'        => $this->request->getPost('activo')
      ];
    }
  
    public function insertar()
    {
      $dataWeb = $this->setDataSet();
      echo '
       <script>
         console.log("insertar:", '. json_encode($dataWeb) .' );
       </script>
      ';
      if ($this->getValidate( $this->request->getMethod() )) {
          // $msg = "Insercci´n";
          $this->dataModel->save($dataWeb); // Ok
          //   return redirect()->to(base_url().'/unidades');
          return redirect()->to(base_url()."/$this->module");
      }
      else {
          $this->carrier = [
             'validation' => $this->validator,
             'datos'      => $dataWeb
          ];
          $this->agregar();
      }
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
          "$this->item - Editando...", //"Editar $this->item", //
          "$this->module",
          $this->update,//
          'post',  //'put', //
          $validation,
          $dataModel
      );
      echo view('/includes/header');
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
      $dataWeb['id'] = $id;
      $this->carrier = [
        'validation' => $this->validator,
        'datos'      => $dataWeb
        // 'datos'      => ['id'           => $id,
        //                  'nombre'       => $dataWeb['nombre'],
        //                  'nombre_corto' => $dataWeb['nombre_corto']
        //                 ]
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
        $this->eliminar($id, 1);
        return redirect()->to(base_url()."/$this->module/index/0");
    }
  
  }
  