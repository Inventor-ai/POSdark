<?php
var_dump($test);
// var_dump($data);
// $test = null;
// $test = '';
// $test = 0;
// $test = '0';

// $test = 'w';
// $test = ' ';
// $test = 1;
// $test = '00';
// echo $test ? "set" : "no";
?>
<div class="row mt-4">
  <div class="col-12 col-sm-8">
      <h4 class=""><?=$title?></h4>
  </div>
  <div class="col-12 col-sm-4 text-right" style="text-align:right">
    <a href="<?=base_url()."/$path/index/".($onOff == 0?"1":"0")?>" class="btn btn-warning"><?=$switch?></a>
    <?php if ($onOff) {?>
      <a href="<?=base_url()."/$path/agregar"?>" class="btn btn-primary">Agregar</a>
    <?php } ?>
  </div>
</div>
<div class="mt-3">
  <table id="datatablesSimple">
    <thead>
      <tr>
        <th>Id</th>
        <th>Usuario</th>
        <th>Nombre</th>
        <th>Rol</th>
        <th>Caja</th>
        <th class="text-center">Acciones</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <th>Id</th>
        <th>Usuario</th>
        <th>Nombre</th>
        <th>Rol</th>
        <th>Caja</th>
        <th class="text-center">Acciones</th>
      </tr>
    </tfoot>
    <tbody>
      <?php foreach($data as $dato) {?>
        <tr>
          <td><?=$dato['id']?></td>
          <td><?=$dato['usuario']?></td>
          <td><?=$dato['nombre']?></td>
          <td><?=$dato['rol_id']?></td>
          <td><?=$dato['caja_id']?></td>
          <?php if ($onOff) {?>
            <td class="text-center">
              <a href="#confirm" data-bs-toggle="modal"
                 data-info="<?=$dato['nombre']?>" data-item="<?=$item?>"
                 data-href="<?=base_url()."/$path/eliminar/".$dato['id']?>"
                 data-actionText="<?=$delete?>" class="btn btn-danger">
                <i class="fas fa-trash"></i>
              </a>
              <a href="<?=base_url()."/$path/editar/".$dato['id']?>"
                class="btn btn-success"><i class="fas fa-pencil-alt"></i>
              </a>
            </td>
          <?php } else {?>
            </td>
            <td class="text-center">
              <a href="#confirm" data-bs-toggle="modal"
                 data-info="<?=$dato['nombre']?>" data-item="<?=$item?>"
                 data-href="<?=base_url()."/$path/recuperar/".$dato['id']?>"
                 data-actionText="<?=$recover?>"
                 class="btn btn-warning">
                 <i class="fas fa-undo"></i>
              </a>
            </td>
          <?php } ?>
        </tr>  
      <?php }?>
    </tbody>
  </table>
</div>
