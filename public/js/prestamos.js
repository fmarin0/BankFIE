const Respuestas    = document.getElementById('tabla-amortizacion');
const Respuesta     = document.getElementById('respuestas-solicitud');
const Cantidad      = document.getElementById('cantidad');
const Plazo         = document.getElementById('plazo');
const form          = document.getElementById('info');

function validarCampos(){
     if (Cantidad.value != '' && 
          Plazo.value != '' && 
          Cantidad.value != 0 && 
          Plazo.value != 0 && 
          Cantidad.value < 1000001 &&
          Plazo.value < 61
     ) {
          return true;
     }

     return false;
}

function existScript(){
     var script = document.querySelector('script[src="../../public/js/prestamos2.js"]')
     if (script == null) {
          return true;
     }
}

function tabla(){
     let data = new FormData(form);
 
     fetch('../../includes/prestamos.php', {
         method: "POST",
         body: data
     }).then((response) => {
         return response.json();
    }).then((data) => {   
          Respuestas.innerHTML = data;
               (function(document, tag) {
                    var scriptTag = document.createElement(tag), // crea el elemento
                        firstScriptTag = document.getElementsByTagName(tag)[0]; // Busca donde se encuentra el primer script [0]
                    scriptTag.src = '../../public/js/prestamos2.js'; // establece en el src la url del javascript a cargar
                    firstScriptTag.parentNode.insertBefore(scriptTag, firstScriptTag); // añade el script al DOM
                  }(document, 'script'));
     }).catch(err => console.error(err));
}

function openNewPage(){
     window.open('about:blank','print_popup','width=1000,height=800');
}

Cantidad.addEventListener('keyup', () => {
     if (validarCampos()) {
          tabla()
     } else {
          Respuestas.innerHTML = '';
     }
});

Cantidad.addEventListener('change', () => {
     if (validarCampos()) {
          tabla()
     }else {
          Respuestas.innerHTML = '';
     }
});

Plazo.addEventListener('change', () => {
     if (validarCampos()) {
          tabla()
     }else {
          Respuestas.innerHTML = '';
     }
});

