<?php
require_once '../app/models/Usuario.php';
require_once '../app/models/Mesa.php';
require_once '../app/models/Pedido.php';
require_once '../app/models/Producto.php';
require_once '../app/models/Opinion.php';
require_once '../app/models/Archivos.php';
require_once '../app/models/Logs.php';
require_once './middlewares/AutentificadorJWT.php';
//require_once './middlewares/MWVerificar.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use AutentificadorJWT as AutentificadorJWT;
use Slim\Handlers\Strategies\RequestHandler;
//use MWVerificar as Verificar;
 

class CsvController
{
    public function CargaForzada($request, $response, $args)
    {
        $payload = "<h2>Hubo un error al leer el archivo CSV<h2>";
        $filtro = $args['filtro'];
        $lista = LeerCSV();
        $retornoCarga = 0;
        $cantidadElementosLista = 0;
        $estados = 200;

        if(isset($lista))
        {
            $cantidadElementosLista = count($lista);
            $payload = "<h2>No se pudieron cargar ningun dato de tipo $filtro puede ser que el archivo no sea el correcto o que los datos ya existan en la base de datos<h2>";
            $filtro = strtolower($filtro);
            switch($filtro)
            {
                case "usuarios":
                    $retornoCarga = Usuario::CargaForzada($lista);
                    break;

                case "pedidos":
                    break;   

                case "productos":
                    break;

                case "mesas":
                    $retornoCarga = Mesa::CargaForzada($lista);
                    break;

                case "opiniones":
                    break;

                default:
                    $payload = false;
                    break;
            }

            if($payload != false)
            {
                $retornoCarga > 0 ? 
                $payload = "<h2>Se cargaron datos de $filtro <h2><br> <h3>Se cargaron con exito $retornoCarga de $cantidadElementosLista $filtro<h3>" :
                $payload = "<h2>No se pudo cargar ni un dato de $filtro <h2><br> <h3>Se cargaron con exito $retornoCarga de $cantidadElementosLista $filtro<h3>";
        
            }
            else
            {
                $payload = "<h2>No existe la página actual<h2>";
                $estados = 404;
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

    public static function TraerUsuarioActual($request, $response, $args)    
    {
      $usuario = false;
  
      $header = $request->getHeaderLine('Authorization');
      $token = trim(explode("Bearer", $header)[1]);
  
      if(isset($token) && $token != "")
      {
        AutentificadorJWT::VerificarToken($token);
        $datosToken = AutentificadorJWT::ObtenerData($token);
        $usuario = Usuario::ObtenerUsuario($datosToken->id);
      }
  
      return $usuario;
    
    }
    
}

?>