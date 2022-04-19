<link href="<?=base_url("css/dragdrop.css")?>" rel="stylesheet" />
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
           <a href="<?=base_url($path)?>" class="btn btn-primary mb-3">Regresar</a>
        </div>
    </div>
    <input type="hidden" name="id" value="<?=$data['id']?>">
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
    <?php if ($validation) {?>
      <div class="alert alert-danger">
        <?= $validation->listErrors();?>
      </div>
    <?php }?>
    
    <div class="row mt-3">
      <label class="form-label"  for="fotos">Fotos en el álbum: <span id="imgsCount">0</span></label>
      <!-- <div id="album" class="col-10 col-md-11"> -->
      <div id="album" class="col-12"></div>
      <div class="col-10 col-md-11">
        <button type="button" onclick="addPhotos()" class="col-12 btn btn-success" 
                title="Añadir más fotos">Agregar fotos</button>
      </div>
      <div class="col-2 col-md-1 text-end">
        <button type="button" onClick="viewToggle()" class="btn btn-dark" 
                title="Alternar vista tamaño de fotos">
          <i class="fas fa-grip-horizontal view-toggle-btn"></i>
        </button>
      </div>
    </div>
    <div class="row">
      <div class="col-10">
        <p class="text-danger">Cargar imagen .png o .jpg de 150x150 pixeles</p>
      </div>
      <div class="col-2 text-end">
        <button type="button" onClick="viewToggle()" class="btn btn-light">
          <i class="fas fa-grip-horizontal view-toggle-btn"></i>
        </button>
        <button type="button" onClick="viewToggle()">
          <i class="fas fa-grip-horizontal view-toggle-btn"></i>
        </button>
      </div>
    </div>
    <button type="button" onClick="viewToggle()" class="btn btn-dark">
      <i class="fas fa-grip-horizontal view-toggle-btn"></i>
    </button>
    <!--
    <div class="col-2 text-end">
      <button onClick="viewToggle()" class="btn btn-dark"><i class="fas fa-grip-horizontal"></i></button>
      <button onClick="viewToggle()" class="btn btn-dark"><i class="fas fa-expand"></i></button>
      <button onClick="viewToggle()" class="btn btn-light"><i class="fas fa-grip-horizontal"></i></button>
      <button onClick="viewToggle()" class="btn btn-light"><i class="fas fa-expand"></i></button>
      <button onClick="viewToggle()"><i class="fas fa-grip-horizontal"></i></button>
      <button onClick="viewToggle()"><i class="fas fa-expand"></i></button>
    </div>
    <button><i class="fas fa-search"></i></button>
    <button><i class="fas fa-search-plus"></i></button>
    <button><i class="fas fa-binoculars"></i></button>
    <button><i class="fas fa-random"></i></button>
    <button><i class="fas fa-arrows-alt-h"></i></button>
    <button><i class="fas fa-sign-language"></i></button>
    <button><i class="fas fa-expand-arrows-alt"></i></button>
    <button><i class="fas fa-expand"></i></button>
    <button><i class="fas fa-grip-horizontal"></i></button>
    <button><i class="fas fa-grip-vertical"></i></button>    
    <button><i class="fab fa-buromobelexperte"></i></button>
     -->
    <hr> <!-- <-- ¿Dejar esta línea? - Preguntar -->
    <div class="form-group mt-2">
      <div class="row row cols-auto">
        <?php
          $fotos  = [];
          $imagen = base_url('assets/img/img-no-disponible.jpg');
          if ( isset($data['fotos']) && $data['fotos'] != '' ) $fotos = explode('|', $data['fotos']);
          foreach ($fotos as $key => $foto) {
            $imagen = base_url ('images/'."$path/".$data['id']."/$foto");
        ?>
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 text-center mt-3 view-mode" data-new="false">
            <div class="col box">
              <button id="<?=$foto?>" type="button" class="btn btn-light position-relative item" draggable="true">
                <figure class="figure text-center">
                  <img src="<?=$imagen?>" draggable="false"
                       class="figure-img img-fluid rounded mt-3" alt="<?=$data['nombre']?> - Foto">
                  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark"
                        onClick="dropIt(event)" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i>
                  </span>
                  <figcaption class="figure-caption text-center">
                    <input type="text" class="form-control-plaintext text-center" name="imgs[]" readonly 
                           title="<?=$foto?>" value="<?=$foto?>">
                  </figcaption>
                  <figcaption class="figure-caption text-success">Guardada</figcaption>
                </figure>
              </button>
            </div>
          </div>
        <?php }
          $lastPos = "Última posición. Arrastrar y soltar aquí la que será la última foto";
          $lastPos = "";        
        ?>
        <div id="lastOne" class="col-12 col-sm-6 col-md-4 col-lg-3 text-center mt-3 view-mode">
          <div class="col box">
            <button id="holder" type="button" class="btn position-relative item" draggable="false">
              <figure class="figure text-center">
                <figcaption class="figure-caption text-center"><?=$lastPos?></figcaption>
                <img src="<?=$imagen?>" draggable="false" class="figure-img img-fluid rounded mt-3" style="opacity: 0;">
              </figure>
            </button>
          </div>
        </div>
        <div class="mt-3"></div>
      </div>
    </div>
    <hr>    
  </form> 
</div>
<?php if ($validation) {?>
  <div class="alert alert-danger">
    <?= $validation->listErrors();?>
  </div>
<?php }?>

<script src="<?=base_url("js/dragdrop.js")?>"></script>
