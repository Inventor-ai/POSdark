<?php
$runEngine = '/index.php'; // temporal
?>
<h4 class="mt-4"><?=$titulo?></h4>
<div class="mb-3">
    <a href="<?=base_url().$runEngine?>/unidades/agregar" class="btn btn-primary">Agregar</a>
    <a href="<?=base_url().$runEngine?>/unidades/eliminados" class="btn btn-warning">Eliminados</a>
</div>
<table id="datatablesSimple">
  <thead>
    <tr>
      <th>Id</th>
      <th>Nombre</th>
      <th>Nombre corto</th>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th>Id</th>
      <th>Nombre</th>
      <th>Nombre corto</th>
      <th></th>
      <th></th>
    </tr>
  </tfoot>
  <tbody>
    <?php foreach($datos as $dato) {?>
      <tr>
        <td><?=$dato['id']?></td>
        <td><?=$dato['nombre']?></td>
        <td><?=$dato['nombre_corto']?></td>
        <td>
          <a href="<?=base_url().$runEngine?>/unidades/editar/<?=$dato['id']?>"
             class="btn btn-success"><i class="fas fa-pencil-alt"></i>
          </a>
        </td>
        <td>
          <a href="<?=base_url().$runEngine?>/unidades/eliminar/<?=$dato['id']?>"
             class="btn btn-danger"><i class="fas fa-trash"></i>
          </a>
        </td>
      </tr>  
    <?php }?>
  </tbody>
</table>
