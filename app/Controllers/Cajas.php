<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\CajasModel;
use App\Models\CajasArqueoModel;
use App\Models\VentasModel;

class Cajas extends BaseController
{
  protected $item     = 'Caja';      // Examen
  protected $items    = 's';         // Exámenes
  protected $enabled  = 'Disponibles';
  protected $disabled = 'Eliminadas';
  protected $insert   = 'insertar';
  protected $update   = 'actualizar';
  protected $carrier  = [];
  protected $module;
  protected $dataModel;

  public function __construct()
  {
    $search          = explode(',',"á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ");
    $replaceBy       = explode(',',"a,e,i,o,u,ni,A,E,I,O,U,NI");
    $this->items     = $this->item.$this->items; // Exámenes - No concatenate
    $this->module    = strtolower(str_replace($search, $replaceBy, $this->items));
    $this->dataModel = new CajasModel();
  }

  private function setDataSet()
  {
    $dataSet = [
      'nombre' => trim( $this->request->getPost('nombre') ),
      'caja'   => trim( $this->request->getPost('caja') ),
      'folio'  => trim( $this->request->getPost('folio') ),
      
    ];
    // Custom initialize section. Set default value by field
    if ($dataSet['nombre'] == '') $dataSet['nombre'] = '';
    if ($dataSet['caja']   == '') $dataSet['caja']   = '';
    if ($dataSet['folio']  == '') $dataSet['folio']  = '';
    return $dataSet;
  }

  private function getValidate($method = "post")
  {
    $rules = [
      'nombre' => [
         'rules' => "required|is_unique[$this->module.nombre]",
         'errors' => [
            'required'  => "Debe proporcionarse el {field} de la caja|{field}",
            'is_unique' => "¡Esta $this->item ya existe y DEBE ser ÚNICA!|{field}"
         ]
      ],
      'caja' => [
         'rules' => "required|is_natural_no_zero",
         'errors' => [
            'required'  => "Debe proporcionarse el número de {field}|{field}",
            'is_natural_no_zero' => "El número de {field} DEBE ser entero y mayor a cero|{field}"
         ]
      ],
      'folio' => [
         'rules' => "required|is_natural_no_zero",
         'errors' => [
            'required'  => "Debe proporcionarse el número de {field}|{field}",
            'is_natural_no_zero' => "El número de {field} DEBE ser entero y mayor a cero|{field}"
         ]
      ],
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

  public function arqueo($idCaja)
  {
    $arqueoModel = new CajasArqueoModel();
    $arqueo = $arqueoModel->getDatos($idCaja);
    // echo "Arqueo de la caja $idCaja";
    /**/
    $activo = 1; // Eliminar variable y envío?
    $dataWeb   = [
      //  'title'   => "Cierres de caja",
       'title'   => "Apertura de caja $idCaja",
       'item'    => $this->item,
       'path'    => $this->module,
       'onOff'   => $activo,                                         // ??
       'switch'  => $activo == 0 ? $this->enabled : $this->disabled, // ??
       'close'   => 'Cerrar ',                            // ??
       'print'   => 'imprimir',                            // ??
       'data'    => $arqueo
    ];
    echo view('/includes/header');
    echo view("$this->module/arqueos", $dataWeb);
    echo view('/includes/footer');
  }

  public function nuevo_arqueo()
  {
    $session = session();
    $arqueoModel = new CajasArqueoModel();
    $existe = $arqueoModel->where([
                'caja_id' => $session->caja_id,
                "estatus" => 1
    ])->countAllResults();
    if ($existe > 0) {
        echo "¡La caja ya está abierta!";
        exit;
    }
    if ($this->request->getMethod() == 'post') {
        $fecha  = date('Y-m-d H:i:s');
        $arqueo = $arqueoModel->save([
            'caja_id'       => $session->caja_id,
            'usuario_id'    => $session->usuario_id,
            'monto_inicial' => $this->request->getPost('monto_inicial'),
            'fecha_inicio'  => $fecha,
        ]);
        return redirect()->to(base_url($this->module));
    } else {
        $caja    = $this->dataModel->where('id', $session->caja_id)->first();
        $dataWeb = $this->getDataSet(
           "Apertura de caja",
           $this->module,
           "nuevo_arqueo",
           "post",
           null,
           $caja
        );    
        echo view('/includes/header');
        echo view("$this->module/nuevo_arqueo", $dataWeb);
        echo view('/includes/footer');
    }
  }

  public function cerrar()
  {
    $session = session();
    $arqueoModel = new CajasArqueoModel();
    $ventasModel = new VentasModel();
    // $existe = $arqueoModel->where([
    //             'caja_id' => $session->caja_id,
    //             "estatus" => 1
    // ])->countAllResults();
    // if ($existe > 0) {
    //     echo "¡La caja ya está abierta!";
    //     exit;
    // }
    if ($this->request->getMethod() == 'post') {
        $fecha = date('Y-m-d H:i:s');
        // print_r ($ventasModel->conteoDelDia( date('Y-m-d')));
        // $ventasModel->conteoDelDia( date('Y-m-d') ), // null, 
        /*
        */
        $arqueo = $arqueoModel->update($this->request->getPost('arqueo_id'),
          [
            // 'caja_id'       => $session->caja_id,
            // 'usuario_id'    => $session->usuario_id,
            // 'monto_inicial' => $this->request->getPost('monto_inicial'),
            // 'fecha_inicio'  => $fecha,
            'fecha_final'   => $fecha,
            'monto_final'   => $this->request->getPost('monto_final'),
            // 'total_ventas'  => $this->request->getPost('total_ventas'),
            'total_ventas'  => $this->request->getPost('conteo_ventas'),
            'estatus'       => 0
        ]);

        return redirect()->to(base_url($this->module));
    } else {
        $monto  = $ventasModel->totalDelDia( date('Y-m-d'));
        $arqueo = $arqueoModel->where([
                    'caja_id' => $session->caja_id,
                    "estatus" => 1
        ])->First();
        $caja = $this->dataModel->where('id', $session->caja_id)->first();


        $conteo                = $ventasModel->conteoDelDia( date('Y-m-d'));
        $data                  = $monto; // 'totalVentas' // Calculado No se guarda aún
        $data['conteo']        = $conteo;
        $data['caja_id']       = $caja['caja'];
        $data['nombre']        = $caja['nombre'];
        $data['arqueo_id']     = $arqueo['id'];
        $data['monto_inicial'] = $arqueo['monto_inicial'];
        // $data['caja']   = $caja;
        // $data['arqueo'] = $arqueo;
        //     'arqueo' => $arqueo
        // $data = [
        //          'caja'   => $caja,
        //          'arqueo' => $arqueo,
        //          'monto'  => $monto
        // ];
        $dataWeb = $this->getDataSet(
           "Cierre de caja", // Ok
           $this->module,    // 
           "cerrar",   // 
           "post",           // 
           null,             // 
           $data             // ok
        );    
        echo view('/includes/header');
        echo view("$this->module/cerrar", $dataWeb);
        echo view('/includes/footer');
    }
  }

  public function imprimir()
  {
    echo "<h2>Controlador: Caja > imprimir</h2> <br>";
    echo "Generar el reporte de cierre de caja.<br>";
    echo "Posible contenido del reporte<br>";
    echo "<ol>";
    echo "<li>Encabezado: Título, fecha </li>";
    echo "<li>Cuerpo: Título, fecha </li>";
    echo "</ol>";
    echo "Mostrarlo en la vista para mosrtar imprirmir los reportes<br>";
  }

}
