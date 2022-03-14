<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\VentasModel;

class Factura extends BaseController
{
  protected $item     = 'Factura';
  protected $items    = 's';
  protected $enabled  = 'Disponibles'; // Cambiar por???
  protected $disabled = 'Eliminadas';
  protected $carrier  = [];
  protected $activo   = 1;
  protected $module;
  protected $dataModel;

  public function __construct()
  {
    $this->items     = $this->item.$this->items;
    $this->module    = strtolower($this->items);
    $this->dataModel = new VentasModel();
  }

  public function facturar($idVenta)
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