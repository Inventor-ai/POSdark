<?php
if (isset($posted)) var_dump($posted);

?>
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
            <input class="form-control" type="text"
                   id="nombre" value="<?=isset($data['nombre'])?$data['nombre']:''?>" 
                   >
                   <!-- readonly> -->
         </div>
         <div class="col-12 col-sm-6">
            <label class="mb-2" for="usuario">Usuario (email)</label> 
            <input class="form-control" type="text"
                   id="usuario" value="<?=isset($data['usuario'])?$data['usuario']:''?>" 
                   >
                   <!-- required> -->
                   <!-- tmp p/desarrollo y pruebas de validación -->
         </div>
       </div>
    </div>
     <div class="form-group mt-4">
       <div class="row">
         <div class="col-12 col-sm-6">
            <label class="mb-2" for="password">Constraseña</label> 
            <input class="form-control" type="password" name="password" autofocus
                   id="password" value="<?=isset($data['password'])?$data['password']:''?>" 
                   <?=$data['id']==''?'required':''?>>
         </div>
         <div class="col-12 col-sm-6">
            <label class="mb-2" for="repassword">Repetir contraseña</label> 
            <input class="form-control" type="password" name="repassword" 
                   id="repassword" value="<?=isset($data['repassword'])?$data['repassword']:''?>" 
                   <?=$data['id']==''?'required':''?>>
         </div>
       </div>
    </div>
   </form> 
</div>
<?php if ($validation) {?>
  <div class="alert alert-danger">
    <?php 
    // $xx = \Config\Services::validation()->listErrors();
    // echo "$xx";
    // echo "count ". count($xx);
    // echo "json_encode ". json_encode($xx);
    // echo "<br>xx $xx";
    echo $validation->listErrors();
    ?>
  </div>
<?php }?>
