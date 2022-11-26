<?php
require_once '../app/models/Usuario.php';
require_once '../app/models/Archivos.php';
require_once '../app/models/Logs.php';
require_once './middlewares/AutentificadorJWT.php';
//require_once './middlewares/MWVerificar.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use AutentificadorJWT as AutentificadorJWT;
use Slim\Handlers\Strategies\RequestHandler;
//use MWVerificar as Verificar;
 

class PdfController
{
    public function DescargarLogo($request, $response, $args)
    {
        //$html = ob_get_clean();
        $html = "<img src='https://1000marcas.net/wp-content/uploads/2019/11/McDonalds-logo.jpg' width='128'alt='Logo'>";
        //$usuarioActual = PDFController::TraerUsuarioActual($request,$response,$args);
        //Logs::AgregarLogOperacion($usuarioActual,"descargo un pdf con el logo de la empresa");

        DescargarPDF($html,"logo.pdf");
        $payload = $html;

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
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