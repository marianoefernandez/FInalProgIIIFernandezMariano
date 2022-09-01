<?php
require_once '../public/models/Producto.php';
require_once '../public/interfaces/IApiUsable.php';

class ProductoController extends Producto implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $nombre = $parametros['nombre'];
        $tipo = $parametros['tipo'];
        $rol = $parametros['rol'];
        $fechaDeCreacion = $parametros['fechaDeCreacion'];
        $precio = $parametros['precio'];


        // Creamos el producto
        $producto = Producto::CrearProducto($nombre,$tipo,$rol,$fechaDeCreacion,$precio);

        Producto::AltaProducto($producto) ? $payload = json_encode(array("mensaje" => "Producto creado con exito")) : $payload = json_encode(array("mensaje" => "Hubo un error al crear el producto"));;

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        // Buscamos producto por nombre
        $productoId = $args['id'];
        $producto = Producto::ObtenerProducto($productoId);

        $payload = json_encode(array("mensaje" => "Id incorrecto"));

        if($producto != false)
        {
            $payload = json_encode($producto);
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $listaProductos = Producto::ObtenerTodosLosProductos();
        $payload = Producto::RetornarListaDeProductosString($listaProductos);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'text/html');
    }
    
    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $payload = json_encode(array("mensaje" => "Producto modificado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $payload = json_encode(array("mensaje" => "Producto borrado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}