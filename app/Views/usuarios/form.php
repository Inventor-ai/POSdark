<?php

/*
$overrule = ['password', 'repassword']; // clear these rules
// protected $refuseOn
// $disallow = [], 
$disallow = $overrule;
// $exception = 'noExceptions')

foreach ($disallow as $key => $value) {
  echo "disallows: $key => $value <br>";
}
// $disallow

var_dump($data);
echo "0: ";
echo isset($data['nombre']) ? $data['nombre'] . ' nombre':"010";
echo "<br>";
if (isset($data['nombre'])) {
  unset($data['nombre']);
}
echo "1: ";
echo isset($data['nombre'])?$data['nombre']:"w1w";
var_dump($data);
$demo = 1;
$demo = 2;
$demo = 0;
echo $demo ? "trueno: $demo":"falso: $demo";
// $data['nombre'] = "qq";
*/

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
                   id="nombre" value="<?=isset($data['nombre'])?$data['nombre']:''?>" autofocus required>
         </div>
         <div class="col-12 col-sm-6">
            <label class="mb-2" for="usuario">Usuario (email)</label> 
            <input class="form-control" type="text" name="usuario" 
                   id="usuario" value="<?=isset($data['usuario'])?$data['usuario']:''?>" 
                   required>
                   <!-- > -->
                   <!-- tmp p/desarrollo y pruebas de validación -->
         </div>
       </div>
    </div>
     <div class="form-group mt-4">
       <div class="row">
         <div class="col-12 col-sm-6">
            <label class="mb-2" for="password">Constraseña</label> 
            <input class="form-control" type="password" name="password" 
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
     <div class="form-group mt-4">
       <div class="row">
         <div class="col-12 col-sm-6">
            <label class="mb-2" for="caja_id">Caja</label> 
            <select class="form-select" id="caja_id" name="caja_id" 
            required>
            <!-- > -->
            <!-- tmp p/desarrollo y pruebas de validación -->
            <option value="">Seleccionar Caja</option>
            <?php foreach ($dataCajas as $key => $value) {?>
              <option value="<?=$value['id']?>" 
                <?=$value['id'] == (isset($data['caja_id'])?$data['caja_id']:'')? 'selected': ''?>>
                <?=$value['caja'].' '.$value['nombre']?>
              </option>
            <?php } ?>
            <select>
         </div>
         <div class="col-12 col-sm-6">
            <label class="mb-2" for="rol_id">Rol</label> 
            <select class="form-select" id="rol_id" name="rol_id" 
            required>
            <!-- > -->
            <!-- tmp p/desarrollo y pruebas de validación -->
            <option value="">Seleccionar Rol</option>
            <?php foreach ($dataRoles as $key => $value) {?>
              <option value="<?=$value['id']?>" 
                <?=$value['id'] == (isset($data['rol_id'])?$data['rol_id']:'')? 'selected': ''?>>
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
