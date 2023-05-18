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

     const response = fetch('http://localhost/webservices/proyectoRESTslim/holamundo.php/producto', {
        /*especifica el metodo que se va a usar*/
        method: 'POST',
        /*especifica el tipo de informacion (JSON)*/
        headers: {'Content-Type': 'application/json',
                "user": `${newUser["user"]}`, 
                "pass": `${newUser["pass"]}`,
    
        },

        /*coloca la informacion en el formato JSON */
        body: JSON.stringify(newUser),
       
        })
        .then( response => response.json() )
        .then((data) => {
            if (data) {
                console.log("Respuesta del server:\n");
                console.log(data);
                console.log("Respuesta del server:\n");
                console.log(data);
                /// aqui debes sacar los datos del servicio
                let code = data.code; 
                let dataD = data.data;
                formulario.remove();
                let div = document.createElement('div');  // crear div poner bonito y hacer que se pueda cargar 
                div.className = "contaier";
                div.innerHTML =  `
                
                <form class="form" style="height:auto">    
                <img src="../img/logo.png" alt="">
                <h2>El resultado de tu operación</h2>
                
                <p style="font-size:15px" type="Code: ">${code}</p>
                <p style="font-size:15px" type="Mensaje: ">${data["message"]}</p>
                <p style="font-size:15px" type="Status: ">${data["status"]}</p>
                <br>
                <p class="p-title">El resultado de su operación fue:</p>
                <p style="font-size:15px" type="Data: ">${dataD}</p>
                <br><br><br>
                <a href="javascript:history.back(-1);" title="Ir la página anterior" class="a-volver">← Volver</a>
                <br><br>
                </form>`;
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