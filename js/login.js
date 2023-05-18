$("#formulario").submit(function(event) {
    event.preventDefault(); // Evita que se envíe el formulario de manera tradicional
  
    // Obtiene los valores del formulario
    var user = $("#user").val();
    var pass = $("#pass").val();
  
    // Crea un objeto JSON con los valores del formulario
    var jsonData = {
      "user": user,
      "pass": pass
    };
  
    // Realiza la solicitud HTTP POST a tu servidor Flask
    $.ajax({
        url: 'http://localhost:5000/login', // URL de la solicitud POST
        method: 'POST',
        data: JSON.stringify(jsonData), // Datos a enviar en la solicitud POST
        contentType: 'application/json',
        success: function(response) {
          // Éxito en la solicitud POST
          //console.log(response);
      
          // Realizar una solicitud GET dentro de la función de éxito de la solicitud POST
          $.ajax({
            url: 'http://localhost:56169/api/token', // URL de la solicitud GET
            method: 'GET',
            headers: {
              'Authorization': 'Bearer ' + response.token // Encabezado de autorización Bearer token
            },
            success: function(data) {
              // Éxito en la solicitud GET
              console.log(data);
              var user = data.user;
              if (user != null) {
                $.ajax({
                  url: 'http://localhost/webservices/proyectoRESTslim/sessions/save-session.php',
                  method: 'POST',
                  data: { user: user }, // Valor de user a enviar
                  success: function(response) {
                    console.log(response);
                    // Redireccionar a otra página después de guardar en sesión si es necesario
                    window.location.href = "http://localhost/webservices/proyectoRESTslim/client/home.php";
                  },
                  error: function(xhr, status, error) {
                    console.error(error);
                  }
                });
              } else {
                window.location.href = "http://localhost/webservices/proyectoRESTslim/index.html";
              }
            },
            error: function(xhr, status, error) {
              // Error en la solicitud GET

              console.error(error);
              swal( ":(" ,  "Usuario o contraseña incorrecto!" ,  "error" );           
            }
          });
        },
        error: function(xhr, status, error) {
          // Error en la solicitud POST
          console.error(error);
          swal( ":(" ,  "Error con el servidor :(" ,  "error" );
        }
      });
      
  });