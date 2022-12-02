<?php

/*

Clase Usuario

Fernández Mariano

*/
require_once "./db/AccesoDatos.php";
require_once './middlewares/AutentificadorJWT.php';

class Usuario
{
	//ATRIBUTOS
	public $nombre;
	public $apellido;
	public $email;
	public $clave;
	public $id;
	public $tipo;//Socio - Empleado
	public $rol;//(Mozo, Bertender, etc)
    public $fechaDeInicioActividades;
	public $estado;//Suspendido (0), activo(1) o eliminado(-1) (BAJA LÓGICA) 

	//GETTERS

	public function GetNombre()
	{
		$retorno="";

		if(!(is_null($this->nombre)))
		{
			$retorno=$this->nombre;
		}

		return $retorno;
	}

	public function GetApellido()
	{
		$retorno="";

		if(!(is_null($this->apellido)))
		{
			$retorno=$this->apellido;
		}

		return $retorno;
	}

	public function GetEmail()
	{
		$retorno="";

		if(!(is_null($this->email)))
		{
			$retorno=$this->email;
		}

		return $retorno;
	}

	public function GetClave()
	{
		$retorno="";

		if(!(is_null($this->clave)))
		{
			$retorno=$this->clave;
		}

		return $retorno;
	}

	public function GetEstado()
	{
		$retorno="";

		if(!(is_null($this->estado)))
		{
			$retorno=$this->estado;
		}

		return $retorno;
	}

	public function GetID()
	{
		$retorno=0;

		if(!(is_null($this->id)))
		{
			$retorno=$this->id;
		}

		return $retorno;
	}

	public function GetTipo()
	{
		$retorno="Sin tipo";

		if(!(is_null($this->tipo)))
		{
			$retorno=$this->tipo;
		}

		return $retorno;
	}

	public function GetRol()
	{
		$retorno="Sin rol";

		if(!(is_null($this->rol)))
		{
			$retorno=$this->rol;
		}

		return $retorno;
	}

    public function GetFechaInicio()
    {
        $retorno="1/1/1970";

        if(!(is_null($this->fechaDeInicioActividades)))
		{
			$retorno=$this->fechaDeInicioActividades;
		}

		return $retorno;
    }

    //SETTERS

	public function SetNombre($value)
	{
        $this->nombre=$value;
	}

	public function SetApellido($value)
	{
        $this->apellido=$value;
	}

	public function SetEmail($value)
	{
        $this->email=$value;
	}

	public function SetClave($value)
	{
        $this->clave=$value;
	}

	public function SetTipo($value)
	{
        $this->tipo=$value;
	}

	public function SetRol($value)
	{
        $this->rol=$value;
	}

	public function SetFechaInicio($value)
	{
        $this->fechaDeInicioActividades=$value;
	}

	public function SetEstado($value)
	{
        $this->estado=$value;
	}

	public function SetID($value)
	{
        $this->id=$value;
	}

	//CONSTRUCTOR

	public static function CrearUsuario($nombre,$apellido,$email,$clave,$tipo,$rol,$inicioActividades)
	{
		$usuario = new Usuario();

		$tipo = strtolower($tipo);
		$rol = strtolower($rol);

		$usuario->SetNombre($nombre);
		$usuario->SetApellido($apellido);
		$usuario->SetEmail($email);
		$usuario->SetClave($clave);
		$usuario->SetTipo($tipo);
		$usuario->SetRol($rol);
		$usuario->SetEstado(ACTIVO);
		$usuario->SetFechaInicio($inicioActividades);

		return $usuario;
	}

	//METODOS

	//Retorna -1 si hubo error, 0 si el mail ya existe y 1 si todo ok
	public static function AltaUsuario($usuario)
	{
		$retorno=-1;
		$lista=Usuario::ObtenerTodosLosUsuarios();

		if(!(is_null($usuario->GetNombre()) || is_null($usuario->GetApellido()) || is_null($usuario->GetEmail()) || is_null($usuario->GetClave()) || is_null($usuario->GetTipo()) || is_null($usuario->GetRol()) || is_null($usuario->GetFechaInicio()) || is_null($usuario->GetEstado())))
		{
			$retorno = 0;
			if(!($usuario->VerificarEmail($lista)))
			{
				$retorno=1;
				$usuario->AgregarUsuarioDatabase();
			}
		}

		return $retorno;
	}

