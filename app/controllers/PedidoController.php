<?php
require_once '../app/models/Pedido.php';
require_once '../app/models/Producto.php';
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
        $pedidoCodigo = $args['codigoPedido'];
        $pedido = Pedido::ObtenerPedido($pedidoCodigo);

        $payload = json_encode(array("mensaje" => "Id incorrecto"));

        if($pedido != false)
        {
          $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);
          Logs::AgregarLogOperacion($usuarioLoguado,"trajo el pedido con código $pedido->codigo");
          $payload = Pedido::RetornarUnPedidoString($pedido);
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);
        $listaPedidos = Pedido::ObtenerTodosLosPedidos();
        $filtro = $args['filtro'];
        $filtro = strtolower($filtro);
        $estadoInt = Pedido::ObtenerEstadoInt($filtro);
        //$payload = json_encode(array("listaUsuario" => $lista));
        $payload = json_encode(array("mensaje" => "No ingreso un estado válido"));

        if($estadoInt != -3)
        {
          $payload = Pedido::RetornarListaDePedidosString($listaPedidos,$estadoInt); 
          if($payload != false)
          {            
            Logs::AgregarLogOperacion($usuarioLoguado,"trajo los pedidos en estado $filtro");
          }
          else
          {
            $payload = "<h1>No hay ningun pedido en estado $filtro<h1>";
          }
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'text/html');
    }
    
    public function TraerLoQueMasVendio($request, $response, $args)
    {
      $payload = "No hay productos dados de alta";
      $maximo = Producto::ObtenerCantidadVendidosProductoMayor();
      $productosMasVendidos = Producto::RetornarProductosPorCantidadDeVentas($maximo);
      $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);

      if($productosMasVendidos != false && count($productosMasVendidos) > 0)
      {
        count($productosMasVendidos) > 1 ? $payload = "Los productos más vendidos fueron <br><br>"
        : $payload = "El producto más vendido fue <br><br>";
        $payload .= Producto::RetornarListaDeProductosString($productosMasVendidos);
        $payload .= "<br>La cantidad vendida fue de $maximo unidades<br>";

        Logs::AgregarLogOperacion($usuarioLoguado,"pidio informacion sobre el/los productos más vendidos");
      }

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'text/html');
    }

    public function TraerLoQueMenosVendio($request, $response, $args)
    {
      $payload = "No hay productos dados de alta";
      $minimo = Producto::ObtenerCantidadVendidosProductoMenor();
      $productosMenosVendidos = Producto::RetornarProductosPorCantidadDeVentas($minimo);
      $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);

      if($productosMenosVendidos != false && count($productosMenosVendidos) > 0)
      {
        count($productosMenosVendidos) > 1 ? $payload = "Los productos menos vendidos fueron <br><br>"
        : $payload = "El producto menos vendido fue <br><br>";
        $payload .= Producto::RetornarListaDeProductosString($productosMenosVendidos);
        $payload .= "<br>La cantidad vendida fue de $minimo unidades<br>";

        Logs::AgregarLogOperacion($usuarioLoguado,"pidio informacion sobre el/los productos menos vendidos");
      }

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'text/html');
    }
    
    public function TraerLosNoEntregadosATiempo($request, $response, $args)
    {
        $listaPedidosNoEntregadosATiempo = Pedido::ObtenerTodosLosPedidosQueNoLlegaronATiempo();
        $payload = Pedido::RetornarListaDePedidosString($listaPedidosNoEntregadosATiempo,TERMINADO);
        $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);
        
        $payload != false ? Logs::AgregarLogOperacion($usuarioLoguado,"pidio informacion sobre el/los pedidos no entregados a tiempo")
        : $payload = "<h1>No hay ningun pedido que no sea haya entregado a tiempo<h1>";

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