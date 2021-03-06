<?php
// Parameters for config
$currency = "$ ";
$pathImgs = 'images';
?>

<div class="row mt-4">
  <div class="col-12 col-sm-8">
      <h4 class=""><?=$title?></h4>
  </div>
  <div class="col-12 col-sm-4 text-right" style="text-align:right">
    <a href="<?=base_url("$path/index/".($onOff == 0?"1":"0"))?>" class="btn btn-warning mb-2"><?=$switch?></a>
    <?php if ($onOff) {?>
      <a href="<?=base_url("$path/agregar")?>" class="btn btn-primary mb-2">Agregar</a>
      <a href="<?=base_url("$path/muestraCodigos")?>" class="btn btn-dark mb-2 ">Código de barras</a>
      <a href="<?=base_url("$path/rptMinExcel")?>" class="btn btn-success mb-2"><i class="fa fa-file-excel"></i></a>
    <?php } ?>
  </div>
</div>

<div class="mt-3">
  <table id="datatablesSimple">
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Foto</th>
        <th>Precio</th>
        <th>Existen</th>
        <th>Código</th>
        <th>Unidad</th>
        <th>Categoría</th>
        <th>Compra</th>
        <th class="text-center">Acciones</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <th>Nombre</th>
        <th>Foto</th>
        <th>Precio</th>
        <th>Existen</th>
        <th>Código</th>
        <th>Unidad</th>
        <th>Categoría</th>
        <th>Compra</th>
        <th class="text-center">Acciones</th>
      </tr>
    </tfoot>
    <tbody>
      <?php foreach($data as $dato) {
        $imagen  = $dato['foto'] ? 
                   base_url('images/articulos/'.$dato['id'].'/'.$dato['foto']):
                   base_url('assets/img/img-no-disponible.jpg');
        $url     = base_url("$pathImgs/$path/".$dato['id']).'/';
        $caption = "". $dato['nombre'];//
                // Bloque 1 de vista previa una sola foto
        $info    = " - Precio: ".$currency.$dato['precio_venta'] 
                 . " - Existencias: ". $dato['existencias'];
                // Bloque 2
        $info    = " - Hay: ". $dato['existencias']
                 . " - ".$currency.$dato['precio_venta'];
        $prVenta  = $currency.number_format($dato['precio_venta'], 2, ".", ",");
        $prCompra = $currency.number_format($dato['precio_compra'], 2, ".", ",");
        $dato['fotos'] = str_replace(".", "_wm.",$dato['fotos']);
      ?>
        <tr>
          <td><?=$dato['nombre']?></td>
          <td class="text-end">  <!-- Carousel -->
            <img style="width: 50px;"
                 src="<?=$imagen?>"
                 alt="<?=$dato['nombre']?> - Foto"
                 onclick="showPhotos('<?=$url?>', '<?=$caption?>', '<?=$dato['fotos']?>', '<?=$info?>')"
            >
          </td>
          <td class="text-end"><?=$prVenta?></td>
          <td class="text-end"><?=$dato['existencias']?></td>
          <td><?=$dato['codigo']?></td>
          <td><?=$dato['unidad']?></td>
          <td><?=$dato['categoria']?></td>
          <td class="text-end"><?=$prCompra?></td>
          <?php if ($onOff) {?>
            <td class="text-center">
              <a href="#confirm" data-bs-toggle="modal"
                 data-info="<?=$dato['nombre']?>" data-item="<?=$item?>"
                 data-href="<?=base_url("$path/eliminar/".$dato['id'])?>"
                 data-actionText="<?=$delete?>" class="btn btn-danger">
                <i class="fas fa-trash"></i>
              </a>
              <a href="<?=base_url("$path/editar/".$dato['id'])?>"
                class="btn btn-success"><i class="fas fa-pencil-alt"></i>
              </a>
            </td>
          <?php } else {?>
            </td>
            <td class="text-center">
              <a href="#confirm" data-bs-toggle="modal"
                 data-info="<?=$dato['nombre']?>" data-item="<?=$item?>"
                 data-href="<?=base_url("$path/recuperar/".$dato['id'])?>"
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
