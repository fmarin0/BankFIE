const btn_submit = document.getElementById('btn-submit');
const form       = document.getElementById('datos');
const respuestas = document.getElementById('respuestas');
const inputs     = ['nombre', 'CURP', 'fena', 'estado', 'domicilio', 'municipio', 'codPostal', 'email'];

// Content dinamico
const Li1       = document.getElementById('li1');
const Li2       = document.getElementById('li2');
const Li3       = document.getElementById('li3');
const Next      = document.getElementById('next');
const Previus   = document.getElementById('previous');
const Submit    = document.getElementById('submit');
const Datos     = document.getElementById('content-identificacion');
const Domicilio = document.getElementById('content-domicilio');
const Contacto  = document.getElementById('content-contacto');

// API
const CodPostal  = document.getElementById('codPostal');
const Municipio  = document.getElementById('municipio');
const Estado     = document.getElementById('estado');

function removeClass(elemento, clase){
     elemento.classList.remove(clase);
}

function addClass(elemento, clase){
     elemento.classList.add(clase);
}

function addClassError(Datos){
     let llaves  = Object.keys(Datos);
     let mensaje = Object.values(Datos);
     addClass(respuestas, "p-1");
     addClass(respuestas, "mensage-error");

     for (let i = 0; i < llaves.length; i++) {
          let clase = 'error';
          
          if (llaves[i] == 'img') { clase = 'error-img'; }

          document.getElementById(llaves[i]).classList.add(clase);
          document.getElementById(llaves[i]).value = '';

          respuestas.innerHTML += '<li>'+ mensaje[i] +'</li>';
     }
}

function addClassSuccess(Datos){
     inputs.forEach(element => {
          document.getElementById(element).value = '';
     });

     fileList.innerHTML = '<div class="img-temp"></div>';
     addClass(respuestas, "p-1");
     addClass(respuestas, "mensage-correcto");
     respuestas.innerHTML += '<li>'+ Datos +'</li>';
}

function classExist(elemento){
     let exist = elemento.classList;
 
     if (exist[0] === "activo-li")
         return true;

     return false;
}

function inicio(){
     removeClass(Li3, "activo-li")
     removeClass(Contacto, "content-activo");
     addClass(btn_submit, "d-n");
     addClass(Previus, "d-n");

     removeClass(Next,"d-n");
     addClass(Datos, "content-activo");
     addClass(Li1, "activo-li");
}

function limpiarClassError(){

     inputs.forEach(element => {
          removeClass(document.getElementById(element), 'error')
     });

     removeClass(img, 'error-img');
     removeClass(respuestas, "p-1");
     removeClass(respuestas, "mensage-error");

     respuestas.innerHTML = "";
}

function BorrarRespuesta(){
     removeClass(respuestas, "p-1");
     removeClass(respuestas, "mensage-correcto");
     respuestas.innerHTML = '';
}

btn_submit.addEventListener('click', ()=> {
     Municipio.disabled = false;
     Estado.disabled = false;

     let data = new FormData(form);
     let Imagen = document.querySelector("input[type='file']");

     if (Imagen.value != '') {
          const filesArray =  Imagen.files;

          for (let i=0; i<filesArray.length; i++) {
               data.append('img', filesArray[i]);
          }
     }
    
     fetch('../../includes/alta.php', {
          method: "POST",
          body: data
     }).then((response) => {
          return response.json();
     }).then((data) => {
          inicio();
          
          if (data[0] != true) {
               limpiarClassError();
               addClassError(data);
          } else {
               form.reset();
               limpiarClassError();
               addClassSuccess(data[1]);
               const tiempo = setTimeout(BorrarRespuesta, 10000);
          }
          
          if (data[0] === 'error') {
               addClass(respuestas, "p-1");
               addClass(respuestas, "mensage-error");
               respuestas.innerHTML += '<li>'+ data[1] +'</li>';
          }
     }).catch(err => console.error(err));
});


CodPostal.addEventListener('change', () => {
     if (CodPostal.value != '') {
          fetch('https://api.copomex.com/query/info_cp_geocoding/'+ CodPostal.value +'?type=simplified&token=b60def91-4bac-48ce-a61c-733e24046fdd')
          .then(res => res.json())
          .then(respuesta => {
               let info = respuesta.response;
               
               if (info != '') {
                    Municipio.value = info.municipio;
                    Estado.value    = info.estado;

                    let label = $('#municipio').next('label');
                    label.addClass('show');

                    let label2 = $('#estado').next('label');
                    label2.addClass('show'); 
               }
          }) 
     } else {
          let label = $('#municipio').next('label');
          label.removeClass('show');

          let label2 = $('#estado').next('label');
          label2.removeClass('show');
     }
 })

 $(function () {
     let show = 'show';
     
     $('input').on('checkval', function () {
       let label = $(this).next('label');
       if(this.value !== '') {
         label.addClass(show);
       } else {
         label.removeClass(show);
       }
     }).on('keyup', function () {
       $(this).trigger('checkval');
     }); 
});

Next.addEventListener('click', () => {
     
     if (classExist(Li1) && !classExist(Li2) && !classExist(Li3)) {
          removeClass(Li1, "activo-li");
          removeClass(Datos, "content-activo");
          
          addClass(Li2, "activo-li");
          addClass(Domicilio, "content-activo");
          removeClass(Previus, "d-n");
     } else {
          removeClass(Domicilio, "content-activo");
          removeClass(Li2, "activo-li");

          addClass(Next, "d-n");
          addClass(Li3, "activo-li");
          addClass(Contacto, "content-activo");

          removeClass(btn_submit, "d-n");
     }
 });
 
Previus.addEventListener('click',() =>{
     if (!classExist(Li1) && classExist(Li2) && !classExist(Li3)) {
          removeClass(Li2, "activo-li");
          removeClass(Domicilio, "content-activo");
          addClass(Previus, "d-n");

          addClass(Li1, "activo-li");
          addClass(Datos, "content-activo");
     } else {
          removeClass(Li3, "activo-li")
          removeClass(Contacto, "content-activo");
          addClass(btn_submit, "d-n");

          removeClass(Next,"d-n");
          addClass(Domicilio, "content-activo");
          addClass(Li2, "activo-li");
     }
 });


const fileSelect = document.getElementById("fileSelect"),
fileElem = document.getElementById("fileElem"),
fileList = document.getElementById("fileList");

fileSelect.addEventListener("click", (e) => {
  if (fileElem) {
    fileElem.click();
  }
  e.preventDefault(); 
}, false);

fileElem.addEventListener("change", handleFiles, false);

function handleFiles() {
     if (!this.files.length) {
          fileList.innerHTML = '<div class="img-temp"></div>';
     } else {
          fileList.innerHTML = "";
          const list = document.createElement("ul");
          fileList.appendChild(list);
          
          for (let i = 0; i < this.files.length; i++) {
               const li = document.createElement("li");
               list.appendChild(li);

               const img = document.createElement("img");
               
               img.src = URL.createObjectURL(this.files[i]);
               img.height = 60;

               img.onload = () => {
                    URL.revokeObjectURL(img.src);
               }

               li.appendChild(img);
          }
     }
}
