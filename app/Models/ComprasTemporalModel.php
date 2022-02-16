<?php

namespace App\Models;

use CodeIgniter\Model;

class ComprasTemporalModel extends Model 
{
  protected $table      = 'compras_temporal';
  protected $primaryKey = 'id';

  protected $useAutoIncrement = true;

  protected $returnType     = 'array';
  protected $useSoftDeletes = false;
  protected $allowedFields = [
    'folio', 'articulo_id', 'codigo', 'nombre', 'cantidad', 'precio', 'subtotal',
  ];

  protected $useTimestamps = false;
  // protected $createdField  = 'fecha_alta';
  // protected $updatedField  = 'fecha_edit';
//   protected $deletedField  = 'deleted_at';

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;

  public function porIdArticuloCompra($articulo_id, $folio)
  {
    $campos = '*';
    $this->select($campos);
    $this->where('folio', $folio);
    $this->where('id', $articulo_id);
    return $this->get()->getRow();
  }


}
