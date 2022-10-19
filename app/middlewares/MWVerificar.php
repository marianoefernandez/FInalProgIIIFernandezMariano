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

            if($datosToken->tipo == $this->tipo || $datosToken->tipo == "socio")
            {
                if($datosToken->tipo != "socio" && $datosToken->rol != $this->rol)
                {
                    throw new Exception("Acceso denegado, necesita ser un empleado de tipo $this->rol y usted es $datosToken->rol");
                }

                $response = $handler->handle($request);
                $response->withStatus(200);
                $response->getbody()->write("<br> Usuario logueado: $datosToken->nombre $datosToken->apellido<br> Tipo: $datosToken->tipo <br> Rol: $datosToken->rol");
            }
            else
            {
                throw new Exception("Acceso denegado, usted necesita ser socio para acceder a está informacion, actualmente es empleado");
            }
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