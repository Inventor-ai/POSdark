<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ConfiguracionesModel;

class Configurar extends BaseController
{
  protected $item     = 'Configuración'; 
  protected $items    = 'Configurar';
  // Use it to add automatic chk input support
  protected $chkFind  = "'%chk%'";  // Returns records with 'chk' at any position - Default
  // protected $chkFind  = "'%chk'";  // Returns records with 'chk' at end of string
  // protected $chkFind  = "'chk%'";  // Returns records with 'chk' at begining of string
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
      'tienda_siglas' => [
              'rules' => 'max_length[12]',
              'errors' => [
                'max_length[12]' => 'Excede los 12 caracteres permitidos.|{field}'
              ],
      ],
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
       'item'       => $this->item,
       'path'       => $this->module,
       'method'     => 'post',
       'action'     => 'revisar',
       'validation' => null,
    ];
    $dataModel = $this->dataModel
                      ->findAll();
    foreach ($dataModel as $value)
      $dataWeb[$value['nombre']] = $value['valor'];

    echo view('/includes/header');
    echo view("$this->module/form", $dataWeb);
    echo view('/includes/footer');
  }

  public function revisar()
  { // Reset all checkboxes values to 0
    $chkBoxs = $this->dataModel
                    ->where("nombre like $this->chkFind", null,  false)
                    ->findAll();
    foreach ($chkBoxs as $value) {
      $chks[$value['nombre']] = $value['valor'] . ' id: ('. $value['id'] .')';
      $this->dataModel->update( $value['id'], [ 'valor' => 0 ]);
    }
    
    // Get all control names and it's values sent by POST method
    foreach ($_POST as $nombre => $valor) {
      // echo "$nombre => $valor <br>";
      $dataModel = $this->dataModel
                        ->select('id')
                        ->where('nombre', $nombre)
                        ->first();
      $valor     = trim( $valor );

      if (strpos($nombre, 'chk') && $valor === 'on') {
          $valor = 1; // set checked checkbox value to 1
      }
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
    // $this->index();
  }

}
