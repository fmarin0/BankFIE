const content   = document.getElementById('tbody');
const respuesta = document.getElementById('respuesta');
const modal     = document.getElementById('modal');
const cerrar    = document.getElementById('btn-closed');

getTableClients();

cerrar.addEventListener('click', () => {
     modal.style.display = 'none';
});

document.addEventListener("keydown", function (e) {
     if (e.key === "Escape" ) {
          modal.style.display = 'none';
     }
});

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
          respuesta.classList.add('p-1');
          respuesta.innerHTML = '<span>'+ data +'</span>';
          getTableClients();
          const tiempo = setTimeout(BorrarMensaje, 5000);
     }).catch(err => console.error(err));
}

function BorrarMensaje() {
     respuesta.innerHTML = '';
     respuesta.classList.remove('p-1');
}

function modalOpen(){
     modal.style.display = 'block';
}
