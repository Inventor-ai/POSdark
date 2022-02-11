<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ConfiguracionesModel;
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
  // protected $login    = false;
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
  }

  private function setDataSet()
  {
    // Ajustar las reglas según el aeereglo de datos
    $password   = trim( $_POST['password'] );
    $repassword = trim( $_POST['repassword'] );
    if ($_POST['id'] != '' && $password == '' && $repassword == '') {
       unset( $_POST['password'] );
       unset( $_POST['repassword'] );
    } 
    // elseif ($password == $repassword ) {
    //   # encriptar $password y buscar que sea único en la tabla
    //   # Esto tiene que hacerse justo antes de guardar / insertar
    //   # y después de haber pasado la primera validación
    //   # siempre y cuando $password != ''
    // }
    return $_POST;
  }

 /* nullify
  private function nullify($group = [], $overrule = [], $exception = 'noExceptions' )
  {
    if (count ($group) == 0 || count ($overrule) == 0) return $group;
    echo '<script>
      console.log("0 group: ", "|'. count ($group) .'|");
      console.log("0 overrule: ", "|'. count ($overrule) .'|");
      console.log("0 exception: ", "|'. $exception .'|");';
    echo "</script>";
    
    //  echo "
    //     // console.log(' disable: ');
    //     // console.log(". json_encode($disable) .");
    //     // console.log(' rules: ');
    //     // console.log(". json_encode($rules) .");
    // </script>";
    // echo '<script>
    //   console.log("exception 1: ", "|'. $exception .'|");';
    //  echo "
    //     console.log(' disable: ');
    //     console.log(". json_encode($disable) .");
    //     console.log(' rules: ');
    //     console.log(". json_encode($rules) .");
    // </script>";
    //     console.log("1 datarule: ", "|'. $dataRule[$dissmiss] .'|");
    
    $dataRule = $group;
    foreach ($overrule as $dissmiss) {
      echo '<script>
      console.log("1 dissmiss: ", "|'. $dissmiss .'|");
      console.log("1 post: ", "|'. $_POST[$dissmiss] .'|");
      console.log("1 data unset?: ", "|'. ($_POST[$dissmiss] === $exception ? 'eliminar': 'dejar') .'|");        
      console.log("1 post count: ", "|'. count ($_POST) .'|");
      console.log("1 rule unset?: ", "|'. ($dataRule[$dissmiss] === $exception ? 'eliminar': 'dejar') .'|");        
      console.log("1 rule count: ", "|'. count ($dataRule) .'|");
        ';
     echo "
        console.log(' _POST: ');
        console.log(". json_encode($_POST) .");
        console.log(' dataRule: ');
        console.log(". json_encode($dataRule) .");";
      echo "</script>";

      if (isset ($dataRule[$dissmiss]))
          if (
              // is_array($dataRule[$dissmiss]) ||
              $_POST[$dissmiss] == $exception)
              unset ($dataRule[$dissmiss]);
    }
    return $dataRule;  
  }
 */

  private function getValidate($method = "post")
  {
    $rules = [
      // Validar que la contraseña sea diferente al usuario (May/Min)
      // Validar que la contraseña no esté dentro del nombre, ni del usuario
      // Un mínimo de 12 caracteres, sin espacios, ...
      // .Algún otro detalle para hacerla segura
      'password' => [
         'rules' => "required",
        // Encriptar en el control antes de validar esta regla
        //  'rules' => "required|is_unique[$this->module.password]", 
         'errors' => [
            'required'  => "Teclear la contraseña|{field}",
            // 'is_unique' => "¡La contraseña DEBE ser ÚNICA y ya fue usada antes!|{field}"
         ]
      ],
      'repassword' => [
         'rules' => "required|matches[password]",
         'errors' => [
            'required' => "Teclear la confirmación de la contraseña|{field}",
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
                'rules'  => "required|is_unique[$this->module.nombre]",
                'errors' => [
                    'required'  => "Teclear el {field}|{field}",
                    'is_unique' => "¡Este {field} y ya existe! DEBE ser ÚNICO|{field}"
                ]
        ];
        $rules['usuario'] = [
                'rules'   => "required|is_unique[$this->module.usuario]",
                  //  'rules' => "required|email|is_unique[$this->module.usuario]",
                'errors'  => [
                    'required'  => "Teclear el {field}|{field}",
                    // 'email'     => "Proporcionar un email como {field}|{field}",
                    'is_unique' => "¡Este $this->item ya existe y DEBE ser ÚNICO!|{field}"
                ]
        ];
    } else {  // Editando
        $rules['nombre'] = [
            //  'rules' => "required|is_unique[$this->module.nombre]",
                'rules'  => "required",
                'errors' => [
                    'required'  => "Teclear el {field}|{field}",
                     // 'is_unique' => "¡Este {field} y ya existe! DEBE ser ÚNICO|{field}"
                ]
        ];
        $rules['usuario'] = [
                'rules'   => "required",
                  //  'rules' => "required|email",
                'errors' => [
                      'required'  => "Teclear el {field}|{field}",
                      // 'email'     => "Proporcionar un email como {field}|{field}",
                      // 'is_unique' => "¡Este $this->item ya existe y DEBE ser ÚNICO!|{field}"
                ]
        ];
    }    

    echo '<script>
    console.log("0 getValidate post count: ", "|'. count ($_POST) .'|");';
    echo "
      console.log('getValidate _POST: ');
      console.log(". json_encode($_POST) .");";
    echo "</script>";

    $ruleSet = [];
    foreach ($_POST as $include => $value) {
      if (isset($rules[$include])) {
          $ruleSet[$include] = $rules[$include];
      }
      // # code...
      // echo '<script>
      // console.log("1 getValidate key: ", "|'. $include .'|");';
      // echo "
      //   console.log('getValidate value: ');
      //   console.log('". $value ."');";
      // echo "</script>";
    }    
    $rules = $ruleSet;


    
/*
    foreach ($disable as $disabled) {
      # code...
    }
    $overrule = ['password', 'repassword']; // clear these rules
    protected $refuseOn
    $disallow = [], $exception = 'noExceptions')
            // unset ($rules['password']);
            // unset ($rules['repassword']);
    if ($this->action == $this->recEdit) {
        if ($_POST['password']   == '' && 
            $_POST['repassword'] == '') {
            unset ($rules['password']);
            unset ($rules['repassword']);
        }     
    }
    echo '<script>
     console.log("action: ", "'. $this->action .'");
     console.log("recEdit: ", "'. $this->recEdit .'");
     console.log("rules: ", "'. json_encode($rules) .'");
    </script>';

    private function nullify($group = [], $exclused = [], $exception = 'noExceptions' )

    
    $overrule = ['password', 'repassword']; // clear these rules
    $disallow = [], 
    protected $refuseOn
    , $disable = [], $exception = 'noExceptions')
    $this->getValidate($method = "post", $this->overrule, '');
*/
    echo '<script>';
     echo "
        console.log('20 rules: ');
        console.log(". json_encode($rules) .");
    </script>";

    // $rules = $this->nullify($rules, $disable, $exception);
    /*
    echo '<script>
      console.log("exception 1: ", "|'. $exception .'|");';
     echo "
        console.log(' disable: ');
        console.log(". json_encode($disable) .");
        console.log(' rules: ');
        console.log(". json_encode($rules) .");
    </script>";
    */

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
        //  $dataSet    = $this->setDataSet();
         $dataSet['id'] = '';
    }
    // $this->carrier = [];
    // $this->action = $this->recAdd;
    $dataWeb = $this->getDataSet( 
        // "$this->item - Agregando...", //"Agregar $this->item", //
        "$this->item - $this->recAdd", //"Agregar $this->item", //
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

  private function getCodedKey($passw = null)
  {
    if ($passw) 
        return password_hash($passw, PASSWORD_DEFAULT);
  }

  public function insertar()
  {
    $dataWeb = $this->setDataSet();
    if ($this->getValidate( $this->request->getMethod() )) {
        $dataWeb['password'] = $this->getCodedKey($dataWeb['password']);
        unset($dataWeb['repassword']);
        // $hash = password_hash($dataWeb['password'], PASSWORD_DEFAULT);
        // $dataWeb['password'] = $hash;
        // $msg = "Insercci´n";
        $this->dataModel->save($dataWeb); // ok
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
    // $this->action = $this->recEdit;
    $dataWeb = $this->getDataSet( 
        // "$this->item - Editando...", //"Editar $this->item", //
        "$this->item - $this->recEdit", //"Editar $this->item", //
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
 // if ($this->getValidate( $this->request->getMethod()) ) {
        if (isset($dataWeb['password']) ) {
            // $hash = password_hash($dataWeb['password'], PASSWORD_DEFAULT);
            // $dataWeb['password'] = $hash;
            $dataWeb['password'] = $this->getCodedKey($dataWeb['password']);
            unset($dataWeb['repassword']);
        }
        // $msg = "¡Actualización exitosa!";
        $this->dataModel->update( $id, $dataWeb );          // Ok
        return redirect()->to(base_url()."/$this->module"); // Ok
        // tmp - Ini
        // $this->setCarrier($dataWeb, $id);
        // $this->editar($id);
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

  // public function reingresar($id)
  // {
  //   $this->usuarios->update($id, ['activo' => 1]);
  //   return redirect()->to(base_url() . 'usuarios');
  // }

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
      'tabTitle'  => 'Top - SP',
      'brandName' => $this->getSettingOf('tienda_siglas'),
      'webpage'   => $this->getSettingOf('tienda_pagweb'),
      'mainWebPg' => 'http://mamiyasedonde.com/',
      'mainBrand' => 'POS - VS'
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
            // $result = password_verify( trim( $pwd ), $data['password'] ) ? "match" : "mismatch";
            // echo "Validating... $result <br>";
            if (password_verify( $pwd, $data['password'] )) {
                $dataSession = [
                  'id_usuario' => $data['id'],
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

  public function cambia_password()
  {
    // $dataSet['posted'] = $_POST;
    $validation = null;
    $dataSet    = null;
    $dataWeb = $this->getDataSet(
      "$this->item - Cambiar contraseña",
      "$this->module",
      'guarda_password',
      'post',
      $validation,
      $dataSet
    );
    // var_dump (dataSet);
    // return;
    echo view('/includes/header');
    echo view("$this->module/pwdchange", $dataWeb);
    echo view('/includes/footer');
  }

  public function guarda_password()
  {
    $dataSet['posted'] = $_POST;
    $validation = null;
    $dataSet    = null;
    $dataWeb = $this->getDataSet(
      "$this->item - Cambiar contraseña?",
      "$this->module",
      'guarda_password',
      'post',
      $validation,
      $dataSet
    );
    // var_dump (dataSet);
    // return;
    echo view('/includes/header');
    echo view("$this->module/pwdchange", $dataWeb);
    echo view('/includes/footer');
  }

}
