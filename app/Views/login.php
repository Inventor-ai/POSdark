<?php
$session_user = session();
if ($session_user->nombre != null) {
    // return redirect()->to(base_url().'/configurar');
}
// var_dump($data);
  $tabTitle  = 'Top - SP';
  $webSite = 'Virtual Army 5tore ' . date('Y');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title><?= $tabTitle ?></title>
        <!-- <link href="css/styles.css" rel="stylesheet" /> -->
        <link href="<?=base_url()?>/css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <?php print_r($session_user->nombre)?>
        <?php var_dump ($session_user->nombre)?>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Iniciar sesión</h3></div>
                                    <div class="card-body">
                                        <form method="post" action="<?=base_url()."/usuarios/valida"?>">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="usuario" name="usuario" type="text" 
                                                       value="<?=isset($usuario)?$usuario:''?>" placeholder="Teclear usuario" />
                                                <label for="usuario">Usuario</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="password" name="password" type="password" 
                                                       value="<?=isset($password)?$password:''?>" placeholder="Teclear contraseña" />
                                                <label for="password">Contraseña</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button class="btn btn-primary" type="submit">Iniciar sesión</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer py-3">
                                        <!-- <div class="small"><a href="register.html">Need an account? Sign up!</a></div> -->
                                        <?php if (isset($validation)) {?>
                                           <div class="alert alert-danger">
                                             <?=$validation->listErrors();?>
                                           </div>
                                        <?php }?>
                                        <?php if (isset($error)) {?>
                                           <div class="alert alert-danger">
                                             <?=$error?>
                                           </div>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <!-- <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2021</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer> -->
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <!-- <script src="js/scripts.js"></script> -->
        <script src="<?=base_url()?>/js/scripts.js"></script>
    </body>
</html>
