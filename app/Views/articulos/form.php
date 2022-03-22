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
          // $j = $i + 1;
          // $imagen = 'images/'."$path/".$data['id']."/foto".($j < 10 ? "0" : "") . "$j.png";
          // $imagen = 'images/'."$path/".$data['id']."/foto".($j<10?"0":"")."$j.png";
          // $imagen = base_url('images/'."$path/".$data['id']."/foto".($j<10?"0":"")."$j.png");
          //  $imagen = "/foto".($j < 10 ? "0" : "")."$j.png";
           $imagen = "/foto$i.png";
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
        <hr>
        <div class="row row cols-auto">
          <p>line 2</p>
          <?php for ($i=0; $i < $data['fotos']; $i++) {
            //  $j = $i + 1;
             // $imagen = 'images/'."$path/".$data['id']."/foto".($j < 10 ? "0" : "") . "$j.png";
             // $imagen = 'images/'."$path/".$data['id']."/foto".($j<10?"0":"")."$j.png";
             // $imagen = base_url('images/'."$path/".$data['id']."/foto".($j<10?"0":"")."$j.png");
              // $imagen = "/foto".($j < 10 ? "0" : "")."$j.png";
              $imagen = "/foto$i.png";
              $imagen = 'images/'."$path/".$data['id'].$imagen;
              $imagen = base_url ($imagen);
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

              // $imagen = "/foto$i.png";
              // $imagen = 'images/'."$path/".$data['id'].$imagen;
              // $imagen = base_url ($imagen);

              $imagen = base_url ('images/'."$path/".$data['id']."/foto$i.png");
          ?>
            <div class="col mb-3">
            <a href="<?=$imagen?>">
              <input type="file" class="dropify" data-default-file="<?=$imagen?>" style="width: 80px;" />
            </a>
            </div>
          <?php } ?>
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

  function setDraggables() {
    const items = document.querySelectorAll('.item'),
    imgHolder = document.querySelector('.imageBox');
    console.log(imgHolder);
    items.forEach ( item => {
      item.addEventListener('dragstart', dragStart);
      item.addEventListener('dragend', dragEnd);
    });

   /*
   boxes.forEach ( box => {
     box.addEventListener('dragenter', dragEnter);
     //box.addEventListener('dragover', dragEnter); // t2
     box.addEventListener('dragover', dragOver);
     box.addEventListener('dragleave', dragLeave);
     box.addEventListener('drop', drop);
   });
   */
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
</script>
