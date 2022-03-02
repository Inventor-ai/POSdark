<div class="row mt-4">
  <div class="col-12 col-sm-8">
      <h4 class=""><?=$title?></h4>
  </div>
  <div class="col-12 col-sm-4 text-right" style="text-align:right">
    <a href="<?=base_url()."/$path/index/".($onOff == 0?"1":"0")?>" class="btn btn-warning"><?=$switch?></a>
    <?php if ($onOff) {?>
      <a href="<?=base_url()."/$path/agregar"?>" class="btn btn-primary">Agregar</a>
    <?php } ?>
  </div>
</div>

<div class="mt-3">
  <table id="datatablesSimple">
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Foto</th>
        <th>Precio</th>
        <th>Unidad</th>
        <th>Existen</th>
        <th>Categoría</th>
        <th>Código</th>
        <th>Precio compra</th>
        <th class="text-center">Acciones</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <th>Nombre</th>
        <th>Foto</th>
        <th>Precio</th>
        <th>Unidad</th>
        <th>Existen</th>
        <th>Categoría</th>
        <th>Código</th>
        <th>Precio compra</th>
        <th class="text-center">Acciones</th>
      </tr>
    </tfoot>
    <tbody>
      <?php foreach($data as $dato) {?>
        <tr>
          <td><?=$dato['nombre']?></td>
          <td class="text-end">
            <img src="<?=base_url('images/articulos/foto01.jpg')?>" 
                 style="width: 100px;" 
                 onclick="showPhotos(event)"
                 alt="...">
            <!-- class="d-block w-100" -->
          </td>
          <td class="text-end"><?=$dato['precio_venta']?></td>
          <td><?=$dato['id_unidad']?></td>
          <td ><?=$dato['existencias']?></td>
          <td><?=$dato['id_categoria']?></td>
          <td><?=$dato['codigo']?></td>
          <td class="text-end"><?=$dato['precio_compra']?></td>
          <?php if ($onOff) {?>
            <td class="text-center">
              <a href="#confirm" data-bs-toggle="modal"
                 data-info="<?=$dato['nombre']?>" data-item="<?=$item?>"
                 data-href="<?=base_url()."/$path/eliminar/".$dato['id']?>"
                 data-actionText="<?=$delete?>" class="btn btn-danger">
                <i class="fas fa-trash"></i>
              </a>
              <a href="<?=base_url()."/$path/editar/".$dato['id']?>"
                class="btn btn-success"><i class="fas fa-pencil-alt"></i>
              </a>
            </td>
          <?php } else {?>
            </td>
            <td class="text-center">
              <a href="#confirm" data-bs-toggle="modal"
                 data-info="<?=$dato['nombre']?>" data-item="<?=$item?>"
                 data-href="<?=base_url()."/$path/recuperar/".$dato['id']?>"
                 data-actionText="<?=$recover?>"
                 class="btn btn-warning">
                 <i class="fas fa-undo"></i>
              </a>
            </td>
          <?php } ?>
        </tr>  
      <?php }?>
    </tbody>
  </table>
</div>

<!-- Modal -->
<div class="modal fade" id="ModalCarousel" tabindex="-1" aria-labelledby="ModalCarouselLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalCarouselLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="itemsIndicators" class="carousel carousel-dark slide" data-bs-ride="carousel">
          <div class="carousel-indicators">
            <button type="button" data-bs-target="#itemsIndicators" data-bs-slide-to="0" aria-label="Slide 1" class="active" aria-current="true"></button>
            <button type="button" data-bs-target="#itemsIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#itemsIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#itemsIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
            <button type="button" data-bs-target="#itemsIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
          </div>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="<?=base_url('images/articulos/foto01.jpg')?>" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="<?=base_url('images/articulos/foto02.jpg')?>" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="<?=base_url('images/articulos/foto03.jpg')?>" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="<?=base_url('images/articulos/foto04.jfif')?>" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="<?=base_url('images/articulos/foto05.jfif')?>" class="d-block w-100" alt="...">
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#itemsIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#itemsIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script>
  function showPhotos(e) {
    console.log('clicked img',  e);
    // Buscar las fotos en el directorio del articulo
    // Generar el html para el carrusel
    // Abrir el carrusel
    var myModalPhotos = new bootstrap.Modal(document.getElementById('ModalCarousel'), { keyboard: false })
    myModalPhotos.toggle();
    // $('#tablaArticulos tbody').empty();
    // $('#tablaArticulos tbody').append(resp.datos);

  }
</script>