	public static function ModificarUsuario($usuario,$claveHash)
	{
		$retorno=-1;
		$usuarioAnterior = Usuario::ObtenerUsuario($usuario->GetID());
		$lista=Usuario::ObtenerTodosLosUsuarios();

		if(!(is_null($usuario->GetNombre()) || is_null($usuario->GetApellido()) || is_null($usuario->GetEmail()) || is_null($usuario->GetClave()) || is_null($usuario->GetTipo()) || is_null($usuario->GetRol())))
		{
			if($usuarioAnterior != false)
			{
				if($usuarioAnterior->GetEmail() != $usuario->GetEmail())
				{
					$retorno = 0;
					if(($usuario->VerificarEmail($lista)))
					{
						$usuario->ModificarUsuarioDatabase($claveHash);
						$retorno=1;
					}
				}
				else
				{
					$usuario->ModificarUsuarioDatabase($claveHash);
					$retorno=1;
				}
			}
		}

		return $retorno;
	}

	public static function BorrarUsuario($id)
	{
		$retorno = 0;
		$usuario = Usuario::ObtenerUsuario($id);

		if($usuario != false)
		{
			$usuario->BorrarUsuarioDatabase();
			$retorno = 1;
		}

		return $retorno;
	}

	public static function CambiarEstadoUsuario($usuario,$estado)
	{	
		$usuario->CambiarEstadoUsuarioDatabase($estado);
	}

	public function VerificarEmail($lista)
	{
		$retorno=0;

		foreach ($lista as $usuario) 
		{
			if($usuario->GetEmail() == $this->GetEmail())
			{
				$retorno=1;
				break;
			}
		}

		return $retorno;
	}

	public static function CargaForzada($usuarios)
	{
		$contador = 0;

		foreach ($usuarios as $usuario) 
		{
			if(Usuario::VerificarExistencia($usuario) && count((array)$usuario) == 9 && Usuario::ValidarUsuario($usuario))
			{
				$usuarioAux = new Usuario();
				$usuarioAux->SetID((int)$usuario->id);
				$usuarioAux->SetNombre($usuario->nombre);
				$usuarioAux->SetApellido($usuario->apellido);
				$usuarioAux->SetEmail($usuario->email);
				$usuarioAux->SetClave($usuario->clave);
				$usuarioAux->SetTipo($usuario->tipo);
				$usuarioAux->SetRol($usuario->rol);
				$usuarioAux->SetFechaInicio($usuario->fechaDeInicioActividades);
				$usuarioAux->SetEstado((int)$usuario->estado);

				$usuarioAux->CargaForzadaDatabase();
				$contador++;
			}
		}

		return $contador;
	}

	//Retorna 1 si el usuario ya tiene asignado un mail no disponible o si su id corresponde con otro 0 si existe en la database
	public static function VerificarExistencia($usuario)
	{
		$listaUsuarios = Usuario::ObtenerTodosLosUsuarios();

		foreach ($listaUsuarios as $usuarioAux) 
		{
			if($usuarioAux->email == $usuario->email || $usuarioAux->id == $usuario->id)
			{
				return 0;
			}
		}

		return 1;
	}

	public static function ValidarUsuario($usuario)
	{
		foreach ($usuario as $key => $value) 
		{
			if(!isset($usuario->$key) || $usuario->$key == "")
			{
				return 0;
			}
		}

		return (is_numeric($usuario->id) && Usuario::ValidarTipoYRol($usuario) && is_numeric($usuario->estado) && ($usuario->estado > -2 && $usuario->estado < 2));
	}

	public static function ValidarTipoYRol($usuario)
	{
		return (($usuario->tipo == "todos" || $usuario->tipo == "empleado" || $usuario->tipo == "socio") &&
				($usuario->rol == "todos" || $usuario->rol == "mozo" || $usuario->rol == "bartender" || $usuario->rol == "cervecero" || $usuario->rol == "cocinero")); 
	}

	/*
	///Obtiene la extension
	public static function GetExtension($nombreArchivo)
	{
		$lista = array("png","jpg","jpeg","gif","tiff","psd","ico","bmp","svg");
		$retorno = 0;

		foreach ($lista as $extension) 
		{
			if(file_exists($nombreArchivo . "." . $extension))
			{
				$retorno=$extension;
				break;
			}
		}

		return $retorno;
	}
	*/

	function Equals($usuario)
	{
		return $this->GetEmail() == $usuario->GetEmail() && password_verify($this->GetClave(),$usuario->GetClave()); 
	}

