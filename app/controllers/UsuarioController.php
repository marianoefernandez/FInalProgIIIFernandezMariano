<?php
require_once '../app/models/Usuario.php';
require_once '../app/models/Logs.php';
require_once '../app/interfaces/IApiUsable.php';
require_once './middlewares/AutentificadorJWT.php';
//require_once './middlewares/MWVerificar.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use AutentificadorJWT as AutentificadorJWT;
use Slim\Handlers\Strategies\RequestHandler;
//use MWVerificar as Verificar;
 

define('ACTIVO',1);
define('SUSPENDIDO',0);
define('ELIMINADO',-1); 


class UsuarioController extends Usuario implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $nombre = $parametros['nombre'];
        $apellido = $parametros['apellido'];
        $email = $parametros['email'];
        $clave = $parametros['clave'];
        $tipo = $parametros['tipo'];
        $rol = $parametros['rol'];
        $fechaDeCreacion = $parametros['inicioActividades'];
        $payload = json_encode(array("mensaje" => "Hubo un error al crear al usuario"));
        $response->withStatus(401);
        

        // Creamos el usuario
        $usuario = Usuario::CrearUsuario($nombre,$apellido,$email,$clave,$tipo,$rol,$fechaDeCreacion);

        if(Usuario::AltaUsuario($usuario) == 1)
        {
          $payload = json_encode(array("mensaje" => "Usuario creado con exito"));
          $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);
          Logs::AgregarLogOperacion($usuarioLoguado,"dio de alta un nuevo usuario llamado $usuario->nombre $usuario->apellido con email $usuario->email");
        }
        else
        {
          if(Usuario::AltaUsuario($usuario) == 0)
          {
            $payload = json_encode(array("mensaje" => "El email ya esta en uso"));
          }
        }

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        // Buscamos usuario por nombre
        $usuarioId = $args['id'];
        $usuario = Usuario::ObtenerUsuario($usuarioId);

        $payload = json_encode(array("mensaje" => "Id incorrecto"));
        $response->withStatus(401);

        if($usuario != false)
        {
            $payload = Usuario::RetornarUnUsuarioString($usuario,ACTIVO);
            $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);
            Logs::AgregarLogOperacion($usuarioLoguado,"listo al usuario $usuario->nombre $usuario->apellido con email $usuario->email");
            //$payload = json_encode($usuario);
            $response->withStatus(200);

        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Usuario::ObtenerTodosLosUsuarios();
        //$payload = json_encode(array("listaUsuario" => $lista));
        $payload = Usuario::RetornarListaDeUsuariosString($lista,ACTIVO);
        $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);
        Logs::AgregarLogOperacion($usuarioLoguado,"listo a todos los usuarios activos ");

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'text/html');
    }

    public function CambiarEstadoUno($request, $response, $args)
    {
        $usuarioId = $args['id'];
        $parametros = $request->getParsedBody();
        $estado = $parametros['estado'];
        $payload = json_encode(array("mensaje" => "No se pudo modificar el estado, id incorrecto"));          
        $response->withStatus(401);

        $usuario = Usuario::ObtenerUsuario($usuarioId);
        $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);


        if($usuario != false)
        {
          if($usuarioLoguado->GetID() != $usuarioId)
          {
            $estado = Usuario::ValidarEstado($estado); 

            if($estado != false)
            {
              $estadoInt = Usuario::ObtenerEstadoInt($estado);
              $payload = json_encode(array("mensaje" => "No se modifico porque el estado ya estaba como " . $estado));          
            
              if($usuario->GetEstado() != $estadoInt)
              {
                Usuario::CambiarEstadoUsuario($usuario,$estadoInt);
                $payload = json_encode(array("mensaje" => "El estado se modifico con exito y paso a ser " . $estado));          
                Logs::AgregarLogOperacion($usuarioLoguado,"modifico el estado del usuario $usuario->nombre $usuario->apellido a $estado ");
                $response->withStatus(200);
              }
            }
            else
            {
              $payload = json_encode(array("mensaje" => "Hubo un error al modificar el estado"));          
            }
          }
          else
          {
            $payload = json_encode(array("mensaje" => "Usted no puede suspenderse o eliminarse a si mismo del sistema"));          
          }

        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    
    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $nombre = $parametros['nombre'];
        $apellido = $parametros['apellido'];
        $email = $parametros['email'];
        $tipo = $parametros['tipo'];
        $rol = $parametros['rol'];
        $clave = $parametros['clave'];
        $usuarioId = $args['id'];

        $usuarioAux = Usuario::CrearUsuario($nombre,$apellido,$email,$clave,$tipo,$rol,NULL);
        $usuarioAux->SetID($usuarioId);

        $claveHash = "";
        $payload = json_encode(array("mensaje" => "No existe el usuario que se quiere modificar, id incorrecto"));
        $response->withStatus(401);

        if($clave != "")
        {
          $claveHash=password_hash($usuarioAux->GetClave(),PASSWORD_DEFAULT);
        }

        if(Usuario::ModificarUsuario($usuarioAux,$claveHash) == 1)
        {
          $payload = json_encode(array("mensaje" => "Se modifico correctamente"));
          $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);
          Logs::AgregarLogOperacion($usuarioLoguado,"modifico los datos del usuario con id '$usuarioAux->id'");
          $response->withStatus(200);
        }
        else
        {
            if(Usuario::ModificarUsuario($usuarioAux,$claveHash) == 0)
            {
              $payload = json_encode(array("mensaje" => "No se pudo modificar ya que el email que intenta agregar ya existe"));
            }
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $usuarioId = $args['id'];

        $usuarioLoguado = UsuarioController::TraerUsuarioActual($request,$response,$args);
        $payload =  json_encode(array("mensaje" => "Usted no puede borrarse a si mismo de la base de datos"));
        $response->withStatus(401);


        if($usuarioLoguado->GetID() != $usuarioId)
        {
          if(Usuario::BorrarUsuario($usuarioId))
          {
            $payload =  json_encode(array("mensaje" => "Usuario borrado con exito"));
            Logs::AgregarLogOperacion($usuarioLoguado,"elimino al usuario con id $usuarioId");
            $response->withStatus(200);
          }
          else
          {
            $payload =  json_encode(array("mensaje" => "El usuario no se encontro en la base de datos ID incorrecto"));
          }
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function LoguearUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $email = $parametros['email'];
        $clave = $parametros['clave'];
        $response->withStatus(401);
        $payload=json_encode(array('mensaje' => 'Datos erroneos o el usuario fue dado de baja o suspendido.')); //Muestro siempre este mensaje para evitar ataques de fuerza bruta
                                                                                                                //Por eso siempre informo datos erroneos para que no se sepa cuando 
                                                                                                                //Se pone un mail existente o no. La seguridad ante todo.

        $usuario = Usuario::ObtenerUsuarioPorEmail($email);
        if($usuario != false && Usuario::LoguearUsuario($email,$clave) && $usuario->GetEstado() == 1)
        {

          $datos = array
          (
            "id" => $usuario->GetID(),
            "nombre" => $usuario->GetNombre(),
            "apellido" => $usuario->GetApellido(),
            "email" => $usuario->GetEmail(),
            "tipo" => $usuario->GetTipo(),
            "rol" => $usuario->GetRol()
          );

          //var_dump($datos);

          //$payload=json_encode(array('mensaje' => 'Usuario Agregado con exito.'));          
          $payload = json_encode(array(
            'token' => AutentificadorJWT::CrearToken($datos), 
            'response' => 'Usuario logueado con exito', 
            'tipo' => $usuario->GetTipo(),
            'rol' => $usuario->GetRol()));

          //$payload = AutentificadorJWT::CrearToken($datos);
          Logs::AgregarLogLogin($usuario->GetID());
          $response->withStatus(200);
        }

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
