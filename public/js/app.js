const content = document.getElementById('tbody');

getTableClients();

function getTableClients(){
    let datos = true;

    fetch('../../includes/tableClients.php', {
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

    fetch('../../includes/users.php', {
        method: "POST",
        body: data
   }).then((response) => {
        return response.json();
   }).then((data) => {
        window.alert(data);
        getTableClients();
   }).catch(err => console.error(err));
}