	public static function LoguearUsuario($email,$clave)
	{
		$retorno=0;

		$lista=Usuario::ObtenerTodosLosUsuarios();

		foreach ($lista as $usuario) 
		{
			if($usuario->VerificarUsuario($email,$clave))
			{
				$retorno=1;
			}
		}

		return $retorno;
	}

	function VerificarUsuario($email,$clave)
	{
		return $this->GetEmail() == $email && password_verify($clave,$this->GetClave()); 
	}

 	static function GuardarArchivo($path,$contenido,$modo)
	{
		$retorno=0;

		if(!(is_null($path)) && !(is_null($contenido)))
		{
			$archivo=fopen($path, $modo);
			fwrite($archivo, $contenido);
			$retorno=1;
		}

		fclose($archivo);

		return $retorno;
	}

	public static function ValidarEstado($estado)
	{
		$retorno = false;

		if(is_string($estado) && isset($estado))
		{		
			Usuario::ObtenerEstadoInt(strtolower($estado)) > -2 ? $retorno = $estado :
			$retorno = false;
		}

		return $retorno;
	}

	public static function ObtenerEstadoInt($estado)
	{
		switch($estado)
		{
			case "activo":
				return 1;
			break;
			
			case "suspendido":
				return 0;
			break;
			
			case "eliminado":
				return -1;
			break;

			default:
				return false;
			break;
		}
	}

	public static function ObtenerEstadoString($estado)
	{
		switch($estado)
		{
			case 1:
				return "ACTIVO";
			break;
			
			case 0:
				return "SUSPENDIDO";
			break;
			
			case -1:
				return "ELIMINADO";
			break;

			default:
				return false;
			break;
		}
	}

	public static function RetornarUnUsuarioString($usuario,$estado)
	{
		$flag=0;
		$estadoString = Usuario::ObtenerEstadoString($usuario->GetEstado()==$estado);
		$retorno = "Hubo un error al encontrar el usuario en la base de datos";

		
		if($estadoString != false)
		{
			if($usuario->GetEstado()==$estado)
			{
				$retorno=("<table>");
				$retorno.=("<th>[Nombre]</th><th>[Apellido]</th><th>[Email]</th><th>[Tipo]</th><th>[Rol]</th><th>[Fecha de Inicio de Actividades]</th>");
				$retorno.=("<tr align='center'>");
				$retorno.=("<td>[".$usuario->GetNombre()."]</td>");
				$retorno.=("<td>[".$usuario->GetApellido()."]</td>");
				$retorno.=("<td>[".$usuario->GetEmail()."]</td>");
				$retorno.=("<td>[".$usuario->GetTipo()."]</td>");
				$retorno.=("<td>[".$usuario->GetRol()."]</td>");
				$retorno.=("<td>[".$usuario->GetFechaInicio()."]</td>");
				$retorno.=("</tr>");
				$retorno.=("</table>");
			}
			else
			{
				$retorno = "El estado del usuario es distinto a " . $estadoString;
			}
		}

		return $retorno;
    }

	public static function RetornarListaDeUsuariosString($listaUsuarios,$estado)
	{
		$flag=0;
		$len = count($listaUsuarios);

		if($len>0)
		{
			$retorno=("<table>");
			$retorno.=("<th>[Nombre]</th><th>[Apellido]</th><th>[Email]</th><th>[Tipo]</th><th>[Rol]</th><th>[Fecha de Inicio de Actividades]</th>");
			foreach($listaUsuarios as $usuario)
			{
				if($usuario->GetEstado()==$estado)
				{
					$retorno.=("<tr align='center'>");
					$retorno.=("<td>[".$usuario->GetNombre()."]</td>");
					$retorno.=("<td>[".$usuario->GetApellido()."]</td>");
					$retorno.=("<td>[".$usuario->GetEmail()."]</td>");
					$retorno.=("<td>[".$usuario->GetTipo()."]</td>");
					$retorno.=("<td>[".$usuario->GetRol()."]</td>");
					$retorno.=("<td>[".$usuario->GetFechaInicio()."]</td>");
					$retorno.=("</tr>");
					$flag=1;
				}
			}
			$retorno.=("</table>");
		}

		if($flag==0)
		{
			$retorno="No hay ningun elemento en la lista";
		}

		return $retorno;
    }

    //METODOS DATABASE

