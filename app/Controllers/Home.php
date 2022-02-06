<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // return view('tables');
        // $dataHead = [ 
        //    'tabTitle'  => 'Army 5tore - VS',
        //    'brandName' => 'POS - VS',
        // ];
        // $dataFoot = [
        //    'webSite'   => 'Virtual Army 5tore ' . date('Y')
        // ];
        echo view('includes/header');
        // echo view('includes/header', $dataHead);
        echo view('tables');
        // echo view('includes/content');
        // echo view('includes/footer', $dataFoot);
        echo view('includes/footer');
    }
}
