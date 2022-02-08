<?php
  // echo json_decode($todo);
  // var_dump ($todo);
  // var_dump ($todo::'CodeIgniter\HTTP\IncomingRequest') );
  // foreach ($todo as $key => $value) {
  //   echo $key;
  //   echo $value;
  // }
  // var_dump ($data);
?>
<div class="row">
  <form method="<?=$method?>" action="<?=base_url()."/$path/$action"?>" autocomplete="off">
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
          <div class="col-12 col-sm-6">
             <label class="mb-2" for="tienda_nombre">Nombre del negocio o tienda</label> 
             <input class="form-control" type="text" name="tienda_nombre" id="tienda_nombre"
                    value="<?=$tienda_nombre?>" required autofocus>
          </div>
          <div class="col-12 col-sm-6">
            <label class="mb-2" for="tienda_telefono">Número de teléfono</label> 
            <input class="form-control" type="text" name="tienda_telefono" id="tienda_telefono"
                   value="<?=$tienda_telefono?>" required>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-4">      
      <div class="form-group">
        <div class="row">
          <div class="col-12 col-sm-6">
            <label class="mb-2" for="tienda_rfc">RFC:</label> 
            <input class="form-control" type="text" name="tienda_rfc" id="tienda_rfc"
                   value="<?=$tienda_rfc?>" required>
          </div>
          <div class="col-12 col-sm-6">
            <label class="mb-2" for="tienda_email">Correo electrónico</label> 
            <input class="form-control" type="text" name="tienda_email" id="tienda_email"
                   value="<?=$tienda_email?>" required>
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
              rows="3"><?=$tienda_direccion?></textarea>
          </div>
          <div class="col-12 col-sm-6">
             <label class="mb-2" for="ticket_leyenda">Ticket Leyenda</label> 
             <textarea class="form-control" name="ticket_leyenda" id="ticket_leyenda" 
              rows="3"><?=$ticket_leyenda?></textarea>
          </div>
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
