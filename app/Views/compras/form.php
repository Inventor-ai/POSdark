<?php
$compra_id = uniqid();
// $compra_id = '620d0be806f94';
?>
<div class="mb-3">
  <form method="<?=$method?>" name="form_compra" id="form_compra" action="<?=base_url()."/$path/$action"?>"
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
          <input type="hidden" id="articulo_id" name="articulo_id" value="">
          <input type="hidden" id="compra_id" name="compra_id" value="<?=$compra_id?>">
          <label class="mb-2">Código</label> 
          <input class="form-control" type="text" name="codigo" id="codigo" autofocus 
                 placeholder="Escribir código y presionar enter" 
                 onkeyup="buscarArticulo(event, this, this.value)">
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
            <button class="btn btn-primary mt-4" type="button" onclick="agregarArticulo(articulo_id.value, 
                    cantidad.value, '<?=$compra_id?>', precio_compra.value)">Agregar artículo</button>
         </div>
       </div>
    </div>

    <div class="row mt-3">
      <table id="tablaArticulos" class="table table-border table-striped table-hover table-resposive table-sm tablaArticulos">
        <thead>
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
        <input type="text" name="totalBis" id="totalBis" size="6" readonly value="0.00"
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

function buscarArticulo01(e, tagCodigo, codigo) {
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
                      $("#articulo_id").val(resultado.datos.id);
                      $("#nombre").val(resultado.datos.nombre);
                      $("#cantidad").val(1);
                      $("#precio_compra").val(resultado.datos.precio_compra);
                      $("#subtotal").val(resultado.datos.precio_compra);
                      $("#cantidad").focus();
                  } else {
                      $("#articulo_id").val('');
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

function agregarProducto01(articulo_id, cantidad, compra_id, precio) {
// function agregarProducto(articulo_id, cantidad, compra_id) {
  console.log('articulo_id, cantidad, compra_id, precio');
  console.log(articulo_id, cantidad, compra_id, precio);
  if (articulo_id != null && compra_id != 0 && cantidad > 0) {
      url = '<?=base_url()?>/comprastemporal/insertar/' + articulo_id 
          + '/' + cantidad
          + '/' + $precio  // my own
          + '/' + compra_id;
          //  insertar($articulo_id, $cantidad, $precio, $compra_id)
       console.log('url: ', url);          
       /**/
        $.ajax({
          url: url,
          // dataType: 'json',
          method: "post",
          success: function (resultado) {
            console.log('resultado');
            console.log(resultado);
            /*  
                $("#resultado_error").html(resultado.error);
                if (resultado.existe) {
                    $("#articulo_id").val(resultado.datos.id);
                    $("#nombre").val(resultado.datos.nombre);
                    $("#cantidad").val(1);
                    $("#precio_compra").val(resultado.datos.precio_compra);
                    $("#subtotal").val(resultado.datos.precio_compra);
                    $("#cantidad").focus();
                } else {
                    $("#articulo_id").val('');
                    $("#nombre").val('');
                    $("#cantidad").val('');
                    $("#precio_compra").val('');
                    $("#subtotal").val('');
                }
            */     
          },
          error: function (errors) {
            console.log('errors: ', errors);
          }
        });

  }
}

function agregarProductoXX(articulo_id, cantidad, compra_id, precio) {
// (articulo_id, cantidad, precio, compra_id) {
  console.log('articulo_id: ', articulo_id);
  console.log('cantidad:    ', cantidad);
  console.log('precio:      ', precio);
  console.log('compra_id:   ', compra_id);

}



function buscarArticulo(e, tagCodigo, codigo) {
  const enterKey = 13;
  // console.log(e.code);
  // console.log(e.which);
  // if (codigo != '') {
      if (e.which == enterKey) {
          $.ajax({
            url: '<?=base_url()?>/articulos/buscarPorCodigo/' + codigo,
            dataType: 'json',
            method: "post",
            success: function (resultado) {
              console.log('resultado');
              console.log(resultado);
                  $("#resultado_error").html(resultado.error);
                  if (resultado.existe) {
                      $("#articulo_id").val(resultado.datos.id);
                      $("#nombre").val(resultado.datos.nombre);
                      $("#cantidad").val(1);
                      $("#precio_compra").val(resultado.datos.precio_compra);
                      $("#subtotal").val(resultado.datos.precio_compra);
                      $("#cantidad").focus();
                  } else {
                      $("#articulo_id").val('');
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
  // }
}

function agregarArticulo(articulo_id, cantidad, compra_id, precio) {
// function agregarArticulo(articulo_id, cantidad, compra_id) {
  console.log('articulo_id: ', articulo_id);
  console.log('cantidad:    ', cantidad);
  console.log('precio:      ', precio);
  console.log('compra_id:   ', compra_id);
  // if (articulo_id != null && compra_id != 0 && cantidad > 0) { // Sus validaciones
  if (cantidad > 0) {
      url = '<?=base_url()?>/comprastemporal/insertar'
          + '/' + articulo_id 
          + '/' + cantidad
          + '/' + precio  // my own
          + '/' + compra_id;
          //  insertar($articulo_id, $cantidad, $precio, $compra_id)
       console.log('url: ', url);          
       /**/
        $.ajax({
          url: url,
          // dataType: 'json',
          method: "post",
          success: function (resultado) {
            console.log('resultado: ', resultado);
            if (resultado == 0 ) {
              
            } else {
                var resp = JSON.parse(resultado);
                console.log('resp: ', resp);
                console.log('resp.datos: ', resp.datos);
                console.log('resp.total: ', resp.total);
                console.log('resp.error: ', resp.error);
                $('#tablaArticulos tbody').empty();
                $('#tablaArticulos tbody').append(resp.datos);
                $('#total').val(resp.total);
                // $("#codigo").val('');
                $("#articulo_id").val('');
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

function eliminarArticulo(articulo_id, compra_id, precio) {
// function agregarArticulo(articulo_id, cantidad, compra_id) {
  console.log('articulo_id: ', articulo_id);
  console.log('compra_id:   ', compra_id);
      url = '<?=base_url()?>/comprastemporal/eliminar'
          + '/' + articulo_id 
          + '/' + compra_id
          + '/' + precio;
      console.log('url: ', url);
        $.ajax({
          url: url,
          // dataType: 'json',
          // method: "post",
          success: function (resultado) {
            console.log('resultado: ', resultado);
            if (resultado == 0 ) {
              // $(tagCodigo).val();
            } else {
                var resp = JSON.parse(resultado);
                console.log('resp: ', resp);
                console.log('resp.datos: ', resp.datos);
                console.log('resp.total: ', resp.total);
                console.log('resp.error: ', resp.error);
                $('#tablaArticulos tbody').empty();
                $('#tablaArticulos tbody').append(resp.datos);
                $('#total').val(resp.total);
            }
          },
          error: function (errors) {
            console.error('errors: ', errors);
          }
        });
}

</script>
