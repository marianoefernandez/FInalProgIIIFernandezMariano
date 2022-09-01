<?php
require_once '../public/models/Pedido.php';
require_once '../public/interfaces/IApiUsable.php';

class PedidoController extends Pedido implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $archivo = $request->getUploadedFiles();

        $codigoMesa = $parametros['codigoMesa'];
        $idUsuario = $parametros['idUsuario'];
        $idProducto = $parametros['idProducto'];
        $idCliente = $parametros['idCliente'];
        $cantidad = $parametros['cantidad'];
        $tiempoDePedido = $parametros['tiempoDePedido'];//Segundos
        $foto = $archivo['foto'];

        //Creamos el pedido
        $pedido = Pedido::ConstruirPedido($codigoMesa,$idUsuario,$idProducto,$idCliente,$cantidad,date("Y-m-j H:i:s"),date("Y-m-j H:i:s",time() + $tiempoDePedido),$foto->getClientFileName());

        switch(Pedido::AltaPedido($pedido))
        {
          case -1:
            $payload = json_encode(array("mensaje" => "Pedido creado con exito"));
            break;

          case 0:
            $payload = json_encode(array("mensaje" => "El usuario, la mesa o el producto no existen en la base de datos"));
            break;
          
          case 1:
            $payload = json_encode(array("mensaje" => "Pedido creado con exito"));
            break;
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        // Buscamos usuario por nombre
        $pedidoId = $args['id'];
        $pedido = Pedido::ObtenerPedido($pedidoId);

        $payload = json_encode(array("mensaje" => "Id incorrecto"));

        if($pedido != false)
        {
            $payload = json_encode($pedido);
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $listaPedidos = Pedido::ObtenerTodosLosPedidos();
        $listaUsuarios = Usuario::ObtenerTodosLosUsuarios();
        $listaMesas = Mesa::ObtenerTodasLasMesas();
        $listaProductos = Producto::ObtenerTodosLosProductos();
        //$payload = json_encode(array("listaUsuario" => $lista));
        $payload = Pedido::RetornarListaDePedidosString($listaPedidos,$listaUsuarios,$listaMesas,$listaProductos,ENPREPARACION);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'text/html');
    }
    
    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $payload = json_encode(array("mensaje" => "Pedido modificado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $payload = json_encode(array("mensaje" => "Pedido borrado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}