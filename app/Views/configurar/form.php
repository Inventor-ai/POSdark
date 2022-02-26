<?php
  // echo json_decode($todo);
  // var_dump ($todo);
  // var_dump ($todo::'CodeIgniter\HTTP\IncomingRequest') );
  // foreach ($todo as $key => $value) {
  //   echo $key;
  //   echo $value;
  // }
  // var_dump ($data);
  // var_dump ($chks);
  // var_dump ($test);
?>
<div class="row">
  <form method="<?=$method?>" enctype="multipart/form-data" action="<?=base_url()."/$path/$action"?>" autocomplete="off">
    <?php csrf_field();?>
    <div class="row mt-4">
      <div class="col-12 col-sm-9">
         <h4 class=""><?=$title?></h4>
      </div>
      <div class="col-12 col-sm-3 text-end">
        <button type="submit" class="btn btn-success mb-3">Guardar</button>
      </div>
    </div>
    <div class="row mt-4">      
      <div class="form-group">
        <div class="row">
          <div class="col-12 col-sm-7">
             <label class="mb-2" for="tienda_nombre">Nombre del negocio o tienda</label> 
             <input class="form-control" type="text" name="tienda_nombre" id="tienda_nombre"
                    value="<?=isset($tienda_nombre)?$tienda_nombre:''?>" autofocus>
          </div>
          <!-- <div class="col-12 col-sm-2">
            <label class="mb-2" for="tienda_siglas">Alias</label> 
            <input class="form-control" type="text" name="tienda_siglas" id="tienda_siglas"
                   placeholder="Largo 12 máx." value="<?=isset($tienda_siglas)?$tienda_siglas:''?>">
          </div> -->
          <div class="col-12 col-sm-5">
            <label class="mb-2" for="tienda_rfc">RFC:</label> 
            <input class="form-control" type="text" name="tienda_rfc" id="tienda_rfc"
                   value="<?=isset($tienda_rfc)?$tienda_rfc:''?>">
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-4">      
      <div class="form-group">
        <div class="row">
          <div class="col-12 col-sm-2">
            <label class="mb-2" for="tienda_siglas">Alias</label> 
          </div>
          <div class="col-12 col-sm-2">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" role="switch" id="tienda_vincularchk" 
                     name="tienda_vincularchk" <?=isset($tienda_vincularchk)?($tienda_vincularchk == 1?'checked':''):''?>>
              <label class="form-check-label" for="tienda_vincularchk">Vincular con</label>
            </div>
          </div>
          <div class="col-12 col-sm-7">
            <label class="mb-2" for="tienda_pagweb">Página web</label>
          </div>
          <div class="col-12 col-sm-2">
            <!-- <label class="mb-2" for="tienda_siglas">Alias</label>  -->
            <input class="form-control" type="text" name="tienda_siglas" id="tienda_siglas"
                   placeholder="Largo 12 máx." value="<?=isset($tienda_siglas)?$tienda_siglas:''?>" >
          </div>
          <div class="col-12 col-sm-10">
            <input class="form-control" type="text" name="tienda_pagweb" id="tienda_pagweb"
                   value="<?=(isset($tienda_pagweb)?$tienda_pagweb:'')?>">
          </div>
        </div>
      </div>
    </div>
    <!-- 
    <div class="row mt-4">      
      <div class="form-group">
        <div class="row">
          <div class="col-12 col-sm-7">
            <label class="mb-2" for="tienda_webpage">Página web</label>
          </div>
          <div class="col-12 col-sm-3">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" disabled>
              <label class="form-check-label" for="flexSwitchCheckDefault">Vincular con</label>
            </div>
          </div>
          <div class="col-12 col-sm-2">
            <label class="mb-2" for="tienda_siglas">Alias</label> 
          </div>
          <div class="col-12 col-sm-10">
            <input class="form-control" type="text" name="tienda_webpage" id="tienda_webpage"
                   value="<?php //$tienda_webpage?>">
          </div>
          <div class="col-12 col-sm-2">
            <input class="form-control" type="text" name="tienda_siglas" id="tienda_siglas"
                   placeholder="Largo 12 máx." value="<?=isset($tienda_siglas)?$tienda_siglas:''?>">
          </div>
        </div>
      </div>
    </div>
    -->
    <div class="row mt-4">      
      <div class="form-group">
        <div class="row">
          <div class="col-12 col-sm-6">
            <label class="mb-2" for="tienda_email">Correo electrónico</label> 
            <input class="form-control" type="text" name="tienda_email" id="tienda_email"
                   value="<?=isset($tienda_email)?$tienda_email:''?>">
          </div>
          <div class="col-12 col-sm-6">
            <label class="mb-2" for="tienda_telefono">Número de teléfono</label> 
            <input class="form-control" type="text" name="tienda_telefono" id="tienda_telefono"
                   value="<?=isset($tienda_telefono)?$tienda_telefono:''?>">
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-4">      
      <div class="form-group">
        <div class="row">
          <div class="col-12 col-sm-6">
             <label class="mb-2" for="tienda_direccion">Domicilio del negocio o tienda</label> 
             <textarea class="form-control" name="tienda_direccion" id="tienda_direccion" 
              rows="3"><?=isset($tienda_direccion)?$tienda_direccion:''?></textarea>
          </div>
          <div class="col-12 col-sm-6">
             <label class="mb-2" for="ticket_leyenda">Ticket Leyenda</label> 
             <textarea class="form-control" name="ticket_leyenda" id="ticket_leyenda" 
              rows="3"><?=isset($ticket_leyenda)?$ticket_leyenda:''?></textarea>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-12 col-sm-6 mb-3">
          <label for="logotipo">Logotipo</label>
          <img src="" class="img-thumbnail" alt="Logotipo"
          width="200"
          >
          <input type="file" name="logotipo" id="logotipo" accept="image/png,.jpg">
          <p class="text-danger">Cargar imagen .png o .jpg de 150x150 pixeles</p>
          
        </div>
      </div>
    </div>
  </form> 
</div>
<?php if ($validation) {?>
  <div class="alert alert-danger">
    <?php 
    $xx = \Config\Services::validation()->listErrors();
    echo "$xx";
    // echo "count ". count($xx);
    // echo "json_encode ". json_encode($xx);
    // echo "<br>xx $xx";
    // echo $validation->listErrors();
    
    ?>
  </div>
<?php }?>
