<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;


require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/controllers/MesaController.php';
require __DIR__ . '/controllers/UsuarioController.php';
require __DIR__ . '/controllers/PedidoController.php';
require __DIR__ . '/controllers/ProductoController.php';
require __DIR__ . '/controllers/LogLoginController.php';
require __DIR__ . '/controllers/ClientesController.php';
require __DIR__ . '/controllers/LogOperacionesController.php';
require __DIR__ . './middlewares/MWVerificar.php';
require_once './db/AccesoDatos.php';




date_default_timezone_set('America/Argentina/Buenos_Aires');


// Load ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Instantiate App
$app = AppFactory::create();
//$app->setBasePath("/app"); 

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();

// Routing Middlewere
$app->addRoutingMiddleware();

// Actualiza el estado del pedido en tiempo real
//Hay que crear un subproceso
//Pedido::VerificarTiempoPedidos();

$app->get('/',function ($request, $response, $args)
{
    //Sólo interfaz
    include __DIR__ . './html/inicio.php';

   // $response->getBody()->write("Bienvenido a la comanda.");
    return $response;
});

//Login
//$app->post('[/login]', \UsuarioController::class . ':LoguearUno');

$app->group('/login', function (RouteCollectorProxy $group) 
{
    $group->post('[/]', \UsuarioController::class . ':LoguearUno');
});

//Usuarios


$app->group('/usuarios', function (RouteCollectorProxy $group)
{
    $group->get('',function ($request, $response, $args)
    {
        //$header = $request->getHeaderLine('Authorization');
        //$token = trim(explode("Bearer", $header)[1]);

        //$usuario = AutentificadorJWT::ObtenerData($token);
        $response->getBody()->write("<h1>Bienvenido <h1>");

        //Sólo visual
        include __DIR__ . './html/usuarios.php';

        return $response;
    });

    //7-a Los días y horarios que se ingresaron al sistema.
    $group->get('/horariosLogin',\LogLoginController::class . ':TraerTodos');
    $group->get('/horariosLogin/{id}',\LogLoginController::class . ':TraerUno');

    //7-b Cantidad de operaciones de todos por sector
    $group->get('/logOperacionesSector/{sector}',\LogOperacionesController::class . ':TraerTodosSector');

    //7-c Cantidad de operaciones de todos por sector, listada por cada empleado.
    $group->get('/logOperacionesPorEmpleado/{sector}',\LogOperacionesController::class . ':TraerTodosSectorUsuario');

    //7-d Cantidad de operaciones de cada uno por separado.
    $group->get('/logOperacionesId/{id}',\LogOperacionesController::class . ':TraerUno');

    //7-e Posibilidad de dar de alta a nuevos, suspenderlos o borrarlos
    $group->post('/crearUsuario',\UsuarioController::class . ':CargarUno');
    $group->get('/listarUsuarios',\UsuarioController::class . ':TraerTodos');
    $group->get('/listarUsuario/{id}',\UsuarioController::class . ':TraerUno');
    $group->put('/cambiarEstado/{id}',\UsuarioController::class . ':CambiarEstadoUno');
    $group->delete('/borrarUno/{id}',\UsuarioController::class . ':BorrarUno');
    $group->put('/modificarUno/{id}',\UsuarioController::class . ':ModificarUno');

})->add(new MWVerificar("socio","todos"));

//Productos
$app->group('/productos', function (RouteCollectorProxy $group)
{   
    $group->get('',function ($request, $response, $args)
    {
        $response->getBody()->write("<h1>Bienvenido <h1>");

        //Sólo visual
        include __DIR__ . './html/productos.php';

        return $response;
    });

    $group->post('/crearProducto',\ProductoController::class . ':CargarUno');
    $group->get('/listarProductos',\ProductoController::class . ':TraerTodos');
    $group->get('/listarUno/{id}', \ProductoController::class . ':TraerUno');
    $group->delete('/borrarUno',\ProductoController::class . ':BorrarUno');
    $group->put('/modificarUno',\ProductoController::class . ':ModificarUno');

})->add(new MWVerificar("socio","todos"));

