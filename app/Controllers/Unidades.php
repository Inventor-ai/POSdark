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
  protected $insert   = 'insertar';
  protected $update   = 'actualizar';
  protected $carrier  = [];
  protected $module;
  protected $dataModel;

  public function __construct()
  {
    $search          = explode(',',"á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ");
    $replaceBy       = explode(',',"a,e,i,o,u,ni,A,E,I,O,U,NI");
    $this->items     = $this->item.$this->items;
    $this->module    = strtolower(str_replace($search, $replaceBy, $this->items));
    $this->dataModel = new UnidadesModel();
  }

  // método innecesario (D)escartado)
  public function eliminados()
  {
    $this->index(0);
    //  echo "donas";
  }

  // private function setDataSet(Request $request)
  private function setDataSetOld()
  {
    return [
      'nombre'       => $this->request->getPost('nombre'),
      'nombre_corto' => $this->request->getPost('nombre_corto')
    ];
  }
  // private function setDataSet(Request $request)

  private function setDataSet()
  {
    $dataSet = [
      'nombre'       => trim( $this->request->getPost('nombre') ),
      'nombre_corto' => trim( $this->request->getPost('nombre_corto') )
    ];
    // Custom initialize section. Set default value by field
    if ($dataSet['nombre']       == '') $dataSet['nombre']       = '';
    if ($dataSet['nombre_corto'] == '') $dataSet['nombre_corto'] = '';
    return $dataSet;
    // return [
    //   'nombre'       => $this->request->getPost('nombre'),
    //   'nombre_corto' => $this->request->getPost('nombre_corto')
    // ];
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
  
  private function getDataSet( 
        $titulo    = '',  $ruta      = '',   $action = "", 
        $method = "post", $validador = null, $dataSet = [])
  {
    //   $id = ($action == $this->insert ? '' : $dataSet['id']);
    // $edit
    return [
      'title'      => $titulo,
      'path'       => $ruta,
      'action'     => $action,
      'method'     => $method,
      'validation' => $validador,
      'data'       => $dataSet
    //   'data'       => ['id'           => $dataSet['id'],
    //                    'nombre'       => $dataSet['nombre'],
    //                    'nombre_corto' => $dataSet['nombre_corto']
    //                   ]
    ];
  }

  private function setCarrier($dataWeb, $value = '', $key = 'id')
  {
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

  public function agregar()
  { 
    if ( count ($this->carrier) > 0 ) {
         $dataSet    = $this->carrier['datos'];
         $validation = $this->carrier['validation'];
     } else { # Registro nuevo y en blanco
         $validation = null;
         $dataSet    = $this->setDataSet();
         $dataSet['id'] = '';
        //  $dataSet = ['id'           => '',
        //              'nombre'       => '',
        //              'nombre_corto' => ''
        //  ];
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
    if ($this->getValidate( $this->request->getMethod() )) {
        // $msg = "Insercci´n";
        $this->dataModel->save($dataWeb);
        return redirect()->to(base_url()."/$this->module");
    }
     // else {
      // $dataWeb       = $this->setDataSet();
    $this->setCarrier($dataWeb, '');
    /*
    $dataWeb['id'] = '';    
    $this->carrier = [
      'validation' => $this->validator,
      'datos'      => $dataWeb
          //  'datos'      => [
          //      'id'           => '',
          //      'nombre'       => $dataWeb['nombre'],
          //      'nombre_corto' => $dataWeb['nombre_corto']
          //  ]
    ];
    */
    $this->agregar();
    // }
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

  public function actualizar()
  {
    $id      = $this->request->getPost('id');
    $dataWeb = $this->setDataSet();
    if ($this->getValidate( $this->request->getMethod() )) {
        // $msg = "¡Actualización exitosa!";
        $this->dataModel->update( $id, $dataWeb );
        return redirect()->to(base_url()."/$this->module");
    }
    $this->setCarrier($dataWeb, $id);
    /*
    $dataWeb['id'] = $id,
    $this->carrier = [
      'validation' => $this->validator,
      'datos'      => $dataWeb
      // 'datos'      => ['id'           => $id,
      //                  'nombre'       => $dataWeb['nombre'],
      //                  'nombre_corto' => $dataWeb['nombre_corto']
      //                 ]
    ];
    */
    $this->editar($id);
    // return;
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

}
