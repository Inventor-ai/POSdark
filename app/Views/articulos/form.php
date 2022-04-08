<?php
// $imgExt = "jpg";
// var_dump($data);
?>
<link href="<?=base_url("css/dragdrop.css")?>" rel="stylesheet" />

<style>
</style>

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
    <!-- Ok - Original -->
    <div class="mt-2">
      <label class="form-label"  for="fotos">Imagen</label>
      <input class="form-control" type="file" id="fotos" name="fotos[]" accept="image/png,.jpg" multiple>
      <!-- <input class="form-control" type="file" id="fotos" name="fotos[]" accept="image/png,.jpg" multiple> -->
    </div>
    <!-- <p class="text-danger">Cargar imagen .png o .jpg de 150x150 pixeles</p> -->
    <!-- test group 0 -->
    <div class="row mt-3">
      <div class="col-11">
        <input class="form-control" type="file" id="fotos0" name="fotos[]" accept="image/png,.jpg" multiple>
      </div>
      <div class="col-1">
        <button type="button" class="btn btn-success">+</button>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-1">
        <button type="button" class="btn btn-danger">&times;</button>
      </div>  
      <div class="col-1">
        <label class="form-label"  for="fotos">1</label>
      </div>
      <div class="col-10">
        <input class="form-control" type="file" id="fotos1" name="fotos[]" accept="image/png,.jpg" multiple>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-2">
        <button type="button" class="btn btn-danger">&times;</button>
        <label class="form-label"  for="fotos">2</label>
      </div>
      <div class="col-10">
        <input class="form-control" type="file" id="fotos2" name="fotos[]" accept="image/png,.jpg" multiple>
      </div>
    </div>
    <!-- test group 1 -->
    <div class="row">
      <div class="col-10">
        <p class="text-danger">Cargar imagen .png o .jpg de 150x150 pixeles</p>
      </div>
      <div class="col-2 text-end">
        <button type="button" onClick="viewToggle()" class="btn btn-dark">
          <i class="fas fa-grip-horizontal view-toggle-btn"></i>
        </button>
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
    <hr> <!-- ¿Dejar esta línea? - Preguntar -->
    <div class="form-group mt-2">
      <div class="row row cols-auto">
      <!-- <div class="row row cols-auto" style="border: 2px solid"> -->
      <!-- <div class="row row cols-auto" style="border: #ced4da 1px solid"> -->
        <?php
         $fotos = explode('|', $data['fotos']);
         $items = count($fotos);
         var_dump($items);
         var_dump($fotos);
         foreach ($fotos as $key => $foto) {
            // var_dump($key);
            // var_dump($foto);
           $imagen = base_url ('images/'."$path/".$data['id']."/$foto");
        ?>
          <!-- <div class="col-12 col-lg-3 col-md-4 col-sm-6 text-center mt-3"> -->
          <!-- <div class="col-4 col-sm-6 col-md-4 col-lg-3 text-center mt-3"> -->
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 text-center mt-3 view-mode">
            <!-- <div class="col box" style="border: #26e18a 2px dashed;"> -->
              <!-- <div class="col box" style="border: #777 1px solid;"> -->
            <div class="col box">
              <button id="<?=$foto?>" type="button" class="btn btn-light position-relative item" draggable="true">
                <figure class="figure text-center">
                  <img src="<?=$imagen?>" draggable="false"
                          class="figure-img img-fluid rounded mt-3" alt="<?=$data['nombre']?> - Foto">
                  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark"
                          onClick="dropIt(event)" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i>
                  </span>
                  <!-- <figcaption class="figure-caption text-center"><?=$data['nombre']?></figcaption> -->
                  <figcaption class="figure-caption text-center"><?=$foto?></figcaption>
                  <!-- <figcaption class="figure-caption text-center">Cargada</figcaption> -->
                  <!-- <figcaption class="figure-caption text-center">Screenshot_20211217-004145_WhatsApp.jpg</figcaption> -->
                  <!-- <figcaption class="figure-caption text-center">Pendiente</figcaption> -->
                  <figcaption class="figure-caption text-danger">Pendiente</figcaption>
                  <figcaption class="figure-caption text-success">Cargada</figcaption>
                  <figcaption class="figure-caption text-primary">Cargada</figcaption>
                  <figcaption class="figure-caption text-center">Scr...app.jpg</figcaption>
                  <figcaption class="figure-caption text-center">Scr...app.jpeg</figcaption>
                  <figcaption class="figure-caption text-center">Screenshot_20211217-004145_WhatsApp.jpg</figcaption>
                  <input type="hidden" name="imgs[]" value="<?=$foto?>">
                </figure>
              </button>
              <!-- <div class="mb-2" style="border: #900 1px dashed;"></div> -->
            </div>
          </div>
        <?php }
        $noImg = base_url('assets/img/img-no-disponible.jpg');
        ?>
        <div class="mt-3"></div>
      </div>
    </div>

    <hr>
    <p>line 1</p>
    <div class="form-group mt-2">
      <div class="row row-cols-auto" >
        <?php for ($i=0; $i < $data['fotos']; $i++) {
          // $j = $i + 1;
          // $imagen = 'images/'."$path/".$data['id']."/foto".($j < 10 ? "0" : "") . "$j.png";
          // $imagen = 'images/'."$path/".$data['id']."/foto".($j<10?"0":"")."$j.png";
          // $imagen = base_url('images/'."$path/".$data['id']."/foto".($j<10?"0":"")."$j.png");
          //  $imagen = "/foto".($j < 10 ? "0" : "")."$j.png";

          //  $imagen = "/foto$i.png"; // old
          //  $imagen = "/foto$i";
          //  $imagen = 'images/'."$path/".$data['id'].$imagen;
          //  $imagen = base_url ($imagen);

           $imagen = base_url ('images/'."$path/".$data['id']."/foto$i");
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
        ?>
        <hr>
        <div class="row row cols-auto">
          <p>line 2</p>
          <?php for ($i=0; $i < $data['fotos']; $i++) {
            //  $j = $i + 1;
             // $imagen = 'images/'."$path/".$data['id']."/foto".($j < 10 ? "0" : "") . "$j.png";
             // $imagen = 'images/'."$path/".$data['id']."/foto".($j<10?"0":"")."$j.png";
             // $imagen = base_url('images/'."$path/".$data['id']."/foto".($j<10?"0":"")."$j.png");
              // $imagen = "/foto".($j < 10 ? "0" : "")."$j.png";

              // $imagen = "/foto$i.png"; // old
              // $imagen = "/foto$i";
              // $imagen = 'images/'."$path/".$data['id'].$imagen;
              // $imagen = base_url ($imagen);

              // $imagen = base_url ('images/'."$path/".$data['id']."/foto$i.jpg");
              $imagen = base_url ('images/'."$path/".$data['id']."/foto$i");
          ?>
            <div class="col-4 col-sm-2">
            <!-- <a href="<?=$imagen?>"> -->
              <input type="file" class="dropify" id="<?="file$i"?>"
                     data-default-file="<?=$imagen?>" style="width: 80px;" />
            <!-- </a> -->
            </div>
          <?php } ?>
        </div>
        <hr>
        <div class="row row cols-auto">
          <p>line 3</p>
          <?php for ($i=0; $i < $data['fotos']; $i++) {
            //  $j = $i + 1;
             // $imagen = 'images/'."$path/".$data['id']."/foto".($j < 10 ? "0" : "") . "$j.png";
             // $imagen = 'images/'."$path/".$data['id']."/foto".($j<10?"0":"")."$j.png";
             // $imagen = base_url('images/'."$path/".$data['id']."/foto".($j<10?"0":"")."$j.png");
              // $imagen = "/foto".($j < 10 ? "0" : "")."$j.png";

              // $imagen = "/foto$i.png";  // old
              // $imagen = "/foto$i";
              // $imagen = 'images/'."$path/".$data['id'].$imagen;
              // $imagen = base_url ($imagen);

              // $imagen = base_url ('images/'."$path/".$data['id']."/foto$i.jpg");
              $imagen = base_url ('images/'."$path/".$data['id']."/foto$i");
          ?>
            <div class="col mb-3">
            <a href="<?=$imagen?>">
              <input type="file" class="dropify" data-default-file="<?=$imagen?>" style="width: 80px;" />
            </a>
            </div>
          <?php } ?>
        </div>
        <div class="row row cols-auto">
          <p>line 4</p>
          <?php for ($i=0; $i < $data['fotos']; $i++) {
            //  $j = $i + 1;
             // $imagen = 'images/'."$path/".$data['id']."/foto".($j < 10 ? "0" : "") . "$j.png";
             // $imagen = 'images/'."$path/".$data['id']."/foto".($j<10?"0":"")."$j.png";
             // $imagen = base_url('images/'."$path/".$data['id']."/foto".($j<10?"0":"")."$j.png");
              // $imagen = "/foto".($j < 10 ? "0" : "")."$j.png";

              // $imagen = "/foto$i.png";  // old
              // $imagen = "/foto$i";
              // $imagen = 'images/'."$path/".$data['id'].$imagen;
              // $imagen = base_url ($imagen);

              // $imagen = base_url ('images/'."$path/".$data['id']."/foto$i.jpg");
              $imagen = base_url ('images/'."$path/".$data['id']."/foto$i");
          ?>
            <!-- <div class="col mb-3">
              <a href="<?=$imagen?>">
                <div class="dropify-wrapper touch-fallback has-preview">
                  <input type="file" class="dropify" data-default-file="<?=$imagen?>" style="width: 80px;" />
                </div>
              </a>
            </div> -->

            <div class="col mb-3">
              <div class="dropify-wrapper touch-fallback has-preview">
                <div class="dropify-message">
                  <span class="file-icon"><p>Drag and drop a file here or click</p></span>
                  <p class="dropify-error">Ooops, something wrong appended.</p>
                </div>
                <div class="dropify-loader" style="display: none;"></div>
                <div class="dropify-errors-container">
                  <ul></ul>
                </div>
                <input type="file" class="dropify" data-default-file="<?=$imagen?>" style="width: 80px;">
                <button type="button" class="dropify-clear">Remove</button>
                <div class="dropify-preview" style="display: block;">
                  <span class="dropify-render">
                    <a href="<?=$imagen?>">
                      <img src="<?=$imagen?>">
                    </a>
                  </span>
                  <div class="dropify-infos">
                    <div class="dropify-infos-inner">
                      <p class="dropify-filename">
                        <span class="file-icon"></span>
                        <span class="dropify-filename-inner">foto3.png</span>
                      </p>
                      <p class="dropify-infos-message">Drag and drop or click to replace</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>


          <?php } ?>
          <p>line 5</p>
        <!-- <div class="container"> -->
          <div class="row row cols-auto">
            <div class="col-12 col-md-3">
              <div class="col mb-3">
                <div class="row">
                  <img src="http://192.168.1.65/posci4/public/images/articulos/1/foto4.jpg" alt="Cargando imagen...">
                </div>
                <div class="row">
                  <div class="col">
                    span
                  </div>
                  <div class="col">boton</div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3">
              <div class="col mb-3">
                <div class="row">
                  <img class="img" src="http://192.168.1.65/posci4/public/images/articulos/1/foto4.jpg" alt="Cargando imagen...">
                </div>
                <div class="row">
                  <div class="col">
                    span
                  </div>
                  <div class="col">boton</div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3 col-sm-6 text-center">
              <div class="col mb-3">
                <div class="row">
                  <img class="img" src="http://192.168.1.65/posci4/public/images/articulos/1/foto4.jpg" alt="Cargando imagen...">
                </div>
                <div class="row">
                  <div class="col">
                    span
                  </div>
                  <div class="col">boton</div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3 col-sm-6 text-center">
              <div class="col mb-3">
                <div class="row">
                  <img class="img" src="http://192.168.1.65/posci4/public/images/articulos/1/foto4.jpg" alt="Cargando imagen...">
                </div>
                <div class="row">
                  <div class="col">
                    span
                  </div>
                  <div class="col">boton</div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3 col-sm-6 text-center">
              <div class="col mb-3">
                <div class="row">
                  <img class="img" src="http://192.168.1.65/posci4/public/images/articulos/1/foto4.jpg" alt="Cargando imagen...">
                </div>
                <div class="row">
                  <div class="col-8">
                    span
                  </div>
                  <div class="col-2 text-center">
                    <button class="btn btn-danger">Borrar</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3 col-sm-6 text-center">
              <div class="col mb-3">
                <div class="row">
                  <img class="img" src="http://192.168.1.65/posci4/public/images/articulos/1/foto4.jpg" alt="Cargando imagen...">
                </div>
                <div class="row">
                  <div class="col-8">
                    span
                  </div>
                  <div class="col-2 text-center">
                    <button class="btn btn-danger">Borrar</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3 col-sm-6 text-center">
              <div class="col mb-3">
                <div class="row">
                  <img class="img" src="http://192.168.1.65/posci4/public/images/articulos/1/foto4.jpg" alt="Cargando imagen...">
                </div>
                <div class="row">
                  <div class="col-10">
                    span
                  </div>
                  <div class="col-1">
                    <button class="btn btn-danger">&times</button>
                  </div>
                </div>1              </div>
            </div>
            <div class="col-12 col-md-3 col-sm-6 text-center">
              <div class="col mb-3" style="border: #777 1px solid;">
                <div class="row">
                  <!-- <a href="#" class="position-relative"> -->
                  <div class="position-relative">
                    <figure class="figure text-center">
                      <img src="http://192.168.1.65/posci4/public/images/articulos/1/foto4.jpg"
                           class="figure-img img-fluid rounded mt-3" alt="...">
                           <span class="position-absolute top-0 start-90 translate-middle badge bg-danger">
                            999+ <span class="visually-hidden">unread messages</span>
                           </span>
                      <figcaption class="figure-caption text-center">
                        A caption for the above image.
                        <button class="btn-danger">
                          &times
                        </button>
                      </figcaption>
                    </figure>
                  </div>
                  <!-- </a> -->
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3 col-sm-6 text-center">
              <div class="col mb-3" style="border: #777 1px solid;">
                <div class="row">
                  <figure class="figure text-center">
                    <button type="button" class="btn btn-light position-relative">
                      <img src="http://192.168.1.65/posci4/public/images/articulos/1/foto4.jpg"
                           class="figure-img img-fluid rounded mt-3" alt="...">
                      <span class="position-absolute top-0 start-100 translate-middle badge bg-danger"
                            onClick="badge(event)" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i>
                      </span>
                    </button>
                    <figcaption class="figure-caption text-center">
                      <span>
                        A caption for the above image.
                      </span>
                    </figcaption>
                  </figure>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3 col-sm-6 text-center">
              <div class="col mb-3" style="border: #777 1px solid;">
                <div class="row">
                  <figure class="figure text-center">
                    <button type="button" class="btn btn-light position-relative">
                      <img src="http://192.168.1.65/posci4/public/images/articulos/1/foto4.jpg"
                           class="figure-img img-fluid rounded mt-3" alt="...">
                      <span class="position-absolute top-0 start-100 translate-middle badge bg-warning"
                            onClick="badge(event)" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i>
                      </span>
                    </button>
                    <figcaption class="figure-caption text-center">
                      <span>
                        A caption for the above image.
                      </span>
                    </figcaption>
                  </figure>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3 col-sm-6 text-center">
              <div class="col mb-3" style="border: #777 1px solid;">
                <div class="row">
                  <figure class="figure text-center">
                    <button type="button" class="btn btn-light position-relative">
                      <img src="http://192.168.1.65/posci4/public/images/articulos/1/foto4.jpg"
                           class="figure-img img-fluid rounded mt-3" alt="...">
                      <span class="position-absolute top-0 start-100 translate-middle badge bg-success"
                            onClick="badge(event)" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i>
                      </span>
                    </button>
                    <figcaption class="figure-caption text-center">
                      <span>
                        A caption for the above image.
                      </span>
                    </figcaption>
                  </figure>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3 col-sm-6 text-center">
              <div class="col mb-3" style="border: #777 1px solid;">
                <!-- <div class="row"> -->
                  <button type="button" class="btn btn-light position-relative">
                    <figure class="figure text-center">
                      <img src="http://192.168.1.65/posci4/public/images/articulos/1/foto4.jpg"
                           class="figure-img img-fluid rounded mt-3" alt="...">
                      <span class="position-absolute top-0 start-100 translate-middle badge bg-dark"
                            onClick="badge(event)" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i>
                      </span>
                      <figcaption class="figure-caption text-center">
                        <span>
                          A caption for the above image.
                        </span>
                        A caption for the above image.
                      </figcaption>
                    </figure>
                  </button>
                <!-- </div> -->
              </div>
            </div>
            <div class="col-12 col-md-3 col-sm-6 text-center">
              <div class="col mb-3" style="border: #777 1px solid;">
                <div class="row">
                  <figure class="figure text-center">
                    <button type="button" class="btn btn-light position-relative">
                      <img src="http://192.168.1.65/posci4/public/images/articulos/1/foto4.jpg"
                           class="figure-img img-fluid rounded mt-3" alt="...">
                      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            onClick="badge(event)" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i>
                      </span>
                    </button>
                    <figcaption class="figure-caption text-center">
                      <span>
                        A caption for the above image.
                      </span>
                    </figcaption>
                  </figure>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3 col-sm-6 text-center">
              <div class="col mb-3" style="border: #777 1px solid;">
                <div class="row">
                  <figure class="figure text-center">
                    <button type="button" class="btn btn-light position-relative">
                      <img src="http://192.168.1.65/posci4/public/images/articulos/1/foto4.jpg"
                           class="figure-img img-fluid rounded mt-3" alt="...">
                      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning"
                            onClick="badge(event)" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i>
                      </span>
                    </button>
                    <figcaption class="figure-caption text-center">
                      <span>
                        A caption for the above image.
                      </span>
                    </figcaption>
                  </figure>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3 col-sm-6 text-center">
              <div class="col mb-3" style="border: #777 1px solid;">
                <div class="row">
                  <figure class="figure text-center">
                    <button type="button" class="btn btn-light position-relative">
                      <img src="http://192.168.1.65/posci4/public/images/articulos/1/foto4.jpg"
                           class="figure-img img-fluid rounded mt-3" alt="...">
                      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success"
                            onClick="badge(event)" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i>
                      </span>
                    </button>
                    <figcaption class="figure-caption text-center">
                      <span>
                        A caption for the above image.
                      </span>
                    </figcaption>
                  </figure>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3 col-sm-6 text-center">
              <div class="col mb-3" style="border: #777 1px solid;">
                <!-- <div class="row"> -->
                  <button type="button" class="btn btn-light position-relative">
                    <figure class="figure text-center">
                      <img src="http://192.168.1.65/posci4/public/images/articulos/1/foto4.jpg"
                           class="figure-img img-fluid rounded mt-3" alt="...">
                      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark"
                            onClick="badge(event)" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i>
                      </span>
                      <figcaption class="figure-caption text-center">
                        <span>
                          A caption for the above image.
                        </span>
                        A caption for the above image.
                      </figcaption>
                    </figure>
                  </button>
                <!-- </div> -->
              </div>
            </div>
          </div>
        <!-- </div>   -->
<button type="button" class="btn btn-light position-relative">
  <img src="http://192.168.1.65/posci4/public/images/articulos/1/foto4.jpg"
       class="figure-img img-fluid rounded mt-3" alt="...">
  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark"
        onClick="badge(event)" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i>
  </span>
</button>
<a href="#" class="btn btn-light position-relative mt-3">
  <img src="http://192.168.1.65/posci4/public/images/articulos/1/foto4.jpg"
       class="figure-img img-fluid rounded mt-3" alt="...">
  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark"
        onClick="badge(event)" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i>
  </span>
</a>
<a href="#" class="btn btn-warnig position-relative mt-3">
  mensajes
  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark"
        onClick="badge(event)" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i>
  </span>
</a>
<a href="#" class="btn btn-dark position-relative mt-3">
  mensajes
  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
     99+ <span class="visually-hidden">unread messages</span>
  </span>
</a>
<button mat-button class="position-relative mt-3">text
<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            99+ <span class="visually-hidden">unread messages</span>
                           </span>
</button>
<button class="position-relative mt-3">msg_send
<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            99+ <span class="visually-hidden">unread messages</span>
                           </span>
</button>

        <!-- </div> -->
        <p>line 6</p>
        
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
<!-- </script>
<script>
-->

  const imgSelected = document.querySelector('.imageSelect'),
      previewImagen = document.querySelector('.imageBox');

  // Escuchar cuando cambie
  imgSelected.addEventListener("change", () => {
    // Los archivos seleccionados, pueden ser muchos o uno
    const archivos = imgSelected.files;
    console.log(archivos);
    // Si no hay archivos salimos de la función y quitamos la imagen
    if (!archivos || !archivos.length) {
      //$imagenPrevisualizacion.src = "";
      console.log('Revisar efectos al guardar cambios');
      return;
    }
    //previewImagen
    for (i = 0; i < archivos.length; i++) {
     //const img = document.createElement('img');
     const img = document.createElement('IMG');
     const objectURL = URL.createObjectURL(archivos[i]);
     img.id = 'foto' + i ;
     img.src = objectURL;
     img.classList.add('item');
     img.setAttribute ('dragable', true);

     //const attr document.createAttribute('draggable');
     //attr.value = 'true';
     previewImagen.appendChild(img);
    }
    setDraggables();
  });

/* 
  function setDraggables() {
    const items = document.querySelectorAll('.item'),
      imgHolder = document.querySelector('.imageBox');
    console.log(imgHolder);
    items.forEach ( item => {
      item.addEventListener('dragstart', dragStart);
      item.addEventListener('dragend', dragEnd);
    });

  //  boxes.forEach ( box => {
  //    box.addEventListener('dragenter', dragEnter);
  //    //box.addEventListener('dragover', dragEnter); // t2
  //    box.addEventListener('dragover', dragOver);
  //    box.addEventListener('dragleave', dragLeave);
  //    box.addEventListener('drop', drop);
  //  });
   
   imgHolder.addEventListener('dragenter', dragEnter);
     //box.addEventListener('dragover', dragEnter); // t2
   imgHolder.addEventListener('dragover', dragOver);
   imgHolder.addEventListener('dragleave', dragLeave);
   imgHolder.addEventListener('drop', drop);
  }

 function dragStart(e) {
   e.dataTransfer.setData('text/plain', e.target.id);
   setTimeout( () => {
     e.target.classList.add('hide');
     console.log('dragStart: ', e);
     origen = e.target.parentElement; //
   }, 0);
 }

 function dragEnd(e) {
   e.preventDefault();
   const itemDragged = document.getElementById(e.target.id);
   itemDragged.classList.remove('hide');
 }

 function dragEnter(e) {
   e.preventDefault();
   e.target.classList.add('drag-over');
 }

 function dragOver(e) { // t1
   dragEnter(e);
 }

 function dragLeave(e) {
   e.target.classList.remove('drag-over');
 }

 var origen, destino;
 function drop(e) {
   //e.target.classList.remove('drag-over');
   dragLeave(e);
   const id = e.dataTransfer.getData('text/plain');
   // const itemDragged = document.getElementById(e.target.id);
   const itemDragged = document.getElementById(id);
  //  destino = e;
  //  console.log('drop - e:', e);
  //  console.log('drop - target:', e.target);
   //  if (destino.target.localName == 'div' )
   if (destino.target.nodeName == 'DIV' )
       e.target.appendChild(itemDragged);
 }
*/ 

</script>
<!-- change name and content to toggle mode -->
<!-- <script src="<?=base_url("js/dragdrop.js")?>"></script> -->
<script src="<?=base_url("js/dragdrop.js")?>"></script>
