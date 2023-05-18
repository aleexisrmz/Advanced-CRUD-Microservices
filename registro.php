<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;

require __DIR__ . '../vendor/autoload.php';
require_once __DIR__ . '/ClaseSw.php';

use ClaseSw\DB;


AppFactory::setSlimHttpDecoratorsAutomaticDetection(false);
ServerRequestCreatorFactory::setSlimHttpDecoratorsAutomaticDetection(false);

// Instantiate App
$app = AppFactory::create();
$res = new DB(' ');

$app->setBasePath("/webservices/proyectoRESTslim/registro.php");

$app->addBodyParsingMiddleware();

$app->addRoutingMiddleware();
// Add error middleware
$app->addErrorMiddleware(true, true, true);
$resp = array(
    'code'    => 999,
    'message' => '',
    'data'    => '',
    'status'  => 'error'
);

$app->post('/registro', function (Request $request, Response $response, $args) { // metodo para subir productos 
    $dt = new DateTime('now', new DateTimeZone('America/Monterrey'));
    global $res, $resp;

    $params = $request->getBody();
    $json = json_decode($params, true);
    $usuario = $json["user"];
    $pass = $json["pass"];
    $email = $json["email"];

    if ($res->isUserDB($usuario)) {
        $resp['message'] = "User ya existe ";
        $resp['status'] = 'fail';
        $resp['data'] = "prubea otro usuario";
        $json = json_encode($resp);
        $response->getBody()->write($json);
    } else {

        $usuarioNuevo = '{
            
                    "' . $usuario . '": {
                        "pass": "' . md5($pass) . '",
                        "email": "' . $email . '"
                    }
        
                }';
        $res->setUsuario($usuarioNuevo);
        $resp['code'] = 201;
        $resp['message'] =   $res->obtainMessage('202');
        $resp['status'] = "exito";
        $resp['data'] = $res->obtainUsuarios($usuario);
        ///$dt->format('Y-m-d H:i:s');
        $json = json_encode($resp);
        $response->getBody()->write($json);
    }
    return $response;
});


$app->run();
