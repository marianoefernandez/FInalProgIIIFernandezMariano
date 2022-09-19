<?php
require_once '../app/models/Mesa.php';
require_once '../app/interfaces/IApiUsable.php';


class MesaController extends Mesa implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $fechaDeCreacion = $parametros['fechaDeCreacion'];

        // Creamos la mesa
        $mesa = Mesa::ConstruirMesa(CERRADA,$fechaDeCreacion);

        Mesa::AltaMesa($mesa) ? $payload = json_encode(array("mensaje" => "Mesa creada con exito")) : $payload = json_encode(array("mensaje" => "Hubo un error al crear la mesa"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        // Buscamos mesa por id
        $mesaCodigo = $args['mesaCodigo'];
        $mesa = Mesa::ObtenerMesa($mesaCodigo);

        $payload = json_encode(array("mensaje" => "Código incorrecto"));

        if($mesa != false)
        {
            $payload = json_encode($mesa);
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $listaMesas = Mesa::ObtenerTodasLasMesas();
        $payload = Mesa::RetornarListaDeMesasString($listaMesas);

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
}