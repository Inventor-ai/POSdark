<?php

namespace App\Models;

use CodeIgniter\Model;

class CajasArqueoModel extends Model 
{
  protected $table      = 'cajas_arqueo';
  protected $primaryKey = 'id';

  protected $useAutoIncrement = true;

  protected $returnType     = 'array';
  protected $useSoftDeletes = false;
  protected $allowedFields = [
    'caja_id',       'usuario_id', 
    'fecha_inicio',  'fecha_final', 
    'monto_inicial', 'monto_final', 
    'total_ventas',  'estatus'
  ];

  protected $useTimestamps = false;
  protected $createdField  = '';
  protected $updatedField  = '';
  protected $deletedField  = '';

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;

  public function getDatos( $idCaja )
  {
    // $this->select('cajas_arqueo.*, nombre'); // Own ok
    $this->select('nombre, cajas_arqueo.*');    // Own ok
    $this->join('cajas', 'cajas.caja = cajas_arqueo.caja_id');
    // $this->where('cajas_arqueo.caja_id', $idCaja); // Video
    $this->where('cajas.caja', $idCaja);        // Own 
    $this->orderBy('cajas_arqueo.id', 'DESC');  // Own 
    return $this->findAll();       // Own
    // $datos = $this->findAll();  // Video
    // return $datos;              // Video
  }
}