//Mesas
$app->group('/mesas', function (RouteCollectorProxy $group)
{

    $group->get('',function ($request, $response, $args)
    {
        $response->getBody()->write("<h1>Bienvenido <h1>");

        //Sólo visual
        include __DIR__ . './html/mesas.php';

        return $response;
    });

    $group->post('/crearMesa',\MesaController::class . ':CargarUno')->add(new MWVerificar("empleado","mozo"));
    $group->get('/listarMesas',\MesaController::class . ':TraerTodos')->add(new MWVerificar("empleado","mozo"));
    $group->get('/listarUna/{codigoMesa}',\MesaController::class . ':TraerUno')->add(new MWVerificar("empleado","mozo"));
    $group->delete('/borrarUna',\MesaController::class . ':BorrarUno')->add(new MWVerificar("socio","todos"));
    $group->put('/modificarUna',\MesaController::class . ':ModificarUno')->add(new MWVerificar("empleado","mozo"));
    $group->put('/cambiarEstado/{codigoMesa}',\MesaController::class . ':CambiarEstadoUno');

    //9-a La más usada.
    $group->get('/masUsada',\MesaController::class . ':TraerMesasMasUsadas')->add(new MWVerificar("socio","todos"));

    //9-b La menos usada.
    $group->get('/menosUsada',\MesaController::class . ':TraerMesasMenosUsadas')->add(new MWVerificar("socio","todos"));

    //9-c La que más facturó.
    $group->get('/mayorRecaudacion',\MesaController::class . ':TraerMesasQueMasRecaudaron')->add(new MWVerificar("socio","todos"));

    //9-d La que menos facturó.    
    $group->get('/menorRecaudacion',\MesaController::class . ':TraerMesasQueMenosRecaudaron')->add(new MWVerificar("socio","todos"));

    
    //9-e La/s que tuvo la factura con el mayor importe.
    $group->get('/facturaMayor',\MesaController::class . ':TraerMesasConFacturaMayor')->add(new MWVerificar("socio","todos"));

    //9-f La/s que tuvo la factura con el menor importe.
    $group->get('/facturaMenor',\MesaController::class . ':TraerMesasConFacturaMenor')->add(new MWVerificar("socio","todos"));

    //9-g Lo que facturó entre dos fechas dadas.
    $group->get('/facturaEntreDosFechas/{codigoMesa}',\MesaController::class . ':TraerRecaudacionEntreFechas')->add(new MWVerificar("socio","todos"));

    
    //9-h Mejores comentarios.
    $group->get('/mejoresComentarios/{codigoMesa}',\MesaController::class . ':TraerMejoresComentarios')->add(new MWVerificar("socio","todos"));

    //9-i Peores comentarios.
    $group->get('/peoresComentarios/{codigoMesa}',\MesaController::class . ':TraerPeoresComentarios')->add(new MWVerificar("socio","todos"));

});

//Pedidos
$app->group('/pedidos', function (RouteCollectorProxy $group)
{

    $group->get('',function ($request, $response, $args)
    {
        $response->getBody()->write("<h1>Bienvenido <h1>");

        //Sólo visual
        include __DIR__ . './html/pedidos.php';

        return $response;
    });

    $group->post('/crearPedido',\PedidoController::class . ':CrearUno')->add(new MWVerificar("empleado","mozo"));
    $group->post('/cargarPedido/{codigoPedido}',\PedidoController::class . ':CargarUno')->add(new MWVerificar("empleado","mozo"));
    $group->post('/subirFoto/{codigoPedido}',\PedidoController::class . ':SubirFoto')->add(new MWVerificar("empleado","mozo"));
    $group->delete('/borrarUno',\ProductoController::class . ':BorrarUno');
    $group->put('/modificarUno',\ProductoController::class . ':ModificarUno');

    //8-a Lo que más se vendió.
    $group->get('/masVendidos',\PedidoController::class . ':TraerLoQueMasVendio')->add(new MWVerificar("socio","todos"));

    //8-b Lo que menos se vendió.
    $group->get('/menosVendidos',\PedidoController::class . ':TraerLoQueMenosVendio')->add(new MWVerificar("socio","todos"));

    //8-c Los que no se entregaron en el tiempo estipulado
    $group->get('/noEntregadosATiempo',\PedidoController::class . ':TraerLosNoEntregadosATiempo')->add(new MWVerificar("socio","todos"));

    //8-d Los cancelados Muestra pedidos en un filtro (No muestra sus productos) -> Sólo admin
    //También trae pendientes, en preparación y terminados por si se desea ver
    $group->get('/traerPedidosPorEstado/{filtro}',\PedidoController::class . ':TraerTodos')->add(new MWVerificar("socio","todos"));
    

});


$app->group('/clientes', function (RouteCollectorProxy $group)
{
    $group->post('/darOpinion',\ClientesController::class . ':DarOpinion');
    $group->get('/mostrarTiempoDemora',\ClientesController::class . ':TraerTiempoDemora');

});

$app->run();
