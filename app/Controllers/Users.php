<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ConfiguracionesModel;
use App\Models\UsersModel;
use App\Models\CajasModel;
use App\Models\RolesModel;
// use App\>Entities\User;

class Users extends BaseController
{
  protected $item      = 'Usuario';   // Examen
  protected $items     = 's';         // Exámenes
  protected $enabled   = 'Disponibles.';
  protected $disabled  = 'Eliminados.';
  protected $insert    = 'insertar';
  protected $update    = 'actualizar';
  protected $recAdd    = 'Agregando...';
  protected $recEdit   = 'Editando...';
  protected $loadAll   = true;
  protected $minLength = 3;  // Fix Settings for tests
  protected $maxLength = 5;  // Fix Settings for tests
  // protected $session   = false;
  protected $carrier   = [];
  protected $module    ='users';
  protected $dataModel;
  protected $objEntity;

  public function __construct()
  {
    // $search          = explode(',',"á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ");
    // $replaceBy       = explode(',',"a,e,i,o,u,ni,A,E,I,O,U,NI");
    $this->items     = $this->item.$this->items; // Exámenes - No concatenate
    // $this->module    = strtolower(str_replace($search, $replaceBy, $this->items));
    $this->dataModel = new UsersModel();
    $this->dataCajas = new CajasModel();
    $this->dataRoles = new RolesModel();
    $this->objEntity = new \App\Entities\User();
  }

  private function setDataSet()
  {
    // $data = ['id' => ''];
    if ($_POST) {
       $password   = $_POST['password'];
       $repassword = $_POST['repassword'];
       if ($_POST['id'] != '' && $password == '' && $repassword == '') {
          unset( $_POST['password'] );
          unset( $_POST['repassword'] );
       }
       $data = $_POST;
    } else {
    //    $data
    }
    // $obj = $this->objEntity->fill($data);
    // $obj = new \App\Entities\User($data);
    // var_dump( $obj->toArray() );
    // return;
    return $_POST;
    // return new \App\Entities\User($_POST);
    // return new \App\Entities\User($data);
  }

