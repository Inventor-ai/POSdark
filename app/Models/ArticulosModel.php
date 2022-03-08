<?php

namespace App\Models;

use CodeIgniter\Model;

class ArticulosModel extends Model 
{
  protected $table      = 'articulos';
  protected $primaryKey = 'id';

  protected $useAutoIncrement = true;

  protected $returnType     = 'array';
  protected $useSoftDeletes = false;
  protected $allowedFields = [
    'nombre', 'codigo', 'inventariable',
    'precio_venta', 'precio_compra',
    'existencias', 'stock_minimo',
    'id_unidad'  , 'id_categoria',
    'fotos', 'activo'  
  ];

  protected $useTimestamps = true;
  protected $createdField  = 'fecha_alta';
  protected $updatedField  = 'fecha_edit';
//   protected $deletedField  = 'deleted_at';

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;

  // public function actualizaStock($articulo_id, $cantidad)  // For Try with my own
  public function actualizaStock($articulo_id, $cantidad, $operador = '+')
  {
    // $this->set('existencias', "existencias + $cantidad", FALSE);
    $this->set('existencias', "existencias $operador $cantidad", FALSE);
    $this->where('id', $articulo_id);
    $this->update();
  }

  public function indexList($activo = 1)
  {
    $campos = 'articulos.id as id, articulos.nombre as nombre, fotos, '
            . 'precio_venta, existencias, codigo, precio_compra, '
            // . 'id_unidad, id_categoria, '
            . 'unidades.nombre as unidad, '
            . 'categorias.nombre as categoria';
    $this->select($campos);
    $this->where('articulos.activo', $activo);
    $this->join('categorias', 'categorias.id = articulos.id_categoria');
    $this->join('unidades'  , 'unidades.id = articulos.id_unidad');
    return $this->findAll();
  }

  public function total()
  {
    return $this->where('activo', 1)->countAllResults(); // num_rows
  }

  public function minimos()
  {
    $filtro = "stock_minimo >= existencias AND ";
    $filtro = "$filtro inventariable = 1 AND ";
    $filtro = "$filtro activo = 1";
    $this->where($filtro);
    return $this->countAllResults();
  }

  public function codeList($activo = 1)
  {
    $this->select('codigo, nombre');
    $this->where('activo', $activo);
    return $this->findAll();
  }

  public function listarMinimos()
  {
    $filtro = "stock_minimo >= existencias AND ";
    $filtro = "$filtro inventariable = 1 AND ";
    $filtro = "$filtro activo = 1";
    $this->where($filtro);
    return $this->findAll();
  }

}
