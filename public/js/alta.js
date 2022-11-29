const btn_submit = document.getElementById('btn-submit');
const form       = document.getElementById('datos');
const respuestas = document.getElementById('respuestas');

btn_submit.addEventListener('click', ()=> {
        let data = new FormData(form);
    
        fetch('../../includes/alta.php', {
            method: "POST",
            body: data
       }).then((response) => {
            return response.json();
       }).then((data) => {
          form.reset();
          respuestas.innerHTML = data;
       }).catch(err => console.error(err));
});
