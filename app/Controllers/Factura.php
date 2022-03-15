<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\VentasModel;
use App\Models\VentasDetalleModel;
use App\Models\UsersModel;
// use App\Models\ArticulosModel;
// use App\Models\CajasModel;

class Factura extends BaseController
{
  protected $item      = 'Factura';
  protected $items     = 's';
  protected $enabled   = 'Disponibles'; // Cambiar por???
  protected $disabled  = 'Eliminadas';
  protected $carrier   = [];
  protected $activo    = 1;
  protected $module;
  protected $search;
  protected $replaceBy;
  protected $dataModel;


  public function __construct()
  {
    $this->search    = explode(',',"á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ");
    $this->replaceBy = explode(',',"a,e,i,o,u,ni,A,E,I,O,U,NI");  
    $this->items     = $this->item.$this->items;
    $this->module    = strtolower($this->items);
    $this->dataModel = new VentasModel();
  }

  public function facturaV33data() // Estructura base demo
  {
    //Datos generales de factura
	  $datosFactura["version"] = "3.3";
	  $datosFactura["serie"] = "A";
	  $datosFactura["folio"] = "1";
	  $datosFactura["fecha"] = date('YmdHis');
	  $datosFactura["formaPago"] = "01";
	  $datosFactura["noCertificado"] = "20001000000300022762";
	  $datosFactura["subTotal"] = "1000.00";
	  $datosFactura["descuento"] = "0.00";
	  $datosFactura["moneda"] = "MXN";
	  $datosFactura["total"] = "1160.00";
	  $datosFactura["tipoDeComprobante"] = "I";
	  $datosFactura["metodoPago"] = "PUE";
	  $datosFactura["lugarExpedicion"] = "01000";
	
	  //Datos del emisor
	  $datosFactura['emisor']['rfc'] = 'TCM970625MB1';
	  $datosFactura['emisor']['nombre'] = 'Tienda CDP';
	  $datosFactura['emisor']['regimen'] = '601';
	
	  //Datos del receptor
	  $datosFactura['receptor']['rfc'] = 'XAXX010101000';
	  $datosFactura['receptor']['nombre'] = 'Publico en general';
	  $datosFactura['receptor']['usocfdi'] = 'P01';	
	
	  $datosFactura["conceptos"][] = array("clave" => "01010101", "sku" => "75654123", "descripcion" =>"Venta de productos", "cantidad" => "1", "claveUnidad" => "H87", "unidad" => "Pieza", "precio" => "1000.00", "importe" => "1000.00", "descuento" => "0.00", "iBase" => "1000.00", "iImpuesto" => "002", "iTipoFactor" => "Tasa", "iTasaOCuota" => "0.160000", "iImporte" => "160.00");
	
	  $datosFactura['traslados']['impuesto'] = "002";
	  $datosFactura['traslados']['tasa'] = "0.160000";
	  $datosFactura['traslados']['importe'] = "160.00";
    var_dump($datosFactura);
  }  

