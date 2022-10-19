<?php
require_once '../app/models/Pedido.php';
require_once '../app/models/Usuario.php';
require_once '../app/models/Logs.php';
require_once '../app/interfaces/IApiUsable.php';
require_once './middlewares/AutentificadorJWT.php';
require_once 'UsuarioController.php';
//require_once './middlewares/MWVerificar.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use AutentificadorJWT as AutentificadorJWT;
use Slim\Handlers\Strategies\RequestHandler;
//use MWVerificar as Verificar;
 

class PedidoController extends Pedido implements IApiUsable
{
    public function CrearUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $codigoMesa = $parametros['codigoMesa'];
        $tiempoDePedido = $parametros['tiempoAproximado'];//Segundos

        $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);

        //Creamos el pedido
        $pedido = Pedido::ConstruirPedido($codigoMesa,$usuarioLoguado->GetID(),date("Y-m-j H:i:s"),date("Y-m-j H:i:s",time() + $tiempoDePedido));

        switch(Pedido::AltaPedido($pedido))
        {
          case -1:
            $payload = json_encode(array("mensaje" => "No se pudo crear el pedido"));
            break;

          case 0:
            $payload = json_encode(array("mensaje" => "El usuario, la mesa o el producto no existen en la base de datos"));
            break;
          
          case 1:
            $payload = json_encode(array("mensaje" => "Pedido creado con exito"));
            $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);
            Logs::AgregarLogOperacion($usuarioLoguado,"creo un nuevo pedido con el codigo $pedido->codigo para la mesa $pedido->codigoMesa");
            break;
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function CargarUno($request, $response, $args)
    {
      $parametros = $request->getParsedBody();
      $idProducto = $args['id'];
      $cantidad = $parametros['cantidad'];
      $codigoPedido = $parametros['codigoPedido'];


      $payload = json_encode(array("mensaje" => "La cantidad debe ser un numero mayor a cero"));


      if(is_numeric($cantidad) && $cantidad > 0)
      {
        switch(Pedido::CargarPedido($codigoPedido,$idProducto,$cantidad))
        {
          case -1:
            $payload = json_encode(array("mensaje" => "El pedido no existe"));
            break;

          case 0:
            $payload = json_encode(array("mensaje" => "El producto no existe"));
            break;
          
          case 1:
            $payload = json_encode(array("mensaje" => "Pedido cargado con exito"));
            $producto = Producto::ObtenerProducto($idProducto);
            $pedido = Pedido::ObtenerPedido($codigoPedido);
            $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);
            Logs::AgregarLogOperacion($usuarioLoguado,"cargo un producto $producto->nombre al pedido con codigo $pedido->codigo para la mesa $pedido->codigoMesa");
            break;  
        }
      }
    

      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json');
    }
    
    public function SubirFoto($request, $response, $args)
    {
      $codigoPedido = $args['codigoPedido'];
      $archivo = $request->getUploadedFiles();
      $foto = $archivo['foto'];


      switch(Pedido::SacarFoto($codigoPedido,$foto))
      {
        case -1:
          $payload = json_encode(array("mensaje" => "Error al subir la foto"));
          break;

        case 0:
          $payload = json_encode(array("mensaje" => "La foto para ese pedido ya está guardada en /ImagenesPedidos, borrela si quiere guardar una nueva"));
          break;
        
        case 1:
          $pedido = Pedido::ObtenerPedido($codigoPedido);
          $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);
          Logs::AgregarLogOperacion($usuarioLoguado,"saco una foto de la mesa con codigo $pedido->codigoMesa para el pedido $pedido->codigo");
          $payload = json_encode(array("mensaje" => "Foto cargada con exito"));
          break;  
      }
      
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json');

    }

    public function TraerUno($request, $response, $args)
    {
        // Buscamos usuario por nombre
        $pedidoId = $args['id'];
        $pedido = Pedido::ObtenerPedido($pedidoId);

        $payload = json_encode(array("mensaje" => "Id incorrecto"));

        if($pedido != false)
        {
            $payload = json_encode($pedido);
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $listaPedidos = Pedido::ObtenerTodosLosPedidos();
        $listaUsuarios = Usuario::ObtenerTodosLosUsuarios();
        $listaMesas = Mesa::ObtenerTodasLasMesas();
        $listaProductos = Producto::ObtenerTodosLosProductos();
        //$payload = json_encode(array("listaUsuario" => $lista));
        $payload = Pedido::RetornarListaDePedidosString($listaPedidos,$listaUsuarios,$listaMesas,$listaProductos,ENPREPARACION);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'text/html');
    }
    
    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $payload = json_encode(array("mensaje" => "Pedido modificado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $payload = json_encode(array("mensaje" => "Pedido borrado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}