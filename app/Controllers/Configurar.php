<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ConfiguracionesModel;

class Configurar extends BaseController
{
  protected $item     = 'Configuración'; 
  protected $items    = 'Configurar';
  protected $module;
  protected $dataModel;

  public function __construct()
  {
    $search          = explode(',',"á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ");
    $replaceBy       = explode(',',"a,e,i,o,u,ni,A,E,I,O,U,NI");
    $this->module    = strtolower(str_replace($search, $replaceBy, $this->items));
    $this->dataModel = new ConfiguracionesModel();
  }

  private function getValidate($method = "post")
  {
    // $rules = [
    //    'nombre' => 'required'
    // ];
    $rules = [
      'nombre' => [
         'rules' => 'required|is_unique[configuraciones.nombre]',
         'errors' => [
            'required'  => "Debe proporcionarse el {field}|{field}",
            'is_unique' => "¡Esta $this->item ya existe y DEBE ser ÚNICA!"
         ]
      ]
    ];
    return ($this->request->getMethod() == $method &&
            $this->validate($rules) );
  }

  public function index()
  {
    $dataWeb   = [
       'title'      => "$this->items - Datos generales",
       'item'       =>  $this->item,
       'path'       =>  $this->module,
       'method'     => 'post',
       'action'     => 'revisar',
       'validation' =>  null,
    ];
    $dataModel = $this->dataModel
                      ->findAll();
    foreach ($dataModel as $value) {
      $dataWeb[$value['nombre']] = $value['valor'];
    }
    // var_dump($dataWeb);
    echo view('/includes/header');
    echo view("$this->module/form", $dataWeb);
    echo view('/includes/footer');
  }

  public function revisar()
  {
    foreach ($_POST as $nombre => $valor) {
      // echo "$nombre => $valor <br>";
      $dataModel = $this->dataModel
                        ->select('id')
                        ->where('nombre', $nombre)
                        ->first();
      $valor     = trim( $valor );
      // $valor => trim( $this->request->getPost('valor') ),
      // Validar
      // echo "dataModel: "; var_dump($dataModel);
      if ($dataModel) { # existe update
          $this->dataModel->update( $dataModel['id'], 
                                  ['valor' => $valor ]
          );
       } else {         # No existe create
          $this->dataModel->save([
                              'nombre' => $nombre,
                              'valor'  => $valor
          ]);
      }
    }
    return redirect()->to(base_url()."/$this->module");
  }

}
