<?php
require_once '../app/models/Usuario.php';
require_once '../app/models/Validaciones.php';
require_once '../app/models/Logs.php';
require_once './middlewares/AutentificadorJWT.php';
require_once '../app/models/Archivos.php';


class LogLoginController extends Logs
{
    public function TraerUno($request, $response, $args)
    {
      $parametros = $request->getParsedBody();
      $fechaInicio = $parametros['fechaInicio'];
      $fechaFinal = $parametros['fechaFinal'];
      $formatoFecha = ValidarFechas($fechaInicio,$fechaFinal);
      $usuarioId = $args['id'];
      $payload = json_encode(array("mensaje" => "La fecha tiene un formato invalido"));

      if($formatoFecha)
      {
        if($fechaInicio == "" || $fechaFinal == "")
        {
          $listaLog = Logs::ObtenerLogsLoginPorId($usuarioId);
          $payload = "<h2>Obtengo los horarios de un sólo usuario</h2>";
        }
        else
        {
          $listaLog = Logs::ObtenerLogsLoginPorIdEntreDosFechas($usuarioId,$fechaInicio,$fechaFinal);
          $payload = "<h2>Obtengo los horarios de ingresos de un sólo usuario entre el $fechaInicio al $fechaFinal</h2>";
        }
        
        $payload .= Logs::RetornarListaDeLogsLoginPorId($listaLog,$usuarioId);

        if(isset($parametros['descarga']))
        {
          GestionarArchivos($parametros['descarga'], $payload,$listaLog ,"listaLogs");
        }

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
      $formatoFecha = ValidarFechas($fechaInicio,$fechaFinal);
      $payload = json_encode(array("mensaje" => "La fecha tiene un formato invalido"));

      if($formatoFecha)
      {
        if($fechaInicio == "" || $fechaFinal == "")
        {
          $listaLog = Logs::ObtenerLogsLogin();
          $payload = "<h2>Obtengo los horarios de ingresos de todos los usuarios</h2>";
        }
        else
        {
          $listaLog = Logs::ObtenerLogsLoginEntreDosFechas($fechaInicio,$fechaFinal);
          $payload = "<h2>Obtengo los horarios de ingresos de todos los usuarios entre el $fechaInicio al $fechaFinal</h2>";
        }

        $payload .= Logs::RetornarListaDeLogsLogin($listaLog);

        if(isset($parametros['descarga']))
        {
          GestionarArchivos($parametros['descarga'], $payload,$listaLog ,"listaLogs");
        }
      }

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'text/html');
    }
}
    