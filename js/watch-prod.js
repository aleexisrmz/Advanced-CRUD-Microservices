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
  
      const url = `http://localhost/webservices/proyectoRESTslim/holamundo.php/productos/${newUser["categoria"]}`;
      //const url = 'http://localhost/webservices/proyectoRESTslim/holamundo.php/detalles/LIB001';

        function removerCaracteres(texto) {
            if (texto.constructor != String) {
                return null;
            }

            let patron = /[^\x20\x2D0-9A-Z\x5Fa-z\xC0-\xD6\xD8-\xF6\xF8-\xFF]/g;

            return texto.replace(patron, '');
        }
  
      fetch(url,options)
          .then( response => response.json() )
          .then((data) => {
              if (data) {
                  console.log("Respuesta del server:\n");
                  console.log(data);
                  /// aqui debes sacar los datos del servicio
                  let code = data.code; 
                  const dataD = JSON.stringify(data.data);
                  //let dataD = removerCaracteres(dataDD);
                  let desglose = dataD.split(",");
                  console.log(desglose);
                  formulario.remove();
                  const arr = [];
                  for (i = 0; i < desglose.length; i++) {
                    const imprimir = desglose[i]+"<br><br>";
                    arr.push(imprimir);
                  } 
                  let div = document.createElement('div');  // crear div poner bonito y hacer que se pueda cargar 
                  div.className = "contaier";
                  div.innerHTML =  `
                  
                  <form class="form" style="height:auto">    
                  <img src="../img/logo.png" alt="">
                  <h2>Tu resultado de la busqueda</h2>
                  
                  <p style="font-size:15px" type="Code: ">${code}</p>
                  <p style="font-size:15px" type="Mensaje: ">${data["message"]}</p>
                  <p style="font-size:15px" type="Status: ">${data["status"]}</p>
                  <br>
                  <p class="p-title">Los datos de tu busqueda son:</p>
                  <p style="font-size:12px" type="Contenido de la categoria: "><br>${arr+"<br>"}</p>
                  <br><br>
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
    postData();  
  });
  // formulario.addEventListener('submit', getData());