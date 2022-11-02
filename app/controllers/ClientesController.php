<?php
require_once '../app/models/Pedido.php';
require_once '../app/models/Producto.php';
require_once '../app/models/Mesa.php';
require_once '../app/models/Usuario.php';
require_once '../app/models/Opinion.php';
require_once '../app/models/Logs.php';
require_once './middlewares/AutentificadorJWT.php';
require_once 'UsuarioController.php';
//require_once './middlewares/MWVerificar.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use AutentificadorJWT as AutentificadorJWT;
use Slim\Handlers\Strategies\RequestHandler;
//use MWVerificar as Verificar;
 

class ClientesController
{
    public function DarOpinion($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $codigoMesa = $parametros['codigoMesa'];
        $codigoPedido = $parametros['codigoPedido'];
        $notaMesa = $parametros['notaMesa'];
        $notaRestaurante = $parametros['notaRestaurante'];
        $notaCocinero = $parametros['notaCocinero'];
        $notaMozo = $parametros['notaMozo'];
        $comentario = $parametros['comentario'];
        $payload = json_encode(array("mensaje" => "Las notas deben ser del 1 al 10 y la opinión no debe superar los 66 caracteres"));
        
        if(Opinion::ValidarParametros($notaCocinero,$notaMesa,$notaMozo,$notaRestaurante,$comentario))
        {
          $opinion = Opinion::ConstruirOpinion(0,$codigoMesa,$codigoPedido,$notaCocinero,$notaMesa,$notaMozo,$notaRestaurante,$comentario);
          $listaOpiniones = Opinion::ObtenerTodasLasOpiniones();

          switch(Opinion::AltaOpinion($listaOpiniones,$opinion))
          {
            case -4:
              $payload = json_encode(array("mensaje" => "No se pudo crear la opinión verifique los datos ingresados"));
              break;

            case -3:
              $payload = json_encode(array("mensaje" => "La mesa ingresada no existe"));
              break;

            case -2:
              $payload = json_encode(array("mensaje" => "El pedido ingresado no existe"));
              break;
  
            case -1:
              $payload = json_encode(array("mensaje" => "El pedido debio de haber terminado para poder hacer una opinión"));
              break;  
  
            case 0:
              $payload = json_encode(array("mensaje" => "Ya se emitio la opinión para este pedido"));
              break;
            
            case 1:
              $payload = json_encode(array("mensaje" => "Opinión enviada con exito"));
              break;
          }
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTiempoDemora($request, $response, $args)
    {
      $parametros = $request->getParsedBody();
      $codigoMesa = $_GET['codigoMesa'];
      $codigoPedido = $_GET['codigoPedido'];
      $mesa = Mesa::ObtenerMesa($codigoMesa);
      $pedido = Pedido::ObtenerPedido($codigoPedido);
      
      $payload = json_encode(array("mensaje" => "Hubo un error al extraer la informacion"));

      if($mesa != false)
      {
        $payload = json_encode(array("mensaje" => "El pedido no existe"));
        if($pedido != false)
        {
          $payload = "<h2>Tiempo de demora para el pedido con el código $codigoPedido correspondiente a la mesa con código $codigoMesa:<h2>";
          $payload .= Pedido::RetornarTiempoDemora($pedido);
        }
      }
      else
      {
        $payload = json_encode(array("mensaje" => "La mesa no existe"));
      }
    

      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json');
    }
}