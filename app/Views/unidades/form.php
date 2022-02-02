<!-- <h4 class="mt-4"><?=$titulo?></h4> -->
<div class="mb-3">
   <form method="<?=$method?>" action="<?=base_url()."/$ruta/$action"?>"
         autocomplete="off">
         <?php csrf_field();?>
    <!-- <a href="<?=base_url()."/$ruta"?>" class="btn btn-primary mb-3">Regresar</a>
    <button type="submit" class="btn btn-success mb-3">Guardar</button> -->
    <div class="row mt-4">
        <div class="col-12 col-sm-9">
            <h4 class=""><?=$titulo?></h4>
        </div>
        <div class="col-12 col-sm-3">
            <button type="submit" class="btn btn-success mb-3">Guardar</button>
            <a href="<?=base_url()."/$ruta"?>" class="btn btn-primary mb-3">Regresar</a>
        </div>
    </div>
     <input type="hidden" name="id" value="<?=$datos['id']?>">
     <div class="form-group">
       <div class="row">
         <div class="col-12 col-sm-6">
            <label class="mb-2" for="nombre">Nombre</label> 
            <input class="form-control" type="text" name="nombre" 
                   id="nombre" value="<?=$datos['nombre']?>" autofocus >
         </div>
         <div class="col-12 col-sm-6">
            <label class="mb-2" for="nombre_corto">Nombre corto</label> 
            <input class="form-control" type="text" name="nombre_corto" 
                   id="nombre_corto" value="<?=$datos['nombre_corto']?>" >
         </div>
       </div>
    </div>
    <!-- <a href="<?=base_url()."/$ruta"?>" class="btn btn-primary mt-3">Regresar</a>
    <button type="submit" class="btn btn-success mt-3">Guardar</button> -->
   </form> 
</div>
<div class="alert alert-danger">
  <?php 
    $xx = \Config\Services::validation()->listErrors();
    // echo "count ". count($xx);
    echo "json_encode ". json_encode($xx);
    echo "<br>xx $xx";
  ?>
  <?php //echo $validation->listErrors() ?>
</div>
