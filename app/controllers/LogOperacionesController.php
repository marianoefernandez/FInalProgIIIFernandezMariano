<?php
require_once '../app/models/Usuario.php';
require_once '../app/models/Logs.php';
require_once './middlewares/AutentificadorJWT.php';

class LogOperacionesController extends Logs
{
    public function TraerUno($request, $response, $args)
    {
        $usuarioId = $args['id'];
        $payload = Logs::RetornarListaDeLogsOperacionesPorId($usuarioId);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodosSector($request, $response, $args)
    {
        $rol = $args['sector'];
        $payload = "Error -> No se ingreso un sector correspondiente del sistema (socio, mozo, bartender, cocinero, mozo, cervecero)";

        if($rol == "socio" || $rol == "bartender" || $rol == "cocinero" || $rol == "mozo" || $rol == "cerveceros")
        {
          $payload = Logs::RetornarListaDeLogsOperacionesPorRol($rol);
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'text/html');
    }

    public function TraerTodosSectorUsuario($request, $response, $args)
    {
        $rol = $args['sector'];
        $payload = "Error -> No se ingreso un sector correspondiente del sistema (socio, mozo, bartender, cocinero, mozo, cervecero)";

        if($rol == "socio" || $rol == "bartender" || $rol == "cocinero" || $rol == "mozo" || $rol == "cerveceros")
        {
          $payload = Logs::RetornarListaDeLogsOperacionesPorRolSeparadaPorUsuario($rol);
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'text/html');
    }
}
    