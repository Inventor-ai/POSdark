<?php
var_dump($data);
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
            <input class="form-control" type="text" name="nombre" 
                   id="nombre" value="<?=$data['nombre']?>" autofocus required>
         </div>
         <div class="col-12 col-sm-6">
            <label class="mb-2" for="usuario">Usuario (email)</label> 
            <input class="form-control" type="text" name="usuario" 
                   id="usuario" value="<?=$data['usuario']?>" 
                   >
                   <!-- tmp p/desarrollo y pruebas de validación -->
                   <!-- required> -->
         </div>
       </div>
    </div>
     <div class="form-group mt-4">
       <div class="row">
         <div class="col-12 col-sm-6">
            <label class="mb-2" for="password">Constraseña</label> 
            <input class="form-control" type="text" name="password" 
                   id="password" value="<?=isset($data['password'])?$data['password']:''?>" 
                   >
                   <!-- tmp p/desarrollo y pruebas de validación -->
                   <!-- required> -->
         </div>
         <div class="col-12 col-sm-6">
            <label class="mb-2" for="repassword">Repetir contraseña</label> 
            <input class="form-control" type="text" name="repassword" 
                   id="repassword" value="<?=isset($data['repassword'])?$data['repassword']:''?>" 
                   >
                   <!-- tmp p/desarrollo y pruebas de validación -->
                   <!-- required> -->
         </div>
       </div>
    </div>
     <div class="form-group mt-4">
       <div class="row">
         <div class="col-12 col-sm-6">
            <label class="mb-2" for="caja_id">Caja</label> 
            <select class="form-select" id="caja_id" name="caja_id" 
            >
            <!-- tmp p/desarrollo y pruebas de validación -->
            <!-- required> -->
            <option value="">Seleccionar Caja</option>
            <?php foreach ($dataCajas as $key => $value) {?>
              <option value="<?=$value['id']?>" 
                <?=$value['id'] == $data['caja_id']? 'selected': ''?>>
                <?=$value['caja'].' '.$value['nombre']?>
              </option>
            <?php } ?>
            <select>
         </div>
         <div class="col-12 col-sm-6">
            <label class="mb-2" for="rol_id">Rol</label> 
            <select class="form-select" id="rol_id" name="rol_id" 
            >
            <!-- tmp p/desarrollo y pruebas de validación -->
            <!-- required> -->
            <option value="">Seleccionar Rol</option>
            <?php foreach ($dataRoles as $key => $value) {?>
              <option value="<?=$value['id']?>" 
                <?=$value['id'] == $data['rol_id']? 'selected': ''?>>
                <?=$value['nombre']?>
              </option>
            <?php } ?>
            <select>
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
