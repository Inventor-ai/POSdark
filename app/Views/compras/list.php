<div class="row mt-4">
  <div class="col-12 col-sm-8">
      <h4 class=""><?=$title?></h4>
  </div>
  <div class="col-12 col-sm-4 text-right" style="text-align:right">
    <a href="<?=base_url()."/$path/index/".($onOff == 0?"1":"0")?>" class="btn btn-warning"><?=$switch?></a>
    <?php if ($onOff) {?>
      <a href="<?=base_url()."/$path/nueva"?>" class="btn btn-primary">Nueva</a>
      <!-- <a href="<?=base_url()."/$path/agregar"?>" class="btn btn-primary">Agregar</a> -->
    <?php } ?>
  </div>
</div>
<div class="mt-3">
  <table id="datatablesSimple">
    <thead>
      <tr>
        <th>Fecha</th>
        <th>Folio</th>
        <th>Usuario</th>
        <th>Total</th>
        <th class="text-center">Acciones</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <th>Fecha</th>
        <th>Folio</th>
        <th>Usuario</th>
        <th>Total</th>
        <th class="text-center">Acciones</th>
      </tr>
    </tfoot>
    <tbody>
      <?php foreach($data as $dato) {
          // $info = $dato['folio'] 
          //       . " del ". $dato['fecha_alta'] 
          //       . " de $"
          //       . number_format($dato['total'], 2, ".", ",");
          $info = $dato['folio'] . " de $"
                . number_format($dato['total'], 2, ".", ",");
      ?>
        <tr>
          <td><?=$dato['fecha_alta']?></td>
          <td><?=$dato['folio']?></td>
          <td><?=$dato['nombre']?></td>
          <td class="text-end">
              <?="$ ".number_format($dato['total'], 2, ".", ",")?>
          </td>
          <?php if ($onOff) {?>
            <td class="text-center">
              <a href="#confirm" data-bs-toggle="modal"
                 data-info="<?=$info?>" data-item="<?=$item?>"
                 data-href="<?=base_url()."/$path/eliminar/".$dato['id']?>"
                 data-actionText="<?=$delete?>" class="btn btn-danger">
                <i class="fas fa-trash"></i>
              </a>
              <a href="<?=base_url()."/$path/editar/".$dato['id']?>"
                class="btn btn-success"><i class="fas fa-pencil-alt"></i>
              </a>
              <a href="<?=base_url()."/$path/muestraCompraPDF/".$dato['id']?>"
                class="btn btn-primary"><i class="fas fa-file-alt"></i>
              </a>
            </td>
          <?php } else {?>
            </td>
            <td class="text-center">
              <a href="#confirm" data-bs-toggle="modal"
                 data-info="<?=$info?>" data-item="<?=$item?>"
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
