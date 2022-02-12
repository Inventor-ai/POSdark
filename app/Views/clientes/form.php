<div class="mb-3">
   <form method="<?=$method?>" action="<?=base_url()."/$path/$action"?>"
         autocomplete="off">
         <?php csrf_field();?>
    <div class="row mt-4">
        <div class="col-12 col-sm-9">
            <h4 class=""><?=$title?></h4>
        </div>
        <div class="col-12 col-sm-3">
            <button type="submit" class="btn btn-success mb-3">Guardar</button>
            <a href="<?=base_url()."/$path"?>" class="btn btn-primary mb-3">Regresar</a>
        </div>
    </div>
     <input type="hidden" name="id" value="<?=$data['id']?>">
     <div class="form-group">
       <div class="row">
         <div class="col-12 col-sm-6">
            <label class="mb-2" for="nombre">Nombre</label> 
            <input class="form-control" type="text" name="nombre" 
                   id="nombre" value="<?=$data['nombre']?>" autofocus required>
         </div>
         <div class="col-12 col-sm-6">
            <label class="mb-2" for="telefono">Teléfono</label> 
            <input class="form-control" type="text" name="telefono" 
                   id="telefono" value="<?=$data['telefono']?>">
         </div>
       </div>
       <div class="row">
         <div class="col-12 col-sm-6">
            <label class="mb-2" for="correo">Correo</label> 
            <input class="form-control" type="text" name="correo" 
                   id="correo" value="<?=$data['correo']?>">
         </div>
         <div class="col-12 col-sm-6">
            <label class="mb-2" for="direccion">Dirección</label> 
            <input class="form-control" type="text" name="direccion" 
                   id="direccion" value="<?=$data['direccion']?>">
         </div>
       </div>
    </div>
   </form> 
</div>
<div class="mt-4" style="padding: 10px 0px;">
  <?php if ($validation) {?>
   <div class="alert alert-danger">
     <?=$validation->listErrors()?>
     <!--      
     //  $xx = \Config\Services::validation()->listErrors();
     //  echo "$xx";
     // echo "count ". count($xx);
     // echo "json_encode ". json_encode($xx);
     // echo "<br>xx $xx";
     -->
   </div>
  <?php }?>
</div>
