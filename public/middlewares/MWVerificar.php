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
        $header = $request->getHeaderLine('Authorization');
        $headers = apache_request_headers();
        var_dump($headers);
        $response = new ResponseMW();
        if (!empty($header)) {
            $token = trim(explode("Bearer", $header)[1]);
            AutentificadorJWT::VerificarToken($token);
            $response = $handler->handle($request);
        } else 
        {
            $response->getBody()->write(json_encode(array("Token error" => "No hay ningun usuario logueado")));
            $response = $response->withStatus(401);
        }
        return  $response->withHeader('Content-Type', 'application/json');   
    }

}

?>