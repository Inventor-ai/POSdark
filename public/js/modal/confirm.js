// console.log('running...');

function setTextCase(word, setCaseAs = 0) {
  if (setCaseAs == 1) {
      return word.toLowerCase();
   } else if (setCaseAs == 2) {
      return word.toUpperCase();
   } else if (setCaseAs == 3) {
      return word[0].toUpperCase() + word.slice(1);
  }
  return word;
}

function setAttrib ( eventHandler, dataName, attrName, setCaseAs = 0 ) {
  const prefix = 'conf';
  var value = setTextCase(eventHandler.relatedTarget.getAttribute('data-' + dataName), setCaseAs);
  document.getElementById(prefix+setTextCase(dataName, 3))[attrName] = value;
  return value;
}

var mdlConfirm = document.getElementById('confirm');
var ezModalEvent; // tmp para hacer otras pruebas
mdlConfirm.addEventListener('show.bs.modal', function(event) {
  ezModalEvent = event;
  const objMHeader = 'modal-header';
  const colMHeader = 'modal-header bg-warning';
  const objButtons = 'btn';
  const colRecupSi = 'btn btn-warning';
  const colRecupNo = 'btn btn-dark';
  // const colBorraSi = 'btn-';  // Ya están por feault
  // const colBorraNo = 'btn-';  // Ya están por feault
  // const btn = mdlConfirm.getElementsByClassName('btn');
  // const mhd = mdlConfirm.getElementsByClassName('modal-header')
  const btn = mdlConfirm.getElementsByClassName(objButtons);
  const mhd = mdlConfirm.getElementsByClassName(objMHeader)
  var actionText = 
         setAttrib ( event, 'actionText', 'innerText', 3 );
        //  setAttrib ( event, 'actionText', 'innerText', 2 );
        //  setAttrib ( event, 'actionText', 'innerText', 1 );
        //  setAttrib ( event, 'actionText', 'innerText', 0 );
//   console.log(actionText);
  setAttrib ( event, 'item', 'innerText', 1 );
  setAttrib ( event, 'info', 'innerText' );
  // document.getElementById('conf2Ask').innerText = actionText;
//   console.log(actionText);
//   console.log(actionText.toLowerCase());
//   console.log(actionText.toLowerCase() != 'eliminar' ? 'true':'false');
//   console.log(mhd[0].ClassName);
  /**/
  if (actionText.toLowerCase() == 'recuperar' ) {
  // if (actionText.toLowerCase() != 'eliminar' ) {
    //   btn[0].className = "btn btn-danger";  // Sí
    //   btn[1].className = "btn btn-success";  // No
    // } else {
      // btn[0].className = "btn btn-warning";   // Sí
      btn[0].className = colRecupSi;
    //   btn[1].className = "btn btn-dark";      // No
    //   btn[1].className = "btn btn-secondary"; // No
      // btn[1].className = "btn btn-success";   // No
      btn[1].className = colRecupNo;
    //   btn[1].className = "btn btn-primary";   // No
      mhd[0].className = colMHeader;
    // mhd[0].className = 'modal-header text-warning';
    // mhd[0].className = "modal-header bg-warning"
    // mhd[0].className = "modal-header bg-warning text-white"
    // mhd[0].getElementsByClassName('modal-header bg-warning')
  }
  
//   setAttrib ( event, 'action', 'innerText', 3 ); // Uso futuro en form
//   setAttrib ( event, 'info', 'innerText', 0 );   // Sin cambio.
//   setAttrib ( event, 'info', 'innerText', 1 );   // Texto a minúsculas
//   setAttrib ( event, 'info', 'innerText', 2 );   // Texto a mayúsculas
//   setAttrib ( event, 'info', 'innerText', 3 );   // Texto Capitalizado
//   setAttrib ( event, 'href', 'href' );  // Reemplaza la línea siguiente
{/* <a id="confHref" href="#" class="btn btn-danger">Si</a> */}
mdlConfirm.getElementsByTagName('a')[0].href = event.relatedTarget.getAttribute('data-href');
// <a href="#" class="btn btn-danger">Si</a> //

// console.log(document.getElementById('conf2Ask'));
// console.log(document.getElementById('conf2Ask').innerText);
});
