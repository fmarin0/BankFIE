const modal       = document.getElementById('modal');
const Modal2      = document.getElementById('modal2');
const content     = document.getElementById('tbody');
const desglose    = document.getElementById('desglose');
const cerrar      = document.getElementById('btn-closed');
const Cerrar      = document.getElementById('btn-closed2');
const NoPrestamo  = document.getElementById('NoPrestamo');
const Respuesta   = document.getElementById('respuestas-pagos');
const Mensualidad = document.getElementById('pago');
const Opcion1     = document.getElementById('pago1');
const Opcion2     = document.getElementById('pago2');
const Cantidad    = document.getElementById('Cantidad'); 
const Enviar      = document.getElementById('btn-submit');
const Interes     = document.getElementById('interes');
const RespuestaS  = document.getElementById('respuesta');
const NoPrestamoD = document.getElementById('NoPrestamoD');

const Saldo = document.getElementById('Saldo');
const Datos = document.getElementById('Datos');

var DatosPrestamo = '';

function addClass(Elemento,clase){ Elemento.classList.add(clase);}
function removeClass(Elemento,clase){ Elemento.classList.remove(clase);}

function prepararPago(data){
    Saldo.innerHTML       = data.saldo;
    Mensualidad.innerHTML = data.NoMensualidad + '/' + data.plazo;
}

function modalOpen(value){
    let data = new FormData(document.getElementById('formVer' + value));

    fetch('../../includes/consulta.php', {
        method: "POST",
        body: data
    }).then((response) => {
        return response.json();
    }).then((data) => {
        desglose.innerHTML = data;
        NoPrestamo.innerHTML =  value;
        modal.style.display = 'block';
    }).catch(err => console.error(err));
     
}

function modalOpen2(value){
    let data = new FormData(document.getElementById('FormPagar' + value));

    fetch('../../includes/consulta.php', {
        method: "POST",
        body: data
    }).then((response) => {
        return response.json();
    }).then((data) => {
        DatosPrestamo = data;
        prepararPago(data);
        NoPrestamoD.value = value;
        Modal2.style.display = 'block';
    }).catch(err => console.error(err));
}

function getTableLoans(){
    let data = true;

    fetch('../../includes/tablaPrestamos.php', {
        method: "POST",
        body: data
    }).then((response) => {
        return response.json();
    }).then((data) => {
        content.innerHTML = data;
    }).catch(err => console.error(err));
}


function limpiarRespuesta(){
    removeClass(Respuesta, "p-1");
    removeClass(Respuesta, "mensage-error");
    Respuesta.innerHTML = '';
}

function addClassError(Datos){
    let llaves  = Object.keys(Datos);
    let mensaje = Object.values(Datos);
    addClass(Respuesta, "p-1");
    addClass(Respuesta, "mensage-error");

    for (let i = 0; i < llaves.length; i++) {
        Respuesta.innerHTML += '<li>'+ mensaje[i] +'</li>';
    }
}

function addClassSucces(){
    Modal2.style.display = 'none'; 
    limpiarRespuesta();
    Datos.innerHTML = '';
    document.getElementById("pagarPrestamo").reset();
    addClass(RespuestaS, "mensage-correcto");
    addClass(RespuestaS, "p-1");
}


function BorrarRespuesta(){
    removeClass(RespuestaS, "p-1");
    removeClass(RespuestaS, "mensage-correcto");
    RespuestaS.innerHTML = '';
}

cerrar.addEventListener('click', () => { 
    modal.style.display = 'none'; 
    desglose.innerHTML   = '';
});


Cerrar.addEventListener('click', () => { 
    Modal2.style.display = 'none'; 
});


Opcion1.addEventListener('click', ()=> {
    let Total = +DatosPrestamo.total + +DatosPrestamo.interesTotal;
    Datos.innerHTML = '';
    Datos.innerHTML += '<p>Pago:                $<span></span>' + DatosPrestamo.total + ' MXN</p>';
    Datos.innerHTML += '<p>Interes moratorios:  $<span></span>' + DatosPrestamo.interesTotal + ' MXN</p>';
    Datos.innerHTML += '<p>Total:               $<span></span>' + Total + ' MXN</p>';
    Cantidad.value = Total;
    Interes.value  = DatosPrestamo.interesTotal;
});

Opcion2.addEventListener('click', ()=> {
    let Total = +DatosPrestamo.mensualidad + +DatosPrestamo.interesMensual;
    Datos.innerHTML = '';
    Datos.innerHTML += '<p>Pago:                $<span></span>' + DatosPrestamo.mensualidad + ' MXN</p>';
    Datos.innerHTML += '<p>Interes moratorios:  $<span></span>' + DatosPrestamo.interesMensual + ' MXN</p>';
    Datos.innerHTML += '<p>Total:               $<span></span>' + Total + ' MXN</p>';
    Cantidad.value = Total;
    Interes.value  = DatosPrestamo.interesMensual;

});

Enviar.addEventListener('click', () => {
    let data    = new FormData(document.getElementById("pagarPrestamo"));

    fetch('../../includes/consulta.php', {
       method: "POST",
       body: data
    }).then((response) => {
       return response.json();
    }).then((data) => {   
         if (data[0] != true) { 
            limpiarRespuesta();
            addClassError(data);
         } else {
            getTableLoans();
            addClassSucces()
            RespuestaS.innerHTML = data[1];
            const tiempo = setTimeout(BorrarRespuesta, 10000);
         }
    }).catch(err => console.error(err));
});

getTableLoans();
