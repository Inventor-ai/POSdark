<div class="row mt-4">
  <div class="col-12 col-sm-9">
      <h4 class=""><?=$titulo?></h4>
  </div>
  <div class="col-12 col-sm-3">
    <a href="<?=base_url()."/$ruta/index/".($onOff == 0?"1":"0")?>" class="btn btn-warning mb-3"><?=$switch?></a>
    <?php if ($onOff) {?>
      <a href="<?=base_url()."/$ruta/agregar"?>" class="btn btn-primary mb-3">Agregar</a>
    <?php } ?>
  </div>
</div>
<!-- 
<h4 class="mt-4"><?=$titulo?></h4>
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
      <?php foreach($datos as $dato) {?>
        <tr>
          <td><?=$dato['id']?></td>
          <td><?=$dato['nombre']?></td>
          <td><?=$dato['nombre_corto']?></td>
          <?php if ($onOff) {?>
            
            <td class="text-center">
              <a href="<?=base_url()."/$ruta/eliminar/".$dato['id']?>"
                class="btn btn-danger"><i class="fas fa-trash"></i>
              </a>
              <!-- </td>
              <td class="text-center"> -->
              <a href="<?=base_url()."/$ruta/editar/".$dato['id']?>"
                class="btn btn-success"><i class="fas fa-pencil-alt"></i>
              </a>
            </td>

              <!-- 
            <td class="text-center">
              <div class="row">
                <div class="col">
                  <a href="<?=base_url()."/$ruta/eliminar/".$dato['id']?>"
                    class="btn btn-danger"><i class="fas fa-trash"></i>
                  </a>
                </div>
                <div class="col">
                  <a href="<?=base_url()."/$ruta/editar/".$dato['id']?>"
                    class="btn btn-success"><i class="fas fa-pencil-alt"></i>
                  </a>
                </div>
              </div>
               -->
              <!-- </td>
              <td class="text-center"> -->
            </td>
          <?php } else {?>
            <td class="text-center">
              <a href="<?=base_url()."/$ruta/recuperar/".$dato['id']?>"
                class="btn btn-dark">
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
