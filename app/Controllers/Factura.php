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

  public function facturaV33($data) // Own
  {
    date_default_timezone_set('America/Mexico_City');
    $dirCfdi = APPPATH . 'Libraries/cfdi_sat/cfdi/';
    $dir     = APPPATH . 'Libraries/cfdi_sat/';
    // $nombre  = "A1";

    $nombre                    = $data["serie"].$data["folio"];
    $data["version"]           = "3.3";
    $data["fecha"]             = date('YmdHis');
    $data["tipoDeComprobante"] = "I";

    // get SAT config data
    $data['noCertificado']   = "20001000000300022762"; // get from config: filenames .pem


    $usuario  = "UsuarioPruebasWS";  // Usuario
    $password = "b9ec2afa3361a59af4b4d102d3f704eabdf097d4";
    
    echo "data 33<br>";
    var_dump($data);
    // phpinfo(INFO_ALL);
    // return;
    
    $xml = new \GeneraXML();
    $xmlBase = $xml->satxmlsv33($data, '', $dir, '');	
    
    $timbra = new \Pac();
    // $cfdi = $timbra->enviar("UsuarioPruebasWS","b9ec2afa3361a59af4b4d102d3f704eabdf097d4","TCM970625MB1", $xmlBase);

    $cfdi = $timbra->enviar($usuario, 
                            $password, // Contraseña
                            $data['emisor']['rfc'], // "TCM970625MB1",  // <> RFC - SOAPFault
                            // "TCM970625MB1",  // RFC para hacer las pruebas.
                            $xmlBase);
    // $cfdi = $timbra->enviar("UsuarioPruebasWS",                         // Usuario
    //                         "b9ec2afa3361a59af4b4d102d3f704eabdf097d4", // Contraseña
    //                         $data['emisor']['rfc'], // "TCM970625MB1",  // <> RFC - SOAPFault
    //                         // "TCM970625MB1",  // RFC para hacer las pruebas.
    //                         $xmlBase);

    if($xml)
    {
      file_put_contents($dirCfdi.$nombre.'.xml', base64_decode($cfdi->xml));
      // unlink($dirXML.$nombre'.xml');  // Del repositorio - 2022-03-13
      // unlink($dir.'/tmp/'.$nombre.'.xml'); // 2 preserve file
    }

  }

  public function facturar($venta_id)
  {
    $timbrado = $this->dataModel->select('timbrado')-where('id', $venta_id)-first();
    if ($timbrado == 1) {
       echo "La venta ya ha sido facturada";
       exit;
       // Cambiar esto por una vista o implementar el modal.
       // Sería más intersante disparar el modal desde php
    }
    // get from config: Folio factura
    $folio = "6"; // Cambiar manualmente para pruebas.
    // get from config: Serie facturas (X RFC ó X sucursal?)
    $serie = "A"; // Cambiar manualmente para pruebas.
    $datosventa   = $this->dataModel->where('id', $venta_id)->first();
    // Cambiar las siguientes dos líneas por función estática (crearla), 
    // o bien, crear en el modelo de ventas una función con join completo
    $detalleModel = new VentasDetalleModel();
    $detalleVenta = $detalleModel->conceptos($venta_id);

    // Actualmente no existe. Agregar
    $data["serie"]   = $serie; // get from config: Serie facturas (X RFC ó X sucursal?)

    $data["folio"]           = $folio; // get from config: Folio factura 
    $data['formaPago']       = $datosventa['forma_pago'];
    // $data['noCertificado']   = "20001000000300022762"; // get from config: filenames .pem
    $data['subTotal']        = $datosventa['total'];

    $data['descuento']       = "0.00";     // $datosventa - No existe. Agregar
    $data['moneda']          = "MXN";      // $datosventa - No existe. Agregar

    $data['total']           = $datosventa['total'];

    // $data["tipoDeComprobante"] = "I";
    $data["metodoPago"]      = "PUE";      // El registrado en la venta (Incorporar)
    $data["lugarExpedicion"] = "01000";  // CodPos fiscal o de la sucursal

    // $emisor['rfc']     = Usuarios::getSettingValue('tienda_rfc');
    // $emisor['nombre']  = Usuarios::getSettingValue('tienda_nombre');
    // $emisor['regimen'] = '601';

    // Datos originales
    $emisor['rfc']     = 'TCM970625MB1';
    $emisor['nombre']  = 'Tienda CDP';
    $emisor['regimen'] = '601';
    // $datosFactura['emisor']['rfc']         = 'TCM970625MB1';
    // $datosFactura['emisor']['nombre']      = 'Tienda CDP';
    // $datosFactura['emisor']['regimen']     = '601';

    // Deberían provenir de los datos del cliente registrado en la venta
    // $datosventa['cliente_id'] para consultar datos del cliente (Receptor)
    $clienteNombre           = 'Publico en general'; // hardcode para demo
    $receptor['rfc']         = 'XAXX010101000';      // hardcode para demo
    $receptor['nombre']      = str_replace($this->search, $this->replaceBy, $clienteNombre);
    $receptor['usocfdi']     = 'P01';  // $datosventa <= Seleccionado y registrado durante venta

    // $conceptos[] = array(
    //        "clave"       => "01010101", 
    //        "sku"         => "75654123", 
    //        "descripcion" =>"Venta de productos", 
    //        "cantidad"    => "1", 
    //        "claveUnidad" => "H87", 
    //        "unidad"      => "Pieza", 
    //        "precio"      => "1000.00", 
    //        "importe"     => "1000.00", 
    //        "descuento"   => "0.00", 
    //        "iBase"       => "1000.00", 
    //        "iImpuesto"   => "002", 
    //        "iTipoFactor" => "Tasa", 
    //        "iTasaOCuota" => "0.160000", 
    //        "iImporte"    => "160.00"
    // );
    
    //  var_dump ($descripcion);
    //  var_dump ($detalleVenta);
    //  return;
    $trasImporte = 0;
    forEach ($detalleVenta as $concepto) {
       // config decimales o convertir a enteros al hacer el registro?
      // $sku = Articulos::getValueOf('codigo', $concepto['articulo_id']);
      // $sku = "75654123";

      // $descripcion = Articulos::getValueOf('nombre', 1);
      // $descripcion = $concepto['nombre'];

      // $unidad      = Unidades::getValueOf('nombre', $concepto['articulo_id']); // After SAT sync
      // $unidad      = "Pieza";

      // $cantidad    = number_format($concepto['cantidad'], 2, ".", "");
      // $cantidad    = number_format($concepto['cantidad'], 0, "", "");
      // $cantidad    = $concepto['cantidad'];
      // $importe     = $precio * $cantidad;
      $precio  = $concepto['precio'];
      $importe = $concepto['precio'] * $concepto['cantidad'];
      $iBase   = $importe;

      // Funciona bien y devuelve la clave. Asignarla en la clave del concepto, no
      // Se produce: Fatal error: Maximum execution time of 120 seconds exceeded...
      // $clave   = Articulos::getValueOf('codigo', $concepto['articulo_id']);
      // var_dump($clave);
      
      $unidad  = Unidades::getValueOf('nombre', $concepto['articulo_id']); // After SAT sync

      // Parche temporal en esta aplicación
      // $tasa        = "0.160000"; // TO DO: get from config / detalleventa ?
      $tasa        = "0.000000"; // TO DO: get from config / detalleventa ?
      /*
      $iTasaCuota  = $tasa; // Agregar a cada registro detalleVenta según config x Articulo
      // Parche calculando precio sin IVA para demo 
      // $precio      = $concepto['precio']; // Video/Sistema actual - Corregir en módulo
      // $precio      = number_format($concepto['precio'] / ( 1 + $iTasaCuota), 2, ".", "");
      // $precio      = $iBase; 
      // $iBase       = 0; // fail
      // $descuento   = ;
      $iImporte    = $iBase * $iTasaCuota;
      $iBase       = number_format($iBase, 2, ".", "");
      $iImporte    = number_format($iImporte, 2, ".", "");
      $iTasaCuota  = number_format($iTasaCuota, 6, ".", "");
      $trasImporte+= $iImporte;
      */
      
      // $precio      = number_format($precio, 2, ".", "");
      $importe     = number_format($importe, 2, ".", "");
      $iBase       = number_format($iBase, 2, ".", "");

      $conceptos[] = array(
             "clave"       => "01010101", // articulo['codigo'] ó del catálogo del SAT?

            // articulo['codigo'] No funciona. Tarda mucho y responde con error:
            // Fatal error: Maximum execution time of 120 seconds exceeded in 
            //  "clave"       => $clave,

             "sku"         => "75654123", // 
            //  "sku"         => $sku,           // articulo['codigo']

            //  "descripcion" =>"Venta de productos",  // articulo['nombre']
            //  "descripcion" => $descripcion,  // articulo['nombre']
             "descripcion" => $concepto['nombre'],  // articulo['nombre']

            //  "cantidad"    => "1",
            //  "cantidad"    => $cantidad,
             "cantidad"    => $concepto['cantidad'],

             "claveUnidad" => "H87",       // SAT catálogo

            //  "unidad"      => "Pieza",     // SAT catálogo? articulo['id_unidad'] -> unidades['nombre']
            "unidad"      => $unidad,     // SAT catálogo? articulo['id_unidad'] -> unidades['nombre']

            //  "precio"     => "1000.00",
            "precio"      => $precio,

            // "importe"     => "1000.00",
            "importe"     => $importe,
            
            "descuento"   => "0.00", 
            //  "descuento"   => "0.00", 
            
            //  "iBase"       => "1000.00", 
            "iBase"       => $iBase, 
            
            "iImpuesto"   => "002",       // Catálogo del SAT?
            //  "iImpuesto"   => "002",       // Catálogo del SAT?
            
            "iTipoFactor" => "Tasa",      // ??
            //  "iTipoFactor" => "Tasa",      // ??
            
            //  "iTasaOCuota" => "0.160000",  // From config SAT?
            "iTasaOCuota" => "0.000000",  // From config SAT?
            //  "iTasaOCuota" => $iTasaCuota,  // From config SAT?
            
            //  "iImporte"    => "160.00"
             "iImporte"    => "0.00"
      );
    }

    // $subtotal = round($datosventa['total'] / (1 + $tasa), 2);  // Demo test only
    // $data['subTotal']        = (string) $subtotal;

    // $subtotal = number_format($datosventa['total'] / (1 + $tasa), 2, ".", ""); // Demo test only
    // $data['subTotal']        = $subtotal;

    $traslados['impuesto']   = "002";       
    $traslados['tasa']       = $tasa;      // TO DO: get from config?
    // $traslados['importe']    = $data['subTotal'] * $tasa;
    // $importe = number_format($datosventa['total'] - $subtotal, 2, ".", ""); // Demo test only
    // $traslados['importe']    = $importe;
    // $traslados['importe']    = number_format($trasImporte, 2, ".", "");
    $traslados['importe']    = "0.00";

    // $data['traslados']['impuesto'] = "002";
    // $data['traslados']['tasa']     = "0.160000";
    // $data['traslados']['importe']  = "160.00";

    $data['emisor']          = $emisor;
    $data['receptor']        = $receptor;
    $data['conceptos']       = $conceptos;
    $data['traslados']       = $traslados;

    // echo "facturar ($venta_id) <br>";
    // var_dump ($data);
    // echo "facturaV33data <br>";
    // $this->facturaV33data();
    // echo "facturaV33 <br>";
    $this->facturaV33($data);

    // // $this->generaPdf("$serie$folio");
    // $this->generaPdf($venta_id);
    $this->generaPdf("$serie$folio", $venta_id);
  }

  public function facturarFailed($venta_id)
  {
    // get from config: Folio factura
    $folio = "2"; // Cambiar manualmente para pruebas.
    // get from config: Serie facturas (X RFC ó X sucursal?)
    $serie = "A"; // Cambiar manualmente para pruebas.

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

    // Cambiar las siguientes dos líneas por función estática (crearla), 
    // o bien, crear en el modelo de ventas una función con join completo
    $detalleModel = new VentasDetalleModel();
    $detalleVenta = $detalleModel->conceptos($venta_id);

    // $userModel    = new UsersModel();
    // $dataUser     = $userModel->usuario( $datosventa['usuario_id'] );
    // $session      = session();

    // Deberían provenir de los datos del cliente registrado en la venta
    // $datosventa['cliente_id'] para consultar datos del cliente (Receptor)
    $clienteNombre           = 'Publico en general'; // hardcode para demo
    $receptor['rfc']         = 'XAXX010101000';      // hardcode para demo
    $receptor['nombre']      = str_replace($this->search, $this->replaceBy, $clienteNombre);
    $receptor['usocfdi']     = 'P01';  // $datosventa <= Seleccionado y registrado durante venta

    // $conceptos[] = array(
    //        "clave"       => "01010101", 
    //        "sku"         => "75654123", 
    //        "descripcion" =>"Venta de productos", 
    //        "cantidad"    => "1", 
    //        "claveUnidad" => "H87", 
    //        "unidad"      => "Pieza", 
    //        "precio"      => "1000.00", 
    //        "importe"     => "1000.00", 
    //        "descuento"   => "0.00", 
    //        "iBase"       => "1000.00", 
    //        "iImpuesto"   => "002", 
    //        "iTipoFactor" => "Tasa", 
    //        "iTasaOCuota" => "0.160000", 
    //        "iImporte"    => "160.00"
    // );
    
    //  var_dump ($descripcion);
    //  var_dump ($detalleVenta);
    //  return;
    $trasImporte = 0;
    forEach ($detalleVenta as $concepto) {
       // config decimales o convertir a enteros al hacer el registro?
      $sku         = Articulos::getValueOf('codigo', $concepto['articulo_id']);
      // $descripcion = Articulos::getValueOf('nombre', 1);
      $descripcion = $concepto['nombre'];
      // $cantidad    = number_format($concepto['cantidad'], 2, ".", "");
      $cantidad    = $concepto['cantidad'];
      // $unidad      = Unidades::getValueOf('nombre', $concepto['articulo_id']); // After SAT sync
      $unidad      = "Pieza";
      // Parche temporal en esta aplicación
      $tasa        = "0.160000"; // TO DO: get from config / detalleventa ?
      $iTasaCuota  = $tasa; // Agregar a cada registro detalleVenta según config x Articulo
      // Parche calculando precio sin IVA para demo 
      // $precio      = $concepto['precio']; // Video/Sistema actual - Corregir en módulo
      $precio      = number_format($concepto['precio'] / ( 1 + $iTasaCuota), 2, ".", "");
      // $precio      = $iBase; 
      $importe     = $precio * $cantidad;
      $iBase       = $importe;
      // $iBase       = 0; // fail
      // $descuento   = ;
      $iImporte    = $iBase * $iTasaCuota;
      $iBase       = number_format($iBase, 2, ".", "");
      $precio      = number_format($precio, 2, ".", "");
      $importe     = number_format($importe, 2, ".", "");
      $iImporte    = number_format($iImporte, 2, ".", "");
      $iTasaCuota  = number_format($iTasaCuota, 6, ".", "");
      $trasImporte+= $iImporte;
      $conceptos[] = array(
             "clave"       => "01010101",           // Del catálogo del SAT?
            //  "clave"       => $clave,           
            //  "sku"         => "75654123",           // articulo['codigo']
             "sku"         => $sku,           // articulo['codigo']
            //  "descripcion" =>"Venta de productos",  // articulo['nombre']
             "descripcion" => $descripcion,  // articulo['nombre']
            //  "cantidad"    => "1",
             "cantidad"    => $cantidad,
             "claveUnidad" => "H87",       // SAT catálogo
            //  "unidad"      => "Pieza",     // SAT catálogo? articulo['id_unidad'] -> unidades['nombre']
             "unidad"      => $unidad,     // SAT catálogo? articulo['id_unidad'] -> unidades['nombre']
            //  "precio"      => "1000.00",
             "precio"      => $precio,
            //  "importe"     => "1000.00", 
             "importe"     => $importe,
             "descuento"   => "0.00", 
            //  "iBase"       => "1000.00", 
             "iBase"       => $iBase, 
             "iImpuesto"   => "002",       // Catálogo del SAT?
             "iTipoFactor" => "Tasa",      // ??
            //  "iTasaOCuota" => "0.160000",  // From config SAT?
             "iTasaOCuota" => $iTasaCuota,  // From config SAT?
            //  "iImporte"    => "160.00"
             "iImporte"    => $iImporte
      );
    }

    // Actualmente no existe. Agregar
    $data["serie"]   = $serie; // get from config: Serie facturas (X RFC ó X sucursal?)

    // $data["folio"]           = "1"; // get from config: Folio factura 
    $data["folio"]           = $folio; // get from config: Folio factura 
    $data['noCertificado']   = "20001000000300022762"; // get from config: filenames .pem

    $data['descuento']       = "0.00";     // $datosventa - No existe. Agregar
    $data['moneda']          = "MXN";      // $datosventa - No existe. Agregar
    $data["metodoPago"]      = "PUE";      // El registrado en la venta (Incorporar)

    $data["lugarExpedicion"] = "01000";  // CodPos fiscal o de la sucursal
    $data['formaPago']       = $datosventa['forma_pago'];

    // $subtotal = round($datosventa['total'] / (1 + $tasa), 2);  // Demo test only
    // $data['subTotal']        = (string) $subtotal;
    $subtotal = number_format($datosventa['total'] / (1 + $tasa), 2, ".", ""); // Demo test only
    $data['subTotal']        = $subtotal;

    $traslados['impuesto']   = "002";       
    $traslados['tasa']       = $tasa;      // TO DO: get from config?
    // $traslados['importe']    = $data['subTotal'] * $tasa;
    // $importe = number_format($datosventa['total'] - $subtotal, 2, ".", ""); // Demo test only
    // $traslados['importe']    = $importe;
    $traslados['importe']    = number_format($trasImporte, 2, ".", "");

    // $data['total']           = (string) round($datosventa['total'], 2);
    $data['total']           = number_format($datosventa['total'], 2, ".", "");
    $data['emisor']          = $emisor;
    $data['receptor']        = $receptor;
    $data['conceptos']       = $conceptos;
    $data['traslados']       = $traslados;
    // $data['traslados']['impuesto'] = "002";
    // $data['traslados']['tasa']     = "0.160000";
    // $data['traslados']['importe']  = "160.00";

    // echo "facturar ($venta_id) <br>";
    // var_dump ($data);
    // // $pdf = new \FPDF('P', 'mm', array(80, 200));
    // echo "facturaV33data <br>";
    // $this->facturaV33data();
    // echo "facturaV33 <br>";
    $this->facturaV33($data);
  }

  public function facturaV33demo()    // Estructura base demo
  {
    date_default_timezone_set('America/Mexico_City');
    $datosFactura = array();
	
    $dirCfdi = APPPATH . 'Libraries/cfdi_sat/cfdi/';
    $dir = APPPATH . 'Libraries/cfdi_sat/';    
    $nombre = "A1";

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
    return;
    $xml = new \GeneraXML();
    $xmlBase = $xml->satxmlsv33($datosFactura, '', $dir, '');	
    
    $timbra = new \Pac();
    $cfdi = $timbra->enviar("UsuarioPruebasWS","b9ec2afa3361a59af4b4d102d3f704eabdf097d4","TCM970625MB1", $xmlBase);
    
    if($xml)
    {
      file_put_contents($dirCfdi.$nombre.'.xml', base64_decode($cfdi->xml));
      // unlink($dirXML.$nombre'.xml');  // Del repositorio - 2022-03-13
      // unlink($dir.'/tmp/'.$nombre.'.xml');
    }
  }  

  public function facturaV33Ok($data) // Base v1 Ok
  {
    date_default_timezone_set('America/Mexico_City');
    $datosFactura = array();
	
    $dirCfdi = APPPATH . 'Libraries/cfdi_sat/cfdi/';
    $dir = APPPATH . 'Libraries/cfdi_sat/';
    
    // $nombre = "A1";
    $nombre = $data["serie"].$data["folio"];

  	//Datos generales de factura
    $datosFactura["version"]               = "3.3";
    // $datosFactura["serie"]                 = "A";
    $datosFactura["serie"]                 = $data["serie"];
    // $datosFactura["folio"]                 = "1";
    $datosFactura["folio"]                 = $data["folio"];
    $datosFactura["fecha"]                 = date('YmdHis');
    // $datosFactura["formaPago"] = "01";
    $datosFactura["formaPago"]             = $data['formaPago'];
    $datosFactura["noCertificado"]         = $data['noCertificado'];
    // $datosFactura["subTotal"] = "1000.00";
    $datosFactura["subTotal"]              = $data['subTotal'];
    // $datosFactura["descuento"]             = "0.00";
    $datosFactura["descuento"]             = $data['descuento'];
    // $datosFactura["moneda"]                = "MXN";
    $datosFactura["moneda"]                = $data['moneda'];

    // $datosFactura["total"] = "1160.00";
    $datosFactura["total"]                 = $data['total'];
    // $datosFactura["tipoDeComprobante"]     = "I";
    $datosFactura["tipoDeComprobante"] = "I";
    // $datosFactura["metodoPago"]            = "PUE";
    $datosFactura["metodoPago"]            = $data["metodoPago"];
    // $datosFactura["lugarExpedicion"]       = "01000";
    $datosFactura["lugarExpedicion"]       = $data["lugarExpedicion"];
    
    //Datos del emisor
    $datosFactura['emisor']['rfc']         = 'TCM970625MB1';
    $datosFactura['emisor']['nombre']      = 'Tienda CDP';
    $datosFactura['emisor']['regimen']     = '601';
    // $datosFactura['emisor']['rfc']         = $data['emisor']['rfc'];
    // $datosFactura['emisor']['nombre']      = $data['emisor']['nombre'];
    // $datosFactura['emisor']['regimen']     = $data['emisor']['regimen'];
        
    //Datos del receptor
    $datosFactura['receptor']['rfc']       = 'XAXX010101000';
    $datosFactura['receptor']['nombre']    = 'Publico en general';
    $datosFactura['receptor']['usocfdi']   = 'P01';
    // $datosFactura['receptor']['rfc']       = $data['receptor']['rfc'];
    // $datosFactura['receptor']['nombre']    = $data['receptor']['nombre'];
    // $datosFactura['receptor']['usocfdi']   = $data['receptor']['usocfdi'];
    
    // $datosFactura["conceptos"][] = array(
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

    // $datosFactura["conceptos"][] = $data['conceptos'];
    $datosFactura["conceptos"] = $data['conceptos'];
    
    // $datosFactura['traslados']['impuesto'] = "002";
    // $datosFactura['traslados']['tasa']     = "0.160000";
    // $datosFactura['traslados']['importe']  = "160.00";

    $datosFactura['traslados'] = $data['traslados'];
    echo "datosFactura33<br>";
    var_dump($datosFactura);
    echo "data 4-33<br>";
    var_dump($data);
    // return;
    
    $xml = new \GeneraXML();
    $xmlBase = $xml->satxmlsv33($datosFactura, '', $dir, '');	
    
    $timbra = new \Pac();
    $cfdi = $timbra->enviar("UsuarioPruebasWS","b9ec2afa3361a59af4b4d102d3f704eabdf097d4","TCM970625MB1", $xmlBase);
    
    if($xml)
    {
      file_put_contents($dirCfdi.$nombre.'.xml', base64_decode($cfdi->xml));
      // unlink($dirXML.$nombre'.xml');  // Del repositorio - 2022-03-13
      // unlink($dir.'/tmp/'.$nombre.'.xml');
    }

  }

  // public function generaPdf($xmlFile)
  // public function generaPdf($venta_id)
  public function generaPdf($xmlFile, $venta_id)
  {

    // $xmlFile = '';
    // echo "xmlFile : $xmlFile <br>";
    // echo "venta_id: $venta_id <br>";
    // return;
    /*
      // get this from system configurations
      // Libraries SAT CFDI
      $dirCfdi = APPPATH . 'Libraries/cfdi_sat/cfdi/';

      $xmlFile = "$dirCfdi$serie$folio";
      if ( is_file ($xmlFile) ) {
      }
    */
    // var_dump($xmlFile);

    $dirCfdi = APPPATH . 'Libraries/cfdi_sat/cfdi/';
    $xml = simplexml_load_file("$dirCfdi$xmlFile.xml");
    $ns  = $xml->getNamespaces(true);
    $xml->registerXPathNamespace('c', $ns['cfdi']);
    $xml->registerXPathNamespace('t', $ns['tfd']);

    // $uuid          = '';
    // $fechaTimbrado = '';
    $path = '//t:TimbreFiscalDigital';    
    echo "$path <br>";
    /*
    // Código del video
    $uuid          = '';
    $fechaTimbrado = '';
    forEach($xml->xpath($path) as $tfd) {
      $uuid          = $tfd['UUID'];
      $fechaTimbrado = $tfd['FechaTimbrado'];
    }
    echo "0: uuid: $uuid <br>";
    echo "0: fechaTimbrado: $fechaTimbrado <br>";
    */

    $nodo          = $xml->xpath($path);
    $uuid          = $nodo[0]['UUID'];
    $fechaTimbrado = $nodo[0]['FechaTimbrado'];

    echo "1: uuid: $uuid <br>";
    echo "1: fechaTimbrado: $fechaTimbrado <br>";
    var_dump($uuid);
    var_dump($fechaTimbrado);
    ;

    $this->dataModel->update($venta_id, [
      'timbrado'       => 1,
      'uuid'           => $uuid,
      'fecha_timbrado' => $fechaTimbrado
    ]);


    return
    var_dump($nodo);
    var_dump($nodo[0]);
    var_dump($nodo[0]['UUID']);
    echo $nodo[0]['UUID'] . "<br>" ;
    return;

    forEach($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante) {
      var_dump ($cfdiComprobante['Version']);
      var_dump ($cfdiComprobante['Fecha']);
      var_dump ($cfdiComprobante['Serie']);
      var_dump ($cfdiComprobante['Folio']);
      var_dump ($cfdiComprobante['Total']);
    }

    forEach($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $cfdiComprobante) {
      var_dump ($cfdiComprobante);
      // var_dump ($cfdiComprobante['Fecha']);
      // var_dump ($cfdiComprobante['Serie']);
      // var_dump ($cfdiComprobante['Folio']);
      // var_dump ($cfdiComprobante['Total']);
    }

    forEach($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $cfdiComprobante) {
      var_dump ($cfdiComprobante);
      // var_dump ($cfdiComprobante['Fecha']);
      // var_dump ($cfdiComprobante['Serie']);
      // var_dump ($cfdiComprobante['Folio']);
      // var_dump ($cfdiComprobante['Total']);
    }

    $path = '//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto';
    echo $path;
    forEach($xml->xpath($path) as $cfdiComprobante) {
      var_dump ($cfdiComprobante);
      // var_dump ($cfdiComprobante['Fecha']);
      // var_dump ($cfdiComprobante['Serie']);
      // var_dump ($cfdiComprobante['Folio']);
      // var_dump ($cfdiComprobante['Total']);
    }

    $path = '//t:TimbreFiscalDigital';
    echo $path;
    forEach($xml->xpath($path) as $tfd) {
      var_dump ($tfd);
      // var_dump ($tfd['UUID']);
      // var_dump ($tfd['Serie']);
      // var_dump ($tfd['Folio']);
      // var_dump ($tfd['Total']);
    }

    $path = '//t:TimbreFiscalDigital';
    echo $path;
    forEach($xml->xpath($path) as $tfd) {
      var_dump ($tfd['UUID']);
      echo  $tfd['UUID'];
      var_dump ($tfd['FechaTimbrado']);
      echo  $tfd['FechaTimbrado'];
    }

    $path = '//t:TimbreFiscalDigital';
    $obj  = $xml->xpath($path);
    var_dump($obj);
    var_dump($obj[0]);
    var_dump($obj[0]['UUID']);
    echo $obj[0]['UUID'] . "<br>" ;
    // echo $obj['UUID'] . "<br>" ; // Fail
    // echo $obj[0]['UUID'] . "<br>" ;
    // var_dump($obj[0][0]['UUID']);
    
    
    // ->attributes;

    // $path = '//cfdi:Comprobante//cfdi:Complemento//tfd:TimbreFiscalDigital';
    // echo $path;
    // forEach($xml->xpath($path) as $cfdiComprobante) {
    //   var_dump ($cfdiComprobante);
    //   // var_dump ($cfdiComprobante['Fecha']);
    //   // var_dump ($cfdiComprobante['Serie']);
    //   // var_dump ($cfdiComprobante['Folio']);
    //   // var_dump ($cfdiComprobante['Total']);
    // }

    /*
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
    */
  }

  public function generaPdfBak($xmlFile)
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

  public function viewX()
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