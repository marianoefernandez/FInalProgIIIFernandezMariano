<?php

/*

Clase Usuario

Fernández Mariano

*/
require_once "./db/AccesoDatos.php";

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
			$retorno=0;
			if(!($usuario->VerificarEmail($lista)))
			{
				$retorno=1;
				$usuario->AgregarUsuarioDatabase();
			}
		}

		return $retorno;
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

	public function SubirArchivo($origen,$destino,$nombreArchivo,$extension)
	{
		if (!file_exists($destino)) 
		{
			mkdir($destino, 0777, true);
		}
	
		$destino .= $nombreArchivo . "." . $extension;

		$this->archivoFoto=$destino;
	
		move_uploaded_file($origen,$destino);
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

    public function AgregarUsuarioDatabase()
    {
       $objetoAccesoDato = AccesoDatos::obtenerInstancia(); 
	   $claveHash=password_hash($this->clave,PASSWORD_DEFAULT);
       $consulta = $objetoAccesoDato->prepararConsulta("INSERT into usuario (nombre,apellido,email,clave,tipo,rol,fechaDeInicioActividades,estado)values('$this->nombre','$this->apellido','$this->email','$claveHash','$this->tipo','$this->rol','$this->fechaDeInicioActividades','$this->estado')");
       $consulta->execute();
    }

    public static function ObtenerTodosLosUsuarios()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT nombre,apellido,email,clave,tipo,rol,fechaDeInicioActividades,estado FROM usuario");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');
    }

    public static function ObtenerUsuario($id)
    {
		$retorno=false;
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT nombre,apellido,email,clave,tipo,rol,fechaDeInicioActividades,estado FROM usuario WHERE id = :id");
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
        $consulta = $objAccesoDatos->prepararConsulta("SELECT nombre,apellido,email,clave,tipo,rol,fechaDeInicioActividades,estado FROM usuario WHERE email = :email");
        $consulta->bindValue(':email', $email, PDO::PARAM_STR);
        
		if($consulta->execute())
		{
			$retorno = $consulta->fetchObject('Usuario');
		}

        return $retorno;
    }

}

?>