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
        <script src="<?=base_url()?>/js/bootstrap.bundle.min.js"></script>
        <script src="<?=base_url()?>/js/scripts.js"></script>
        <script src="<?=base_url()?>/js/simple-datatables.js"></script>
        <script src="<?=base_url()?>/js/datatables-simple-demo.js"></script>
        <script src="<?=base_url()?>/js/modal/confirm.js"></script>
        <script src="<?=base_url()?>/js/vsutils.js"></script>
         
        <script src="<?=base_url()?>/vendor/jquery/jquery.min.js"></script>
        <script src="<?=base_url()?>/vendor/jquery-ui/jquery-ui.min.js"></script>

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
        </script>

<script>
// Scripts para ventas 
//   Autocompletar cliente
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

</script>


    </body>
</html>
