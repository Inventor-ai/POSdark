<div class="mb-3">
  <form method="<?=$method?>" action="<?=base_url()."/$path/$action"?>"
         autocomplete="off">
         <?php csrf_field();?>
    <div class="row mt-4">
      <div class="col-12 col-sm-9">
         <h4 class=""><?=$title?></h4>
      </div>
      <div class="col-12 col-sm-3">
         <button type="submit" class="btn btn-success mb-3">Guardar</button>
         <a href="<?=base_url()."/$path"?>" class="btn btn-primary mb-3">Regresar</a>
      </div>
    </div>
    <input type="hidden" name="id" value="<?=$data['id']?>">
    <!-- <div class="row mt-4">      
    </div> -->
    <div class="form-group">
      <div class="row">
        <div class="col-12 col-sm-6">
          <label class="mb-2" for="codigo">Código</label> 
          <input class="form-control" type="text" name="codigo" id="codigo"
                 value="<?= $data['codigo']?>" required autofocus>
        </div>
        <div class="col-12 col-sm-6">
           <label class="mb-2" for="nombre">Nombre</label> 
           <input class="form-control" type="text" name="nombre" id="nombre"
                  value="<?=$data['nombre']?>" required>
        </div>
      </div>
    </div>
    <div class="form-group mt-2">
      <div class="row">
        <div class="col-12 col-sm-6">
          <label class="mb-2" for="precio_venta">Precio de venta</label> 
          <input class="form-control" type="text" name="precio_venta" id="precio_venta"
                 value="<?= $data['precio_venta']?>" >
        </div>
        <div class="col-12 col-sm-6">
          <label class="mb-2" for="existencias">Existencias</label> 
          <input class="form-control" type="text" name="existencias" id="existencias"
                 value="<?=$data['existencias']?>" autofocus >
        </div>
      </div>
    </div>
    <div class="form-group mt-2">
      <div class="row">
        <div class="col-12 col-sm-6">
          <label class="mb-2" for="id_unidad">Unidad</label> 
          <select class="form-select"id="id_unidad" name="id_unidad" required>
             <option value="">Seleccionar Unidad</option>
             <?php foreach ($unidades as $value) {?>
                <option value="<?=$value['id']?>"
                  <?=($value['id'] == $data['id'] ? ' checked' :'' )?>
                >
                <?=$value['nombre']?></option>
             <?php }?>
          </select>
        </div>
        <div class="col-12 col-sm-6">
          <label class="mb-2" for="id_categoria">Categoría</label> 
          <select class="form-select" id="id_categoria" name="id_categoria" required>
             <option value="">Seleccionar Categoría</option>             
             <?php foreach ($categorias as $value) 
                echo '<option value="'.$value['id'].'">'.$value['nombre'].'</option>';
             ?>
          </select>
        </div>
      </div>
    </div>
    <div class="form-group mt-2">
      <div class="row">
        <div class="col-12 col-sm-6">
          <label class="mb-2" for="stock_minimo">Stock minimo</label> 
          <input class="form-control" type="text" name="stock_minimo" id="stock_minimo"
                 value="<?= $data['stock_minimo']?>" >
        </div>
        <div class="col-12 col-sm-6">
          <label class="mb-2" for="inventariable">Es inventariable</label> 
          <select class="form-select" name="inventariable" id="inventariable">
            <option value="1">Sí</option>
            <option value="0">No</option>
          </select>
        </div>
      </div>
    </div>
    <div class="form-group mt-2">
      <div class="row">
        <div class="col-12 col-sm-6">
          <label class="mb-2" for="precio_compra">Precio de compra</label> 
          <input class="form-control" type="text" name="precio_compra" id="precio_compra"
                 value="<?=$data['precio_compra']?>" autofocus >
        </div>
      </div>
    </div>
     <!-- 
    <div class="form-group mt-2">
      <div class="row">
        <div class="col-12 col-sm-6">
          <label class="mb-2" for="stock_minimo">Stock minimo</label> 
          <input class="form-control" type="text" name="stock_minimo" id="stock_minimo"
                 value="<?= $data['stock_minimo']?>" >
        </div>
      </div>
    </div>
     -->
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
