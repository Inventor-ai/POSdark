<?php

namespace App\Models;

use CodeIgniter\Model;

class ComprasModel extends Model 
{
  protected $table      = 'compras';
  protected $primaryKey = 'id';

  protected $useAutoIncrement = true;

  protected $returnType     = 'array';
  protected $useSoftDeletes = false;
  protected $allowedFields = [
    'folio', 'total', 'usuario_id', 'activo'
  ];

  protected $useTimestamps = true;
  protected $createdField  = 'fecha_alta';
  protected $updatedField  = '';
  // protected $updatedField  = 'fecha_edit'; // Fail. updated_at field needed
//   protected $deletedField  = 'deleted_at';

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;

  public function insertaCompra($compra_id, $total, $usuario_id)
  {
    var_dump ($total);
    var_dump (str_replace(",", "", $total ));
    $this->insert([
      'folio'      => $compra_id,
      // 'total'      => $total, // Fails when > 1,000 by format
      // 'total'      => (float) str_replace(",", "", $total ), // Own Ok.
      'total'      => preg_replace('/[\$,]/', "", $total ),
      'usuario_id' => $usuario_id
    ]);
    return $this->insertID();
  }
}
