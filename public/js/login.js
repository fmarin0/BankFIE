const email = document.getElementById('email');
const password = document.getElementById('password');
const send = document.getElementById('send');

function validateLogin() {
    if (email.value == '' ) {
        email.classList.add('error');
    } else {
        email.classList.remove('error');
    }
}

email.addEventListener('change', ()=>{
    validateLogin();
});

password.addEventListener('change', ()=>{
    validateLogin();
});