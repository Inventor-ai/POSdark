<?php

  echo "Fecha: " . date('Y-m-d') . " hora: " . date('H:i:s') . "<br>";
  var_dump($data);
  $caja   = $data['caja'];
  $arqueo = $data['arqueo'];
//   $monto  = $data['arqueo'];
  var_dump($caja);
  var_dump($arqueo);
//   return;
?>
Cierre de caja
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
    <input type="hidden" name="id" value="<?php //$data['id']?>">   
    
    <div class="form-group">
      <div class="row">
        <div class="col-12 col-md-6 mb-3">
          <label for="caja" class="form-label">Número de caja</label>
          <input type="text"  class="form-control" id="caja"
                 value="<?=$caja['caja']?>" name="caja" autofocus required>
        </div>
        <div class="col-12 col-md-6 mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text"  class="form-control" id="nombre" name="nombre"
                 value="<?=$caja['nombre']?>" required>
        </div>
        <div class="col-12 col-md-6 mb-3">
          <label for="monto_inicial" class="form-label">Monto inicial</label>
          <input type="text" class="form-control text-end" id="monto_inicial" 
                 value="<?=$arqueo['monto_inicial']?>" name="monto_inicial"  required>
        </div>
        <div class="col-12 col-md-6 mb-3">
          <label for="monto_final" class="form-label">Monto final</label>
          <input type="text" class="form-control text-end" id="monto_final" 
                 name="monto_final"  required>
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
        <div class="col-12 col-md-6 mb-3">
          <label for="total_ventas" class="form-label">Monto de ventas</label>
          <input type="text" class="form-control text-end" id="total_ventas" 
                 value="<?=$data['totalVentas']?>" name="total_ventas"  required>
        </div>
        <div class="col-12 col-md-6 mb-3">
          <label for="monto_final" class="form-label">Total de ventas</label>
          <input type="text" class="form-control text-end" id="monto_final" 
                 value="<?=$arqueo['monto_final']?>" name="monto_final"  required>
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
