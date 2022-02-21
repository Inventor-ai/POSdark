<?php
$venta_id = uniqid();
// $venta_id = '620d0be806f94';
?>
Ventas
<form method="<?=$method?>" name="form_venta" id="form_venta" 
      action="<?=base_url()."/$path/$action"?>" autocomplete="off">
  <input type="hidden" id="venta_id" name="venta_id" value="<?=$venta_id?>">
  <div class="row">
    <div class="col-sm-6 mb-3">
      <div class="ui-widget">
        <label for="cliente" class="form-label">Cliente</label>
        <input type="text" class="form-control" id="cliente" value="Público en general" 
               placeholder="Nombre del cliente" autocomplete="off" required autofocus
               >
               <!-- onkeyup="agregarCliente(event, this, this.value)" -->
        <input type="hidden" id="cliente_id" name="cliente_id" value="1">
      </div>
    </div>
    <div class="col-sm-6 mb-3">
      <label for="cliente" class="form-label">Forma de pago</label>
      <select name="forma_pago" id="forma_pago" class="form-select" required>
          <option value="001">Efectivo</option>
          <option value="002">Tarjeta</option>
          <option value="003">Transferencia</option>
      </select>
    </div>
  </div>

  <div class="row">
    <div class="col-12 col-sm-4 mb-3">
      <label for="codigo"  class="form-label">Código de barras</label>
      <input type="hidden" id="articulo_id" name="articulo_id">
      <input type="text" class="form-control" id="codigo" name="codigo" 
             placeholder="Escribe el código y enter" 
             onkeyup="agregarArticulo(event, this.value, 1, <?="'$venta_id'"?>)" >
    </div>
    <div class="col-sm-2">
        <label for="codigo" id="resultado_error" syle="color: red;" ></label>
    </div>

    <div class="col-12 col-sm-5 text-center mt-4">
      <label style="font-weight: bold; font-size: 25px; text-align:center;">Total $</label>
      <input type="text" name="total" id="total" size="7" readonly value="0.00"
             style="font-weight: bold; font-size: 25px; text-align:center;">
    </div>

    <div class="col-3">
        <button type="button" class="btn btn-success" id="completa_venta">Completar venta</button>
    </div>


    <div class="col-sm-6 mb-4">
      <label for="cliente" class="form-label">Nombre del artículo</label>
      <input type="text" class="form-control" id="codigo" name="codigo" 
             placeholder="Escribe el código y enter" 
             >
             <!-- onkeyup="buscarProducto(event, this, this.value)" -->
    </div>


  </div>
</form>
<div class="row mt-3">
  <table id="tablaArticulos" class="table table-bordered border-dark table-striped table-hover table-resposive table-sm tablaArticulos">
    <thead>
      <th>#</th>
      <th>Código</th>
      <th class="col-4">Nombre</th>
      <th class="col-1">Cantidad</th>
      <th>Precio</th>
      <th>Total</th>
      <th width="1%"></th>
    </thead>
    <tbody></tbody>
  </table>
</div>

<script>

function agregarArticulo(e, articulo_id, cantidad, venta_id) {
  if (e.which == 13) {      
      console.log('articulo_id: ', articulo_id);
      console.log('cantidad:    ', cantidad);
      console.log('compra_id:   ', compra_id);
      // if (articulo_id != null && compra_id != 0 && cantidad > 0) { // Sus validaciones
      if (cantidad > 0) {
          url = '<?=base_url()?>/comprastemporal/insertarVenta'
              + '/' + articulo_id 
              + '/' + cantidad
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
                    $("#precio_compra").val('');
                    $("#cantidad").val('');
                    $("#subtotal").val('');
                }
              },
              error: function (errors) {
                console.log('errors: ', errors);
              }
            });
      }
  } else {
      
  }
}

</script>