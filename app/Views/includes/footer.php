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
         
        <!-- <script src="<?=base_url()?>/vendor/jquery/jquery.min.js"></script> -->
        <script>
           //
        </script>
        
    </body>
</html>
