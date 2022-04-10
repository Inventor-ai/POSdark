
 function viewThumbs() {
   const vwTg = document.getElementsByClassName('view-toggle-btn');
   return (vwTg[0].className.baseVal.indexOf('expand') < 0);
 }
  
   // design: 18  produccion: 8
 function viewToggle() { 
   const modes = ['fa-grip-horizontal', 'fa-expand'];
   const vwTg = document.getElementsByClassName('view-toggle-btn');
    //  const modes = viewModes();
    //  const vwTg = document.getElementsByClassName(viewToggleButton());
    /*
     var modeSwitch;
     for (let index = 0; index < vwTg.length; index++) {
      //  const element = vwTg[index];
      modeSwitch = vwTg[index].className.baseVal.indexOf(modes[0]) < 0;
      if (modeSwitch) {
         vwTg[index].classList.remove(modes[1]);
         vwTg[index].classList.add(modes[0]);
      } else {
         vwTg[index].classList.remove(modes[0]);
         vwTg[index].classList.add(modes[1]);
      }
      // vwTg[index].classList.remove(modes[modeSwitch?0:1]);
      // vwTg[index].classList.add(modes[modeSwitch?1:0]);
      console.log('modeSwitch 1: ', modeSwitch, modes[0], modes[1], vwTg[index].className.baseVal);
     }
    */
    // Ok - 0
   modeSwitch = vwTg[0].className.baseVal.indexOf(modes[0]) < 0;
   // modeSwitch = viewThumbs();
   vwTg[0].classList.remove(modes[modeSwitch?1:0]);
   vwTg[0].classList.add(modes[modeSwitch?0:1]);
   // console.log(modeSwitch);
   // Ok - 1
   //  viewMode(modeSwitch);
    viewMode();
 }
  
 function ViewModeFrame() {
   return 'view-mode';
 }
  
 function viewMode() {
   //  const modeSetView = viewItems();
   const thumbs = viewThumbs();
   //  const modeSetView = document.getElementsByClassName('view-mode');
   // const expand = ['col-12', 'col-sm-6', 'col-md-4', 'col-lg-3'];
   // const shrink = ['col-4' , 'col-sm-3', 'col-md-3', 'col-lg-2'];
   const modeSetView = document.getElementsByClassName(ViewModeFrame());
   for (let frame = 0; frame < modeSetView.length; frame++) {
      const element = modeSetView[frame];
      viewModeItem(element, thumbs);
       /*
       changeMode = element.className.indexOf(thumbs ? expand[0] : shrink[0]) < 0;
       if (changeMode) 
          for (let i = 0; i < expand.length; i++) {
               element.classList.add(    thumbs ? expand[i] : shrink[i]);
               element.classList.remove( thumbs ? shrink[i] : expand[i]);
          }
       */   
   }
 }
  
    //  test default paraeter in javaScript
 function viewModeItem(element, thumbs) {
  //  function viewModeItem(element, isNew = 0) {
    //  const modeSetView = viewItems();
    //  const modeSetView = document.getElementsByClassName(ViewMode);
  
    //  const thumbs = viewThumbs(); // <- Call it whennew addded
   const expand = ['col-12', 'col-sm-6', 'col-md-4', 'col-lg-3'];
   const shrink = ['col-4' , 'col-sm-3', 'col-md-3', 'col-lg-2'];
    //  for (let frame = 0; frame < modeSetView.length; frame++) {
      //  const element = modeSetView[frame];
   if (element.className.indexOf(ViewModeFrame()) < 0) element.classList.add(ViewModeFrame());   
   changeMode = element.className.indexOf(thumbs ? expand[0] : shrink[0]) < 0;
   if (changeMode) 
      for (let i = 0; i < expand.length; i++) {
           element.classList.add(    thumbs ? expand[i] : shrink[i]);
           element.classList.remove( thumbs ? shrink[i] : expand[i]);
      }
 }

