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
<!-- 
<h4 class="mt-4"><?=$title?></h4>
<div class="mb-3">
    <a href="<?=base_url()?>/unidades/agregar" class="btn btn-primary">Agregar</a>
    <a href="<?=base_url()?>/unidades/eliminados" class="btn btn-warning">Eliminados</a>
</div> -->

<div class="mt-3">
  <table id="datatablesSimple">
    <thead>
      <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th>Nombre corto</th>
        <th class="text-center">Acciones</th>
        <!-- <th class="text-center">Borrar</th>
        <th class="text-center">Editar</th> -->
      </tr>
    </thead>
    <tfoot>
      <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th>Nombre corto</th>
        <th class="text-center">Acciones</th>
        <!-- <th class="text-center">Borrar</th>
        <th class="text-center">Editar</th> -->
      </tr>
    </tfoot>
    <tbody>
      <?php foreach($data as $dato) {?>
        <tr>
          <td><?=$dato['id']?></td>
          <td><?=$dato['nombre']?></td>
          <td><?=$dato['nombre_corto']?></td>
          <?php if ($onOff) {?>

            <td class="text-center">

              <a href="#confirmar" data-bs-toggle="modal"
                 data-info="<?=$dato['nombre']?>" data-item="<?=$item?>"
                 data-href="<?=base_url()."/$path/eliminar/".$dato['id']?>"
                 data-action="<?=$delete?>" class="btn btn-danger">
                <i class="fas fa-trash"></i>
              </a>
              <!-- <a href="<?=base_url()."/$path/eliminar/".$dato['id']?>"
                class="btn btn-danger"><i class="fas fa-trash"></i>
              </a> -->

              <!-- </td>
              <td class="text-center"> -->
              <a href="<?=base_url()."/$path/editar/".$dato['id']?>"
                class="btn btn-success"><i class="fas fa-pencil-alt"></i>
              </a>
            </td>
              <!-- 
            <td class="text-center">
              <div class="row">
                <div class="col">
                  <a href="<?=base_url()."/$path/eliminar/".$dato['id']?>"
                    class="btn btn-danger"><i class="fas fa-trash"></i>
                  </a>
                </div>
                <div class="col">
                  <a href="<?=base_url()."/$path/editar/".$dato['id']?>"
                    class="btn btn-success"><i class="fas fa-pencil-alt"></i>
                  </a>
                </div>
              </div>
               -->
              <!-- </td>
              <td class="text-center"> -->
          <?php } else {?>
            </td>
            <td class="text-center">
              <a href="#confirmar" data-bs-toggle="modal" id="borrarOk" 
                 data-info="<?=$dato['nombre']?>" data-item="<?=$item?>"
                 data-href="<?=base_url()."/$path/recuperar/".$dato['id']?>"
                 data-action="<?=$recover?>"
                 class="btn btn-dark">
                <!-- class="btn btn-warning"> -->
                <i class="fas fa-level-up-alt"></i>
                <!-- <i class="fas fa-retweet"></i> -->
              </a>
            </td>
          <?php } ?>
        </tr>  
      <?php }?>
    </tbody>
  </table>
</div>
