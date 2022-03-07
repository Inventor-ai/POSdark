<?php 
//   $this->include('./includes/footer.php'); // Works ok
?>
<div class="row mt-3">
  <div class="col-4">
    <div class="card text-white bg-primary mb-3" style="max-width: 16rem;">
      <!-- <div class="card-header">Total artículos</div> -->
      <div class="card-body">
        <p class="card-text">
          Total artículos: <?=$articulos?>
          <!-- <a href="<?=base_url('articulos')?>" 
             class="card-footer text-white">Ver detalles</a> -->
        </p>
      </div>
      <div class="card-footer"><a href="<?=base_url('articulos')?>" 
             class="card-footer text-white">Ver detalles</a>
      </div>
    </div>
  </div>

  <div class="col-4">
    <div class="card text-white bg-success mb-3" style="max-width: 16rem;">
      <!-- <div class="card-header">Total artículos</div> -->
      <div class="card-body">
        <p class="card-text">Ventas del día: <?=$ventas?></p>
        <p class="card-text">Importe: $<?=number_format($totalVentas, 2, '.', ",")?></p>
      </div>
      <div class="card-footer"><a href="<?=base_url('ventas')?>" 
             class="card-footer text-white">Ver detalles</a>
      </div>
    </div>
  </div>

  <div class="col-4">
    <div class="card text-white bg-danger mb-3" style="max-width: 16rem;">
      <!-- <div class="card-header">Total artículos</div> -->
      <div class="card-body">
        <p class="card-text">Artículos con stock mínimo: <?=$minimos?></p>
      </div>
      <div class="card-footer"><a href="<?=base_url('ventas')?>" 
             class="card-footer text-white">Ver detalles</a>
      </div>
    </div>
  </div>
</div>
