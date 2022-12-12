const Respuesta     = document.getElementById('respuesta');
const NoCuenta      = document.getElementById('NoCuenta');
const Transacciones = document.getElementById('transacciones');
const Acciones      = document.getElementById('acciones');
const BtnSubmit     = document.getElementById('btn-submit');
const Cantidad      = document.getElementById('cantidad');
const Accion        = document.getElementById('retiro');
const Accion2       = document.getElementById('deposito');
const GetSaldo      = document.getElementById('getSaldo');
const success       = document.getElementById('container');
const cuentaDestino = document.getElementById('cuentaDestino');
const form          = document.getElementById('transacciones');
var   Saldo         = 0;           


function addClassError(Datos){
    let llaves  = Object.keys(Datos);
    let mensaje = Object.values(Datos);
    addClass(Respuesta, "p-1");
    addClass(Respuesta, "mensage-error");

    for (let i = 0; i < llaves.length; i++) {
        Respuesta.innerHTML += '<li>'+ mensaje[i] +'</li>';
    }
}

function addClass(Elemento,clase){ Elemento.classList.add(clase);}
function removeClass(Elemento,clase){ Elemento.classList.remove(clase);}

function limpiarClassError(){
    removeClass(Respuesta, "p-1");
    removeClass(Respuesta, "mensage-error");
    removeClass(Respuesta, "mensage-correcto");
    Respuesta.innerHTML = '';
}

function BorrarRespuesta(){
    removeClass(Respuesta, "p-1");
    removeClass(Respuesta, "mensage-correcto");
    Respuesta.innerHTML = '';
}

function BorrarMensaje() {
    addClass(success, "d-n"); 
    removeClass(NoCuenta, "d-n");
}

function addClassSucces(){
    addClass(NoCuenta, 'd-n');
    limpiarClassError();
    form.reset();
    removeClass(success, "d-n");     
    addClass(Acciones, "d-n");
}

NoCuenta.addEventListener('change', ()=>{
    let data    = new FormData();

    data.append('NoCuenta', NoCuenta.value);

    fetch('../../includes/transacciones.php', {
       method: "POST",
       body: data
    }).then((response) => {
       return response.json();
    }).then((data) => {   
        if (data[0] != true) { 
            limpiarClassError();
            addClassError(data);
        } else {
            limpiarClassError();
            Saldo = data[1];
            removeClass(Acciones, 'd-n');
        }
    }).catch(err => console.error(err));
});

Accion.addEventListener('click', ()=>{
    GetSaldo.innerHTML = 'El cliente tiene: $'+ Saldo + ' mxn';
    removeClass(GetSaldo, 'd-n');
    addClass(cuentaDestino, 'd-n');

});

Accion2.addEventListener('click', ()=>{
    GetSaldo.innerHTML = '';
    addClass(GetSaldo, 'd-n');
    removeClass(cuentaDestino, 'd-n');
});


Cantidad.addEventListener('keyup', ()=> {
    if (Accion.checked) {
        if (+Cantidad.value > Saldo) {
            addClass(Cantidad, 'error-cant');
        } else {
            removeClass(Cantidad, 'error-cant');
        }
    }
});

BtnSubmit.addEventListener('click', ()=> {
    let data    = new FormData(form);

    fetch('../../includes/transacciones.php', {
       method: "POST",
       body: data
    }).then((response) => {
       return response.json();
    }).then((data) => {   
        if (data[0] != true) { 
            limpiarClassError();
            addClassError(data);
        } else {
            addClassSucces();
            const tiempo = setTimeout(BorrarMensaje, 5000);
        }
    }).catch(err => console.error(err));
});