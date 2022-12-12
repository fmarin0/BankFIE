const modal      = document.getElementById('modal');
const content    = document.getElementById('tbody');
const desglose   = document.getElementById('desglose');
const cerrar     = document.getElementById('btn-closed');
const NoPrestamo = document.getElementById('NoPrestamo');


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

cerrar.addEventListener('click', () => { 
    modal.style.display = 'none'; 
    content.innerHTML   = '';
});

getTableLoans();