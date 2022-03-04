<!-- Modal -->
<div class="modal fade" id="ModalCarousel" tabindex="-1" aria-labelledby="ModalCarouselLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalCarouselLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="itemsGallery" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-indicators">
            <!-- <button type="button" data-bs-target="#itemsGallery" data-bs-slide-to="0" aria-label="Slide 1" class="active" aria-current="true"></button>
            <button type="button" data-bs-target="#itemsGallery" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#itemsGallery" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#itemsGallery" data-bs-slide-to="3" aria-label="Slide 4"></button>
            <button type="button" data-bs-target="#itemsGallery" data-bs-slide-to="4" aria-label="Slide 5"></button> -->
          </div>
          <div class="carousel-inner">
            <!-- <div class="carousel-item active">
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
            </div> -->
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#itemsGallery" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#itemsGallery" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

<script>
  //  setupZoom();
  function showPhotos(e, itemId, itemText, itemImgs) {
    if (itemImgs == 0) return;
    const title = document.getElementById("ModalCarouselLabel");
    title.innerHTML = itemText;
    const IG  = 'itemsGallery';
    const url = '<?=base_url('galleryPhotos/')?>';
    // console.log('clicked img: ', e);
    // console.log('clicked itemId:', itemId);
    // console.log('clicked itemText:', itemText);
    // console.log('clicked itemText:', itemImgs);
    var vsCarousel = document.querySelector(IG);;
    const ruta = "<?=base_url('images/articulos')?>";
    const path = ruta + '/' + itemId + '/foto';
    const indicators = $('#'+IG+' .carousel-indicators');
    const inners = $('#'+IG+' .carousel-inner');
    indicators.empty();
    inners.empty();
    for (let index = 0; index < itemImgs; index++) {
      // console.log(index);
      // const item = array[index];
      
      const button = document.createElement('button');
      button.type  = 'button';
      // button.data-bs-target   = "#itemsGallery";  // Not valid
      // const bsTgt = document.createAttribute("data-bs-target");
      // bsTgt. value = "#itemsGallery";
      // button.setAttributeNode(bsTgt);
      setAtt (button, "data-bs-target", '#itemsGallery');
      // $("#cabecera").attr("title","Cabecera de la página");
      // $(button).attr("data-bs-target",'#itemsGallery'); // Try later
      // button.data-bs-slide-to = index;
      // const bsSld = document.createAttribute("data-bs-slide-to");
      // bsSld. value = index;
      // button.setAttributeNode(bsSld);
      setAtt (button, "data-bs-slide-to", index);
      // button.aria-label   = "Slide " + (index + 1);   // Not valid
      // const aria = document.createAttribute("aria-label");
      // aria. value = "Slide " + (index + 1);
      // button.setAttributeNode(aria);
      setAtt (button, "aria-label", "Slide " + (index + 1));
      const div = document.createElement('div');
      div.classList.add("carousel-item");
      if (index == 0) {
        button.classList.add("active");
        // button.aria-current="true";
        setAtt (button, "aria-current", "true");
        div.classList.add("active");
      }
      /*
        <div class="carousel-item active">
          <img src="<?=base_url('images/articulos/foto01.jpg')?>" class="d-block w-100" alt="...">
        </div>
      */
      const photo = document.createElement('img');
      photo.src = path + (index < 10 ? '0':'') + (index + 1) + ".png";
      // photo.classList.add("d-block w-100");
      photo.classList.add("d-block");
      photo.classList.add("w-100");
      photo.alt = "Foto de " + itemText;
      div.appendChild(photo);
      // indicators.appendChild(button);
      indicators.append(button);
      // inners.appendChild(div);
      inners.append(div);
    }
    var myModalPhotos = new bootstrap.Modal(document.getElementById('ModalCarousel'), { keyboard: false })
    myModalPhotos.toggle();
  }

  function setAtt(nodo, attrName, attrVal) {
    const attrObj = document.createAttribute(attrName);
    attrObj. value = attrVal;
    nodo.setAttributeNode(attrObj);
  }
</script>
