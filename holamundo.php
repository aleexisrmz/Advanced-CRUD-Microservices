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
$res = new DB('serviciosweb-2039-default-rtdb');




$app->setBasePath("/webservices/proyectoRESTslim/holamundo.php");

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

// Add routes
$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write('hola mundo slim');
    return $response;
});

$app->get('/productos/{categoria}', function (Request $request, Response $response, $args) {  ///obtener productos  por categoria
    global $res, $resp;

    $categoria = $args['categoria'];
    $usuario = $request->getHeaderLine('user');
    $pass = $request->getHeaderLine('pass');
    if ($request->hasHeader('user')) {
        if ($res->isUser($usuario)) {
            if ($res->obtainPass($usuario) === md5($pass)) {
                if ($res->isCategoryDB($categoria)) {
                    $resp['code'] = 200;
                    $resp['message'] = $res->obtainMessage('200');
                    $resp['status'] = 'success';
                    $resp['data'] = $res->obtainProduc($categoria);
                    $json = json_encode($resp);
                    $response->getBody()->write($json);
                } else {
                    $resp['code'] = 300;
                    $resp['message'] = $res->obtainMessage('300');
                    $json = json_encode($resp, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                    $response->getBody()->write($json);
                }
            } else {
                $resp['code'] = 501;
                $resp['message'] =   $res->obtainMessage('501');
                $json = json_encode($resp);
                $response->getBody()->write($json);
            }
        } else {
            $resp['code'] = 500;
            $resp['message'] =   $res->obtainMessage('500');
            $json = json_encode($resp);
            $response->getBody()->write($json);
        }
    } else {
        $resp['code'] = 999;
        $resp['message'] =  $res->obtainMessage('999');
        $json = json_encode($resp);
        $response->getBody()->write($json);
    }

    return $response;
});
$app->get('/detalles', function (Request $request, Response $response) { // obtener detalles
    global $res;
    global $resp;

    $resp['code'] = 999;
    $resp['message'] =  $res->obtainMessage('999');
    $json = json_encode($resp);
    $response->getBody()->write($json);
    return $response;
});
$app->get('/detalles/{ISBN}', function (Request $request, Response $response, $args) { // obtener detalles bueno
    global $res, $resp;
    $isbn = $args['ISBN'];
    $usuario = $request->getHeaderLine('user');
    $pass = $request->getHeaderLine('pass');
    if ($request->hasHeader('user')) {
        if ($res->isUser($usuario)) {
            if ($res->obtainPass($usuario) === md5($pass)) {
                if ($res->isIsbnDd($isbn)) {
                    $resp['code'] = 201;
                    $resp['message'] = $res->obtainMessage('201');
                    $resp['status'] = 'success';
                    $resp['data'] = $res->obtainDetails($isbn);
                    $json = json_encode($resp);
                    $response->getBody()->write($json);
                } else {
                    $resp['code'] = 304;
                    $resp['message'] = $res->obtainMessage('304');
                    $json = json_encode($resp, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                    $response->getBody()->write($json);
                }
            } else {
                $resp['code'] = 501;
                $resp['message'] =   $res->obtainMessage('501');
                $json = json_encode($resp);
                $response->getBody()->write($json);
            }
        } else {
            $resp['code'] = 500;
            $resp['message'] =   $res->obtainMessage('500');
            $json = json_encode($resp);
            $response->getBody()->write($json);
        }
    } else {
        $resp['code'] = 999;
        $resp['message'] =  $res->obtainMessage('999');
        $json = json_encode($resp);
        $response->getBody()->write($json);
    }

    return $response;
});

$app->post('/producto', function (Request $request, Response $response, $args) { // metodo para subir productos 
    $dt = new DateTime('now', new DateTimeZone('America/Monterrey'));
    global $res, $resp;

    $usuario = $request->getHeaderLine('user');
    $pass = $request->getHeaderLine('pass');
    $params = $request->getBody();
    //$params = $request->getParsedBody();
    $json = json_decode($params, true);
    $isbn = $json["isbn"];
    $categoria = $json['categoria'];
    if ($res->isUser($usuario)) {
        if ($res->obtainPass($usuario) === md5($pass)) {
            if ($res->isCategoryDB($categoria)) {
                if ($res->isIsbnDdV2($isbn)) {
                    $data = '{
                        "' . $isbn . '" : "' . $json["titulo"] . '" 
                    }';
                    $detalles = '{
                        "' . $isbn . '": {
                            "Autor": "' . $json["autor"] . '",
                            "Titulo": "' . $json["titulo"] . '",
                            "Editorial": "' . $json["editorial"] . '",
                            "Fecha" : ' . $json["fecha"] . ', 
                            "Precio" : ' . $json["precio"] . ', 
                            "Descuento" : ' . $json["descuento"] . '
                        }
                    }';
                    $res->setProducto($categoria, $data);         //// insercion de producto a categoria de libros
                    $res->setProductoDetalles($detalles);          //// insercion de producto a la coleccion de detalles 
                    $resp['code'] = 202;
                    $resp['message'] =   $res->obtainMessage('202');
                    $resp['status'] = "exito";
                    $resp['data'] = $dt->format('Y-m-d H:i:s');
                    $json = json_encode($resp);
                    $response->getBody()->write($json);
                } else {
                    $resp['code'] = 302;
                    $resp['message'] =   $res->obtainMessage('302');
                    $resp['data'] = $dt->format('Y-m-d H:i:s');
                    $json = json_encode($resp);
                    $response->getBody()->write($json);
                }
            } else {
                $resp['code'] = 300;
                $resp['message'] =   $res->obtainMessage('300');
                $resp['data'] = $dt->format('Y-m-d H:i:s');
                $json = json_encode($resp);
                $response->getBody()->write($json);
            }
        } else {
            $resp['code'] = 500;
            $resp['message'] =   $res->obtainMessage('500');
            $resp['data'] = $dt->format('Y-m-d H:i:s');
            $json = json_encode($resp);
            $response->getBody()->write($json);
        }
    } else {
        $resp['code'] = 999;
        $resp['message'] =   $res->obtainMessage('999');
        $resp['data'] = $dt->format('Y-m-d H:i:s');
        $json = json_encode($resp);
        $response->getBody()->write($json);
    }
    return $response;
});

