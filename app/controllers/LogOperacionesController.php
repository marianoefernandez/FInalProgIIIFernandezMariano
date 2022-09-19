<?php
require_once '../app/models/Usuario.php';
require_once '../app/models/Logs.php';
require_once './middlewares/AutentificadorJWT.php';

class LogLoginController extends Logs
{
    public function TraerUno($request, $response, $args)
    {
        $usuarioId = $args['id'];
        $payload = Logs::RetornarListaDeLogsOperacionesPorId($usuarioId);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $payload = Logs::RetornarListaDeLogsOperaciones();

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'text/html');
    }
}
    