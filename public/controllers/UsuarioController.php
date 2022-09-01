<?php
require_once '../public/models/Usuario.php';
require_once '../public/interfaces/IApiUsable.php';
require_once './middlewares/AutentificadorJWT.php';


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

        // Creamos el usuario
        $usuario = Usuario::CrearUsuario($nombre,$apellido,$email,$clave,$tipo,$rol,$fechaDeCreacion);

        Usuario::AltaUsuario($usuario) ? $payload = json_encode(array("mensaje" => "Usuario creado con exito")) : $payload = json_encode(array("mensaje" => "Hubo un error al crear el usuario"));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        // Buscamos usuario por nombre
        $usuarioId = $args['id'];
        $usuario = Usuario::ObtenerUsuario($usuarioId);

        $payload = json_encode(array("mensaje" => "Id incorrecto"));

        if($usuario != false)
        {
            $payload = json_encode($usuario);
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

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'text/html');
    }
    
    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $nombre = $parametros['nombre'];
        //Usuario::ModificarUsuario($nombre);

        $payload = json_encode(array("mensaje" => "Usuario modificado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $usuarioId = $parametros['usuarioId'];
        //Usuario::BorrarUsuario($usuarioId);

        $payload = json_encode(array("mensaje" => "Usuario borrado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function LoguearUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $email = $parametros['email'];
        $clave = $parametros['clave'];
        $payload=json_encode(array('mensaje' => 'Datos erroneos o el usuario fue dado de baja o suspendido.')); //Muestro siempre este mensaje para evitar ataques de fuerza bruta
                                                                                                                //Por eso siempre informo datos erroneos para que no se sepa cuando 
                                                                                                                //Se pone un mail existente o no. La seguridad ante todo.

        $usuario = Usuario::ObtenerUsuarioPorEmail($email);

        if($usuario != false && Usuario::LoguearUsuario($email,$clave))
        {

          $datos = array(
            'id' => $usuario->GetID(),
            'Email' => $usuario->GetEmail(),
            'Clave' => $usuario->GetClave(),
            'Tipo' => $usuario->GetTipo(),
            'Rol' => $usuario->GetRol());

          //$payload=json_encode(array('mensaje' => 'Usuario Agregado con exito.'));          
          $payload = json_encode(array(
            'Token' => AutentificadorJWT::CrearToken($datos), 
            'response' => 'Usuario logueado con exito', 
            'Tipo' => $usuario->GetTipo(),
            'Rol' => $usuario->GetRol()));
        }

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }}