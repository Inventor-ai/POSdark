<?php

namespace App\Models;

use CodeIgniter\Model;

class RolesPermisosModel extends Model 
{
  protected $table      = 'roles_permisos';
  protected $primaryKey = 'id';

  protected $useAutoIncrement = true;

  protected $returnType     = 'array';
  protected $useSoftDeletes = false;
  protected $allowedFields = [
    'rol_id', 'permiso_id'
  ];

  protected $useTimestamps = true;
  protected $createdField  = '';
  protected $updatedField  = '';
  protected $deletedField  = '';

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;

  public function verificaPermisos ($idRol, $permiso)
  {
    $tieneAcceso = false;
    // $this->select('*');  // ¿Para esto? no es necesaria esta línea.
    $this->join('permisos', 'roles_permisos.permiso_id = permisos.id');
    $existe = $this->where(['rol_id' => $idRol, 'permisos.nombre' => $permiso])->first();
    echo $this->getLastQuery();
    var_dump($existe);
    if ($existe != null) {
        $tieneAcceso = true;
    }
    return $tieneAcceso;
  }

  public function verificaPermisos_Own ($idRol, $permiso)
  {
    $tieneAcceso = false;
    // $this->select('*');  // ¿Para esto? no es necesaria esta línea.
    $this->join('permisos', 'roles_permisos.permiso_id = permisos.id');
    $existe = $this->where(['rol_id' => $idRol, 'permisos.nombre' => $permiso])->first();
    echo $this->getLastQuery();
    var_dump($existe);
    $tieneAcceso = $existe != null;
    return $tieneAcceso;
  }

}
