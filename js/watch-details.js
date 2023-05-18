function getData() {
  const datos = new FormData(formulario);
  const datosProcesados = Object.fromEntries(datos.entries());
  return  datosProcesados;
}
/*Funcion para colocar los datos en el Servidor */

const postData = async () => {
    var options = {
        method: 'get',
        headers: {
            "user": `${newUser["user"]}`, 
            "pass": `${newUser["pass"]}`,
        }
    };

    const url = `http://localhost/webservices/proyectoRESTslim/holamundo.php/detalles/${newUser["isbn"]}`;
    //const url = 'http://localhost/webservices/proyectoRESTslim/holamundo.php/detalles/LIB001';
    

    fetch(url,options)
        .then( response => response.json() )
        .then((data) => {
            if (data) {
                console.log("Respuesta del server:\n");
                console.log(data);
                /// aqui debes sacar los datos del servicio
                let code = data.code; 
                let autor = data["data"]["Autor"];
                let descuento = data["data"]["Descuento"];
                let editorial = data["data"]["Editorial"];
                let fecha = data["data"]["Fecha"];
                let precio = data["data"]["Precio"];
                let titulo = data["data"]["Titulo"];
                formulario.remove();
                let div = document.createElement('div');  // crear div poner bonito y hacer que se pueda cargar 
                div.className = "contaier";
                div.innerHTML =  `
                
                <form class="form" style="height:1000px">    
                <img src="../img/logo.png" alt="">
                <h2>Tu resultado de la busqueda</h2>
                
                <p style="font-size:15px" type="Code: ">${code}</p>
                <p style="font-size:15px" type="Mensaje: ">${data["message"]}</p>
                <p style="font-size:15px" type="Status: ">${data["status"]}</p>
                <br>
                <p class="p-title">Los datos de tu busqueda son:</p>
                <p style="font-size:15px" type="Autor: ">${autor}</p>
                <p style="font-size:15px" type="Titulo: ">${titulo}</p>
                <p style="font-size:15px" type="Precio: ">${precio}</p>
                <p style="font-size:15px" type="Fecha: ">${fecha}</p>
                <p style="font-size:15px" type="Editorial: ">${editorial}</p>
                <p style="font-size:15px" type="Descuento: ">${descuento}</p>
                <br><br><br>
                <a href="javascript:history.back(-1);" title="Ir la página anterior" class="a-volver">← Volver</a>
                </form>`;
                document.body.append(div);
              
                }
            
        });

   
}

btn.addEventListener('click', (event) => {
  event.preventDefault();
  newUser = getData();
  postData();  
});
// formulario.addEventListener('submit', getData());