$app->put('/producto/detalles', function (Request $request, Response $response, $args) { // metodo para subir productos 
    $dt = new DateTime('now', new DateTimeZone('America/Monterrey'));

    global $res, $resp;
    //$response->getBody()->write('hola mundo slim');

    $usuario = $request->getHeaderLine('user');
    $pass = $request->getHeaderLine('pass');
    $params = $request->getBody();
    //$params = $request->getParsedBody();
    $json = json_decode($params, true);
    $isbn = $json["isbn"];
    $categoria = $json['categoria'];
    $categoria = Obtenercategoria($isbn);
    if ($res->isUser($usuario)) {

        if ($res->obtainPass($usuario) === md5($pass)) {
            if ($res->isCategoryDB($categoria)) {
                if ($res->isIsbnDd($isbn)) {
                    $data = '{
                        "' . $isbn . '" : "' . $json["titulo"] . '" 
                    }';
                    $detalles = '{
                        "' . $isbn . '": {
                            "Autor": "' . $json["autor"] . '",
                            "Titulo": "' . $json["titulo"] . '",
                            "Editorial": "' . $json["editorial"] . '",
                            "Fecha" : ' . $json["fecha"] . ', 
                            "Precio" : ' . $json["precio"] . ', 
                            "Descuento" : ' . $json["descuento"] . '
                        }
                    }';
                    $res->setProductoDetalles($detalles);          //// insercion de producto a la coleccion de detalles 
                    $res->setProducto($categoria, $data);         //// insercion de producto a categoria de libros
                    $resp['code'] = 203;
                    $resp['message'] =   $res->obtainMessage('203');
                    $resp['status'] = "exito";
                    $resp['data'] = $dt->format('Y-m-d H:i:s');
                    $json = json_encode($resp);
                    $response->getBody()->write($json);
                } else {
                    $resp['code'] = 302;
                    $resp['message'] =   $res->obtainMessage('302');
                    $resp['data'] = $dt->format('Y-m-d H:i:s');
                    $json = json_encode($resp);
                    $response->getBody()->write($json);
                }
            } else {
                $resp['code'] = 300;
                $resp['message'] =   $res->obtainMessage('300');
                $resp['data'] = $dt->format('Y-m-d H:i:s');
                $json = json_encode($resp);
                $response->getBody()->write($json);
            }
        } else {
            $resp['code'] = 500;
            $resp['message'] =   $res->obtainMessage('500');
            $resp['data'] = $dt->format('Y-m-d H:i:s');
            $json = json_encode($resp);
            $response->getBody()->write($json);
        }
    } else {
        $resp['code'] = 999;
        $resp['message'] =   $res->obtainMessage('999');
        $resp['data'] = $dt->format('Y-m-d H:i:s');
        $json = json_encode($resp);
        $response->getBody()->write($json);
    }
    return $response;
});

