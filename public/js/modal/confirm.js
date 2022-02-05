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
  // const colBorraSi = 'btn-';  // Defaults
  // const colBorraNo = 'btn-';  // Defaults
  const mhd = mdlConfirm.getElementsByClassName(objMHeader)  // 'modal-header'
  const btn = mdlConfirm.getElementsByClassName(objButtons); // 'btn'
  var actionText = 
         setAttrib ( event, 'actionText', 'innerText', 3 );
        //  setAttrib ( event, 'actionText', 'innerText', 2 );
        //  setAttrib ( event, 'actionText', 'innerText', 1 );
        //  setAttrib ( event, 'actionText', 'innerText', 0 );
  setAttrib ( event, 'item', 'innerText', 1 );
  setAttrib ( event, 'info', 'innerText' );
  if (actionText.toLowerCase() == 'recuperar' ) {
    // } else {
      mhd[0].className = colMHeader;
      btn[0].className = colRecupSi;
      btn[1].className = colRecupNo;
    // }
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
});
