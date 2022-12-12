var cant          = document.getElementById('cant');
var termino       = document.getElementById('termino');
var NoCuenta      = document.getElementById('NoCuenta');
var Enviar        = document.getElementById('btn-submit');
var success       = document.getElementById('container');

function addClass(Elemento,clase){ Elemento.classList.add(clase);}
function removeClass(Elemento,clase){ Elemento.classList.remove(clase);}

function addClassError(Datos){
    limpiarClassError();
    let llaves  = Object.keys(Datos);
    let mensaje = Object.values(Datos);
    addClass(Respuesta, "p-1");
    addClass(Respuesta, "mensage-error");

    for (let i = 0; i < llaves.length; i++) {
         Respuesta.innerHTML += '<li>'+ mensaje[i] +'</li>';
    }
}

function addClassSucces(){
    limpiarClassError();
    Cantidad.value = '';      
    Plazo.value = '';
    Respuestas.innerHTML = "";
    removeClass(success, "d-n");     
}

function limpiarClassError(){
    removeClass(Respuesta, "p-1");
    removeClass(Respuesta, "mensage-error");
    removeClass(Respuesta, "mensage-corr");
    Respuesta.innerHTML = '';
}

function BorrarMensaje() {
    addClass(success, "d-n"); 
}

Enviar.addEventListener('click', () => {
    let data =  new FormData();

    data.append('cant',    cant.value);
    data.append('termino', termino.value);
    data.append('NoCuenta', NoCuenta.value);

    fetch('../../includes/prestamos.php', {
         method: "POST",
         body: data
     }).then((response) => {
         return response.json();
    }).then((data) => {   
        if (data[0] != true) {
            addClassError(data);
        } else {
            addClassSucces();
            const tiempo = setTimeout(BorrarMensaje, 8000);
        }
     }).catch(err => console.error(err));
});
