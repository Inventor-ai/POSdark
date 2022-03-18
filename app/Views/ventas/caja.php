<?php
$venta_id = uniqid();
// $venta_id = '621326e697bae';
?>
<div class="row mt-4 mb-3">
  <div class="col-12 col-sm-8">
      <h4 class=""><?=$title?></h4>
  </div>
</div>

<form method="<?=$method?>" name="form_venta" id="form_venta" 
      action="<?=base_url()."/$path/$action"?>" autocomplete="off">
  <input type="hidden" id="venta_id" name="venta_id" value="<?=$venta_id?>">
  <div class="row">
    <div class="col-sm-6 mb-3">
      <div class="ui-widget">
        <label for="cliente" class="form-label">Cliente</label>
        <input type="text" class="form-control" id="cliente" value="Público en general" 
               placeholder="Nombre del cliente" autocomplete="off" required autofocus>
        <input type="hidden" id="cliente_id" name="cliente_id" value="1">
      </div>
    </div>
    <div class="col-sm-6 mb-3">
      <label for="cliente" class="form-label">Forma de pago</label>
      <select name="forma_pago" id="forma_pago" class="form-select" required>
          <option value="01">Efectivo</option>
          <option value="02">Tarjeta</option>
          <option value="03">Transferencia</option>
      </select>
    </div>
  </div>

  <div class="row">
    <div class="col-12 col-sm-4 mb-3">
      <label for="codigo" class="form-label">Código de barras</label>
      <label id="resultado_error" syle="color: red;" ></label>
      <input type="hidden" id="articulo_id" name="articulo_id">
      <input type="text" class="form-control" id="codigo" name="codigo" 
             placeholder="Escribe el código y enter" 
             >
             <!-- onkeyup="agregarArticulo(event, this.value, 1, '<?=$venta_id?>')"  -->
    </div>
    <div class="col-12 col-sm-2">
        <label for="cantidad" class="form-label">Cantidad</label>
        <input type="text" class="form-control text-end" name="cantidad" id="cantidad" value="1">
    </div>

    <div class="col-12 col-sm-6 text-center mt-4">
      <label style="font-weight: bold; font-size: 25px; text-align:center;">Total $</label>
      <input type="text" name="total" id="total" size="10" readonly value="0.00"
             style="font-weight: bold; font-size: 25px; text-align:center;">
    </div>

    <div class="col-3">
        <button type="button" onclick="ventaCompletar(event, this.value)" class="btn btn-success" id="completa_venta">Completar venta</button>
    </div>


    <div class="col-sm-3 mb-2">
      <label for="precio" class="form-label">Precio</label>
      <!-- <input type="text" class="form-control-plaintext" id="precio" name="codigo"  -->
      <input type="text" class="form-control text-end" id="precio" name="precio" 
             placeholder="Escribe el código y enter" 
             >
             <!-- onkeyup="buscarProducto(event, this, this.value)" -->
    </div>
    <div class="col-sm-6 mb-4">
      <label for="articulo" class="form-label">Nombre del artículo</label>
      <!-- <input type="text" class="form-control-plaintext" id="articulo" name="codigo"  -->
      <input type="text" class="form-control" id="articulo" name="articulo" 
             placeholder="Escribe el código y enter" 
             >
             <!-- onkeyup="buscarProducto(event, this, this.value)" -->
    </div>


  </div>
</form>
<div class="col-12 mt-3">
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
      console.log('compra_id:   ', venta_id);
      // if (articulo_id != null && compra_id != 0 && cantidad > 0) { // Sus validaciones
      if (cantidad > 0) {
          url = '<?=base_url()?>/comprastemporal/insertarVenta'
              + '/' + articulo_id 
              + '/' + cantidad
              + '/' + venta_id;
          console.log('url: ', url);
          $.ajax({
             url: url,
             // dataType: 'json',
             method: "post",
             success: function (resultado) {
               console.log('venta resultado: ', resultado);
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
  }
}

function runSales() {
  $('#cliente').autocomplete({
     source: "<?=base_url()."/clientes/autocompleteData"?>",
     minLength: 3,
     select: function (event, ui) {
       event.preventDefault();
       $('#cliente_id').val(ui.item.id);
       $('#cliente').val(ui.item.value);
    }
  });

  $('#codigo').autocomplete({
    source: "<?=base_url()."/articulos/autocompleteData"?>",
    minLength: 3,
    select: function (event, ui) {
      event.preventDefault();
      $('#codigo').val(ui.item.value);
      console.log('ui.item.value: ', ui.item.value);
      console.log('ui.item.id: ', ui.item.id);
      console.log('ui.item.label: ', ui.item.label);
      e = jQuery.Event("keypress");
      e.which = 13; // Simulando tecla enter
      agregarArticulo(e, ui.item.id, 1, <?="'$venta_id'"?>);
    //   agregarArticulo(e, ui.item.id, 1, '621326e697bae');
    }
  });
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

function ventaCompletar(e) {
  console.log('venta Completar e:', e);
//   console.log('venta Completar valor:', valor);
  let nFilas = $('#tablaArticulos tr').length;
  if (nFilas < 2) {
    //   alert('Agregar por lo menos un artículo');
  } else {
      $('#form_venta').submit();
    //   console.log('Completar venta form_venta submit');
  }

}
</script>