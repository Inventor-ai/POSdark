<?php
//  var_dump($data['permisos']);
//  var_dump($data['recursos']);
?>
<div class="mb-3">
   <form method="<?=$method?>" action="<?=base_url()."/$path/$action"?>" autocomplete="off">
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
    <input type="hidden" name="rol_id" value="<?=$data['idRol']?>">
    <?php
      foreach($data['recursos'] as $recurso) {
        $chkId = 'chk'.$recurso['id'];
        echo '<div class="form-check">
                <input class="form-check-input" type="checkbox" value="'.$recurso['id'].'"'.
                'name="permisos[]" id="'.$chkId.'" '.$recurso['checked'].'> <label class="form-check-label"'.
                ' for="'.$chkId.'"> '.$recurso['nombre'].'</label>
              </div>';
      }
    ?>
   </form>
</div>
<?php if ($validation) {?>
  <div class="alert alert-danger">
    <?php 
    // $xx = \Config\Services::validation()->listErrors();
    // echo "$xx";
    // echo "count ". count($xx);
    // echo "json_encode ". json_encode($xx);
    // echo "<br>xx $xx";
    echo $validation->listErrors();
    ?>
  </div>
<?php }?>
