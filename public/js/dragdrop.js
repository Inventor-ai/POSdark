
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


var origen, destino;

 function setDraggables() {
    const items = document.querySelectorAll('.item'),
      imgHolder = document.querySelector('.box');
    console.log(imgHolder);
    items.forEach ( item => {
      item.addEventListener('dragstart', dragStart);
      item.addEventListener('dragend', dragEnd);
    });

   /*
   boxes.forEach ( box => {
     box.addEventListener('dragenter', dragEnter);
     //box.addEventListener('dragover', dragEnter); // t2
     box.addEventListener('dragover', dragOver);
     box.addEventListener('dragleave', dragLeave);
     box.addEventListener('drop', drop);
   });
   */
   imgHolder.addEventListener('dragenter', dragEnter);
     //box.addEventListener('dragover', dragEnter); // t2
   imgHolder.addEventListener('dragover', dragOver);
   imgHolder.addEventListener('dragleave', dragLeave);
   imgHolder.addEventListener('drop', drop);
 }

  function dragStart(e) {
   e.dataTransfer.setData('text/plain', e.target.id);
   setTimeout( () => {
     e.target.classList.add('hide');
     //  origen = e.target.parentElement; //
     //  origen = e.target; //
     //  origen = e; //
     //  console.log('dragStart: ', e);
    //  origen = e.target.parentNode; //
    //  console.log('dragStart: ', origen);
    //  e.target.parentNode.childen[0].classList.remove('hide'); // Fail
     e.target.parentNode.children['0'].classList.remove('hide');
   }, 0);
 }

 function dragEnd(e) {
   e.preventDefault();
   const itemDragged = document.getElementById(e.target.id);
   itemDragged.classList.remove('hide');
   origen = e.target.parentNode; //
//    e.target.parentNode.childen['0'].classList.add('hide');
   destino = e;
 }

 function dragEnter(e) {
   e.preventDefault();
   e.target.classList.add('drag-over');
 }

 function dragOver(e) { // t1
   dragEnter(e);
 }

 function dragLeave(e) {
   e.target.classList.remove('drag-over');
 }

 function drop(e) {
   //e.target.classList.remove('drag-over');
   dragLeave(e);
   const id = e.dataTransfer.getData('text/plain');
   // const itemDragged = document.getElementById(e.target.id);
   const itemDragged = document.getElementById(id);
  //  destino = e;
  //  console.log('drop - e:', e);
  //  console.log('drop - target:', e.target);
   //  if (destino.target.localName == 'div' )
   if (destino.target.nodeName == 'DIV' )
       e.target.appendChild(itemDragged);
 }

console.log('dragdrop: On');
setDraggables()
