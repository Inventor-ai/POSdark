<?php
  // var_dump($data);
  // $dato = $data[0];
  // var_dump($dato);
  // echo "<br> dato 0: ";
  // echo  $dato['fecha_final'] == null ? 'nada' : $dato['fecha_final'];
  // echo "<br> dato 1: ";
  // echo isset ($dato['fecha_final']) ? 'fecha_final' : 'no set';
  // return;
?>
<div class="row mt-4">
  <div class="col-12 col-sm-8">
      <h4 class=""><?=$title?></h4>
  </div>
  <div class="col-12 col-sm-4 text-right" style="text-align:right">
    <!-- <a href="<?=base_url()."/$path/index/".($onOff == 0?"1":"0")?>" class="btn btn-warning"><?=$switch?></a> -->
    <?php if ($onOff) {?>
      <a href="<?=base_url("$path/nuevo_arqueo")?>" class="btn btn-primary">Agregar</a>
    <?php } ?>
  </div>
</div>
<div class="mt-3">
  <table id="datatablesSimple">
    <thead>
      <tr>
        <th>Id</th>
        <th>Fecha apertura</th>
        <th>Fecha cierre</th>
        <th>Monto inicial</th>
        <th>Monto final</th>
        <th>Total ventas</th>
        <th>Estatus</th>
        <th class="text-center"></th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <th>Id</th>
        <th>Fecha apertura</th>
        <th>Fecha cierre</th>
        <th>Monto inicial</th>
        <th>Monto final</th>
        <th>Total ventas</th>
        <th>Estatus</th>
        <th class="text-center"></th>
      </tr>
    </tfoot>
    <tbody>
      <?php foreach($data as $dato) {?>
        <tr>
          <td><?=$dato['id']?></td>
          <td><?=$dato['fecha_inicio']?></td>
          <td><?=$dato['fecha_final']?></td>
          <td class="text-end"><?="$ ".number_format($dato['monto_inicial'], 2, ".", ",")?></td>
          <td class="text-end"><?="$ ".number_format($dato['monto_final'], 2, ".", ",")?></td>
          <td class="text-end"><?=$dato['total_ventas']?></td>
          <?php if ($dato['estatus'] == 1 ) { ?>
            <td>Abierta</td>
            <td>
              <a href="#confirm" data-bs-toggle="modal"
                  data-info="<?=$dato['nombre']?>" data-item="<?=$item?>"
                  data-href="<?=base_url("/$path/cerrar")?>"
                  data-actionText="<?=$close?>" class="btn btn-danger">
                  <!-- data-href="<?=base_url("/$path/cerrar/".$dato['id'])?>" -->
                <i class="fas fa-lock"></i>
              </a>
            </td>
          <?php } else {?>
            <td>Cerrada</td>
            <td>            
              <a href="<?=base_url("/$path/$print/".$dato['id'])?>" class="btn btn-success">
                 <i class="fas fa-print"></i>
              </a>
            </td>
          <?php }?>
        </tr>  
      <?php }?>
    </tbody>
  </table>
</div>
