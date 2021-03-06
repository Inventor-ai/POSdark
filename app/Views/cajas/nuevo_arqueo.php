<?php
  echo "Fecha: " . date('Y-m-d') . " hora: " . date('H:i:s') . "<br>";
  var_dump($data);
?>
<div class="mb-3">
  <form method="<?=$method?>" action="<?=base_url("/$path/$action")?>"
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
        <div class="col-12 col-md-6 mb-3">
          <label for="caja" class="form-label">Número de caja</label>
          <input type="text"  class="form-control" id="caja"
                 value="<?=$data['caja']?>" name="caja" autofocus required>
        </div>
        <div class="col-12 col-md-6 mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text"  class="form-control" id="nombre" name="nombre"
                 value="<?=$data['nombre']?>" required>
        </div>
        <div class="col-12 col-md-6 mb-3">
          <label for="monto_inicial" class="form-label">Monto inicial</label>
          <input type="text" class="form-control text-end" id="monto_inicial" 
                 name="monto_inicial" required>
        </div>
        <div class="col-12 col-md-6 mb-3">
          <label for="folio" class="form-label">Folio inicial</label>
          <input type="text"  class="form-control" id="folio" name="folio"
                 value="<?=$data['folio']?>" required>
        </div>
        <div class="col-12 col-md-6 mb-3">
          <label for="fecha" class="form-label">Fecha inicial</label>
          <input type="date" class="form-control" id="fecha" name="fecha"
                 value="<?= date('Y-m-d')?>" required>
        </div>
        <div class="col-12 col-md-6 mb-3">
          <label for="hora" class="form-label">Hora</label>
          <input type="time" class="form-control" id="hora" name="hora"
                 value="<?= date('H:i:s')?>" required>
        </div>
      </div>
    </div>
  </form> 
</div>
<?php if ($validation) {?>
  <div class="alert alert-danger">
    <?=$validation->listErrors()?>
  </div>
<?php }?>
