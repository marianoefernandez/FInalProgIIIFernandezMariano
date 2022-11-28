<?php
require_once '../app/models/Mesa.php';
require_once '../app/models/Usuario.php';
require_once '../app/models/Pedido.php';
require_once '../app/models/Opinion.php';
require_once '../app/models/Logs.php';
require_once '../app/interfaces/IApiUsable.php';
require_once './middlewares/AutentificadorJWT.php';
require_once '../app/models/Archivos.php';

class MesaController extends Mesa implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $payload = json_encode(array("mensaje" => "Hubo un error al crear la mesa"));
        $usuarioLoguado = MesaController::TraerUsuarioActual($request,$response,$args);
        $fechaDeCreacion = $parametros['fechaDeCreacion'];

        
        if(isset($fechaDeCreacion) || $fechaDeCreacion == "")
        {
          $fechaDeCreacion = date("Y-m-d");  
        }


        // Creamos la mesa
        $mesa = Mesa::ConstruirMesa(CERRADA,$fechaDeCreacion);

        if(Mesa::AltaMesa($mesa))
        {
          $payload = json_encode(array("mensaje" => "Mesa creada con exito"));
          Logs::AgregarLogOperacion($usuarioLoguado,"dio de alta la mesa con codigo $mesa->codigo");
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
            Logs::AgregarLogOperacion($usuarioLoguado,"pidio información sobre la mesa con codigo $mesa->codigo");
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerMesasMasUsadas($request, $response, $args)
    {
      $parametros = $request->getParsedBody();
      $fechaInicio = $parametros['fechaInicio'];
      $fechaFinal = $parametros['fechaFinal'];
      $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);
      $formatoFecha = ValidarFechas($fechaInicio,$fechaFinal);
      $payload = json_encode(array("mensaje" => "La fecha tiene un formato invalido"));
      
      if($formatoFecha)
      {
        $payload = json_encode(array("mensaje" => "No se encontraron pedidos en la lista"));
        $listaMesas = Mesa::ObtenerTodasLasMesas();
        $listaPedidos = Pedido::TraerPedidosPorFecha($fechaInicio,$fechaFinal);
        $maximo = Mesa::ObtenerMayorCantidadPedidosPorMesa($listaPedidos,$listaMesas);
        $mesasMasUsadas = Mesa::RetornarMesasPorCantidadPedidos($listaPedidos,$listaMesas,$maximo);
        
        if($mesasMasUsadas != false && count($mesasMasUsadas) > 0)
        {
          count($mesasMasUsadas) > 1 ? $payload = "Las mesas más usadas son <br><br>"
          : $payload = "La mesa más usada es <br><br>";
          $payload .= Mesa::RetornarListaDeMesasString($mesasMasUsadas);
          count($mesasMasUsadas) > 1 ? $payload .= "<br>Las mismas tienen $maximo pedidos dados de alta<br>"
          : $payload .= "<br>La misma tiene $maximo pedidos dados de alta<br>";
          
          Logs::AgregarLogOperacion($usuarioLoguado,"pidio informacion sobre la/las mesas mas usadas");
          
          if(isset($parametros['descarga']))
          {
            count($mesasMasUsadas) > 1 ?
            GestionarArchivos($parametros['descarga'], $payload,$mesasMasUsadas ,"mesasMasUsadas") :
            GestionarArchivos($parametros['descarga'], $payload,$mesasMasUsadas ,"mesaMasUsada");
          }
        }

        $fechaInicio == "" || $fechaFinal == "" ? $payload .= "Se tuvieron en cuenta todas las fechas" 
        : $payload .= "Se tuvo en cuenta entre el $fechaInicio al $fechaFinal ";
      }

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'text/html');
    }

    public function TraerMesasMenosUsadas($request, $response, $args)
    {
      $parametros = $request->getParsedBody();
      $fechaInicio = $parametros['fechaInicio'];
      $fechaFinal = $parametros['fechaFinal'];
      $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);
      $formatoFecha = ValidarFechas($fechaInicio,$fechaFinal);
      $payload = json_encode(array("mensaje" => "La fecha tiene un formato invalido"));

      if($formatoFecha)
      {
        $payload = json_encode(array("mensaje" => "No se encontraron pedidos en la lista"));
        $listaMesas = Mesa::ObtenerTodasLasMesas();
        $listaPedidos = Pedido::TraerPedidosPorFecha($fechaInicio,$fechaFinal);
        $minimo = Mesa::ObtenerMenorCantidadPedidosPorMesa($listaPedidos,$listaMesas);
        $mesasMenosUsadas = Mesa::RetornarMesasPorCantidadPedidos($listaPedidos,$listaMesas,$minimo);

        if($mesasMenosUsadas != false && count($mesasMenosUsadas) > 0)
        {
          count($mesasMenosUsadas) > 1 ? $payload = "Las mesas menos usadas son <br><br>"
          : $payload = "La mesa menos usada es <br><br>";
          $payload .= Mesa::RetornarListaDeMesasString($mesasMenosUsadas);
          count($mesasMenosUsadas) > 1 ? $payload .= "<br>Las mismas tienen $minimo pedidos dados de alta<br>"
          : $payload .= "<br>La misma tiene $minimo pedidos dados de alta<br>";

          Logs::AgregarLogOperacion($usuarioLoguado,"pidio informacion sobre la/las mesas menos usadas");
        
          if(isset($parametros['descarga']))
          {
            count($mesasMenosUsadas) > 1 ?
            GestionarArchivos($parametros['descarga'], $payload,$mesasMenosUsadas ,"mesasMenosUsadas") :
            GestionarArchivos($parametros['descarga'], $payload,$mesasMenosUsadas ,"mesaMenosUsada");
          }

        }   
        $fechaInicio == "" || $fechaFinal == "" ? $payload .= "Se tuvieron en cuenta todas las fechas" 
        : $payload .= "Se tuvo en cuenta entre el $fechaInicio al $fechaFinal ";
      }
      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'text/html');
    }

    
    public function TraerMesasQueMasRecaudaron($request, $response, $args)
    {
      $parametros = $request->getParsedBody();
      $fechaInicio = $parametros['fechaInicio'];
      $fechaFinal = $parametros['fechaFinal'];
      $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);
      $formatoFecha = ValidarFechas($fechaInicio,$fechaFinal);
      $payload = json_encode(array("mensaje" => "La fecha tiene un formato invalido"));

      if($formatoFecha)
      {
        $listaMesas = Mesa::ObtenerTodasLasMesas();
        $listaPedidos = Pedido::TraerPedidosPorFecha($fechaInicio,$fechaFinal);
        $maximo = Mesa::ObtenerMayorRecaudacionPorMesa($listaPedidos,$listaMesas);
        $mesasQueMasRecaudaron = Mesa::RetornarMesasPorRecaudacion($listaPedidos,$listaMesas,$maximo);
      
        if($mesasQueMasRecaudaron != false && count($mesasQueMasRecaudaron) > 0)
        {
          count($mesasQueMasRecaudaron) > 1 ? $payload = "Las mesas que más recaudaron son <br><br>"
          : $payload = "La mesa que más recaudo es <br><br>";
          $payload .= Mesa::RetornarListaDeMesasString($mesasQueMasRecaudaron);
          count($mesasQueMasRecaudaron) > 1 ? $payload .= "<br>Las mismas recaudaron $$maximo<br>"
          : $payload .= "<br>La misma recaudo $$maximo<br>";
  
          Logs::AgregarLogOperacion($usuarioLoguado,"pidio informacion sobre la/las mesas mas dinero recaudaron");
        
          if(isset($parametros['descarga']))
          {
            count($mesasQueMasRecaudaron) > 1 ?
            GestionarArchivos($parametros['descarga'], $payload,$mesasQueMasRecaudaron ,"mesasQueMasRecaudaron") :
            GestionarArchivos($parametros['descarga'], $payload,$mesasQueMasRecaudaron ,"mesaQueMasRecaudo");
          }
        }
        $fechaInicio == "" || $fechaFinal == "" ? $payload .= "Se tuvieron en cuenta todas las fechas" 
        : $payload .= "Se tuvo en cuenta entre el $fechaInicio al $fechaFinal ";
      }

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'text/html');
    }

    public function TraerMesasQueMenosRecaudaron($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $fechaInicio = $parametros['fechaInicio'];
        $fechaFinal = $parametros['fechaFinal'];
        $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);
        $formatoFecha = ValidarFechas($fechaInicio,$fechaFinal);
        $payload = json_encode(array("mensaje" => "La fecha tiene un formato invalido"));

      if($formatoFecha)
      {
        $listaMesas = Mesa::ObtenerTodasLasMesas();
        $listaPedidos = Pedido::TraerPedidosPorFecha($fechaInicio,$fechaFinal);
        $minimo = Mesa::ObtenerMenorRecaudacionPorMesa($listaPedidos,$listaMesas);
        $mesasQueMenosRecaudaron = Mesa::RetornarMesasPorRecaudacion($listaPedidos,$listaMesas,$minimo);

        if($mesasQueMenosRecaudaron != false && count($mesasQueMenosRecaudaron) > 0)
        {
          count($mesasQueMenosRecaudaron) > 1 ? $payload = "Las mesas que menos recaudaron son <br><br>"
          : $payload = "La mesa que menos recaudo es <br><br>";
          $payload .= Mesa::RetornarListaDeMesasString($mesasQueMenosRecaudaron);
          count($mesasQueMenosRecaudaron) > 1 ? $payload .= "<br>Las mismas recaudaron $$minimo<br>"
          : $payload .= "<br>La misma recaudo $$minimo<br>";
  
          Logs::AgregarLogOperacion($usuarioLoguado,"pidio informacion sobre la/las mesas mas dinero recaudaron");
        
          if(isset($parametros['descarga']))
          {
            count($mesasQueMenosRecaudaron) > 1 ?
            GestionarArchivos($parametros['descarga'], $payload,$mesasQueMenosRecaudaron ,"mesasQueMenosRecaudaron") :
            GestionarArchivos($parametros['descarga'], $payload,$mesasQueMenosRecaudaron ,"mesaQueMenosRecaudo");
          }
        
        }
        $fechaInicio == "" || $fechaFinal == "" ? $payload .= "Se tuvieron en cuenta todas las fechas" 
        : $payload .= "Se tuvo en cuenta entre el $fechaInicio al $fechaFinal ";
      }

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'text/html');
    }

    public function TraerMesasOrdenadasPorRecaudacion($request, $response, $args)
    {
      $parametros = $request->getParsedBody();
      $fechaInicio = $parametros['fechaInicio'];
      $fechaFinal = $parametros['fechaFinal'];
      $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);
      $formatoFecha = ValidarFechas($fechaInicio,$fechaFinal);
      $payload = json_encode(array("mensaje" => "La fecha tiene un formato invalido"));

      if($formatoFecha)
      {
        $listaMesas = Mesa::ObtenerMesasOrdenadasPorRecaudacion($fechaInicio,$fechaFinal);
      
        if($listaMesas != false && count($listaMesas) > 0)
        {
          $payload = Mesa::RetornarListaDeMesasConRecaudacionString($listaMesas,$fechaInicio,$fechaFinal);
  
          Logs::AgregarLogOperacion($usuarioLoguado,"pidio informacion sobre la/las mesas ordenadas por recaudacion");
        }
        $fechaInicio == "" || $fechaFinal == "" ? $payload .= "Se tuvieron en cuenta todas las fechas" 
        : $payload .= "Se tuvo en cuenta entre el $fechaInicio al $fechaFinal ";
      }

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'text/html');
    }


    public function TraerMesasConFacturaMayor($request, $response, $args)
    {
      $parametros = $request->getParsedBody();
      $fechaInicio = $parametros['fechaInicio'];
      $fechaFinal = $parametros['fechaFinal'];
      $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);
      $formatoFecha = ValidarFechas($fechaInicio,$fechaFinal);
      $payload = json_encode(array("mensaje" => "La fecha tiene un formato invalido"));

      if($formatoFecha)
      {
        $listaMesas = Mesa::ObtenerTodasLasMesas();
        $listaPedidos = Pedido::TraerPedidosPorFecha($fechaInicio,$fechaFinal);
        $maximo = Pedido::ObtenerMayorRecaudacion($listaPedidos);
        $pedidosMayorRecaudacion = Pedido::RetornarPedidosPorRecaudacion($listaPedidos,$maximo);
        $mesasFacturaMayor = Mesa::RetornarMesasAsignadasAPedidos($pedidosMayorRecaudacion,$listaMesas);

        if($mesasFacturaMayor != false && count($mesasFacturaMayor) > 0 && $pedidosMayorRecaudacion != false && count($pedidosMayorRecaudacion) > 0)
        {
          $maximo = number_format($maximo, 2, '.', '');
          count($mesasFacturaMayor) > 1 ? $payload = "Las mesas que tuvieron la factura mayor fueron <br><br>"
          : $payload = "La mesa que tuvo la factura mayor fue <br><br>";
          $payload .= Mesa::RetornarListaDeMesasString($mesasFacturaMayor);
          $payload .= "<br>La factura fue de $$maximo<br>";
  
          Logs::AgregarLogOperacion($usuarioLoguado,"pidio informacion sobre la/las mesas que emitieron la factura mas cara");
          
          if(isset($parametros['descarga']))
          {
            count($mesasFacturaMayor) > 1 ?
            GestionarArchivos($parametros['descarga'], $payload,$mesasFacturaMayor ,"mesasFacturaMayor") :
            GestionarArchivos($parametros['descarga'], $payload,$mesasFacturaMayor ,"mesaFacturaMayor");
          }

        }
        $fechaInicio == "" || $fechaFinal == "" ? $payload .= "Se tuvieron en cuenta todas las fechas" 
        : $payload .= "Se tuvo en cuenta entre el $fechaInicio al $fechaFinal ";   
      }

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'text/html');
    }

    public function TraerMesasConFacturaMenor($request, $response, $args)
    {
      $parametros = $request->getParsedBody();
      $fechaInicio = $parametros['fechaInicio'];
      $fechaFinal = $parametros['fechaFinal'];
      $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);
      $formatoFecha = ValidarFechas($fechaInicio,$fechaFinal);
      $payload = json_encode(array("mensaje" => "La fecha tiene un formato invalido"));

      if($formatoFecha)
      {
        $listaMesas = Mesa::ObtenerTodasLasMesas();
        $listaPedidos = Pedido::TraerPedidosPorFecha($fechaInicio,$fechaFinal);
        $minimo = Pedido::ObtenerMenorRecaudacion($listaPedidos);
        $pedidosMenorRecaudacion = Pedido::RetornarPedidosPorRecaudacion($listaPedidos,$minimo);
        $mesasFacturaMenor = Mesa::RetornarMesasAsignadasAPedidos($pedidosMenorRecaudacion,$listaMesas);

        if($mesasFacturaMenor != false && count($mesasFacturaMenor) > 0 && $pedidosMenorRecaudacion != false && count($pedidosMenorRecaudacion) > 0)
        {
          $minimo = number_format($minimo, 2, '.', '');
          count($mesasFacturaMenor) > 1 ? $payload = "Las mesas que tuvieron la factura menor fueron <br><br>"
          : $payload = "La mesa que tuvo la factura menor fue <br><br>";
          $payload .= Mesa::RetornarListaDeMesasString($mesasFacturaMenor);
          $payload .= "<br>La factura fue de $$minimo<br>";
          Logs::AgregarLogOperacion($usuarioLoguado,"pidio informacion sobre la/las mesas que emitieron la factura mas barata");
        
          if(isset($parametros['descarga']))
          {
            count($mesasFacturaMenor) > 1 ?
            GestionarArchivos($parametros['descarga'], $payload,$mesasFacturaMenor ,"mesasFacturaMenor") :
            GestionarArchivos($parametros['descarga'], $payload,$mesasFacturaMenor ,"mesaFacturaMenor");
          }

        }
        $fechaInicio == "" || $fechaFinal == "" ? $payload .= "Se tuvieron en cuenta todas las fechas" 
        : $payload .= "Se tuvo en cuenta entre el $fechaInicio al $fechaFinal ";  
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
        $formatoFecha = ValidarFechas($fechaInicio,$fechaFinal);
        $mesa = Mesa::ObtenerMesa($mesaCodigo);
        $payload = json_encode(array("mensaje" => "La fecha tiene un formato invalido"));

        if($formatoFecha)
        {
          $payload = json_encode(array("mensaje" => "Las fechas están vacias"));

          if($fechaFinal != "" && $fechaInicio != "")
          {
            $payload = json_encode(array("mensaje" => "La mesa no existe"));

            if($mesa != false)
            {
                $payload = json_encode("La mesa con código $mesa->codigo no facturo nada entre el $fechaInicio hasta el $fechaFinal ");                          
    
                $facturacion = Mesa::ObtenerFacturacionMesaPorFecha($mesa->GetCodigo(),$fechaInicio,$fechaFinal)[0];
    
                if(isset($facturacion) && is_float($facturacion))
                {
                  $facturacion = number_format($facturacion, 2, '.', '');
                  $payload = ("<h2>La mesa con código $mesa->codigo facturo $$facturacion entre el $fechaInicio hasta el $fechaFinal<h2>");                          
                }
                Logs::AgregarLogOperacion($usuarioLoguado,"pidio la facturación de la mesa con codigo $mesa->codigo entre las fechas $fechaInicio y $fechaFinal");
                
                if(isset($parametros['descarga']))
                {
                  GestionarArchivos($parametros['descarga'], $payload,$mesa ,"mesa $mesa->codigo factura entre $fechaInicio a $fechaFinal");
                }

              }
          }
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

                if($estadoInt == PAGANDO)
                {
                  $payload = json_encode(array("mensaje" => "Mesa cobrada con éxito. El socio debe cerrar la mesa ahora"));          
                }

                Logs::AgregarLogOperacion($usuarioLoguado,"modifico el estado de la mesa con codigo $mesa->codigo a $estado ");
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