<?php

  $webSite = 'Virtual Army 5tore ' . date('Y');
?>
                  </div>
                </main>
                <?= $this->include('/includes/modal/confirm.php') ?>
                <footer class="py-4 bg-light mt-auto">
                  <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                      <div class="text-muted">Copyright &copy; <?= $webSite ?></div>
                      <div>
                        <a href="#">Privacy Policy</a>
                        &middot;
                        <a href="#">Terms &amp; Conditions</a>
                      </div>
                    </div>
                  </div>
                </footer>
            </div>
        </div>
        <script src="<?=base_url('js/bootstrap.bundle.min.js')?>"></script>
        <script src="<?=base_url('/js/scripts.js')?>"></script>
        <script src="<?=base_url()?>/js/simple-datatables.js"></script>
        <script src="<?=base_url()?>/js/datatables-simple-demo.js"></script>
        <script src="<?=base_url('js/modal/confirm.js')?>"></script>
        <script src="<?=base_url()?>/js/vsutils.js"></script>
         
        <script src="<?=base_url('js/jquery/jquery.min.js')?>"></script>
        <script src="<?=base_url('js/jquery-ui/jquery-ui.min.js')?>"></script>
        <script src="<?=base_url('js/dropify.min.js')?>"></script>
        
        <script>
// Script para compras
$(document).ready(function(){
  $('#completa_compra').click( function () {
     console.log('clicked');
     let nFila = $('#tablaArticulos tr').length;
     if (nFila < 2) {
          // 
     } else {
       $('#form_compra').submit();
     }
  })
});

// Scripts para ventas
  if (window.runSales) runSales();

  // // Scripts para articulos
  // if (window.setupZoom) setupZoom();

  // if (window.setupZoom) {
  //     console.log('setupZoom found');
  //   } else {
  //     console.log('setupZoom not found');
  //   }

        </script>

<script>
// Scripts para ventas
//   Autocompletar cliente
/*
$(function() {
  $('#cliente').autocomplete({
    source: "<?=base_url()."/clientes/autocompleteData"?>",
    minLength: 3,
    select: function (event, ui) {
       event.preventDefault();
       $('#cliente_id').val(ui.item.id);
       $('#cliente').val(ui.item.value);
    }
  });
});
*/


//   Autocompletar código artículo
/*
$(function() {
  $('#codigo').autocomplete({
    source: "<?=base_url()."/articulos/autocompleteData"?>",
    minLength: 3,
    select: function (event, ui) {
       event.preventDefault();
      //  $('#articulo_id').val(ui.item.id);
       $('#codigo').val(ui.item.value);
       console.log('ui.item.value: ', ui.item.value);
       console.log('ui.item.id: ', ui.item.id);
       console.log('ui.item.label: ', ui.item.label);
    //    setTimeout(() => {
      //  setTimeout(
      //    function () {
           e = jQuery.Event("keypress");
           e.which = 13; // Simulando tecla enter
          //  agregarArticulo(e, ui.item.id, 1, <?php //"'$venta_id'"?>);
           agregarArticulo(e, ui.item.id, 1, '621326e697bae');
      //    }
      //  );
      //  }, 1000);
      //  $('#codigo').val(ui.item.label);
    }
  });
});
*/
</script>


    </body>
</html>
