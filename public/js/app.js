const content   = document.getElementById('tbody');
const modal     = document.getElementById('modal');
const Img       = document.getElementById('img-btn');
const img       = document.getElementById('img');
const Content   = document.getElementById('content');
const respuesta = document.getElementById('respuesta');
const Respuesta = document.getElementById('respuestas');
const cerrar    = document.getElementById('btn-closed');
const btnEdiar  = document.getElementById('btn-editar');
const btnVolver = document.getElementById('btn-volver');
const Enviar    = document.getElementById('btn-submit');
const SetImg    = document.getElementById('setImg');

// Datos
const Name      = document.getElementById('name');
const Fena      = document.getElementById('fena');
const CURP      = document.getElementById('CURP');
const Edad      = document.getElementById('edad');
const Estado    = document.getElementById('estado');
const NoCuenta  = document.getElementById('NoCuenta');
const Domicilio = document.getElementById('domicilio');
const Municipio = document.getElementById('municipio');
const CodPostal = document.getElementById('codPostal')
const Key       = document.getElementById('key');

function getTableClients(){
     let datos = true;
 
     fetch('../../includes/tablaDeClientes.php', {
         method: "POST",
         body: datos
     }).then((response) => {
         return response.json();
     }).then((data) => {
         content.innerHTML = data;
     }).catch(err => console.error(err));
}
 
function Eliminar(value){
     let data = new FormData(document.getElementById('FormEliminar' + value));
 
     fetch('../../includes/controlDeClientes.php', {
         method: "POST",
         body: data
     }).then((response) => {
         return response.json();
     }).then((data) => {   
          addClass(respuesta, "p-1");
          respuesta.innerHTML = '<span>'+ data +'</span>';
          getTableClients();
          const tiempo = setTimeout(BorrarMensaje, 5000);
     }).catch(err => console.error(err));
}
 
function modalOpen(value){
     let data = new FormData(document.getElementById('formEditar' + value));
 
     fetch('../../includes/controlDeClientes.php', {
         method: "POST",
         body: data
     }).then((response) => {
         return response.json();
     }).then((data) => {
          NoCuenta.innerHTML = data.noCuenta;
          Name.value         = data.name;
          Fena.value         = data.fena;
          Domicilio.value    = data.domicilio;
          CURP.value         = data.curp;
          Estado.value       = data.estado;
          Municipio.value    = data.municipio;
          CodPostal.value    = data.cp;
          Edad.value         = data.edad;
          Key.value          = data.key;
          SetImg.innerHTML   = '<img src="./../public/uploads/'+ data.avatar + '" alt="Imagen del cliente" title="Imagen del cliente">';
     }).catch(err => console.error(err));
      
     modal.style.display = 'block';
}

function defaultModal(){
     desactivar(Name);
     desactivar(CURP);
     desactivar(Domicilio);
     desactivar(Estado);
     desactivar(Municipio);
     desactivar(CodPostal);
     desactivar(Fena);

     CodPostal.type = "text";
     Fena.type = "text";

     addClass(Enviar, "disabled");
     addClass(btnVolver, "disabled");
     addClass(Img, "disabled");
     removeClass(btnEdiar, "disabled");
     removeClass(Content, "bg-editar");
}

function addClassError(Datos){
     let llaves  = Object.keys(Datos);
     let mensaje = Object.values(Datos);
     addClass(Respuesta, "p-1");
     addClass(Respuesta, "mensage-error");

     for (let i = 0; i < llaves.length; i++) {
          document.getElementById(llaves[i]).classList.add("error");
          Respuesta.innerHTML += '<li>'+ mensaje[i] +'</li>';
     }
}

function BorrarMensaje() {
     respuesta.innerHTML = '';
     removeClass(respuesta, "p-1");
}

function BorrarRespuesta(){
     removeClass(Respuesta, "p-1");
     removeClass(Respuesta, "mensage-correcto");
     Respuesta.innerHTML = '';
}

function limpiarClassError(){
     removeClass(Name,      'error')      
     removeClass(Fena,      'error')      
     removeClass(CURP,      'error')      
     removeClass(Estado,    'error')    
     removeClass(Domicilio, 'error') 
     removeClass(Municipio, 'error') 
     removeClass(CodPostal, 'error') 
     removeClass(img, 'error') 
     removeClass(Respuesta, "p-1");
     removeClass(Respuesta, "mensage-error");
     removeClass(Respuesta, "mensage-correcto");
     Respuesta.innerHTML = '';
}

function activar(Elemento){ Elemento.disabled = false;}
function desactivar(Elemento){Elemento.disabled = true;}
function addClass(Elemento,clase){ Elemento.classList.add(clase);}
function removeClass(Elemento,clase){ Elemento.classList.remove(clase);}

getTableClients();

Enviar.addEventListener('click', () => {
     let data    = new FormData(document.getElementById("FormEditar"));
     let Imagen  = document.querySelector("input[type='file']");

     if (Imagen.value != '') {
          const filesArray =  Imagen.files;

          for (let i=0; i<filesArray.length; i++) {
               data.append('img', filesArray[i]);
          }
     }

     fetch('../../includes/controlDeClientes.php', {
        method: "POST",
        body: data
     }).then((response) => {
        return response.json();
     }).then((data) => {   
          if (data[0] != true) { 
               limpiarClassError();
               addClassError(data);
          } else {
               defaultModal();
               limpiarClassError();
               modalOpen(Key.value);
               addClass(Respuesta, "p-1");
               addClass(Respuesta, "mensage-correcto");
               Respuesta.innerHTML = data[1];
               const tiempo = setTimeout(BorrarRespuesta, 10000);
          }
     }).catch(err => console.error(err));
});

btnEdiar.addEventListener('click',() => {
     activar(Name);
     activar(CURP);
     activar(Domicilio);
     activar(Estado);
     activar(Municipio);
     activar(CodPostal);
     activar(Fena);

     CodPostal.type = "number";
     Fena.type = "date";

     removeClass(Img, "disabled");
     removeClass(Enviar, "disabled");
     removeClass(btnVolver, "disabled");
     addClass(btnEdiar, "disabled");
     addClass(Content, "bg-editar");
});

btnVolver.addEventListener('click',() => {
     defaultModal();
     limpiarClassError();
     modalOpen(Key.value);
});

cerrar.addEventListener('click', () => { 
     modal.style.display = 'none'; 
     defaultModal(); 
     limpiarClassError();
});

document.addEventListener("keydown", function (e) {
     if (e.key === "Escape"){ 
          modal.style.display = 'none'; 
          defaultModal(); 
          limpiarClassError();
     }
});