//  var origen, destino;
 function dropIt(e) {
   var box = e.target.parentNode.nodeName;
   if (e.target.nodeName == 'path')
       box = e.target.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
   else if (e.target.nodeName == 'svg')
       box = e.target.parentNode.parentNode.parentNode.parentNode.parentNode;
   else if (e.target.nodeName == 'SPAN')
       box = e.target.parentNode.parentNode.parentNode.parentNode;
   box.remove();
   //e.target.parentElement.parentElement.parentElement.parentElement.parentElement.remove()
 }
  
  //  function t(p1, p2 = 10) {
  //    console.log(p1, p2);
  //  }
  
  // called by viewToggle
  //  function viewItems() {
  //    return document.getElementsByClassName('view-mode');
  //  }
  
  
  // function viewModes() {
  //   return ['fa-grip-horizontal', 'fa-expand'];
  // }
  
  // function viewToggleButton() {
  //   return 'view-toggle-btn';
  // }
  
  //  function viewFrame(params) {   
  //  }
  
  // **************************************************************//

/*
 function viewModeOk() {
  //  const modeSetView = viewItems();
   const thumbs = viewThumbs();
  //  const modeSetView = document.getElementsByClassName('view-mode');
   const modeSetView = document.getElementsByClassName(ViewMode);
   const expand = ['col-12', 'col-sm-6', 'col-md-4', 'col-lg-3'];
   const shrink = ['col-4' , 'col-sm-3', 'col-md-3', 'col-lg-2'];
   for (let frame = 0; frame < modeSetView.length; frame++) {
     const element = modeSetView[frame];
     changeMode = element.className.indexOf(thumbs ? expand[0] : shrink[0]) < 0;
     if (changeMode) 
        for (let i = 0; i < expand.length; i++) {
             element.classList.add(    thumbs ? expand[i] : shrink[i]);
             element.classList.remove( thumbs ? shrink[i] : expand[i]);
        }
   }
 }
*/

/*
 // Src: 44  Done: 38
 function viewToggleOkSrc() { // Ok - First one
   const modes = ['fa-grip-horizontal', 'fa-expand'];
   const vwTg = document.getElementsByClassName('view-toggle-btn');
   var modeSwitch;
   const modeSetView = viewItems();
   for (let index = 0; index < vwTg.length; index++) {
    modeSwitch = vwTg[index].className.baseVal.indexOf(modes[0]) < 0;
    if (modeSwitch) {
       vwTg[index].classList.remove(modes[1]);
       vwTg[index].classList.add(modes[0]);
    } else {
       vwTg[index].classList.remove(modes[0]);
       vwTg[index].classList.add(modes[1]);
    }
   }
   for (let index = 0; index < modeSetView.length; index++) {
     if (modeSwitch) {
      modeSetView[index].classList.add('col-12');      // xs
      modeSetView[index].classList.add('col-sm-6');    // sm
      modeSetView[index].classList.add('col-md-4');    // md
      modeSetView[index].classList.remove('col-4');    // xs
      modeSetView[index].classList.remove('col-sm-3'); // sm
      modeSetView[index].classList.remove('col-md-3'); // md
      modeSetView[index].classList.add('col-lg-3');
      modeSetView[index].classList.remove('col-lg-2');
     } 
     else {
      modeSetView[index].classList.add('col-4');       // xs
      modeSetView[index].classList.add('col-sm-3');    // sm
      modeSetView[index].classList.add('col-md-3');    // md
      modeSetView[index].classList.remove('col-12');   // xs  
      modeSetView[index].classList.remove('col-sm-6'); // sm
      modeSetView[index].classList.remove('col-md-4'); // md
      modeSetView[index].classList.add('col-lg-2');
      modeSetView[index].classList.remove('col-lg-3');
     }
   }
 }
*/

