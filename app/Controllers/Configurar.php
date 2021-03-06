<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ConfiguracionesModel;

class Configurar extends BaseController
{
  protected $item      = 'Configuración'; 
  protected $items     = 'Configurar';
  // Use it to add automatic chk input support
  protected $chkFind   = "'%chk%'";  // Returns records with 'chk' at any position - Default
  // protected $chkFind   = "'%chk'";  // Returns records with 'chk' at end of string
  // protected $chkFind   = "'chk%'";  // Returns records with 'chk' at begining of string
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
    $switch      = false;
    $webPage     = '';
    $brandName   = '';
    $dataSession = [];
    $cfgSesion   = session();
    $dataModel   = $this->dataModel
                        ->findAll();
    foreach ($dataModel as $value) {
      $dataWeb[$value['nombre']] = $value['valor'];

      // if ($value['nombre'] == 'tienda_siglas') {
      //     $brandName = $value['valor'];
      //     // $dataSession['brandName'] = $value['valor'];
      // }
      // if ($value['nombre'] == 'tienda_pagweb') {
      //     $webPage = $value['valor'];
      //     // $dataSession['webpage'] = $v1alue['valor'];
      // }
      // if ($value['nombre'] == 'tienda_vincularchk')
      //     $switch = $value['valor'];

    }
    // if ($switch) {
    //    if ($webPage == '')
    //        $webPage = $cfgSesion->mainWebPg;
    // } else {
    //    $webPage = '';
    // }
    // if ($brandName == '') {
    //     $brandName = $cfgSesion->mainBrand;
    // }
    // $dataSession['brandName'] = $brandName;
    // $dataSession['webpage']   = $webPage;
    // $cfgSesion->set($dataSession);
    $settings = new Usuarios();
    $settings->loadSettings();
    unset($settings);

    echo view('/includes/header');
    echo view("$this->module/form", $dataWeb);
    echo view('/includes/footer');
  }

  public function revisar()
  {
    $settings = $_POST;
    $logoFKey = 'tienda_logo';
    $logoPath = 'images';
    $logoFile = 'logotipo';
    $imagen = $this->request->getFile($logoFKey);
    if ($imagen->getSize()) {
        // echo "con imagen <br>";
        $path = WRITEPATH . "../public/$logoPath/";
        $imagen->move($path, $logoFile, TRUE);
        $settings[ $logoFKey ] = "$logoPath/$logoFile";
    }
    $chkBoxs = $this->dataModel
                    ->where("nombre like $this->chkFind", null,  false)
                    ->findAll();
    foreach ($chkBoxs as $value) {
      $chks[$value['nombre']] = $value['valor'] . ' id: ('. $value['id'] .')';
      $this->dataModel->update( $value['id'], [ 'valor' => 0 ]);
    }
    
    // Get all the names of the controls and their values sent by the POST method
    foreach ($settings as $nombre => $valor) {
      $dataModel = $this->dataModel
                        ->select('id')
                        ->where('nombre', $nombre)
                        ->first();
      if (strpos($nombre, 'chk') && $valor === 'on') {
          $valor = 1; // set checked checkbox value to 1
      }
      // $valor => trim( $this->request->getPost('valor') ),
      // Validar
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
    return redirect()->to(base_url()."/$this->module"); // ok
    // $this->index();
  }

}
