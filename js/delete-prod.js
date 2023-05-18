function getData() {
    const datos = new FormData(formulario);
    const datosProcesados = Object.fromEntries(datos.entries());
    return  datosProcesados;
  }
  /*Funcion para colocar los datos en el Servidor */


    const postData = async () => {
      var options = {
          method: 'DELETE',
          headers: {
              "user": `${newUser["user"]}`, 
              "pass": `${newUser["pass"]}`,
          },
          body: JSON.stringify(getData(isbn))
        };
  
      const url = `http://localhost/webservices/proyectoRESTslim/holamundo.php/producto`;
      
  
      fetch(url,options)
        .then(data => data.json()) //verifica que 
          .then((data) => {
            console.log("Respuesta del server:\n");
              if (data) {
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
                  else{
                    console.log("NO");
                  }
              
          });
  
     
}
  
btn.addEventListener('click', (event) => {
  event.preventDefault();
  newUser = getData();
  postData();  
});
  // formulario.addEventListener('submit', getData());