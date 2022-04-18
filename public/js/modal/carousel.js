function setAtt(nodo, attrName, attrVal) {
  const attrObj = document.createAttribute(attrName);
  attrObj. value = attrVal;
  nodo.setAttributeNode(attrObj);
}

function showPhotos(path, itemText, photoItems, itemInfo) {
  if ( !(photoItems) ) return;
  const itemImgs = photoItems.split("|");
  // if (itemImgs.length == 0 || !(photoItems) ) return;
  const title = document.getElementById("ModalCarouselLabel");
  title.innerHTML = itemText + itemInfo;
  const IG = 'itemsGallery';
  var vsCarousel = document.querySelector(IG);
  const indicators = $('#'+IG+' .carousel-indicators');
  const inners = $('#'+IG+' .carousel-inner');
  indicators.empty();
  inners.empty();
  for (let index = 0; index < itemImgs.length; index++) {
      const button = document.createElement('button');
      button.type  = 'button';
      setAtt (button, "data-bs-target", '#itemsGallery');
      setAtt (button, "data-bs-slide-to", index);
      setAtt (button, "aria-label", "Slide " + (index + 1));
      const div = document.createElement('div');
      div.classList.add("carousel-item");
      if (index == 0) {
        button.classList.add("active");
        setAtt (button, "aria-current", "true");
        div.classList.add("active");
      }
      const photo = document.createElement('img');
      photo.src = path + itemImgs[index];
      photo.classList.add("d-block");
      photo.classList.add("w-100");
      photo.alt = itemText + " - Foto";
      div.appendChild(photo);
      indicators.append(button);;
      inners.append(div);
  }
  var myModalPhotos = new bootstrap.Modal(
                          document.getElementById('ModalCarousel')
                            // , { keyboard: false }
  );
  myModalPhotos.toggle();
}
