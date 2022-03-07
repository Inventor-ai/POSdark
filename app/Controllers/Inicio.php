<?php

namespace App\Controllers;
use App\Models\ArticulosModel;
use App\Models\VentasModel;

class Inicio extends BaseController
{
  protected $dataModel;

  public function __construct()
  {
    //   $this->dataModel = new ArticulosModel();
  }

  public function index()
  {
    // return view('tables');
    // $dataHead = [ 
    //    'tabTitle'  => 'Army 5tore - VS',
    //    'brandName' => 'POS - VS',
    // ];
    // $dataFoot = [
    //    'webSite'   => 'Virtual Army 5tore ' . date('Y')

    $this->dataModel = new VentasModel();
    // $data['ventas'] = $this->dataModel->conteoDelDia( '2022-02-21' ); // 2022-02-21
    // $data['ventas'] = $this->dataModel->conteoDelDia( '2022-02-22' ); // 2022-02-22
    $hoy = '2022-02-21';
    // $hoy = '2022-02-22';
    // $hoy = date('Y-m-d');
    $data = $this->dataModel->totalDelDia( $hoy );
    $data['ventas'] = $this->dataModel->conteoDelDia( $hoy );

    $this->dataModel = new ArticulosModel();
    $data['articulos'] = $this->dataModel->total();
    $data['minimos'] = $this->dataModel->minimos();
    // // $this->dataModel = new ArticulosModel();
    // // $data = [ 'total'] = $this->dataModel->total();
    // var_dump($data);
    // return;
    echo view('includes/header');
    // echo view('includes/header', $dataHead);
    // echo view('tables');
    echo view('inicio', $data);
    // echo view('includes/footer', $dataFoot);
    echo view('includes/footer');
  }
}
