<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\UnidadesModel;

class Unidades extends BaseController
{
  protected $item     = 'Unidad'; 
  protected $items    = 'es';
  protected $enabled  = 'Disponibles';
  protected $disabled = 'Eliminadas';
//    protected $; 
//    protected $; 
  protected $module;
  protected $dataModel;

  public function __construct()
  {
    $search          = array(explode(',',"á,é,í,ó,ú,ñ")[0]); // "á", "é", "í", "í", "í"
    $replaceBy       = array(explode(',',"a,e,i,o,u,ni")[0]);
    $this->items     = $this->item.$this->items;
    $this->module    = str_replace($search, $replaceBy, strtolower($this->items));
    $this->dataModel = new UnidadesModel();
  }

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
        // 'titulo' => 'Unidades - Listado', //'Lista de unidades', //
        // 'titulo'   => "$this->items ".strtolower($activo == 1 ? $this->enabled : $this->disabled),
        'title'   => "$this->items ".strtolower($activo == 1 ? $this->enabled : $this->disabled),
        'item'    => $this->item,
        'path'    => "$this->module",
        'onOff'   => $activo,
        'switch'  => $activo == 0 ? $this->enabled : $this->disabled,
        'delete'  => 'eliminar',
        'recover' => 'recuperar',
        // 'switch'   => $activo == 0 ? $this->enabled : $this->disabled,
        'data'    => $dataModel
     ];
     echo view('/includes/header');
    //  echo view('unidades/unidades', $dataWeb);
     echo view("$this->module/$this->module", $dataWeb);
     echo view('/includes/footer');
    //  var_dump($dataWeb);
    }

    private function getDataSet( 
        $titulo    = '',  $ruta      = '',   $action = "", 
        $method = "post", $validador = null, $dataSet = []) 
    {
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
        'data'       => ['id'           => '',
                         'nombre'       => $dataWeb['nombre'],
                         'nombre_corto' => $dataWeb['nombre_corto']
                        ]
      ];
    }

    public function agregar()
    {
      //   echo "Editando id: $id";
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
      $dataWeb = $this->getDataSet( 
        $titulo    = "$this->item - Agregando...", //"Agregar $this->item", //
        $ruta      = "$this->module",
        $action    = "insertar",
        $method    = 'post',
        $validador = null,
        $dataSet   = ['id'           => '',
                      'nombre'       => '',
                      'nombre_corto' => ''
                     ]
      );
     /*
      $dataWeb = $this->getDataSet(
         "$this->item - Agregando...",
        , $action = "", $method = "post", $dataSet = []
      );
     */
      echo view('/includes/header');
     //   echo view("$this->module/nuevo", $dataWeb);
      echo view("$this->module/form", $dataWeb);
      echo view('/includes/footer');        
    }

    public function insertar()
    {
      $dataWeb = [
        'nombre'       => $this->request->getPost('nombre'),
        'nombre_corto' => $this->request->getPost('nombre_corto')
      ];
      $rules = [
         'nombre'       => 'required',
         'nombre_corto' => 'required'
      ];
      
      if ($this->request->getMethod() == "post" &&
          $this->validate($rules) ) {
          $msg = "Insercci´n";
        //   $this->dataModel->save($dataWeb); // Ok 
        //   return redirect()->to(base_url().'/unidades');
          return redirect()->to(base_url()."/$this->module");
      } 
    //   else {
          $data = [
            'titulo'     => "$this->item - Agregando...",
            'ruta'       => "$this->module",
            'action'     => "insertar",
            'method'     => 'post',
            'validation' => $this->validator,
            'datos'      => ['id'           => '',
                             'nombre'       => $dataWeb['nombre'],
                             'nombre_corto' => $dataWeb['nombre_corto']
                        ]
          ];
          echo view('/includes/header');
          echo view("$this->module/form", $data);
          echo view('/includes/footer');          
    //   }
    }

    public function editar($id)
    {
      $dataModel = $this->dataModel
                        ->where('id', $id)
                        ->first();
      $dataWeb   = [
        // 'titulo' => 'Unidad - Editando...', //'Editar unidad', //
        'titulo' => "$this->item - Editando...", //"Editar $this->item", //
        'ruta'   => "$this->module",
        'action' => "actualizar",
        'method' => 'post', //'put', //
        'datos'  => $dataModel
      ];
      echo view('/includes/header');
    //   echo view("$this->module/editar", $dataWeb);
      echo view("$this->module/form", $dataWeb);
      echo view('/includes/footer');
    }

    public function actualizar()
    {
      $dataWeb = [
        'nombre'       => $this->request->getPost('nombre'),
        'nombre_corto' => $this->request->getPost('nombre_corto')
      ];
      $msg = "¡Actualización exitosa!";
      $this->dataModel->update(
        $this->request->getPost('id'), $dataWeb
      );
      return redirect()->to(base_url()."/$this->module");
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
