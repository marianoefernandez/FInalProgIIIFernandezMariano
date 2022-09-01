<?php

error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;
use Slim\Exception\NotFoundException;
use Illuminate\Database\Capsule\Manager as Capsule;
use Psr7Middlewares\Middleware;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/controllers/MesaController.php';
require __DIR__ . '/controllers/UsuarioController.php';
require __DIR__ . '/controllers/PedidoController.php';
require __DIR__ . '/controllers/ProductoController.php';
require __DIR__ . './middlewares/MWparaCORS.php';
require __DIR__ . './middlewares/MWVerificar.php';
require_once './db/AccesoDatos.php';

define('ACTIVO',1);
define('SUSPENDIDO',0);
define('ELIMINADO',-1); 


date_default_timezone_set('America/Argentina/Buenos_Aires');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$app = AppFactory::create();
$app->setBasePath('/FinalProgIIIFernandezMariano/public');
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
// Add error middleware
$app->addErrorMiddleware(true, true, true);


$app->get('/',function ($request, $response, $args)
{
    $response->getBody()->write("Fernández Mariano -> La Comanda TP");
    return $response;
});

//Login
$app->post('[/login]', \UsuarioController::class . ':LoguearUno');

//Usuarios
$app->group('/usuarios', function (RouteCollectorProxy $group)
{
    $group->post('/crearUsuario',\UsuarioController::class . ':CargarUno');
    $group->get('/listarUsuarios',\UsuarioController::class . ':TraerTodos');
})->add(new MWVerificar("socio","todos"))
->add(\MWparaCORS::class . ':HabilitarCORS4200');

//Productos
$app->group('/productos', function (RouteCollectorProxy $group)
{
    $group->post('/crearProducto',\ProductoController::class . ':CargarUno');
    $group->get('/listarProductos',\ProductoController::class . ':TraerTodos');
})->add(\MWparaCORS::class . ':HabilitarCORS4200');

//Mesas
$app->group('/mesas', function (RouteCollectorProxy $group)
{
    $group->post('/crearMesa',\MesaController::class . ':CargarUno');
    $group->get('/listarMesas',\MesaController::class . ':TraerTodos');
})->add(\MWparaCORS::class . ':HabilitarCORS4200');

//Pedidos
$app->group('/pedidos', function (RouteCollectorProxy $group)
{
    $group->post('/crearPedido',\PedidoController::class . ':CargarUno');
    $group->get('/listarPedidos',\PedidoController::class . ':TraerTodos');
})->add(\MWparaCORS::class . ':HabilitarCORS4200');

//Filtros Admin

$app->group('/filtros', function (RouteCollectorProxy $group) 
{
  
})->add(new MWVerificar("socio","todos"));

$app->run();

?>