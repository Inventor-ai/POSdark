<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\UsuariosModel;
use App\Models\CajasModel;
use App\Models\RolesModel;

class Usuarios extends BaseController
{
  protected $item     = 'Usuario'; // Examen
  protected $items    = 's';         // Exámenes
  protected $enabled  = 'Disponibles';
  protected $disabled = 'Eliminados';
  protected $insert   = 'insertar';
  protected $update   = 'actualizar';

  protected $recAdd   = 'Agregando...';
  protected $recEdit  = 'Editando...';
  
  protected $action   = '';
  protected $carrier  = [];
  protected $module;
  protected $dataModel;

  public function __construct()
  {
    $search          = explode(',',"á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ");
    $replaceBy       = explode(',',"a,e,i,o,u,ni,A,E,I,O,U,NI");
    $this->items     = $this->item.$this->items; // Exámenes - No concatenate
    $this->module    = strtolower(str_replace($search, $replaceBy, $this->items));
    $this->dataModel = new UsuariosModel();
    $this->dataCajas = new CajasModel();
    $this->dataRoles = new RolesModel();
    /*
    // helper (['setupController', $this]);
    $search          = explode(',',"á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ");
    $replaceBy       = explode(',',"a,e,i,o,u,ni,A,E,I,O,U,NI");
    $this->items     = $this->item.$this->items;
    $this->module    = strtolower(str_replace($search, $replaceBy, $this->items));
    */
  }

  private function setDataSet()
  {
    // $dataSet = [
    //   'nombre'     => trim( $this->request->getPost('nombre') ),
    //   'usuario'    => trim( $this->request->getPost('usuario') ),
    //   'password'   => trim( $this->request->getPost('password') ),
    //   'repassword' => trim( $this->request->getPost('repassword') ),
    //   'caja_id'    => trim( $this->request->getPost('caja_id') ),
    //   'rol_id'     => trim( $this->request->getPost('rol_id') ),
    // ];
    $dataSet = $_POST;
    // Custom initialize section. Set default value by field
    // if ($dataSet['nombre']     == '') $dataSet['nombre']     = '';
    // if ($dataSet['usuario']    == '') $dataSet['usuario']    = '';
    // if ($dataSet['password']   == '') $dataSet['password']   = '';
    // if ($dataSet['repassword'] == '') $dataSet['repassword'] = '';
    // if ($dataSet['caja_id']    == '') $dataSet['caja_id']    = '';
    // if ($dataSet['rol_id']     == '') $dataSet['rol_id']     = '';
    return $dataSet;
  }

  private function getValidate($method = "post")
  {
    // $rules = [
    //    'nombre' => 'required'
    // ];
    $rules = [
      'nombre' => [
        //  'rules' => "required|is_unique[$this->module.nombre]",
         'rules' => "required",
         'errors' => [
            'required'  => "Debe proporcionarse el {field}|{field}",
            // 'is_unique' => "¡Este {field} y ya existe! DEBE ser ÚNICO|{field}"
         ]
      ],
      'usuario' => [
         'rules' => "required|is_unique[$this->module.usuario]",
        //  'rules' => "required|email|is_unique[$this->module.usuario]",
         'errors' => [
            'required'  => "Debe proporcionarse el {field}|{field}",
            // 'email'     => "Proporcionar un email como {field}|{field}",
            'is_unique' => "¡Este $this->item ya existe y DEBE ser ÚNICO!|{field}"
         ]
      ],
      // Validar que la contraseña sea diferente al usuario (May/Min)
      // Validar que la contraseña no esté dentro del nombre, ni del usuario
      // Un mínimo de 12 caracteres, sin espacios, ...
      // .Algún otro detalle para hacerla segura
      'password' => [
         'rules' => "required|is_unique[$this->module.password]",
        //  'rules' => "required|is_unique[$this->module.password]",
         'errors' => [
            'required'  => "Debe proporcionarse la contraseña|{field}",
            'is_unique' => "¡La contraseña DEBE ser ÚNICA y ya fue usada antes!|{field}"
         ]
      ],
      'repassword' => [
         'rules' => "required|matches[password]",
         'errors' => [
            'required' => "Debe proporcionarse la confirmación de la contraseña|{field}",
            'matches'  => "La contraseña no coincide con su confirmación|{field}"
         ]
      ],
      'caja_id' => [
         'rules' => "required|integer",
         'errors' => [
            'required' => "Debe proporcionarse la caja|{field}",
            'integer'  => "Falta seleccionar una caja|{field}"
         ]
      ],
      'rol_id' => [
         'rules' => "required|is_natural_no_zero",
         'errors' => [
            'required' => "Falta seleccionar un rol|{field}",
            'is_natural_no_zero' => "Falta seleccionar un rol|{field}"
         ]
      ],
    ];
            unset ($rules['password']);
            unset ($rules['repassword']);
    if ($this->action == $this->recEdit) {
        if ($_POST['password']   == '' && 
            $_POST['repassword'] == '') {
            // unset ($rules['password']);
            // unset ($rules['repassword']);
        }     
    }
    return ($this->request->getMethod() == $method &&
            $this->validate($rules) );
  }
  
  private function getDataSet(
       $titulo    = '',  $ruta      = '',   $action = "", 
       $method = "post", $validador = null, $dataSet = [])
  {
    $dataCajas = $this->dataCajas->where('activo', 1)->findAll();
    $dataRoles = $this->dataRoles->where('activo', 1)->findAll();
    return [
      'title'      => $titulo,
      'path'       => $ruta,
      'action'     => $action,
      'method'     => $method,
      'validation' => $validador,
      'data'       => $dataSet,
      'dataCajas'  => $dataCajas,
      'dataRoles'  => $dataRoles,
  
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
    // Hacer join para completar los datos del usuario.
    $dataModel = $this->dataModel
                      ->select('id, usuario, nombre, rol_id, caja_id')
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
    $this->action = $this->recAdd;
    $dataWeb = $this->getDataSet( 
        // "$this->item - Agregando...", //"Agregar $this->item", //
        "$this->item - $this->action", //"Agregar $this->item", //
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
        $hash = password_hash($dataWeb['password'], PASSWORD_DEFAULT);
        $dataWeb['password'] = $hash;
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
                            ->select('id, nombre, usuario, rol_id, caja_id')
                            ->where('id', $id)
                            ->first();
    }
    // $this->carrier = [];
    $this->action = $this->recEdit;
    $dataWeb = $this->getDataSet( 
        // "$this->item - Editando...", //"Editar $this->item", //
        "$this->item - $this->action", //"Editar $this->item", //
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
        $hash = password_hash($dataWeb['password'], PASSWORD_DEFAULT);
        $dataWeb['password'] = $hash;
        // $msg = "¡Actualización exitosa!";
        // $this->dataModel->update( $id, $dataWeb );          // Ok
        // return redirect()->to(base_url()."/$this->module"); // Ok
        // tmp - Ini
        $this->setCarrier($dataWeb, $id);
        $this->editar($id);
        // tmp - Fin
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

}
