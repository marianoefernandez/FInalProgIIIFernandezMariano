<?php
require_once '../app/models/Usuario.php';
require_once '../app/models/Logs.php';
require_once './middlewares/AutentificadorJWT.php';
require_once '../app/models/Validaciones.php';

class LogOperacionesController extends Logs
{
    public function TraerUno($request, $response, $args)
    {
      $parametros = $request->getParsedBody();
      $fechaInicio = $parametros['fechaInicio'];
      $fechaFinal = $parametros['fechaFinal'];
      $usuarioId = $args['id'];
      $formatoFecha = ValidarFechas($fechaInicio,$fechaFinal);
      $payload = json_encode(array("mensaje" => "La fecha tiene un formato invalido"));

      if($formatoFecha)
      {
        if($fechaInicio == "" || $fechaFinal == "")
        {
          $listaLog = Logs::ObtenerLogsOperacionPorId($usuarioId);
        }
        else
        {
          $listaLog = Logs::ObtenerLogsOperacionPorIdEntreDosFechas($usuarioId,$fechaInicio,$fechaFinal);
        }

        $payload = Logs::RetornarListaDeLogsOperacionesPorId($listaLog,$usuarioId);
        
        $fechaInicio == "" || $fechaFinal == "" ? $payload .= "Se mostraron todas las operaciones " 
        : $payload .= "Se mostraron todas las operaciones entre el $fechaInicio al $fechaFinal ";
      }
      
      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodosSector($request, $response, $args)
    {
      $parametros = $request->getParsedBody();
      $fechaInicio = $parametros['fechaInicio'];
      $fechaFinal = $parametros['fechaFinal'];
      $rol = $args['sector'];
      $roles = array("socio", "bartender", "cocinero", "mozo","cervecero");
      $payload = "Error -> No se ingreso un sector correspondiente del sistema (socio, mozo, bartender, cocinero, mozo, cervecero)";
      $formatoFecha = ValidarFechas($fechaInicio,$fechaFinal);

      if(ValidarSectores($rol))
      {   
        $payload = json_encode(array("mensaje" => "La fecha tiene un formato invalido"));
        if($formatoFecha)
        {
          if($fechaInicio == "" || $fechaFinal == "")
          {
            $listaLog = Logs::ObtenerLogsOperaciones();
          }
          else
          {
            $listaLog = Logs::ObtenerLogsOperacionesEntreDosFechas($fechaInicio,$fechaFinal);
          }

          if($rol == "todos")
          {
            $payload = "";
            foreach ($roles as $rolEspecifico) 
            {
              $payload .= Logs::RetornarListaDeLogsOperacionesPorRol($listaLog,$rolEspecifico);
            } 
          }
          else
          {
            $payload = Logs::RetornarListaDeLogsOperacionesPorRol($listaLog,$rol);
          }

          $fechaInicio == "" || $fechaFinal == "" ? $payload .= "Se mostraron todas las operaciones " 
          : $payload .= "Se mostraron todas las operaciones entre el $fechaInicio al $fechaFinal ";

          if($payload == "")
          {
            $payload=("<h2>No se encontro ningun log en el sistema</h2>");
          }
        }
      }

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'text/html');
    }

    public function TraerTodosSectorUsuario($request, $response, $args)
    {
      $parametros = $request->getParsedBody();
      $fechaInicio = $parametros['fechaInicio'];
      $fechaFinal = $parametros['fechaFinal'];
      $rol = $args['sector'];
      $roles = array("socio", "bartender", "cocinero", "mozo","cervecero");
      $payload = "Error -> No se ingreso un sector correspondiente del sistema (socio, mozo, bartender, cocinero, mozo, cervecero)";
      $formatoFecha = ValidarFechas($fechaInicio,$fechaFinal);

      if(ValidarSectores($rol))
      {   
        $payload = json_encode(array("mensaje" => "La fecha tiene un formato invalido"));
        if($formatoFecha)
        {
          if($rol == "todos")
          {
            $payload = "";
            foreach ($roles as $rolEspecifico) 
            {
              $payload .= Logs::RetornarListaDeLogsOperacionesPorRolSeparadaPorUsuario($rolEspecifico,$fechaInicio,$fechaFinal);
            } 
          }
          else
          {
            $payload .= Logs::RetornarListaDeLogsOperacionesPorRolSeparadaPorUsuario($rol,$fechaInicio,$fechaFinal);
          }

          $fechaInicio == "" || $fechaFinal == "" ? $payload .= "Se mostraron todas las operaciones " 
          : $payload .= "Se mostraron todas las operaciones entre el $fechaInicio al $fechaFinal ";

          if($payload == "")
          {
            $payload=("<h2>No se encontro ningun log en el sistema</h2>");
          }
        }
      }
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'text/html');
    }
}
    