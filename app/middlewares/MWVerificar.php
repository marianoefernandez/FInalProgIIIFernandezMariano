<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as ResponseMW;

require_once './middlewares/AutentificadorJWT.php';


class MWVerificar
{
    private $tipo;
    private $rol;

    public function __construct($tipo,$rol)
    {
        $this->tipo = $tipo;
        $this->rol = $rol;
    }
    
    public function __invoke(Request $request, RequestHandler $handler)
    {
        $response = new ResponseMW();
        $header = $request->getHeaderLine('Authorization');
        //$headers = apache_request_headers();
        try
        {
            $token = trim(explode("Bearer", $header)[1]);
            AutentificadorJWT::VerificarToken($token);
            $datosToken = AutentificadorJWT::ObtenerData($token);

            $response = $handler->handle($request);
            $response->withStatus(200);
            $response->getbody()->write("<br> Usuario logueado: $datosToken->nombre $datosToken->apellido<br> Tipo: $datosToken->tipo <br> Rol: $datosToken->rol");
        }
        catch(Exception $e)
        {
            $response->getBody()->write($e->getMessage());
            $response->withStatus(401);
        }

        return  $response->withHeader('Content-Type', 'application/json');   
    }

    public function ObtenerToken()
    {
        
    }

}

?>