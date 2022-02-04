<?php

namespace App\Controllers;
use App\Controllers\BaseController;
// use App\Models\UnidadesModel; // Replace It

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
      $search          = array(explode(',',"á,é,í,ó,ú,ñ")[0]); // "á", "é", "í", "í", "í"
      $replaceBy       = array(explode(',',"a,e,i,o,u,ni")[0]);
      $this->items     = $this->item.$this->items;
      $this->module    = str_replace($search, $replaceBy, strtolower($this->items));
      // $this->dataModel = new UnidadesModel();
    }

    public function index()  // 
    {
      $dataWeb = ['data' => "$this->module demo<br>"];
      echo view('/includes/header');
      echo view("$this->module/list", $dataWeb);
      echo view('/includes/footer');
    }

    public function indexOk($activo = 1)
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
      return [
        'title'      => $titulo,
        'path'       => $ruta,
        'action'     => $action,
        'method'     => $method,
        'validation' => $validador,
        'data'       => $dataSet
      ];
    }
  
    private function getValidate($method = "post")
    {
      $rules = [
          'nombre'       => 'required',
          'nombre_corto' => 'required'
      ];
      return ($this->request->getMethod() == $method &&
              $this->validate($rules) );
    }
  
    public function agregar()
    {

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
      if ($this->getValidate( $this->request->getMethod() )) {
          $msg = "Insercci´n";
          $this->dataModel->save($dataWeb); // Ok
          //   return redirect()->to(base_url().'/unidades');
          return redirect()->to(base_url()."/$this->module");
      }
      else {
          $this->carrier = [
             'validation' => $this->validator,
             'datos'      => ['id'           => '',
                              'nombre'       => $dataWeb['nombre'],
                              'nombre_corto' => $dataWeb['nombre_corto']
                         ]
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
      echo view("$this->module/form", $dataWeb);
      echo view('/includes/footer');
    }
  
    public function actualizar()
    {
      $id      = $this->request->getPost('id');
      $dataWeb = [
        'nombre'       => $this->request->getPost('nombre'),
        'nombre_corto' => $this->request->getPost('nombre_corto')
      ];
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
        $this->eliminar($id, 1);
        return redirect()->to(base_url()."/$this->module/index/0");
    }
  
  }
  