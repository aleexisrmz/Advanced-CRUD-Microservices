const btn = document.querySelector('#btn');
const enviar = document.getElementById("enviar");
const formulario = document.querySelector('#formulario');
const respuesta = document.querySelector('#respuesta');
var newUser;
var respues;

/*Funcion para sacar los datos del Formulario con FormData (ve la leccion anterior)*/

function getData() {
  const datos = new FormData(formulario);
  const datosProcesados = Object.fromEntries(datos.entries());
  return  datosProcesados;
  
}

function insertDatos(){

     const response = fetch('http://localhost/webservices/proyectoRESTslim/registro.php/registro', {
        /*especifica el metodo que se va a usar*/
        method: 'POST',
        /*coloca la informacion en el formato JSON */
        body: JSON.stringify(newUser),
       
        })
        .then( response => response.json() )
        .then((data) => {
            if (data) {
                console.log("Respuesta del server:\n");
                console.log(data);
                /// aqui debes sacar los datos del servicio
                let code = data.code; 
                let dataD = data.data;
                formulario.remove();
                let div = document.createElement('div');  // crear div poner bonito y hacer que se pueda cargar 
                div.className = "contaier";
                if(code == 201){
                  div.innerHTML =  `
                
                <form class="form" style="height:550px">    
                <img src="img/logo.png" alt="">
                <h2>¡Registro completado con exito!</h2>
                <div class="success-img"><img src="img/success.png" alt="" style="all: unset;
                position: relative; left: 110px;
                margin-top: 15px;
                right: 180px;
                width: 150px; /* Ancho deseado */
                height: auto; /* Altura automática para mantener la proporción */"></div>
                <p type="Muchas gracias por tu registro a nuestro sistema">Tu registro ha sido un exito, ahora puedes ingresar a tu cuenta</p>
                <p style="font-size:15px" type="Code: ">${code}</p><br>
                <button type="button" class="btn btn-primary"><div class="back"><a href="./index.html" title="Ir a la pantalla de logueo" class="a-volver">🏠 Ingresar a mi cuenta </a></div></button>
                
                <br>
              </form>`
                }else{
                  div.innerHTML =  `
                
                <form class="form" style="height:550px">    
                <img src="img/logo.png" alt="">
                <h2>¡Error en tu registro!</h2>
                <div class="success-img"><img src="img/failure.png" alt="" style="all: unset;
                position: relative; left: 110px;
                margin-top: 15px;
                right: 180px;
                width: 150px; /* Ancho deseado */
                height: auto; /* Altura automática para mantener la proporción */"></div>
                <p type="Ese usuario ya está en uso">Tu registro no ha salido con éxito, por favor reingresa otro usuario</p>
                <p style="font-size:15px" type="Code: ">${code}</p><br>
                <button type="button" class="btn btn-primary"><div class="back"><a href="./register.html" title="Ingresar otro usuario" class="a-volver">🔙 Ingresar otro usuario </a></div></button>
                
                <br>
              </form>`
                }
                ;
                document.body.append(div);
            }

    
        });
}

btn.addEventListener('click', (event) => {
  event.preventDefault();
  newUser = getData();
  insertDatos(); 
  console.log(respuesta);
});