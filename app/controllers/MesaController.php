<?php
require_once '../app/models/Mesa.php';
require_once '../app/models/Usuario.php';
require_once '../app/models/Opinion.php';
require_once '../app/models/Logs.php';
require_once '../app/interfaces/IApiUsable.php';
require_once './middlewares/AutentificadorJWT.php';

class MesaController extends Mesa implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $payload = json_encode(array("mensaje" => "Hubo un error al crear la mesa"));
        $usuarioLoguado = MesaController::TraerUsuarioActual($request,$response,$args);
        $fechaDeCreacion = $parametros['fechaDeCreacion'];

        // Creamos la mesa
        $mesa = Mesa::ConstruirMesa(CERRADA,$fechaDeCreacion);

        if(Mesa::AltaMesa($mesa))
        {
          $payload = json_encode(array("mensaje" => "Mesa creada con exito"));
          Logs::AgregarLogOperacion($usuarioLoguado,"dio de alta la mesa con código $mesa->codigo");
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        // Buscamos mesa por id
        $usuarioLoguado = MesaController::TraerUsuarioActual($request,$response,$args);

        $mesaCodigo = $args['codigoMesa'];
        $mesa = Mesa::ObtenerMesa($mesaCodigo);

        $payload = json_encode(array("mensaje" => "La mesa no existe"));

        if($mesa != false)
        {
            $mesaAux = array();
            array_push($mesaAux,$mesa);
            $payload = Mesa::RetornarListaDeMesasString($mesaAux);
            Logs::AgregarLogOperacion($usuarioLoguado,"pidio información sobre la mesa con código $mesa->codigo");
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerMesasMasUsadas($request, $response, $args)
    {
      $payload = "No hay ninguna mesa dada de alta";
      $maximo = Mesa::ObtenerMayorCantidadPedidosPorMesa();
      $mesasMasUsadas = Mesa::RetornarMesasPorCantidadPedidos($maximo);
      $usuarioLoguado = MesaController::TraerUsuarioActual($request,$response,$args);

      if($mesasMasUsadas != false && count($mesasMasUsadas) > 0)
      {
        count($mesasMasUsadas) > 1 ? $payload = "Las mesas más usadas son <br><br>"
        : $payload = "La mesa más usada es <br><br>";
        $payload .= Mesa::RetornarListaDeMesasString($mesasMasUsadas);
        count($mesasMasUsadas) > 1 ? $payload .= "<br>Las mismas tienen $maximo pedidos dados de alta<br>"
        : $payload .= "<br>La misma tiene $maximo pedidos dados de alta<br>";

        Logs::AgregarLogOperacion($usuarioLoguado,"pidio informacion sobre la/las mesas mas usadas");

      }

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'text/html');
    }

    public function TraerMesasMenosUsadas($request, $response, $args)
    {
      $payload = "No hay ninguna mesa dada de alta";
      $minimo = Mesa::ObtenerMenorCantidadPedidosPorMesa();
      $mesasMenosUsadas = Mesa::RetornarMesasPorCantidadPedidos($minimo);
      $usuarioLoguado = MesaController::TraerUsuarioActual($request,$response,$args);

      if($mesasMenosUsadas != false && count($mesasMenosUsadas) > 0)
      {
        count($mesasMenosUsadas) > 1 ? $payload = "Las mesas menos usadas son <br><br>"
        : $payload = "La mesa menos usada es <br><br>";
        $payload .= Mesa::RetornarListaDeMesasString($mesasMenosUsadas);
        count($mesasMenosUsadas) > 1 ? $payload .= "<br>Las mismas tienen $minimo pedidos dados de alta<br>"
        : $payload .= "<br>La misma tiene $minimo pedidos dados de alta<br>";

        Logs::AgregarLogOperacion($usuarioLoguado,"pidio informacion sobre la/las mesas menos usadas");

      }
      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'text/html');
    }

    
    public function TraerMesasQueMasRecaudaron($request, $response, $args)
    {
      $payload = "No hay ninguna mesa dada de alta";
      $maximo = Mesa::ObtenerMayorRecaudacionPorMesa();
      $mesasQueMasRecaudaron = Mesa::RetornarMesasPorRecaudacion($maximo);
      $usuarioLoguado = MesaController::TraerUsuarioActual($request,$response,$args);

      if($mesasQueMasRecaudaron != false && count($mesasQueMasRecaudaron) > 0)
      {
        count($mesasQueMasRecaudaron) > 1 ? $payload = "Las mesas que más recaudaron son <br><br>"
        : $payload = "La mesa que más recaudo es <br><br>";
        $payload .= Mesa::RetornarListaDeMesasString($mesasQueMasRecaudaron);
        count($mesasQueMasRecaudaron) > 1 ? $payload .= "<br>Las mismas recaudaron $$maximo<br>"
        : $payload .= "<br>La misma recaudo $$maximo<br>";

        Logs::AgregarLogOperacion($usuarioLoguado,"pidio informacion sobre la/las mesas mas dinero recaudaron");

      }

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'text/html');
    }

    public function TraerMesasQueMenosRecaudaron($request, $response, $args)
    {
      $payload = "No hay ninguna mesa dada de alta";
      $minimo = Mesa::ObtenerMenorRecaudacionPorMesa();
      $mesasQueMenosRecaudaron = Mesa::RetornarMesasPorRecaudacion($minimo);
      $usuarioLoguado = MesaController::TraerUsuarioActual($request,$response,$args);

      if($mesasQueMenosRecaudaron != false && count($mesasQueMenosRecaudaron) > 0)
      {
        count($mesasQueMenosRecaudaron) > 1 ? $payload = "Las mesas que menos recaudaron son <br><br>"
        : $payload = "La mesa que menos recaudo es <br><br>";
        $payload .= Mesa::RetornarListaDeMesasString($mesasQueMenosRecaudaron);
        count($mesasQueMenosRecaudaron) > 1 ? $payload .= "<br>Las mismas recaudaron $$minimo<br>"
        : $payload .= "<br>La misma recaudo $$minimo<br>";

        Logs::AgregarLogOperacion($usuarioLoguado,"pidio informacion sobre la/las mesas mas dinero recaudaron");

      }

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'text/html');
    }


    public function TraerMesasConFacturaMayor($request, $response, $args)
    {
      $payload = "No hay ninguna mesa dada de alta";
      $maximo = Pedido::ObtenerMayorRecaudacion();
      $pedidosMayorRecaudacion = Pedido::RetornarPedidosPorRecaudacion($maximo);
      $mesasFacturaMayor = Mesa::RetornarMesasAsignadasAPedidos($pedidosMayorRecaudacion);
      $usuarioLoguado = MesaController::TraerUsuarioActual($request,$response,$args);

      if($mesasFacturaMayor != false && count($mesasFacturaMayor) > 0 && $pedidosMayorRecaudacion != false && count($pedidosMayorRecaudacion) > 0)
      {
        $maximo = number_format($maximo, 2, '.', '');
        count($mesasFacturaMayor) > 1 ? $payload = "Las mesas que tuvieron la factura mayor fueron <br><br>"
        : $payload = "La mesa que tuvo la factura mayor fue <br><br>";
        $payload .= Mesa::RetornarListaDeMesasString($mesasFacturaMayor);
        $payload .= "<br>La factura fue de $$maximo<br>";

        Logs::AgregarLogOperacion($usuarioLoguado,"pidio informacion sobre la/las mesas que emitieron la factura más cara");
      }

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'text/html');
    }

    public function TraerMesasConFacturaMenor($request, $response, $args)
    {
      $payload = "No hay ninguna mesa dada de alta";
      $minimo = Pedido::ObtenerMenorRecaudacion();
      $pedidosMenorRecaudacion = Pedido::RetornarPedidosPorRecaudacion($minimo);
      $mesasFacturaMenor = Mesa::RetornarMesasAsignadasAPedidos($pedidosMenorRecaudacion);
      $usuarioLoguado = MesaController::TraerUsuarioActual($request,$response,$args);

      if($mesasFacturaMenor != false && count($mesasFacturaMenor) > 0 && $pedidosMenorRecaudacion != false && count($pedidosMenorRecaudacion) > 0)
      {
        $minimo = number_format($minimo, 2, '.', '');
        count($mesasFacturaMenor) > 1 ? $payload = "Las mesas que tuvieron la factura menor fueron <br><br>"
        : $payload = "La mesa que tuvo la factura menor fue <br><br>";
        $payload .= Mesa::RetornarListaDeMesasString($mesasFacturaMenor);
        $payload .= "<br>La factura fue de $$minimo<br>";

        Logs::AgregarLogOperacion($usuarioLoguado,"pidio informacion sobre la/las mesas que emitieron la factura más barata");
      }

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'text/html');
    }

    public function TraerRecaudacionEntreFechas($request, $response, $args)
    {
        // Buscamos mesa por id
        $usuarioLoguado = MesaController::TraerUsuarioActual($request,$response,$args);

        $mesaCodigo = $args['codigoMesa'];
        $parametros = $request->getParsedBody();

        $fechaInicio = $parametros["fechaInicio"];
        $fechaFinal = $parametros["fechaFinal"];

        $mesa = Mesa::ObtenerMesa($mesaCodigo);

        $payload = json_encode(array("mensaje" => "La mesa no existe"));

        if($mesa != false)
        {
            $payload = json_encode("La mesa con código $mesa->codigo no facturo nada entre el $fechaInicio hasta el $fechaFinal ");                          

            $facturacion = Mesa::ObtenerFacturacionMesaPorFecha($mesa->GetCodigo(),$fechaInicio,$fechaFinal)[0];

            if(isset($facturacion) && is_float($facturacion))
            {
              $facturacion = number_format($facturacion, 2, '.', '');
              $payload = json_encode("La mesa con código $mesa->codigo facturo $$facturacion entre el $fechaInicio hasta el $fechaFinal ");                          
            }
            Logs::AgregarLogOperacion($usuarioLoguado,"pidio la facturación de la mesa con código $mesa->codigo entre las fechas $fechaInicio y $fechaFinal");

        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerMejoresComentarios($request, $response, $args)
    {
        // Buscamos mesa por id
        $usuarioLoguado = MesaController::TraerUsuarioActual($request,$response,$args);

        $mesaCodigo = $args['codigoMesa'];
        $mesa = Mesa::ObtenerMesa($mesaCodigo);

        $payload = json_encode(array("mensaje" => "La mesa no existe"));

        if($mesa != false)
        {
          $payload = json_encode(array("mensaje" => "No hay ningun comentario que corresponda dicha mesa"));
          $comentarios = Opinion::ObtenerMejoresOPeoresComentariosPorMesa($mesa->GetCodigo(),"MAX");

          if(count($comentarios)>0)
          {
            $payload = "Los comentarios con la más alta calificación para la mesa con código $mesa->codigo son<br><br>";
            $payload .= Opinion::RetornarListaComentarios($comentarios);
          }
          Logs::AgregarLogOperacion($usuarioLoguado,"pidio información sobre los comentarios mejor valorados de la mesa con código $mesa->codigo");
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    
    public function TraerPeoresComentarios($request, $response, $args)
    {
        // Buscamos mesa por id
        $usuarioLoguado = MesaController::TraerUsuarioActual($request,$response,$args);

        $mesaCodigo = $args['codigoMesa'];
        $mesa = Mesa::ObtenerMesa($mesaCodigo);

        $payload = json_encode(array("mensaje" => "La mesa no existe"));

        if($mesa != false)
        {
          $payload = json_encode(array("mensaje" => "No hay ningun comentario que corresponda dicha mesa"));
          $comentarios = Opinion::ObtenerMejoresOPeoresComentariosPorMesa($mesa->GetCodigo(),"MIN");

          if(count($comentarios)>0)
          {
            $payload = "Los comentarios con la más baja calificación para la mesa con código $mesa->codigo son<br><br>";
            $payload .= Opinion::RetornarListaComentarios($comentarios);
          }
          Logs::AgregarLogOperacion($usuarioLoguado,"pidio información sobre los comentarios peor valorados de la mesa con código $mesa->codigo");
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $listaMesas = Mesa::ObtenerTodasLasMesas();
        $payload = Mesa::RetornarListaDeMesasString($listaMesas);
        $usuarioLoguado = MesaController::TraerUsuarioActual($request,$response,$args);
        Logs::AgregarLogOperacion($usuarioLoguado,"pidio informacion sobre todas las mesas");

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'text/html');
    }
    
    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $payload = json_encode(array("mensaje" => "Mesa modificada con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $payload = json_encode(array("mensaje" => "Mesa borrada con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function CambiarEstadoUno($request, $response, $args)
    {
        $codigoMesa = $args['codigoMesa'];
        $parametros = $request->getParsedBody();
        $estado = $parametros['estado'];
        $payload = json_encode(array("mensaje" => "No se pudo modificar el estado, codigo mesa incorrecto"));          
        $response->withStatus(401);

        $mesa = Mesa::ObtenerMesa($codigoMesa);
        $usuarioLoguado = MesaController::TraerUsuarioActual($request,$response,$args);

        if($mesa != false)
        {
          $estado = strtolower($estado);
          $estadoInt = Mesa::ObtenerEstadoInt($estado);

          if($estadoInt != -3)
          {
            $payload = json_encode(array("mensaje" => "No se modifico porque el estado de la mesa ya estaba como " . $estado));          
        
            if($mesa->GetEstado() != $estadoInt)
            {
              $payload = json_encode(array("mensaje" => "Sólo un socio puede cerrar la mesa "));          
  
              if($mesa->GetEstado() > -1 || $usuarioLoguado->GetTipo() == "socio")
              {
                Mesa::CambiarEstadoMesa($mesa,$estadoInt);
                $payload = json_encode(array("mensaje" => "El estado de la mesa se modifico con exito y paso a ser " . $estado));          
                Logs::AgregarLogOperacion($usuarioLoguado,"modifico el estado de la mesa con código $mesa->codigo a $estado ");
                $response->withStatus(200);
              }
            }
          }
          else
          {
            $payload = json_encode(array("mensaje" => "Hubo un error al modificar el estado de la mesa"));          
          }
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public static function TraerUsuarioActual($request, $response, $args)    
    {
      $usuario = false;
  
      $header = $request->getHeaderLine('Authorization');
      $token = trim(explode("Bearer", $header)[1]);
  
      if(isset($token) && $token != "")
      {
        AutentificadorJWT::VerificarToken($token);
        $datosToken = AutentificadorJWT::ObtenerData($token);
        $usuario = Usuario::ObtenerUsuario($datosToken->id);
      }
  
      return $usuario;
    
    }


    
}