    public function CargaForzadaDatabase()
    {
       $objetoAccesoDato = AccesoDatos::obtenerInstancia(); 
	   $claveHash=password_hash($this->GetClave(),PASSWORD_DEFAULT);
       $consulta = $objetoAccesoDato->prepararConsulta("INSERT into usuarios (id,nombre,apellido,email,clave,tipo,rol,fechaDeInicioActividades,estado)values('$this->id','$this->nombre','$this->apellido','$this->email','$claveHash','$this->tipo','$this->rol','$this->fechaDeInicioActividades','$this->estado')");
       $consulta->execute();
    }

    public function AgregarUsuarioDatabase()
    {
       $objetoAccesoDato = AccesoDatos::obtenerInstancia(); 
	   $claveHash=password_hash($this->GetClave(),PASSWORD_DEFAULT);
       $consulta = $objetoAccesoDato->prepararConsulta("INSERT into usuarios (nombre,apellido,email,clave,tipo,rol,fechaDeInicioActividades,estado)values('$this->nombre','$this->apellido','$this->email','$claveHash','$this->tipo','$this->rol','$this->fechaDeInicioActividades','$this->estado')");
       $consulta->execute();
    }

	public function CambiarEstadoUsuarioDatabase($estado)
    {
       $objetoAccesoDato = AccesoDatos::obtenerInstancia(); 

       $consulta = $objetoAccesoDato->prepararConsulta("UPDATE usuarios SET estado = '$estado' WHERE id = '$this->id' ");
	   $consulta->execute();
    }

	public function ModificarUsuarioDatabase($claveHash)
    {
       $objetoAccesoDato = AccesoDatos::obtenerInstancia(); 

	   if($claveHash == "")
	   {
	   	$consulta = $objetoAccesoDato->prepararConsulta("UPDATE usuarios SET nombre = '$this->nombre' , apellido = '$this->apellido' ,tipo = '$this->tipo', rol = '$this->rol' , email = '$this->email' WHERE id = '$this->id' ");
	   }
	   else
	   {
		$consulta = $objetoAccesoDato->prepararConsulta("UPDATE usuarios SET nombre = '$this->nombre' , apellido = '$this->apellido' , tipo = '$this->tipo', rol = '$this->rol' , email = '$this->email', clave = '$claveHash' WHERE id = '$this->id' ");
	   }

	   $consulta->execute();
    }

	public function BorrarUsuarioDatabase()
    {
       $objetoAccesoDato = AccesoDatos::obtenerInstancia(); 
       $consulta = $objetoAccesoDato->prepararConsulta("DELETE FROM usuarios WHERE id = '$this->id'");
       $consulta->execute();
    }


    public static function ObtenerTodosLosUsuarios()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, nombre,apellido,email,clave,tipo,rol,fechaDeInicioActividades,estado FROM usuarios");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');
    }

    public static function ObtenerTodosLosUsuariosOrdenadosPorRol()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, nombre,apellido,email,clave,tipo,rol,fechaDeInicioActividades,estado FROM usuarios ORDER BY rol");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');
    }

    public static function ObtenerUsuario($id)
    {
		$retorno=false;
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id,nombre,apellido,email,clave,tipo,rol,fechaDeInicioActividades,estado FROM usuarios WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        
		if($consulta->execute())
		{
			$retorno = $consulta->fetchObject('Usuario');
		}

        return $retorno;
    }

	public static function ObtenerUsuarioPorEmail($email)
    {
		$retorno=false;
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id,nombre,apellido,email,clave,tipo,rol,fechaDeInicioActividades,estado FROM usuarios WHERE email = :email");
        $consulta->bindValue(':email', $email, PDO::PARAM_STR);
        
		if($consulta->execute())
		{
			$retorno = $consulta->fetchObject('Usuario');
		}

        return $retorno;
    }

	public static function ObtenerUsuariosPorRol($rol)
    {
		$objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, nombre,apellido,email,clave,tipo,rol,fechaDeInicioActividades,estado FROM usuarios WHERE rol = :rol");
        $consulta->bindValue(':rol', $rol, PDO::PARAM_STR);
		$consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');
    }

	public static function ObtenerUsuariosPorTipo($tipo)
    {
		$objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, nombre,apellido,email,clave,tipo,rol,fechaDeInicioActividades,estado FROM usuarios WHERE tipo = :tipo");
        $consulta->bindValue(':tipo', $tipo, PDO::PARAM_STR);
		$consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');
    }

}

?>