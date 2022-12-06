<?php
require_once '../app/models/Producto.php';
require_once '../app/interfaces/IApiUsable.php';

class ProductoController extends Producto implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $estados = 400;
        $payload = json_encode(array("mensaje" => "Debe ingresar un rol valido"));
        $nombre = $parametros['nombre'];
        $tipo = $parametros['tipo'];
        $rol = $parametros['rol'];
        $fechaDeCreacion = $parametros['fechaDeCreacion'];
        $precio = $parametros['precio'];

        if(isset($fechaDeCreacion) || $fechaDeCreacion == "")
        {
           $fechaDeCreacion = date("Y-m-j H:i:s");
        }

        // Creamos el producto
        if($rol == "bartender" || $rol == "cocinero" || $rol == "mozo" || $rol == "cervecero")
        {
          $payload = json_encode(array("mensaje" => "Hubo un error al crear el producto"));
          $producto = Producto::CrearProducto($nombre,$tipo,$rol,$fechaDeCreacion,$precio);
          if(Producto::AltaProducto($producto))
          {
            $payload = json_encode(array("mensaje" => "Producto creado con exito"));
            $estados = 201;
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

    public function TraerUno($request, $response, $args)
    {
        // Buscamos producto por nombre
        $productoId = $args['id'];
        $producto = Producto::ObtenerProducto($productoId);
        $estados = 400;
        $payload = json_encode(array("mensaje" => "Id incorrecto"));

        if($producto != false)
        {
            $payload = json_encode($producto);
            $estados = 200;
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

    public function TraerTodos($request, $response, $args)
    {
        $listaProductos = Producto::ObtenerTodosLosProductos();
        $payload = Producto::RetornarListaDeProductosString($listaProductos,"","");

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'text/html');
    }
    
    public function ModificarUno($request, $response, $args)
    {
      $parametros = $request->getParsedBody();
      $estados = 400;
      $nombre = $parametros['nombre'];
      $tipo = $parametros['tipo'];
      $rol = $parametros['rol'];
      $fechaDeCreacion = $parametros['fechaDeCreacion'];
      $precio = $parametros['precio'];
      $idProducto = $parametros['idProducto']; 
      $payload = json_encode(array("mensaje" => "Debe ingresar un rol válido"));

      if(isset($fechaDeCreacion) || $fechaDeCreacion == "")
      {
         $fechaDeCreacion = date("Y-m-j H:i:s");
      }
      if($rol == "bartender" || $rol == "cocinero" || $rol == "mozo" || $rol == "cervecero")
      {
        // Creamos el producto
        $producto = Producto::CrearProducto($nombre,$tipo,$rol,$fechaDeCreacion,$precio);
        $producto->SetID($idProducto);

        switch(Producto::ModificarProducto($producto))
        {
          case 2:
            $payload = json_encode(array("mensaje" => "Producto Modificado con exito"));
            $estados = 201;
            break;

          case 1:
            $payload = json_encode(array("mensaje" => "El producto quedo con los mismos datos o los datos a modificar corresponden a un producto ya activo (VERIFICAR NOMBRE, ROL y TIPO)"));
            break;

          case 0:
            $payload = json_encode(array("mensaje" => "El ID no existe en la lista"));
            break;

          case -1:
            $payload = json_encode(array("mensaje" => "Hubo un error al modificar el producto revise los datos"));
            break;
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

    public function BorrarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $id = $args['id'];
        $estados = 400;

        $payload = json_encode(array("mensaje" => "Hubo un error al eliminar el producto"));

        if(Producto::DarDeBajaUnProducto($id))
        {
          $payload = json_encode(array("mensaje" => "Producto eliminado con exito"));
          $estados = 200;
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