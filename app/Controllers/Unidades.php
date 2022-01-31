<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\UnidadesModel;

class Unidades extends BaseController
{
   protected $unidades;

   public function __construct()
   {
     $this->unidades = new UnidadesModel();
   }
   
   public function index($activo = 1)
   {
     $unidades =  $this->unidades
                      ->where('activo', $activo)
                      ->findAll();
     $data = [
        'titulo' => 'Unidades',
        'datos'  => $unidades
     ];
     $dataHead = [ 
        'tabTitle'  => 'Army 5tore - VS',
        'brandName' => 'POS - VS',
     ];
     $dataFoot = [
        'webSite'   => 'Virtual Army 5tore ' . date('Y')
     ];
     echo view('/includes/header', $dataHead);
     echo view('unidades', $data);
     echo view('/includes/footer', $dataFoot);
    }
}