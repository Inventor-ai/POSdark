<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\CajasModel;
use App\Models\CajasArqueoModel;

class Cajas extends BaseController
{
  protected $item     = 'Caja';      // Examen
  protected $items    = 's';         // Exámenes
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
    $this->items     = $this->item.$this->items; // Exámenes - No concatenate
    $this->module    = strtolower(str_replace($search, $replaceBy, $this->items));
    $this->dataModel = new CajasModel();
  }

  private function setDataSet()
  {
    $dataSet = [
      'nombre' => trim( $this->request->getPost('nombre') ),
      'caja'   => trim( $this->request->getPost('caja') ),
      'folio'  => trim( $this->request->getPost('folio') ),
      
    ];
    // Custom initialize section. Set default value by field
    if ($dataSet['nombre'] == '') $dataSet['nombre'] = '';
    if ($dataSet['caja']   == '') $dataSet['caja']   = '';
    if ($dataSet['folio']  == '') $dataSet['folio']  = '';
    return $dataSet;
  }

  private function getValidate($method = "post")
  {
    $rules = [
      'nombre' => [
         'rules' => "required|is_unique[$this->module.nombre]",
         'errors' => [
            'required'  => "Debe proporcionarse el {field} de la caja|{field}",
            'is_unique' => "¡Esta $this->item ya existe y DEBE ser ÚNICA!|{field}"
         ]
      ],
      'caja' => [
         'rules' => "required|is_natural_no_zero",
         'errors' => [
            'required'  => "Debe proporcionarse el número de {field}|{field}",
            'is_natural_no_zero' => "El número de {field} DEBE ser entero y mayor a cero|{field}"
         ]
      ],
      'folio' => [
         'rules' => "required|is_natural_no_zero",
         'errors' => [
            'required'  => "Debe proporcionarse el número de {field}|{field}",
            'is_natural_no_zero' => "El número de {field} DEBE ser entero y mayor a cero|{field}"
         ]
      ],
    ];
    return ($this->request->getMethod() == $method &&
            $this->validate($rules) );
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

  public function arqueo($idCaja)
  {
    $arqueoModel = new CajasArqueoModel();
    $arqueo = $arqueoModel->getDatos($idCaja);
    echo "Arqueo de la caja $idCaja";
/**/
    $activo = 1;
    $dataWeb   = [
       'title'   => "Cierres de caja",
       'item'    => $this->item,
       'path'    => $this->module,
       'onOff'   => $activo,
       'switch'  => $activo == 0 ? $this->enabled : $this->disabled,
       'delete'  => 'dEliminar registro',
       'close'   => 'cEliminar registro',
       'data'    => $arqueo
    ];
    echo view('/includes/header');
    echo view("$this->module/arqueos", $dataWeb);
    echo view('/includes/footer');
  }

  public function nuevo_arqueo()
  {
    $session = session();
    if ($this->request->getMethod() == 'post') {
        # code...
    } else {
        $caja = $this->dataModel->where('id', $session->caja_id)->first();
        $dataWeb   = [
          'title'   => "Cierres de caja",
        //   'item'    => $this->item,
        //   'path'    => $this->module,
        //  //  'onOff'   => $activo,
        //  //  'switch'  => $activo == 0 ? $this->enabled : $this->disabled,
        //   'delete'  => 'dEliminar registro',
        //   'close'   => 'cEliminar registro',
          'data'    => $caja
        ];
        echo view('/includes/header');
        echo view("$this->module/nuevo_arqueo", $dataWeb);
        echo view('/includes/footer');
    }
  }

}
