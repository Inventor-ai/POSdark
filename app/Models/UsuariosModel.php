<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuariosModel extends Model 
{
  protected $table      =  'usuarios';
  protected $primaryKey = 'id';

  protected $useAutoIncrement = true;

  protected $returnType     = 'array';
  protected $useSoftDeletes = false;
  protected $allowedFields = [
    'nombre',  'usuario', 'password',
    'caja_id', 'rol_id',   'activo'

  ];

  protected $useTimestamps = true;
  protected $createdField  = 'fecha_alta';
  protected $updatedField  = 'fecha_edit';
//   protected $deletedField  = 'deleted_at';

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;

  /*
  public function indexTable($activo = 1)
  {
    // $builder = $db->table($this->table);
    $builder->select('*');
    $builder->join('cajas', 'cajas.id = cajas_id');
    $builder->join('roles', 'roles.id = roles_id');
    $builder->where("$this->table.activo", $activo);
    $query = $builder->get();
    return $query;
  }
    $dataModel = $this->dataModel
                      ->select('id, usuario, nombre, rol_id, caja_id')
                      ->join('cajas', 'cajas.id = cajas_id')
                      ->where('activo', $activo)
                      ->findAll();
                      
    $builder->select('*');
    $builder->join('cajas', 'cajas.id = cajas_id');
    $builder->join('roles', 'roles.id = roles_id');
    $builder->where("$this->table.activo", $activo);
    $query = $builder->get();
*/
}