$app->delete('/producto', function (Request $request, Response $response, $args) { // metodo para subir productos 
    $dt = new DateTime('now', new DateTimeZone('America/Monterrey'));

    global $res, $resp;
    //$response->getBody()->write('hola mundo slim');

    $usuario = $request->getHeaderLine('user');
    $pass = $request->getHeaderLine('pass');
    $params = $request->getBody();
    //$params = $request->getParsedBody();
    $json = json_decode($params, true);
    $isbn = $json["isbn"];

    $categoria = Obtenercategoria($isbn);
    if ($res->isUser($usuario)) {
        if ($res->obtainPass($usuario) === md5($pass)) {
            if ($res->isCategoryDB($categoria)) {
                if ($res->isIsbnDd($isbn)) {

                    if ($res->deleteProd($categoria, $isbn)) {
                        $resp['code'] = 204;
                        $resp['message'] =  $res->obtainMessage('204');
                        $resp['status'] = "exito";
                        $resp['data'] = $dt->format('Y-m-d H:i:s');
                        $json = json_encode($resp);
                        $response->getBody()->write($json);
                    } else {
                        $resp['code'] = 998;
                        $resp['message'] =   $res->obtainMessage('998');
                        $resp['data'] = $dt->format('Y-m-d H:i:s');
                        $json = json_encode($resp);
                        $response->getBody()->write($json);
                    }
                } else {
                    $resp['code'] = 305;
                    $resp['message'] =   $res->obtainMessage('305');
                    $resp['data'] = $dt->format('Y-m-d H:i:s');
                    $json = json_encode($resp);
                    $response->getBody()->write($json);
                }
            } else {
                $resp['code'] = 300;
                $resp['message'] =   $res->obtainMessage('300');
                $resp['data'] = $dt->format('Y-m-d H:i:s');
                $json = json_encode($resp);
                $response->getBody()->write($json);
            }
        } else {
            $resp['code'] = 500;
            $resp['message'] =   $res->obtainMessage('500');
            $resp['data'] = $dt->format('Y-m-d H:i:s');
            $json = json_encode($resp);
            $response->getBody()->write($json);
        }
    } else {
        $resp['code'] = 999;
        $resp['message'] =   $res->obtainMessage('999');
        $resp['data'] = $dt->format('Y-m-d H:i:s');
        $json = json_encode($resp);
        $response->getBody()->write($json);
    }
    return $response;
});

function Obtenercategoria($detalles)
{
    if (stripos($detalles, 'L') !== false) {
        return "libros";
    } else {
        if (strpos($detalles, 'M') !== false) {
            return "mangas";
        } else {
            if (strpos($detalles, 'C') !== false) {
                return "comics";
            } else {
                return "nu";
            }
        }
    }
}

$app->run();