  private function getValidate($method = "post")
  {
    $rules = [
      'password' => [
         'rules' => "required|min_length[$this->minLength]|max_length[$this->maxLength]",
        // Encriptar en el control antes de validar esta regla
        //  'rules' => "required|is_unique[$this->module.password]", 
         'errors' => [
            // 'required'  => "Teclear la contraseña|{field}",
            'required'   => "Falta teclear la contraseña|{field}",
            'min_length' => "La contraseña debe tener entre $this->minLength y $this->maxLength caracteres|{field}",
            'max_length' => "La contraseña debe tener entre $this->minLength y $this->maxLength caracteres|{field}",
            // 'is_unique' => "¡La contraseña DEBE ser ÚNICA y ya fue usada antes!|{field}"
         ]
      ],
      'repassword' => [
         'rules' => "required|matches[password]",
         'errors' => [
            // 'required' => "Teclear la confirmación de la contraseña|{field}",
            'required' => "Falta teclear la confirmación de la contraseña|{field}",
            'matches'  => "La contraseña no coincide con su confirmación|{field}"
         ]
      ],
      'caja_id' => [
         'rules' => "required|integer",
         'errors' => [
            'required' => "Falta seleccionar una caja|{field}",
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

    if ((isset($_POST['id'])?$_POST['id']:true) == '' ) {  // Nuevo
        $rules['nombre'] = [
                'rules'  => "required|is_unique[usuarios.nombre]",
                'errors' => [
                    // 'required'  => "Teclear el {field}|{field}",
                    'required'  => "Falta teclear el {field}|{field}",
                    'is_unique' => "¡Este {field} y ya existe! DEBE ser ÚNICO|{field}"
                ]
        ];
        $rules['usuario'] = [
                'rules'   => "required|is_unique[usuarios.usuario]",
                  //  'rules' => "required|email|is_unique[usuarios.usuario]",
                'errors'  => [
                    // 'required'  => "Teclear el {field}|{field}",
                    'required'  => "Falta teclear el {field}|{field}",
                    // 'email'     => "Proporcionar un email como {field}|{field}",
                    'is_unique' => "¡Este $this->item ya existe y DEBE ser ÚNICO!|{field}"
                ]
        ];
    } else {  // Editando / Cambiando contraseña
        $rules['nombre'] = [
            //  'rules' => "required|is_unique[usuarios.nombre]",
                'rules'  => "required",
                'errors' => [
                    // 'required'  => "Teclear el {field}|{field}",
                    'required'  => "Falta teclear el {field}|{field}",
                     // 'is_unique' => "¡Este {field} y ya existe! DEBE ser ÚNICO|{field}"
                ]
        ];
        $rules['usuario'] = [
                'rules'   => "required",
                  //  'rules' => "required|email",
                'errors' => [
                      // 'required'  => "Teclear el {field}|{field}",
                      'required'  => "Falta teclear el {field}|{field}",
                      // 'email'     => "Proporcionar un email como {field}|{field}",
                      // 'is_unique' => "¡Este $this->item ya existe y DEBE ser ÚNICO!|{field}"
                ]
        ];
    }    

    // debug - section -
    echo '<script>
    console.log("0 getValidate post count: ", "|'. count ($_POST) .'|");';
    echo "console.log('getValidate _POST: ');
          console.log(". json_encode($_POST) .");";
    echo "</script>";

    $ruleSet = [];
    foreach ($_POST as $include => $value) {
      if (isset($rules[$include])) {
          $ruleSet[$include] = $rules[$include];
      }
    }

    // debug - section -
    echo "<script>
        console.log('". count($ruleSet) ." rules: ');
        console.log(". json_encode($ruleSet) .");
    </script>";

    // echo "getValidate()";
    // var_dump($this->request->getMethod());
    // var_dump($this->validate($ruleSet));
    // return;
    return ($this->request->getMethod() == $method &&
            $this->validate($ruleSet) );
  }
  
  private function getDataSet(
       $titulo    = '',  $ruta      = '',   $action = "", 
       $method = "post", $validador = null, $dataSet = [])
  {
    $data = [
      'title'      => $titulo,
      'path'       => $ruta,
      'action'     => $action,
      'method'     => $method,
      'validation' => $validador,
      'data'       => $dataSet,
      // 'dataCajas'  => $dataCajas,
      // 'dataRoles'  => $dataRoles,
    ];
    if ($this->loadAll) {
        $dataCajas = $this->dataCajas->where('activo', 1)->findAll();
        $dataRoles = $this->dataRoles->where('activo', 1)->findAll();
        $data['dataCajas'] = $dataCajas;
        $data['dataRoles'] = $dataRoles;
    }
    return $data;
  }

  private function setCarrier($dataWeb, $value = '', $key = 'id')
  {
    $dataWeb[$key] = $value;
    // $dataWeb->$key = $value;  // Ya no es necesaria New/edit???
    // $dataWeb->password   = '';
    // $dataWeb->repassword = '';
    // var_dump($dataWeb);
    // return;
    $this->carrier = [
      'validation' => $this->validator,
      'datos'      => $dataWeb
    ];
  }

  public function index($activo = 1)
  {
    // Hacer join para completar los datos del usuario.
    // $fieldList = 'usuarios.id, usuarios.nombre, usuario, caja_id, rol_id,'.
    $fieldList = 'usuarios.id, usuarios.nombre, usuario,'.
                 'cajas.nombre as caja,'.
                 'roles.nombre as rol,'.
                 '';
    $dataObj = $this->dataModel
                      ->select($fieldList)
                      ->join('cajas', 'cajas.id = caja_id')
                      ->join('roles', 'roles.id = rol_id')
                      ->where('usuarios.activo', $activo)
                      ->findAll();
    // var_dump($dataModel);
    $dataModel = [];
    foreach ($dataObj as $key => $value) {
      // var_dump( $key);
      // var_dump( $value->toArray() );
      $dataModel[] = $value->toArray();
    }
    // var_dump($dataModel);
    // $qq = $this->objEntity->fill($dataModel);
    // var_dump($dataModel[0]->nombre);
    // $qq = $dataModel;
    // var_dump( $qq->toArray() );
    // var_dump( $qq );
    // var_dump( $qq );
    // return;
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
        //  $dataSet    = $this->setDataSet();
         $dataSet['id'] = '';
        /*
         var_dump($_POST);
         var_dump($dataSet);
         var_dump(new \App\Entities\User());
        //  var_dump(new \App\Entities\User($dataSet));
         return;
       */  
    }
    // $this->carrier = [];
    $dataWeb = $this->getDataSet( 
        // "$this->item - Agregando...", //"Agregar $this->item", //
        "$this->item - $this->recAdd", //"Agregar $this->item", //
        "$this->module",
        $this->insert,
        'post',
        $validation,
        $dataSet
    );
    $dataWeb = $this->passwordSettings($dataWeb);
    echo view('/includes/header');
    echo view("$this->module/form", $dataWeb);
    echo view('/includes/footer');
  }

  // private function getCodedKey($passw = null)
  // {
  //   if ($passw) 
  //       return password_hash($passw, PASSWORD_DEFAULT);
  // }

  public function insertar()
  {
    $dataWeb = $this->setDataSet();
    // var_dump( $this->request->getMethod() );
    if ($this->getValidate( $this->request->getMethod() )) {
      // var_dump($dataWeb);
      $data = $this->objEntity->fill($dataWeb);
      // var_dump($data);
      // return;
        // $dataWeb['password'] = $this->getCodedKey($dataWeb['password']);
        // unset($dataWeb['repassword']); // Correcto pero innecesario
        // $msg = "Insercci´n";
        // $this->dataModel->save($dataWeb); // ok
        $this->dataModel->save($data); // ok
        return redirect()->to(base_url()."/$this->module");
    }
     // else {
    // var_dump($this->getValidate( $this->request->getMethod() ));
    // var_dump($dataWeb);
    // var_dump($this->validator);
    // var_dump($this->validator->listErrors());
    // return;
    $this->setCarrier($dataWeb, '');
    // $dataWeb->password   = '';
    // $dataWeb->repassword = '';
    // $this->setCarrier($dataWeb);
    $this->agregar();
    // }
  }

  public function editar($id)
  {
    if ( count ($this->carrier) > 0 ) {
         $dataModel  = $this->carrier['datos'];
         $validation = $this->carrier['validation'];
         //  $this->dataModel->fill($dataModel);
        //  $dataModel = new \App\Entities\User($dataModel);
        //  var_dump($dataModel);
      //  return;
     } else { # Registro nuevo y en blanco
         $validation = null;
         $dataObject = $this->dataModel
                            ->select('id, nombre, usuario, rol_id, caja_id')
                            ->where('id', $id)
                            ->first();
        //  var_dump($dataObject);
        //  var_dump($dataObject->toArray() );
        //  return;
         $dataModel = $dataObject->toArray();
        //  $dataModel = $dataObject;
    }
    // $this->carrier = [];
    $dataWeb = $this->getDataSet( 
        "$this->item - $this->recEdit", //"Editar $this->item", //
        $this->module,
        $this->update, //
        'post',        //'put', //
        $validation,
        $dataModel
    );
    $dataWeb = $this->passwordSettings($dataWeb);
    echo view('/includes/header');
    echo view("$this->module/form", $dataWeb);
    echo view('/includes/footer');
  }

  public function actualizar()
  {
    $id      = $this->request->getPost('id');
    $dataWeb = $this->setDataSet();
    // var_dump($dataWeb->id);
    // return;
    if ($this->getValidate( $this->request->getMethod() )) {
      // var_dump($this->getValidate( $this->request->getMethod() ));
      // var_dump($dataWeb);
      // return;
        /*
        if (isset($dataWeb['password']) ) {
            // $hash = password_hash($dataWeb['password'], PASSWORD_DEFAULT);
            // $dataWeb['password'] = $hash;
            $dataWeb['password'] = $this->getCodedKey($dataWeb['password']);
            unset($dataWeb['repassword']);
        }
        */
        // $msg = "¡Actualización exitosa!";
        // $this->dataModel->update( $id, $dataWeb );
        $dataWeb = $this->objEntity->fill($dataWeb);
        $this->dataModel->update( $dataWeb->id, $dataWeb );
        return redirect()->to(base_url()."/$this->module");
    }
    // $this->setCarrier($dataWeb, $id);
    // $this->editar($id);
    // $dataWeb->password   = '';
    // $dataWeb->repassword = '';
    $this->setCarrier($dataWeb);
    $this->editar($dataWeb->id);
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

  public function login()
  {
    echo view('login');
  }

  private function getSettingValue($keyName)
  {
    $ConfigModel = new ConfiguracionesModel();
    $data = $ConfigModel->select('valor')
                      ->where('nombre', $keyName)
                      ->first();
    $ConfigModel = Null;
    return $data['valor'];
  }

  private function getSettingOf($keyName = '')
  {
    $defaultPage = 'http://mamiyasedonde.com/';
    $keyName = trim($keyName);
    if ($keyName == '') return '';
    if ($keyName == 'tienda_pagweb') {
        $switch = $this->getSettingValue('tienda_vincularchk');
        if ($switch == 0 ) {
            return '';
            // return '#';
        } else {
            $result = $this->getSettingValue($keyName);
            if ($result == '') return $defaultPage;
            else return $result;
        }
    } else if ($keyName == 'tienda_siglas') {
        $result = $this->getSettingValue($keyName);
        if ($result == '') return 'POS - VS';
        return $result;
    }
  }

  public function loadSettings()
  {
    $dataSession = [
      'tabTitle'        => 'Top - SP',
      'brandName'       => $this->getSettingOf('tienda_siglas'),
      'webpage'         => $this->getSettingOf('tienda_pagweb'),
      'mainWebPg'       => 'http://mamiyasedonde.com/',
      'mainBrand'       => 'POS - VS',
      'tiendaLogo'      => $this->getSettingOf('tienda_logo'),
      'tiendaNombre'    => $this->getSettingOf('tienda_nombre'),
      'tiendaDireccion' => $this->getSettingOf('tienda_direccion'),
      'ticketLeyenda'   => $this->getSettingOf('ticket_leyenda'),
      // Agregar valores de configuración
    ];
    $session = session();
    $session->set($dataSession);
  }

  public function valida()
  {
    if ($this->getValidate( $this->request->getMethod()) ) {
        $usr = $_POST['usuario'];
        $pwd = $_POST['password'];
        $data = $this->dataModel
                     ->select('id, nombre, usuario, password, rol_id, caja_id')
                     ->where ('usuario', $usr)
                     ->first();
        if ($data) {
            if (password_verify( $pwd, $data['password'] )) {
                $dataSession = [
                  'usuario_id' => $data['id'],
                  'usuario'    => $data['usuario'],
                  'nombre'     => $data['nombre'],
                  'rol_id'     => $data['rol_id'],
                  'caja_id'    => $data['caja_id'],
                  
                ];
                $session = session();
                $session->set($dataSession);
                $this->loadSettings();  // Valores de configuración
                return redirect()->to(base_url().'/configurar');
            } else {
                $msg['error'] = '¡La contraseña no coincide!';
                echo view('login', $msg);
            }
        } else {
            $msg['error'] = '¡El usuario no existe!';
            echo view('login', $msg);
        }
    } else {
      $msg = ['validation' => $this->validator ];
      $msg['usuario']  = $_POST['usuario'];
      $msg['password'] = $_POST['password'];
      echo view('login', $msg);
    }
  }

  public function logout()
  {
    $session = session();
    $session->destroy(); 
    // session_destroy();  // php
    return redirect()->to(base_url());
  }

  private function passwordSettings($dataWeb = [])
  {
    $dataWeb['minLength'] = $this->minLength; // Hardcoded values
    $dataWeb['maxLength'] = $this->maxLength; // Hardcoded values
    return $dataWeb;
  }

  public function cambia_password()
  {
    $session = session();
    if ( count ($this->carrier) > 0 ) {
        //  $dataModel  = $this->carrier['datos'];
         $dataModel['nombre']  = $session->nombre;
         $dataModel['usuario'] = $session->usuario;
         $validation = $this->carrier['validation'];
     } else { # Primer intento
         $validation = null;
         $dataObject = $this->dataModel
                            ->select('id, nombre, usuario')
                            ->where('id', $session->usuario_id)
                            ->first();
         $dataModel  = $dataObject->toArray();
    }
    $this->loadAll = false;
    $dataWeb = $this->getDataSet(
      "$this->item - Cambiar contraseña",
      "$this->module",
      'guardar_password',
      'post',
      $validation,
      $dataModel,
    );
    $dataWeb = $this->passwordSettings($dataWeb);
    echo view('/includes/header');
    echo view("$this->module/pwdchange", $dataWeb);
    echo view('/includes/footer');
  }

  public function guardar_password()
  {
    $dataSet = $_POST;
    $session = session(); // Verificar si id ==
    if ($this->getValidate( $this->request->getMethod())) {
        /** Control de contraseñas seguras - Crear función
         *   > Insertar la llamada al algoritmo de control de contraseñas fuertes
         *   > Contener un mínimo de { n } caracteres
         *   > 
         // elseif ($password == $repassword ) {
         //   # encriptar $password y buscar que sea único en la tabla
         //   # Esto tiene que hacerse justo antes de guardar / insertar
         //   # y después de haber pasado la primera validación
         //   # siempre y cuando $password != ''
         // }
         // Validar que la contraseña sea diferente al usuario (May/Min)
         // Validar que la contraseña no esté dentro del nombre, ni del usuario
         // Un mínimo de 12 caracteres, sin espacios, ...
         // .Algún otro detalle para hacerla segura       
             // 642 - 483 = 159
         *   > 
         */
        // Agregar el update aquí
        // $dataWeb = $this->objEntity->fill($dataWeb);
        $dataSet['id'] = $session->usuario_id;
        // var_dump($dataSet);
        // $this->dataModel->update( $dataWeb->id, $dataWeb );
        $dataSet = $this->objEntity->fill($dataSet);
        $this->dataModel->update( $dataSet->id, $dataSet );
        $this->carrier['validation'] = "¡Cambio de contraseña exitoso!";
        // $this->cambia_password();
    } else 
        $this->setCarrier($dataSet, $session->usuario_id);
    $this->cambia_password();
  }

}