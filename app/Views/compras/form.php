<div class="mb-3">
  <!-- <form method="<?=$method?>" name="nuevaCompra" action="<?=base_url()."/$path/$action"?>" -->
  <form method="<?=$method?>" name="nuevaCompra"
         autocomplete="off">
         <?php csrf_field();?>
    <div class="row mt-4">
      <div class="col-12 col-sm-3">
        <h4 class=""><?=$title?></h4>
      </div>
      <div class="col-12 col-sm-5 text-center">
        <label style="font-weight: bold; font-size: 25px; text-align:center;">Total $</label>
        <input type="text" name="total" id="total" size="7" readonly value="0.00"
               style="font-weight: bold; font-size: 25px; text-align:center;">
        <!-- <button type="buttn" class="btn btn-success" id="completa_compra">Completar compra</button> -->
      </div>
      <div class="d-block d-ms-none d-md-none d-lg-none mt-4"></div>
      <div class="col-12 col-sm-4 text-center">
        <a href="<?=base_url()."/$path"?>" class="btn btn-primary mb-3">Regresar</a>
        <button type="button" class="btn btn-success mb-3">Completar compra</button>
      </div>
    </div>
    <hr>
    <div class="form-group">
      <div class="row">
        <div class="col-12 col-sm-4">
          <input type="hidden" id="id_producto" name="id_producto" value="">
          <label class="mb-2">Código</label> 
          <input class="form-control" type="text" name="codigo" id="codigo" autofocus 
                 placeholder="Escribir código y presionar enter" 
                 onkeyup="buscarProducto(event, this, this.value)">
          <label class="mt-1" for="codigo" id="resultado_error" style="color: red;"></label>
        </div>
        <div class="col-12 col-sm-8">
          <label class="mb-2" for="nombre">Nombre del producto</label> 
          <input class="form-control" type="text" name="nombre" id="nombre" disabled>
        </div>
      </div>
    </div>
     <div class="form-group">
       <div class="row mt-3">
        <div class="col-12 col-sm-3">
          <label class="mb-2" for="cantidad">Cantidad</label> 
          <input class="form-control text-end" type="text" name="cantidad" id="cantidad">
        </div>
       <div class="col-12 col-sm-3">
            <label class="mb-2" for="precio_compra">Precio de compra</label> 
            <input class="form-control text-end" type="text" name="precio_compra" id="precio_compra">
         </div>
         <div class="col-12 col-sm-3">
           <label class="mb-2" for="subtotal">Subtotal</label> 
           <div class="input-group">
             <span class="input-group-text">$</span>          
             <input type="text" class="form-control text-end" name="subtotal" id="subtotal" disabled>
           </div>
         </div>
         <div class="col-12 col-sm-3 mt-2">
            <button class="btn btn-primary mt-4" type="button">Agregar producto</button>
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
    <hr>
    <div class="row">
      <div class="col-12 col-sm-4 offset-md-4">
        <label style="font-weight: bold; font-size: 25px; text-align:center;">Total $</label>
        <input type="text" name="total" id="total" size="6" readonly value="0.00"
               style="font-weight: bold; font-size: 25px; text-align:center;">
      </div>
      <div class="col-12 col-sm-4" style="text-align: center;">
        <div class="d-block d-ms-none d-md-none d-lg-none mt-4"></div>
        <button type="button" class="btn btn-success mb-3" id="completa_compra">Completar compra</button>
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


<script>

function buscarProducto01(e, tagCodigo, codigo) {
  if (codigo != '') {
      if (e.code == 'Enter') {
          $.ajax({
            url: '<?=base_url()?>/articulos/buscarPorCodigo/' + codigo,
            dataType: 'json',
            method: "post",
            success: function (resultado) {
              console.log('resultado');
              console.log(resultado);
                  $("#resultado_error").html(resultado.error);
                  if (resultado.existe) {
                      $("#id_producto").val(resultado.datos.id);
                      $("#nombre").val(resultado.datos.nombre);
                      $("#cantidad").val(1);
                      $("#precio_compra").val(resultado.datos.precio_compra);
                      $("#subtotal").val(resultado.datos.precio_compra);
                      $("#cantidad").focus();
                  } else {
                      $("#id_producto").val('');
                      $("#nombre").val('');
                      $("#cantidad").val('');
                      $("#precio_compra").val('');
                      $("#subtotal").val('');
                  }
            },
            error: function (errors) {
              console.log('errors: ', errors);
            }
          });
      }
  }  
}

function buscarProducto(e, tagCodigo, codigo) {
  if (codigo != '') {
      if (e.code == 'Enter') {
          $.ajax({
            url: '<?=base_url()?>/articulos/buscarPorCodigo/' + codigo,
            dataType: 'json',
            method: "post",
            success: function (resultado) {
              console.log('resultado');
              console.log(resultado);
                  $("#resultado_error").html(resultado.error);
                  if (resultado.existe) {
                      $("#id_producto").val(resultado.datos.id);
                      $("#nombre").val(resultado.datos.nombre);
                      $("#cantidad").val(1);
                      $("#precio_compra").val(resultado.datos.precio_compra);
                      $("#subtotal").val(resultado.datos.precio_compra);
                      $("#cantidad").focus();
                  } else {
                      $("#id_producto").val('');
                      $("#nombre").val('');
                      $("#cantidad").val('');
                      $("#precio_compra").val('');
                      $("#subtotal").val('');
                  }
            },
            error: function (errors) {
              console.log('errors: ', errors);
            }
          });
      }
  }  
}

function agregarProducto(articulo_id, cantidad, compra_id, precio) {
// function agregarProducto(articulo_id, cantidad, compra_id) {
  if (articulo_id != null && compra_id != 0 && cantidad > 0) {
        $.ajax({
          url = '<?=base_url()?>/comprastemporal/insertar/' + articulo_id 
              + '/' + cantidad
              + '/' + $precio  // my own
              + '/' + compra_id;
              //  insertar($articulo_id, $cantidad, $precio, $compra_id)
          url: url,
          // dataType: 'json',
          method: "post",
          success: function (resultado) {
            console.log('resultado');
            console.log(resultado);
                $("#resultado_error").html(resultado.error);
                if (resultado.existe) {
                    $("#id_producto").val(resultado.datos.id);
                    $("#nombre").val(resultado.datos.nombre);
                    $("#cantidad").val(1);
                    $("#precio_compra").val(resultado.datos.precio_compra);
                    $("#subtotal").val(resultado.datos.precio_compra);
                    $("#cantidad").focus();
                } else {
                    $("#id_producto").val('');
                    $("#nombre").val('');
                    $("#cantidad").val('');
                    $("#precio_compra").val('');
                    $("#subtotal").val('');
                }
          },
          error: function (errors) {
            console.log('errors: ', errors);
          }
        });      
  }
}

</script>