  public function facturaV33($data)
  {
    date_default_timezone_set('America/Mexico_City');
    $datosFactura = array();
	
    $dirCfdi = APPPATH . 'Libraries/cfdi_sat/cfdi/';
    $dir = APPPATH . 'Libraries/cfdi_sat/';
    
    $nombre = "A1";

  	//Datos generales de factura
    $datosFactura["version"]               = "3.3";
    // $datosFactura["serie"]                 = "A";
    $datosFactura["serie"]                 = $data["serie"];
    // $datosFactura["folio"]                 = "1";
    $datosFactura["folio"]                 = $data["folio"];
    $datosFactura["fecha"]                 = date('YmdHis');
    // $datosFactura["formaPago"] = "01";
    $datosFactura["formaPago"]             = $data['forma_pago'];
    $datosFactura["noCertificado"]         = $data['noCertificado'];
    // $datosFactura["subTotal"] = "1000.00";
    $datosFactura["subTotal"]              = $data['subTotal'];
    // $datosFactura["descuento"]             = "0.00";
    $datosFactura["descuento"]             = $data['descuento'];
    // $datosFactura["moneda"]                = "MXN";
    $datosFactura["moneda"]                = $data['moneda'];

    // $datosFactura["total"] = "1160.00";
    $datosFactura["total"]                 = $data['total'];
    $datosFactura["tipoDeComprobante"]     = "I";
    // $datosFactura["metodoPago"]            = "PUE";
    $datosFactura["metodoPago"]            = $data["metodoPago"];
    // $datosFactura["lugarExpedicion"]       = "01000";
    $datosFactura["lugarExpedicion"]       = $data["lugarExpedicion"];
    
    //Datos del emisor
    // $datosFactura['emisor']['rfc']         = 'TCM970625MB1';
    $datosFactura['emisor']['rfc']         = $data['emisor']['rfc'];
    // $datosFactura['emisor']['nombre']      = 'Tienda CDP';
    $datosFactura['emisor']['nombre']      = $data['emisor']['nombre'];
    // $datosFactura['emisor']['regimen']     = '601';
    $datosFactura['emisor']['regimen']     = $data['emisor']['regimen'];
        
    //Datos del receptor
    // $datosFactura['receptor']['rfc']       = 'XAXX010101000';
    $datosFactura['receptor']['rfc']       = $data['receptor']['rfc'];
    // $datosFactura['receptor']['nombre']    = 'Publico en general';
    $datosFactura['receptor']['nombre']    = $data['receptor']['nombre'];
    // $datosFactura['receptor']['usocfdi']   = 'P01';
    $datosFactura['receptor']['usocfdi']   = $data['receptor']['usocfdi'];
    
    // $datosFactura["conceptos"][]           = array(
    //               "clave"       => "01010101", 
    //               "sku"         => "75654123", 
    //               "descripcion" =>"Venta de productos", 
    //               "cantidad"    => "1", 
    //               "claveUnidad" => "H87", 
    //               "unidad"      => "Pieza", 
    //               "precio"      => "1000.00", 
    //               "importe"     => "1000.00", 
    //               "descuento"   => "0.00", 
    //               "iBase"       => "1000.00", 
    //               "iImpuesto"   => "002", 
    //               "iTipoFactor" => "Tasa", 
    //               "iTasaOCuota" => "0.160000", 
    //               "iImporte"    => "160.00");

    $datosFactura["conceptos"][] = $data['receptor'];
    
    // $datosFactura['traslados']['impuesto'] = "002";
    // $datosFactura['traslados']['tasa']     = "0.160000";
    // $datosFactura['traslados']['importe']  = "160.00";

    $datosFactura['traslados'][] = $data['traslados'];
    var_dump($datosFactura);
    return;
    
    $xml = new \GeneraXML();
    $xmlBase = $xml->satxmlsv33($datosFactura, '', $dir, '');	
    
    $timbra = new \Pac();
    $cfdi = $timbra->enviar("UsuarioPruebasWS","b9ec2afa3361a59af4b4d102d3f704eabdf097d4","TCM970625MB1", $xmlBase);
    
    if($xml)
    {
      file_put_contents($dirCfdi.$nombre.'.xml', base64_decode($cfdi->xml));
      // unlink($dirXML.$nombre'.xml');  // Del repositorio - 2022-03-13
      unlink($dir.'/tmp/'.$nombre.'.xml');
    }

  }

  public function facturar($idVenta)
  {

    // $data['emisor']['rfc']     = utf8_decode (Usuarios::getSettingValue('tienda_rfc'));
    // $data['emisor']['nombre']  = utf8_decode (Usuarios::getSettingValue('tienda_nombre'));
    // $data['emisor']['regimen'] = '601';

    $emisor['rfc']     = Usuarios::getSettingValue('tienda_rfc');
    $emisor['nombre']  = Usuarios::getSettingValue('tienda_nombre');
    $emisor['regimen'] = '601';

    // $datosFactura['receptor']['rfc']       = 'XAXX010101000';
    // $datosFactura['receptor']['nombre']    = 'Publico en general';
    // $datosFactura['receptor']['usocfdi']   = 'P01';

    // $signo       = "$ ";
    $datosventa   = $this->dataModel->where('id', $venta_id)->first();
    // $detalleModel = new VentasDetalleModel();
    // $detalleVenta = $detalleModel->articulos($venta_id);
    // $userModel    = new UsersModel();
    // $dataUser     = $userModel->usuario( $datosventa['usuario_id'] );
    // $session      = session();

    // Deberían provenir de los datos del cliente registrado en la venta
    // $datosventa['cliente_id'] para consultar datos del cliente (Receptor)
    $clienteNombre           = 'Publico en general'; // hardcode para demo
    $receptor['rfc']         = 'XAXX010101000';      // hardcode para demo
    $receptor['nombre']      = str_replace($this->search, $this->replaceBy, $clienteNombre);
    $receptor['usocfdi']     = '601';  // $datosventa <= Seleccionado y registrado durante venta

    

    $conceptos = array(
           "clave"       => "01010101", 
           "sku"         => "75654123", 
           "descripcion" =>"Venta de productos", 
           "cantidad"    => "1", 
           "claveUnidad" => "H87", 
           "unidad"      => "Pieza", 
           "precio"      => "1000.00", 
           "importe"     => "1000.00", 
           "descuento"   => "0.00", 
           "iBase"       => "1000.00", 
           "iImpuesto"   => "002", 
           "iTipoFactor" => "Tasa", 
           "iTasaOCuota" => "0.160000", 
           "iImporte"    => "160.00"
    );


    // Actualmente no existe. Agregar
    $data["serie"]           = "A"; // get from config: Serie facturas (X RFC ó X sucursal?)
    $data["folio"]           = "1"; // get from config: Folio factura 
    $data['noCertificado']   = "20001000000300022762"; // get from config: filenames .pem

    $data['descuento']       = "0.00";     // $datosventa - No existe. Agregar
    $data['moneda']          = "MXN";      // $datosventa - No existe. Agregar
    $data["metodoPago"]      = "PUE";      // El registrado en la venta (Incorporar)

    $data["lugarExpedicion"] = "01000";  // CodPos fiscal o de la sucursal
    $data['forma_pago']      = $datosventa['forma_pago'];

    $data['subTotal']        = $datosventa['total'] / (1 + $tasa); // Demo test only

    // $IVA                     = .16;  // TO DO: get from config?
    $tasa                    = "0.160000"; // TO DO: get from config?
    $traslados['impuesto']   = "002";       
    $traslados['tasa']       = $tasa;      // TO DO: get from config?
    $traslados['importe']    = $data['subTotal'] * $tasa;

    $data['total']           = $datosventa['total'];
    $data['emisor']          = $emisor;
    $data['receptor']        = $receptor;
    $data['conceptos']       = $conceptos;
    $data['traslados']       = $traslados;
    // $data['traslados']['impuesto'] = "002";
    // $data['traslados']['tasa']     = "0.160000";
    // $data['traslados']['importe']  = "160.00";
    var_dump ($data);
    // $pdf = new \FPDF('P', 'mm', array(80, 200));
    $this->facturaV33($data);
    // $this->facturaV33($data);

  }



