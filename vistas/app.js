const iconoMenu = document.querySelector('#icono-menu'),
    menu = document.querySelector('#menu');

iconoMenu.addEventListener('click', (e) => {

    //Se alterna estilo menu y body

    menu.classList.toggle('active');
    document.body.classList.toggle('opacity');

    //Alternamos el atributo src

    const rutaActual = e.target.getAttribute('src');

    if (rutaActual == '.img/hamburguesa.png') {
        e.target.setAttribute('src', './img/hamburguesa2.png');
    } else {
        e.target.setAttribute('src', './img/hamburguesa.png');
    }

});