// var src;
// var origen, destino;

 function setDraggables() {
    const items = document.querySelectorAll('.item'),
          boxes = document.querySelectorAll('.box');
    //   imgHolder = document.querySelector('.box');
    // console.log(imgHolder);
    items.forEach ( item => {
      item.addEventListener('dragstart', dragStart);
      item.addEventListener('dragend', dragEnd);
    });

   /**/
   boxes.forEach ( box => {
     box.addEventListener('dragenter', dragEnter);
     //box.addEventListener('dragover', dragEnter); // t2
     box.addEventListener('dragover', dragOver);
     box.addEventListener('dragleave', dragLeave);
     box.addEventListener('drop', drop);
   });
   
//    imgHolder.addEventListener('dragenter', dragEnter);
//      //box.addEventListener('dragover', dragEnter); // t2
//    imgHolder.addEventListener('dragover', dragOver);
//    imgHolder.addEventListener('dragleave', dragLeave);
//    imgHolder.addEventListener('drop', drop);
 }

  const photoScroll = 1;
  function dragStart(e) {
   e.dataTransfer.setData('text/plain', e.target.id);
   setTimeout( () => {
   if (photoScroll) 
      e.target.parentNode.parentNode.classList.add('hide');
   else 
      e.target.classList.add('hide');
    //  src = e.target.parentElement;
     //  origen = e.target.parentElement; //
     //  origen = e.target; //
      // origen = e; //
      // console.log('dragStart: ', e);
    //  origen = e.target.parentNode; //
    //  console.log('dragStart: ', origen);
    //  e.target.parentNode.childen[0].classList.remove('hide'); // Fail
    //  e.target.parentNode.children['0'].classList.remove('hide'); // Try out
   }, 0);
 }

 function dragEnd(e) {
   e.preventDefault();
   const itemDragged = document.getElementById(e.target.id);
   if (photoScroll) 
      itemDragged.parentNode.parentNode.classList.remove('hide');  // Ok Original fix place 2/2
   else 
      itemDragged.classList.remove('hide');
   
//    origen = e.target.parentNode; //
//    e.target.parentNode.children['0'].classList.add('hide');      // Try out
 }

 function imgInfo() {
   return '|IMG|FIGCAPTION';
 }

 function dragEnter(e) {
   e.preventDefault();
   const DragOver = 'drag-over';
   const IMGinfo  = imgInfo();
//    const IMGinfo  = '|IMG|FIGCAPTION';
   //    e.target.classList.add('drag-over'); 
   //    console.log(origen);
   if (e.target.nodeName == 'BUTTON') {
       e.target.classList.add(DragOver);
    //    e.target.parentNode.classList.add('drag-over');
   } else if (e.target.nodeName == 'FIGURE') {
       e.target.parentElement.classList.add(DragOver);
    //    } else if (e.target.nodeName == 'IMG') {
       } else if (IMGinfo.indexOf(e.target.nodeName) > -1) {
       e.target.parentElement.parentElement.classList.add(DragOver);
   }
 }

 function dragOver(e) { // t1
   dragEnter(e);
 }

 function dragLeave(e) {
   const DragOver = 'drag-over';
   const IMGinfo  = imgInfo();
//    const IMGinfo  = '|IMG|FIGCAPTION';
//    e.target.classList.remove('drag-over');
//    origen = e;
   if (e.target.nodeName == 'BUTTON') {
       e.target.classList.remove(DragOver);
   } else if (e.target.nodeName == 'FIGURE') {
       e.target.parentElement.classList.remove(DragOver);
//    } else if (e.target.nodeName == 'IMG') {
//    } else if (e.target.nodeName == 'IMG' || e.target.nodeName == 'IMG') {
   } else if (IMGinfo.indexOf(e.target.nodeName) > -1) {
       e.target.parentElement.parentElement.classList.remove(DragOver);
   }
 }

 function drop_OK01(e) { // 1st version Works Ok - interchage fotos
   const IMGinfo  = imgInfo();
   //e.target.classList.remove('drag-over');
    // origen = e;
    // console.log('drop - e:', e);
    // console.log(e.target.nodeName);
   dragLeave(e);
   const id = e.dataTransfer.getData('text/plain');
   // const itemDragged = document.getElementById(e.target.id);
   const itemDragged = document.getElementById(id);
   var boxTgt;
   if (IMGinfo.indexOf(e.target.nodeName) > -1) 
       boxTgt = e.target.parentNode.parentNode.parentNode;
   else if (e.target.nodeName == 'FIGURE')
       boxTgt = e.target.parentNode.parentNode;
   else if (e.target.nodeName == 'BUTTON') 
       boxTgt = e.target.parentNode;
  //  console.log('drop - target:', e.target);
   //  if (destino.target.localName == 'div' )
   if (boxTgt.children[1].nodeName             == 'BUTTON' &&
       boxTgt.children[1].children[0].nodeName == 'FIGURE') {
    //    origen = itemDragged;
       itemDragged.parentElement.appendChild(boxTgt.children[1]);
    //    itemDragged.parentElement.children['0'].classList.add('hide'); // try out
       boxTgt.appendChild(itemDragged);
    }
 }

 function drop(e) {
   const IMGinfo  = imgInfo();
   //e.target.classList.remove('drag-over');
   //  origen = e;
    // console.log('drop - e:', e);
    // console.log(e.target.nodeName);
   dragLeave(e);
   const id = e.dataTransfer.getData('text/plain');
   const itemDragged = document.getElementById(id);
   // const itemDragged = document.getElementById(e.target.id);
   var boxTgt;
   if (IMGinfo.indexOf(e.target.nodeName) > -1) 
       boxTgt = e.target.parentNode.parentNode.parentNode;
   else if (e.target.nodeName == 'FIGURE')
       boxTgt = e.target.parentNode.parentNode;
   else if (e.target.nodeName == 'BUTTON') 
       boxTgt = e.target.parentNode;

   
   console.log('drop - boxTgt:', boxTgt);
//    console.log('drop - boxTgt:', e.target.id);
//    origen  = e;
//    origen  = itemDragged;
//    destino = boxTgt;
   // Optimizar no volviendo a bajar por la estructura del DOM
//    console.log('drop on', e.target.nodeName, 
//        '|path|svg|SPAN'.indexOf(e.target.nodeName) < 0
//    );
   if ('|path|svg|SPAN'.indexOf(e.target.nodeName) < 0) 
       boxTgt.parentNode.parentNode.insertBefore(itemDragged.parentNode.parentNode, 
                                                 boxTgt.parentNode);
 }

 console.log('dragdrop: On');
 setDraggables()
 
 console.log('script jalando');
 // setupZoom();

 // $('.dropify').dropify();

 const imgSelected = document.querySelector('.imageSelect'),
     previewImagen = document.querySelector('.imageBox');

 // Escuchar cuando cambie
 imgSelected.addEventListener("change", () => {
   // Los archivos seleccionados, pueden ser muchos o uno
   const archivos = imgSelected.files;
   console.log(archivos);
   // Si no hay archivos salimos de la función y quitamos la imagen
   if (!archivos || !archivos.length) {
     //$imagenPrevisualizacion.src = "";
     console.log('Revisar efectos al guardar cambios');
     return;
   }
   //previewImagen
   for (i = 0; i < archivos.length; i++) {
    //const img = document.createElement('img');
    const img = document.createElement('IMG');
    const objectURL = URL.createObjectURL(archivos[i]);
    img.id = 'foto' + i ;
    img.src = objectURL;
    img.classList.add('item');
    img.setAttribute ('dragable', true);
    //const attr document.createAttribute('draggable');
    //attr.value = 'true';
    previewImagen.appendChild(img);
   }
   setDraggables();
 });

//  "lastOne"   // 
// boxTgt.parentNode.parentNode.insertBefore(itemDragged.parentNode.parentNode, 
//    boxTgt.parentNode);  //  "lastOne"
