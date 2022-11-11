<?php
require_once '../app/models/Mesa.php';
require_once '../app/models/Usuario.php';
require_once '../app/models/Opinion.php';
require_once '../app/models/Logs.php';
require_once '../app/interfaces/IApiUsable.php';
require_once './middlewares/AutentificadorJWT.php';

class OpinionController extends Opinion
{
  public function TraerMejoresComentarios($request, $response, $args)
  {
      // Buscamos mesa por id
      $usuarioLoguado = OpinionController::TraerUsuarioActual($request,$response,$args);
      $payload = json_encode(array("mensaje" => "Filtro invalido"));
      $filtro = $args['filtro'];
      if($filtro == "notaMozo" || $filtro == "notaMesa" || $filtro == "notaRestaurante" || $filtro == "notaCocinero")
      {
        $payload = json_encode(array("mensaje" => "No se ha realizado ningun comentario"));

        $comentarios = Opinion::ObtenerMejoresOPeoresComentarios($filtro,"MAX");
  
        if(count($comentarios)>0)
        {
          $payload = "Los comentarios con mayor $filtro son <br><br>";
          $payload .= Opinion::RetornarListaComentarios($comentarios);
          Logs::AgregarLogOperacion($usuarioLoguado,"pidio información sobre los comentarios con la nota más alta de $filtro");
        }
      }

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json');
  }

  public function TraerPeoresComentarios($request, $response, $args)
  {
      // Buscamos mesa por id
      $usuarioLoguado = OpinionController::TraerUsuarioActual($request,$response,$args);
      $payload = json_encode(array("mensaje" => "Filtro invalido"));
      $filtro = $args['filtro'];
      if($filtro == "notaMozo" || $filtro == "notaMesa" || $filtro == "notaRestaurante" || $filtro == "notaCocinero")
      {
        $payload = json_encode(array("mensaje" => "No se ha realizado ningun comentario"));

        $comentarios = Opinion::ObtenerMejoresOPeoresComentarios($filtro,"MIN");
  
        if(count($comentarios)>0)
        {
          $payload = "Los comentarios con menor $filtro son <br><br>";
          $payload .= Opinion::RetornarListaComentarios($comentarios);
          Logs::AgregarLogOperacion($usuarioLoguado,"pidio información sobre los comentarios con la nota más baja de $filtro");
        }
      }

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json');
  }

    public function TraerMejoresComentariosPorMesa($request, $response, $args)
    {
        // Buscamos mesa por id
        $usuarioLoguado = OpinionController::TraerUsuarioActual($request,$response,$args);

        $mesaCodigo = $args['codigoMesa'];
        var_dump($mesaCodigo);
        $mesa = Mesa::ObtenerMesa($mesaCodigo);

        $payload = json_encode(array("mensaje" => "La mesa no existe"));

        if($mesa != false)
        {
          $payload = json_encode(array("mensaje" => "No hay ningun comentario que corresponda dicha mesa"));
          $comentarios = Opinion::ObtenerMejoresOPeoresComentariosPorMesa($mesa->GetCodigo(),"MAX");

          if(count($comentarios)>0)
          {
            $payload = "Los comentarios con la más alta calificación para la mesa con código $mesa->codigo son<br><br>";
            $payload .= Opinion::RetornarListaComentarios($comentarios);
            Logs::AgregarLogOperacion($usuarioLoguado,"pidio información sobre los comentarios mejor valorados de la mesa con código $mesa->codigo");
          }
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    
    public function TraerPeoresComentariosPorMesa($request, $response, $args)
    {
        // Buscamos mesa por id
        $usuarioLoguado = MesaController::TraerUsuarioActual($request,$response,$args);

        $mesaCodigo = $args['codigoMesa'];
        $mesa = Mesa::ObtenerMesa($mesaCodigo);

        $payload = json_encode(array("mensaje" => "La mesa no existe"));

        if($mesa != false)
        {
          $payload = json_encode(array("mensaje" => "No hay ningun comentario que corresponda dicha mesa"));
          $comentarios = Opinion::ObtenerMejoresOPeoresComentariosPorMesa($mesa->GetCodigo(),"MIN");

          if(count($comentarios)>0)
          {
            $payload = "Los comentarios con la más baja calificación para la mesa con código $mesa->codigo son<br><br>";
            $payload .= Opinion::RetornarListaComentarios($comentarios);
            Logs::AgregarLogOperacion($usuarioLoguado,"pidio información sobre los comentarios peor valorados de la mesa con código $mesa->codigo");
          }
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
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