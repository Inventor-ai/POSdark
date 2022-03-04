<?php
// var_dump($data);
?>
<div class="mb-3">
  <form method="<?=$method?>" enctype="multipart/form-data" action="<?=base_url("$path/$action")?>"
         autocomplete="off">
         <?php csrf_field();?>
    <div class="row mt-4">
      <div class="col-12 col-sm-9">
         <h4 class=""><?=$title?></h4>
      </div>
      <div class="col-12 col-sm-3 text-end">
          <?php if ($method != '') {?>
           <button type="submit" class="btn btn-success mb-3">Guardar</button>
           <?php }?>
           <a href="<?=base_url()."/$path"?>" class="btn btn-primary mb-3">Regresar</a>
        </div>
    </div>
    <input type="hidden" name="id" value="<?=$data['id']?>">
    <!-- <div class="row mt-4">      
    </div> -->
    <div class="form-group">
      <div class="row">
        <div class="col-12 col-sm-6 mb-3">
          <label class="mb-2" for="codigo">Código</label> 
          <input class="form-control" type="text" name="codigo" id="codigo"
                 value="<?= $data['codigo']?>" required autofocus>
        </div>
        <div class="col-12 col-sm-6 mb-3">
           <label class="mb-2" for="nombre">Nombre</label> 
           <input class="form-control" type="text" name="nombre" id="nombre"
                  value="<?=$data['nombre']?>" required>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="row">
        <div class="col-12 col-sm-6 mb-3">
          <label class="mb-2" for="precio_venta">Precio de venta</label> 
          <input class="form-control" type="text" name="precio_venta" id="precio_venta"
                 value="<?= $data['precio_venta']?>" required>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="mb-2" for="existencias">Existencias</label> 
          <input class="form-control" type="text" name="existencias" id="existencias"
                 value="<?=$data['existencias']?>" required >
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="row">
        <div class="col-12 col-sm-6 mb-3">
          <label class="mb-2" for="id_unidad">Unidad</label> 
          <select class="form-select"id="id_unidad" name="id_unidad" required>
            <option value="">Seleccionar Unidad</option>
              <?php foreach ($unidades as $value) {?>
                <option value="<?=$value['id']?>"
                  <?=($value['id'] == $data['id_unidad'] ? 'selected' :'' )?> >
                  <?=$value['nombre']?>
                </option>  
              <?php }?>
          </select>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="mb-2" for="id_categoria">Categoría</label> 
          <select class="form-select" id="id_categoria" name="id_categoria" required>
            <option value="">Seleccionar Categoría</option>             
              <?php foreach ($categorias as $value) 
                 echo '<option value="'.$value['id'].'" '.
                 ($value['id'] == $data['id_categoria'] ? "selected":"").'>'
                 .$value['nombre'];
              ?>
            </option>
          </select>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="row">
        <div class="col-12 col-sm-6 mb-3">
          <label class="mb-2" for="stock_minimo">Stock mínimo</label> 
          <input class="form-control" type="text" name="stock_minimo" id="stock_minimo"
                 value="<?= $data['stock_minimo']?>" required>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="mb-2" for="inventariable">Es inventariable</label> 
          <select class="form-select" name="inventariable" id="inventariable" required>
            <option value="1">Sí</option>
            <option value="0">No</option>
          </select>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="row">
        <div class="col-12 col-sm-6 mb-3">
          <label class="mb-2" for="precio_compra">Precio de compra</label> 
          <input class="form-control text-end" type="text" name="precio_compra" id="precio_compra"
                 value="<?=$data['precio_compra']?>" required >
        </div>
      </div>
    </div>
    
    <div class="mt-2">
      <label class="form-label"  for="fotos">Imagen</label>
      <input class="form-control" type="file" id="fotos" name="fotos[]" accept="image/png,.jpg" multiple>
    </div>
    <p class="text-danger">Cargar imagen .png o .jpg de 150x150 pixeles</p>
    <hr> <!-- ¿Dejar esta línea? - Preguntar -->
    <div class="form-group mt-2">
      <div class="row row-cols-auto" >
        <?php for ($i=0; $i < $data['fotos']; $i++) {
          $j = $i + 1;
          // $imagen = 'images/'."$path/".$data['id']."/foto".($j < 10 ? "0" : "") . "$j.png";
          // $imagen = 'images/'."$path/".$data['id']."/foto".($j<10?"0":"")."$j.png";
          // $imagen = base_url('images/'."$path/".$data['id']."/foto".($j<10?"0":"")."$j.png");
           $imagen = "/foto".($j < 10 ? "0" : "")."$j.png";
           $imagen = 'images/'."$path/".$data['id'].$imagen;
           $imagen = base_url ($imagen);
        ?>
          <div class="col mb-3">
            <!-- <div class="mb-1"> -->
              <a href="<?=$imagen?>">
                <img src="<?=$imagen?>" 
                     alt="foto de <?=$data['nombre']?>" style="width: 80px;">
               <!--  class="img-thumbnail"  -->
              </a>
            <!-- </div> -->
          </div>
        <?php } 
        $noImg = base_url('assets/img/img-no-disponible.jpg');
        ?>
        <div class="row row cols-auto">
          <?php for ($i=0; $i < $data['fotos']; $i++) {
             $j = $i + 1;
             // $imagen = 'images/'."$path/".$data['id']."/foto".($j < 10 ? "0" : "") . "$j.png";
             // $imagen = 'images/'."$path/".$data['id']."/foto".($j<10?"0":"")."$j.png";
             // $imagen = base_url('images/'."$path/".$data['id']."/foto".($j<10?"0":"")."$j.png");
              $imagen = "/foto".($j < 10 ? "0" : "")."$j.png";
              $imagen = 'images/'."$path/".$data['id'].$imagen;
              $imagen = base_url ($imagen);
          ?>
            <div class="col mb-3">
            <a href="<?=$imagen?>">
              <input type="file" class="dropify" data-default-file="<?=$imagen?>" style="width: 80px;" />
            </a>
            </div>
          <?php } ?>
          <!-- <div class="col mb-3">
            <input type="file" class="dropify" data-default-file="<?=$noImg?>" />
          </div>
          <div class="col mb-3">
            <input type="file" class="dropify" data-default-file="<?=$noImg?>" />
          </div>
          <div class="col mb-3">
            <input type="file" class="dropify" data-default-file="<?=$noImg?>" />
          </div> -->
        </div>
      </div>
    </div>
  </form> 
</div>
<?php if ($validation) {?>
  <div class="alert alert-danger">
    <?= $validation->listErrors();?>
  </div>
<?php }?>

<script>
  console.log('script jalando');
  setupZoom();

  // $('.dropify').dropify();
</script>
