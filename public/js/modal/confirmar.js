console.log('running...');

function capitalize(word) {
    return word[0].toUpperCase() + word.slice(1).toLowerCase();
}

function setAttrib ( eventHandler, dataName, attrName, setCaseAs = 0 ) {
  const prefix = 'conf';
  var word = eventHandler.relatedTarget.getAttribute('data-' + dataName);
  if (setCaseAs == 2) {
      word = word.toUpperCase();
   } else if (setCaseAs == 1) {
      word = word.toLowerCase();
   } else if (setCaseAs == 3) {
      word = capitalize(word);
  }
  //   console.log(word, setCaseAs)
//   document.getElementById(prefix+capitalize(dataName)).innerText = word;
  document.getElementById(prefix+capitalize(dataName))[attrName] = word;
  return word;
}

var modalConfirmar = document.getElementById('confirmar');
var ezModalEvent; // tmp para hacer otras pruebas
modalConfirmar.addEventListener('show.bs.modal', function(event) {
  ezModalEvent = event;
  document.getElementById('conf2Ask').innerText = 
  setAttrib ( event, 'action', 'innerText', 3 );
  setAttrib ( event, 'item', 'innerText', 1 );
  setAttrib ( event, 'info', 'innerText' );
//   setAttrib ( event, 'info', 'innerText', 0 );  // Sin cambio. Tal y como viene
//   setAttrib ( event, 'info', 'innerText', 1 );  // Cambia a minúsculas
//   setAttrib ( event, 'info', 'innerText', 2 );  // Cambia a mayúsculas
//   setAttrib ( event, 'info', 'innerText', 3 );  // Capitaliza el texto
  setAttrib ( event, 'href', 'href' );  // Para reemplazar la línea siguiente
//   modalConfirmar.getElementsByTagName('a')[0].href = e.relatedTarget.getAttribute('data-href');
// <a href="#" class="btn btn-danger">Si</a> //
});

