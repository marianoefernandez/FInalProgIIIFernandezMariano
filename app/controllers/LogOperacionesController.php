<?php
require_once '../app/models/Usuario.php';
require_once '../app/models/Logs.php';
require_once './middlewares/AutentificadorJWT.php';
require_once '../app/models/Validaciones.php';
require_once '../app/models/Archivos.php';


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
      $estados = 400;

      if($formatoFecha)
      {
        $estados = 200;
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
      
        if(isset($parametros['descarga']))
        {
          GestionarArchivos($parametros['descarga'], $payload,$listaLog ,"listaLog" . $usuarioId);
        }

      }
      
      $response->getBody()->write($payload);

      if($estados == 200)
      {
          return $response->withHeader('Content-Type', 'application/json');
      }
      else
      {
          return $response->withStatus($estados);
      }
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
      $estados = 400;

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
          else
          {
            $estados = 200;
            if(isset($parametros['descarga']))
            {
              GestionarArchivos($parametros['descarga'], $payload,$listaLog ,"listaLogsPorSector");
            }
          }
        }
      }

      $response->getBody()->write($payload);

      if($estados == 200)
      {
          return $response->withHeader('Content-Type', 'application/json');
      }
      else
      {
          return $response->withStatus($estados);
      }
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
      $estados = 400;

      if(ValidarSectores($rol))
      {   
        $payload = json_encode(array("mensaje" => "La fecha tiene un formato invalido"));
        if($formatoFecha)
        {
          $payload = "";
          
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
          else
          {
            $estados = 200;

            $fechaInicio == "" || $fechaFinal == "" ? $listaLog = Logs::ObtenerLogsOperaciones() 
            : $listaLog = Logs::ObtenerLogsOperacionesEntreDosFechas($fechaInicio,$fechaFinal);

            if(isset($parametros['descarga']))
            {
              GestionarArchivos($parametros['descarga'], $payload,$listaLog ,"listaLogsPorSectorSeparadaUsuario");
            }
          }
        }
      }
        $response->getBody()->write($payload);
        
        if($estados == 200)
        {
            return $response->withHeader('Content-Type', 'application/json');
        }
        else
        {
            return $response->withStatus($estados);
        }
    }
}
    