  public function xxxgeneraTicket($venta_id)
  {
    // ob_start();  //  
    // $pdf->AddPage();
    // $pdf->setMargins(5, 5, 1);
    // $pdf->setTitle('Ticket');
    // $pdf->SetFont('Arial','B', 9);
    $tiendaNombre = utf8_decode (Usuarios::getSettingValue('tienda_nombre'));
    // $pdf->Cell(70, 4, $tiendaNombre, 0, 1, 'C');

    // $pdf->SetFont('Arial','', 7);
    $img = Usuarios::getSettingOf('tienda_logo');
    // $pdf->image( $img , 6, 6, 12, 12, 'PNG');

    // $pdf->Cell(80, 4, utf8_decode ("Venta por: $dataUser->usuario / $dataUser->nombre"), 0, 1, 'C');
    $domicilio = utf8_decode ("Dirección: ". Usuarios::getSettingValue('tienda_direccion'));
    // $pdf->Cell(73, 3, "$domicilio", 0, 1, 'C');

    $pdf->Cell(72, 3, "Fecha y hora: ". $datosventa['fecha_alta'], 0, 1, 'C');

    $pdf->Cell(70, 3, "Ticket: ". $datosventa['folio'], 0, 0, 'C');

    // $pdf->Ln(3);
    // $pdf->SetFont('Arial','B', 7);
    // $pdf->Cell(9, 5, "Cant.", 0, 0, 'L');
    // $pdf->Cell(33, 5, "Nombre", 0, 0, 'L');
    // $pdf->Cell(15, 5, "Precio", 0, 0, 'L');
    // $pdf->Cell(15, 5, "Importe", 0, 1, 'L');
    // $pdf->SetFont('Arial','', 7);
    $num    = 0;
    $piezas = 0;
    foreach ($detalleVenta as $row) {
      $num++;
      $precio  = number_format($row['precio'], 2, '.', ',');
      $importe = number_format($row['precio'] * $row['cantidad'], 2, '.', ',');
      $piezas += $row['cantidad'];

      $pdf->Cell(9, 3,  $row['cantidad'] , 0, 0, 'C');
      $pdf->Cell(33, 3, utf8_decode ($row['nombre']), 0, 0, 'L');
      $pdf->Cell(15, 3, "$signo$precio" , 0, 0, 'R');
      $pdf->Cell(15, 3, "$signo$importe", 0, 1, 'R');  
    }
    // $pdf->Cell( 9, 3, number_format($piezas, 0, '.', ','), 0, 0, 'C');
    // $pdf->Cell( 21, 3, 'Totales:', 0, 0, 'C');
    $pdf->Cell( 42, 3, $signo . number_format($datosventa['total'], 2, '.', ','), 0, 1, 'R');
    // $pdf->Ln(3);
    // $ticketLeyenda = utf8_decode(Usuarios::getSettingValue('ticket_leyenda'));
    // $pdf->Multicell( 72, 3, $ticketLeyenda, 0, 'C', 0);
    // $this->response->setHeader('Content-Type', 'application/pdf');
    // $pdf->Output('ticket.pdf', "I");
    // ob_end_flush();    //
  }

  public function xxx()
  {
      $dataModel = $this->dataModel;

      $dataWeb   = [
        // 'title'   => "$this->items ".strtolower($this->activo == 1 ? $this->enabled : $this->disabled),
        'title'   => "$this->items ",
       //  'title'   => "$this->items ",
        'item'    => $this->item,
        'path'    => $this->module,
        // 'onOff'   => $this->activo,
        // 'switch'  => $this->activo == 0 ? $this->enabled : $this->disabled,
        'delete'  => 'eliminar',
       //  'recover' => 'recuperar',
        'data'    => $dataModel
     ];
    //  $vista = $this->activo == 1 ? 'list' : 'eliminados';
     echo view('/includes/header');
     echo "Factura -> facturar()";
    //  echo view("$this->module/$vista", $dataWeb);
     echo view('/includes/footer');
  }
  
}