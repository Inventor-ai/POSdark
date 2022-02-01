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
     $unidades = $this->unidades
                      ->where('activo', $activo)
                      ->findAll();
     $data = [
        'titulo' => 'Unidades',
        'datos'  => $unidades
     ];
     echo view('/includes/header');
     echo view('unidades/unidades', $data);
     echo view('/includes/footer');
    }

    public function agregar()
    {
    //   echo "Editando id: $id";
      $data = [
        'titulo' => 'Agregar unidad',
        // 'datos'  => $unidades
      ];
      echo view('/includes/header');
      echo view('unidades/nuevo', $data);
      echo view('/includes/footer');        
    }

    public function insertar()
    {
      $datos = [
        'nombre'       => $this->request->getPost('nombre'),
        'nombre_corto' => $this->request->getPost('nombre_corto')
      ];
      $msg = "Insercci´n";
      $this->unidades->save($datos);
      return redirect()->to(base_url().'/index.php'.'/unidades');
    }

    public function editar($id)
    {
    //   echo "Editando id: $id";
      $data = [];
      echo view('/includes/header');
    //   echo view('unidades/nuevo', $data);
      echo view('/includes/footer');        
    }

    public function eliminar($id)
    {
      echo "Eliminando id: $id";
    //   echo view('/includes/header');
    //   echo view('unidades/eliminar', $data);
    //   echo view('/includes/footer');        
    }
}