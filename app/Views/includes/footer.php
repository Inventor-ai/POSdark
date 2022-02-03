<?php
  $webSite = 'Virtual Army 5tore ' . date('Y');
?>
                  </div>
                </main>
                <div class="modal" tabindex="-1" id="confirmar">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                      <!-- <div class="modal-header text-white bg-danger"> -->
                      <!-- <div class="modal-header text-danger"> -->
                      <div class="modal-header">
                        <h5 class="modal-title">
                          <span id="confAction">Acción</span>
                          <span id="confItem">elemento</span>                          
                        </h5>
                        <!-- <h5 class="modal-title">Eliminar registro</h5> -->
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <!-- <div class="modal-body"> -->
                      <div class="modal-body text-center">
                        <!-- <span id="borrarInfo" class="mt-2"></span> -->
                        <!-- <p class="mt-2">¿Eliminar esto?</p> -->
                        <!-- <span id="borrarInfo"></span> -->
                        <!-- <p>¿Eliminar esto?</p> -->
                        <!-- <p class="text-danger">¿Eliminar esto?</p> -->
                        <!-- <p class="text-danger mt-2">¿Eliminar esto?</p> -->
                        <!-- <p class="text-danger mt-2">¿Continuar?</p> -->
                        <!-- <p class="text-danger mt-2">¿Proceder?</p> -->

                        <p>¿<span id="conf2Ask" class="mt-2">Eliminar</span> 
                            <span id="confInfo" class="mt-2"></span>
                           ?
                        </p>
                      </div>
                      <div class="modal-footer">
                        <a id="confHref" href="#" class="btn btn-danger">Si</a>
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">No</button>
                      </div>
                    </div>
                  </div>
                </div>

                
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
        <script src="<?=base_url()?>/js/modal/confirmar.js"></script>
         
        <script src="<?=base_url()?>/vendor/jquery/jquery.min.js"></script>
        <script>
           //
        </script>
        
    </body>
</html>
