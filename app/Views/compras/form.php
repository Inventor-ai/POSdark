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
    <div class="form-group">
      <div class="row">
        <div class="col-12 col-sm-4">
          <label class="mb-2" for="codigo">Código</label> 
          <input class="form-control" type="text" name="codigo" id="codigo" autofocus 
                 placeholder="Escriba el código y presione enter">
        </div>
        <div class="col-12 col-sm-4">
          <label class="mb-2" for="nombre">Nombre del producto</label> 
          <input class="form-control" type="text" name="nombre" id="nombre" disabled>
        </div>
        <div class="col-12 col-sm-4">
          <label class="mb-2" for="cantidad">Cantidad</label> 
          <input class="form-control" type="text" name="cantidad" id="cantidad">
        </div>
      </div>
    </div>
     <div class="form-group">
       <div class="row mt-3">
       <div class="col-12 col-sm-4">
            <label class="mb-2" for="precio_compra">Precio de compra</label> 
            <input class="form-control" type="text" name="precio_compra" id="precio_compra">
         </div>
         <div class="col-12 col-sm-4">
            <label class="mb-2" for="subtotal">Subtotal</label> 
            <input class="form-control" type="text" name="subtotal" id="subtotal" disabled>
         </div>
         <div class="col-12 col-sm-4 mt-2">
            <button class="btn btn-primary mt-4" type="submit">Agregar producto</button>
         </div>
       </div>
    </div>

    <div class="row mt-3">
      <table class="table table-striped table-hover table-resposive table-sm tablaProductos">
        <thead class="thead-dark">
           <th>#</th>
           <th>Código</th>
           <th>Nombre</th>
           <th>Precio</th>
           <th>Cantidad</th>
           <th>Total</th>
           <th width="1%"></th>
        </thead>
        <tbody></tbody>
      </table>
    </div>

    <div class="row">
      <div class="col-12 col-sm-7 offset-md-2">
        <label style="font-weight: bold; font-size: 30px; text-align:center;">Total $</label>
        <input type="text" name="total" id="total" size="7" readonly value="0.00"
               style="font-weight: bold; font-size: 30px; text-align:center;">
        <button type="button" class="btn btn-success" id="completa_compra">Completar compra</button>
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
