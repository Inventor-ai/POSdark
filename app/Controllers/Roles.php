<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\RolesModel;
use App\Models\PermisosModel;
use App\Models\RolesPermisosModel;

class Roles extends BaseController
{
  protected $item     = 'Rol';     // Examen
  protected $items    = 'es';      // Exámenes
  protected $enabled  = 'Disponibles';
  protected $disabled = 'Eliminados';
  protected $insert   = 'insertar';
  protected $update   = 'actualizar';
  protected $carrier  = [];
  protected $module;
  protected $dataModel;
  protected $permisosModel;
  protected $rolPermisosModel;

  public function __construct()
  {
    $search        = explode(',',"á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ");
    $replaceBy     = explode(',',"a,e,i,o,u,ni,A,E,I,O,U,NI");
    $this->items   = $this->item.$this->items; // Exámenes - No concatenate
    $this->module  = strtolower(str_replace($search, $replaceBy, $this->items));
    $this->dataModel = new RolesModel();
    $this->permisosModel = new PermisosModel();
    $this->rolPermisosModel = new RolesPermisosModel();
  }

  private function setDataSet()
  {
    $dataSet = [
      'nombre' => trim( $this->request->getPost('nombre') ),
      
    ];
    // Custom initialize section. Set default value by field
    if ($dataSet['nombre'] == '') $dataSet['nombre'] = '';    
    return $dataSet;
  }

  private function getValidate($method = "post")
  {
    $rules = [
      'nombre' => [
         'rules' => "required|is_unique[$this->module.nombre]",
         'errors' => [
            'required'  => "Debe proporcionarse el {field} del rol|{field}",
            'is_unique' => "¡Este $this->item ya existe y DEBE ser ÚNICO!|{field}"
         ]
      ]
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

  public function detalles($idRol, $rol)
  {
    // En el video mueve esto a otro controlador
    // $permiso = 'ProductosCatalogo';
    // $permiso = 'MenuProductos';
    // $acceso = $this->rolPermisosModel->verificaPermisos ($idRol, $permiso);
    // var_dump($acceso);
    // return;

    $filtro   = "nombre NOT LIKE 'X%'";
    $recursos = $this->permisosModel->where($filtro)->findAll();
    $permisos = $this->rolPermisosModel->select('permiso_id')
                     ->where('rol_id', $idRol)->findAll();
    $perfil = array();
    forEach($permisos as $permiso) $perfil[] = $permiso['permiso_id'];
    forEach ($recursos as $index => $recurso) {
      $recursos[$index]['checked'] = in_array($recurso['id'], array_values($perfil)) ? "checked" : "";
    }
    $data = [
      'idRol'    => $idRol,
      'recursos' => $recursos
    ];
    $dataWeb = $this->getDataSet( 
        "$this->item: $rol - Asignar permisos",
        "$this->module",
        "guardaPermisos",
        'post',
         null, // $validation,
        $data
    ); 
    echo view('/includes/header');
    echo view("$this->module/details", $dataWeb);
    echo view('/includes/footer');
  }

  public function guardaPermisos()
  {
    // var_dump($_POST);
    if ($this->request->getMethod() == 'post') {
        $rolId    = $this->request->getPost('rol_id');
        $permisos = $this->request->getPost('permisos');
        $this->rolPermisosModel->where('rol_id', $rolId)->delete();
        foreach( $permisos as $permiso) {
          // var_dump($permiso);
          $this->rolPermisosModel->save([
            'rol_id'     => $rolId,
            'permiso_id' => $permiso
          ]);
        }
    }
    return redirect()->to($this->module); // Own
    // return redirect()->to(base_url ($this->module)); // Analogy own version
    // return redirect()->to(base_url ("roles"));       // Video own analogy
    // return redirect()->to(base_url () . "roles" );   // Video
  }

}
