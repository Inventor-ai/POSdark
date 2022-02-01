<?php
$runEngine = '/index.php'; // temporal
?>
<h4 class="mt-4"><?=$titulo?></h4>
<div class="mb-3">
   <form method="post" action="<?=base_url().$runEngine ?>/unidades/insertar"
         autocomplete="off">
     <div class="form-group">
       <div class="row">
         <div class="col-12 col-sm-6">
            <label class="mb-2" for="nombre">Nombre</label> 
            <input class="form-control" type="text" name="nombre" id="nombre" autofocus require>
          </div>
          
         <div class="col-12 col-sm-6">
            <label class="mb-2" for="nombre_corto">Nombre corto</label> 
            <input class="form-control" type="text" name="nombre_corto" id="nombre_corto" require>
          </div>
       </div>
    </div>
    <a href="<?=base_url().$runEngine?>/unidades" class="btn btn-primary mt-3">Regresar</a>
    <button type="submit" class="btn btn-success mt-3">Guardar</button>
   </form> 
</div>
