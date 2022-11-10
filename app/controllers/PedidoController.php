<?php
require_once '../app/models/Pedido.php';
require_once '../app/models/Producto.php';
require_once '../app/models/Usuario.php';
require_once '../app/models/Logs.php';
require_once '../app/models/Validaciones.php';
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
        //$tiempoDePedido = $parametros['tiempoAproximado'];//Segundos

        $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);

        //Creamos el pedido
        //$pedido = Pedido::ConstruirPedido($codigoMesa,$usuarioLoguado->GetID(),date("Y-m-j H:i:s"),date("Y-m-j H:i:s",time() + $tiempoDePedido));
        $pedido = Pedido::ConstruirPedido($codigoMesa,time(),NULL);

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
      $parametros = $request->getParsedBody();
      $fechaInicio = $parametros['fechaInicio'];
      $fechaFinal = $parametros['fechaFinal'];
      $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);
      $formatoFecha = ValidarFechas($fechaInicio,$fechaFinal);
      $payload = json_encode(array("mensaje" => "La fecha tiene un formato invalido"));        
      $listaPedidos = Pedido::ObtenerTodosLosPedidos();
      $filtro = $args['filtro'];
      $filtro = strtolower($filtro);
      $estadoInt = Pedido::ObtenerEstadoInt($filtro);
      //$payload = json_encode(array("listaUsuario" => $lista));

      if($formatoFecha)
      {
        $payload = json_encode(array("mensaje" => "No se ingreso un estado válido"));
        
        if($estadoInt != -3)
        {
          if($fechaInicio == "" && $fechaFinal == "")
          {
            $listaPedidos = Pedido::ObtenerTodosLosPedidos();
          }
          else
          {
            $listaPedidos = Pedido::ObtenerTodosLosPedidosPorFecha($fechaInicio,$fechaFinal);
          }

          $payload = Pedido::RetornarListaDePedidosString($listaPedidos,$estadoInt); 
          if($payload != false)
          {            
            Logs::AgregarLogOperacion($usuarioLoguado,"trajo los productos de todos los pedidos en estado $filtro");
          }
          else
          {
            $payload = "<h1>No hay ningun pedido en estado $filtro<h1>";
          }
          $fechaInicio == "" || $fechaFinal == "" ? $payload .= "Se tuvieron en cuenta todas las fechas" 
          : $payload .= "Se tuvo en cuenta entre el $fechaInicio al $fechaFinal ";
        }

      }

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'text/html');
    }

    public function TraerPedidosListos($request, $response, $args)
    {
      $usuarioLogueado = UsuarioController::TraerUsuarioActual($request,$response,$args);
      $listaPedidos = Pedido::ObtenerTodosLosPedidosPorEmpleado($usuarioLogueado->GetID());      
      $payload = Pedido::RetornarListaDePedidosString($listaPedidos,TERMINADO); 
      if($payload != false)
      {            
        $payload .= "Todos los pedidos terminados atendidos por usted $usuarioLogueado->nombre $usuarioLogueado->apellido";
        Logs::AgregarLogOperacion($usuarioLogueado,"trajo los pedidos listos para servir de su propiedad");
      }
      else
      {
        $payload = json_encode(array("mensaje" => "No hay ningun pedido listo para servir para el mozo $usuarioLogueado->nombre $usuarioLogueado->apellido"));
      }

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'text/html');    
    }

    public function TraerTodosProductosPedidos($request, $response, $args)
    {
      $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);
      $listaPedidos = Pedido::ObtenerTodosLosPedidos();
      $filtro = $args['filtro'];
      $filtro = strtolower($filtro);
      $estadoInt = Pedido::ObtenerEstadoInt($filtro);

      $payload = json_encode(array("mensaje" => "No se ingreso un estado válido"));
      
      if($estadoInt != -3)
      {
        $payload = Pedido::RetornarListaDePedidosConProductosString($listaPedidos,$usuarioLoguado,$estadoInt);
        if($payload == false)
        {
          $payload = "<h2>No hay productos para el estado $filtro<h2>";
        }
        $payload .= "<h3>Mostre todos los productos en estado $filtro que el usuario $usuarioLoguado->nombre $usuarioLoguado->apellido  puede ver<h3>";
      }

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'text/html');
    }

    public function ServirUnPedido($request, $response, $args)
    {
      $parametros = $request->getParsedBody();
      $codigoPedido = $parametros['codigoPedido'];
      $codigoMesa = $parametros['codigoMesa'];
      $usuarioLogueado = UsuarioController::TraerUsuarioActual($request,$response,$args);
      $pedido = Pedido::ObtenerPedido($codigoPedido);
      $mesa = Mesa::ObtenerMesa($codigoMesa);
      $listaPedidos = Pedido::ObtenerTodosLosPedidosPorEmpleado($usuarioLogueado->GetID());      
      $listaMesas = Mesa::ObtenerTodasLasMesas();      
      $payload = json_encode(array("mensaje" => "La mesa o el pedido no existen o no se encuentran listos para servir"));

      if($mesa != false && $pedido != false)
      {
        switch(Pedido::ServirPedido($listaPedidos,$listaMesas,$pedido,$mesa))
        {
          case -1:
            $payload = json_encode(array("mensaje" => "No hay pedidos terminados asignados al mozo"));
            break;

          case 0:
            $payload = json_encode(array("mensaje" => "La mesa está cerrada o el pedido seleccionado no está terminado o no pertenece al mozo"));
            break;

          case 1:
            $payload = json_encode(array("mensaje" => "Pedido servido con éxito"));
            Logs::AgregarLogOperacion($usuarioLogueado,"Sirvio exitosamente el pedido con el codigo $pedido->codigo");
            break;
        }
      }

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'text/html');    
    }
    
    public function TraerLoQueMasVendio($request, $response, $args)
    {
      $parametros = $request->getParsedBody();
      $fechaInicio = $parametros['fechaInicio'];
      $fechaFinal = $parametros['fechaFinal'];
      $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);
      $formatoFecha = ValidarFechas($fechaInicio,$fechaFinal);
      $listaProductos = Producto::ObtenerTodosLosProductos();
      $payload = json_encode(array("mensaje" => "La fecha tiene un formato invalido"));

      if($formatoFecha)
      {
        $payload = json_encode(array("mensaje" => "No hay ningun pedido o producto en la lista"));
        $maximo = Producto::ObtenerCantidadVendidosProductoMayor($listaProductos,$fechaInicio,$fechaFinal);
        $productosMasVendidos = Producto::RetornarProductosPorCantidadDeVentas($listaProductos,$fechaInicio,$fechaFinal,$maximo);

        if($productosMasVendidos != false && count($productosMasVendidos) > 0)
        {
          count($productosMasVendidos) > 1 ? $payload = "Los productos más vendidos fueron <br><br>"
          : $payload = "El producto más vendido fue <br><br>";
          $payload .= Producto::RetornarListaDeProductosString($productosMasVendidos,"","");
          $payload .= "<br>La cantidad vendida fue de $maximo unidades<br>";
  
          Logs::AgregarLogOperacion($usuarioLoguado,"pidio informacion sobre el/los productos más vendidos");
        }
        
        $fechaInicio == "" || $fechaFinal == "" ? $payload .= "Se tuvieron en cuenta todas las fechas" 
        : $payload .= "Se tuvo en cuenta entre el $fechaInicio al $fechaFinal ";
      }

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'text/html');
    }

    public function TraerLoQueMenosVendio($request, $response, $args)
    {
      $parametros = $request->getParsedBody();
      $fechaInicio = $parametros['fechaInicio'];
      $fechaFinal = $parametros['fechaFinal'];
      $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);
      $formatoFecha = ValidarFechas($fechaInicio,$fechaFinal);
      $listaProductos = Producto::ObtenerTodosLosProductos();
      $payload = json_encode(array("mensaje" => "La fecha tiene un formato invalido"));

      if($formatoFecha)
      {
        $payload = json_encode(array("mensaje" => "No hay ningun pedido o producto en la lista"));
        $minimo = Producto::ObtenerCantidadVendidosProductoMenor($listaProductos,$fechaInicio,$fechaFinal);
        $productosMenosVendidos = Producto::RetornarProductosPorCantidadDeVentas($listaProductos,$fechaInicio,$fechaFinal,$minimo);

        if($productosMenosVendidos != false && count($productosMenosVendidos) > 0)
        {
          count($productosMenosVendidos) > 1 ? $payload = "Los productos menos vendidos fueron <br><br>"
          : $payload = "El producto menos vendido fue <br><br>";
          $payload .= Producto::RetornarListaDeProductosString($productosMenosVendidos,"","");
          $payload .= "<br>La cantidad vendida fue de $minimo unidades<br>";
  
          Logs::AgregarLogOperacion($usuarioLoguado,"pidio informacion sobre el/los productos menos vendidos");
        }
        $fechaInicio == "" || $fechaFinal == "" ? $payload .= "Se tuvieron en cuenta todas las fechas" 
        : $payload .= "Se tuvo en cuenta entre el $fechaInicio al $fechaFinal ";
      }

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'text/html');
    }
    
    public function TraerLosNoEntregadosATiempo($request, $response, $args)
    {
      $parametros = $request->getParsedBody();
      $fechaInicio = $parametros['fechaInicio'];
      $fechaFinal = $parametros['fechaFinal'];
      $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);
      $formatoFecha = ValidarFechas($fechaInicio,$fechaFinal);
      $payload = json_encode(array("mensaje" => "La fecha tiene un formato invalido"));
      
      if($formatoFecha)
      {
        if($fechaInicio == "" && $fechaFinal == "")
        {
          $listaPedidosNoEntregadosATiempo = Pedido::ObtenerTodosLosPedidosQueNoLlegaronATiempo();
        }
        else
        {
          $listaPedidosNoEntregadosATiempo = Pedido::ObtenerTodosLosPedidosQueNoLlegaronATiempoEntreDosFechas($fechaInicio,$fechaFinal);
        }

        $payload = Pedido::RetornarListaDePedidosString($listaPedidosNoEntregadosATiempo,ENTREGADO);
        $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);
        
        $payload != false ? Logs::AgregarLogOperacion($usuarioLoguado,"pidio informacion sobre el/los pedidos no entregados a tiempo")
        : $payload = "<h1>No hay ningun pedido que no sea haya entregado a tiempo<h1>";
        
        $fechaInicio == "" || $fechaFinal == "" ? $payload .= "Se tuvieron en cuenta todas las fechas" 
        : $payload .= "Se tuvo en cuenta entre el $fechaInicio al $fechaFinal ";
      }

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'text/html');
    }

    public function TraerProductosMasVendidoAMenosVendido($request, $response, $args)
    {
      $parametros = $request->getParsedBody();
      $fechaInicio = $parametros['fechaInicio'];
      $fechaFinal = $parametros['fechaFinal'];
      $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);
      $formatoFecha = ValidarFechas($fechaInicio,$fechaFinal);
      $payload = json_encode(array("mensaje" => "La fecha tiene un formato invalido"));

      if($formatoFecha)
      {
        $payload = json_encode(array("mensaje" => "No hay ningun producto en la lista"));
        $listaProductos = Producto::ObtenerProductosOrdenadosPorCantidad($fechaInicio,$fechaFinal);

        if($listaProductos != false && count($listaProductos) > 0)
        {
          $payload = Producto::RetornarListaDeProductosString($listaProductos,$fechaInicio,$fechaFinal);
          Logs::AgregarLogOperacion($usuarioLoguado,"pidio informacion sobre todos los productos ordenados por cantidad de ventas");
        }
        
        $fechaInicio == "" || $fechaFinal == "" ? $payload .= "Se tuvieron en cuenta todas las fechas" 
        : $payload .= "Se tuvo en cuenta entre el $fechaInicio al $fechaFinal ";
      }

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'text/html');
    }

    public function CambiarEstadoUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $estado = $parametros['estado'];
        $idProducto = $parametros['idProducto'];
        $codigoPedido = $parametros['codigoPedido'];
        $tiempoDePreparacion = $parametros['tiempoDePreparacion'];
        $payload = json_encode(array("mensaje" => "No se pudo modificar el estado, revise que los datos ingresados sean correctos"));          
        $response->withStatus(401);
        $pedido = Pedido::ObtenerPedido($codigoPedido);
        $producto = Producto::ObtenerProducto($idProducto);
        $usuarioLoguado = MesaController::TraerUsuarioActual($request,$response,$args);

        if($pedido != false && $producto != false && is_numeric($tiempoDePreparacion) && $tiempoDePreparacion > 0)
        {
          $payload = json_encode(array("mensaje" => "Hubo un error al modificar el estado del pedido se ingreso un dato invalido"));          

          $estado = strtolower($estado);
          $estadoInt = Pedido::ObtenerEstadoInt($estado);

          if($estadoInt != -3)
          {
            $payload = json_encode(array("mensaje" => "No se modifico porque el estado del pedido ya estaba como " . $estado));          
        
            if($pedido->GetEstado() != $estadoInt)
            {  
              $payload = json_encode(array("mensaje" => "No se modifico porque el usuario no tiene acceso a ese producto. Usted esta logueado como $usuarioLoguado->rol y deberia ser $producto->rol"));          

              if($producto->GetRol() == $usuarioLoguado->GetRol() || $usuarioLoguado->GetTipo() == "socio")
              {
                $payload = json_encode(array("mensaje" => "Sólo el mozo o el socio puede servir el producto"));          

                if($estadoInt != ENTREGADO || $usuarioLoguado->GetTipo() == "socio")
                {
                  $payload = json_encode(array("mensaje" => "No puede asignarle al producto el estado $estado porque ya lo tiene asignado"));          

                  if(Producto::CambiarEstadoProductoPedido($pedido,$producto,$estadoInt,$tiempoDePreparacion))
                  {
                    $payload = json_encode(array("mensaje" => "Se modifico el estado exitosamente"));          
                    Logs::AgregarLogOperacion($usuarioLoguado,"modifico el estado del producto con id $producto->id perteneciente al pedido con código $pedido->codigo a $estado");
                  }

                  $response->withStatus(200);
                }
              }
            }
          }      
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
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