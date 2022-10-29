<?php

/*

Clase Producto

Fernández Mariano

*/

require_once "./db/AccesoDatos.php";


class Logs
{
    public $id;
    public $idUsuario;
    public $fechaLogin;
    public $operacion;
    public $fechaOperacion;

    // GETTERS
	public function GetId()
	{
		$retorno=0;

		if(!(is_null($this->id)))
		{
			$retorno=$this->id;
		}

		return $id;
	}

    public function GetIdUsuario()
	{
		$retorno=0;

		if(!(is_null($this->idUsuario)))
		{
			$retorno=$this->idUsuario;
		}

		return $retorno;
	}

    public function GetFechaLogin()
    {
        $retorno="1/1/1970";

        if(!(is_null($this->fechaLogin)))
		{
			$retorno=$this->fechaLogin;
		}

		return $retorno;
    }

    public function GetOperacion()
    {
        $retorno="";

        if(!(is_null($this->operacion)))
		{
			$retorno=$this->operacion;
		}

		return $retorno;
    }

    public function GetFechaOperacion()
    {
        $retorno="1/1/1970";

        if(!(is_null($this->fechaOperacion)))
		{
			$retorno=$this->fechaOperacion;
		}

		return $retorno;
    }

    //SETTERS

	public function SetId($value)
	{
        $this->id=$value;
	}

    public function SetIdUsuario($value)
	{
        $this->idUsuario=$value;
	}
    
    public function SetFechaLogin($value)
	{
        $this->fechaLogin=$value;
	}

    public function SetOperacion($value)
	{
        $this->operacion=$value;
	}

    public function SetFechaOperacion($value)
	{
        $this->fechaOperacion=$value;
	}


    public static function RetornarListaDeLogsLogin()
	{
		$flag=0;
        $listaLogs = Logs::ObtenerLogsLogin();
		$len = count($listaLogs);
        $contador = 0;

		if($len>0)
		{
			$retorno=("<table>");
			$retorno.=("<th>[Nro Operacion]</th><th>[Nombre]</th><th>[Apellido]</th><th>[Email]</th><th>[Tipo]</th><th>[Rol]</th><th>[Hora de Ingreso]</th>");
			foreach($listaLogs as $log)
			{
                $contador++;
                $usuario = Usuario::ObtenerUsuario($log->idUsuario);
                $retorno.=("<tr align='center'>");
                $retorno.=("<td>".$contador."</td>");
                $retorno.=("<td>".$usuario->GetNombre()."</td>");
                $retorno.=("<td>".$usuario->GetApellido()."</td>");
                $retorno.=("<td>".$usuario->GetEmail()."</td>");
                $retorno.=("<td>".$usuario->GetTipo()."</td>");
                $retorno.=("<td>".$usuario->GetRol()."</td>");
                $retorno.=("<td>".$log->GetFechaLogin()."</td>");
                $retorno.=("</tr>");
                $flag=1;
			}
			$retorno.=("</table>");
		}

		if($flag==0)
		{
			$retorno="No hay ningun elemento en la lista";
		}

		return $retorno;
    }


    public static function RetornarListaDeLogsLoginPorId($idUsuario)
	{
		$flag=0;
        $listaLogs = Logs::ObtenerLogsLoginPorId($idUsuario);
		$len = count($listaLogs);
        $contador = 0;

		if($len>0)
		{
            $usuario = Usuario::ObtenerUsuario($idUsuario);
            
            $usuario->rol == "todos" ? 
            $retorno=("<h2>Muestro los logs para el $usuario->tipo $usuario->nombre $usuario->apellido</h2>") :
            $retorno=("<h2>Muestro los logs para el $usuario->rol $usuario->nombre $usuario->apellido</h2>");

			$retorno.=("<table>");
			$retorno.=("<th>Hora de Ingreso</th>");
			foreach($listaLogs as $log)
			{
                $contador++;
                $retorno.=("<tr align='center'>");
                $retorno.=("<td> $contador- ".$log->GetFechaLogin()."</td>");
                $retorno.=("</tr>");
                $flag=1;
			}
			$retorno.=("</table>");
		}

		if($flag==0)
		{
			$retorno="No hay ningun elemento en la lista para ese id";
		}

		return $retorno;
    }

    public static function RetornarListaDeLogsOperacionesPorId($idUsuario)
	{
		$flag=0;
        $listaLogs = Logs::ObtenerLogsOperacionPorId($idUsuario);
        $contador = 0;
		$len = count($listaLogs);

		if($len>0)
		{
            $usuario = Usuario::ObtenerUsuario($idUsuario);
            
            $usuario->rol == "todos" ? 
            $retorno=("<h2>Muestro los logs para el $usuario->tipo $usuario->nombre $usuario->apellido</h2>") :
            $retorno=("<h2>Muestro los logs para el $usuario->rol $usuario->nombre $usuario->apellido</h2>");

			$retorno.=("<table>");
			$retorno.=("<th>[Nro Operacion]</th><th>[Hora de Operacion]</th><th>[Operacion]</th>");
			foreach($listaLogs as $log)
			{
                $contador++;
                $retorno.=("<tr align='center'>");
                $retorno.=("<td>".$contador."</td>");
                $retorno.=("<td>".$log->GetFechaOperacion()."</td>");
                $retorno.=("<td>".$log->GetFechaOperacion()."</td>");
                $retorno.=("</tr>");
                $flag=1;
			}
			$retorno.=("</table>");
		}

		if($flag==0)
		{
			$retorno="No hay ningun elemento en la lista para ese id";
		}

		return $retorno;
    }

    public static function RetornarListaDeLogsOperacionesPorRol($rol)
	{
		$flag=0;

        $listaLogs = Logs::ObtenerLogsOperaciones();
        
		$len = count($listaLogs);
        $contador = 0;

		if($len>0)
		{
            $retorno=("<h2>Muestro las operaciones de todos los $rol </h2>");

            $retorno.=("<table>");
			$retorno.=("<th>Nro de Operacion</th><th>Hora de Operacion</th><th>[Operacion]</th>");

            foreach($listaLogs as $log)
            {
                $usuario = Usuario::ObtenerUsuario($log->GetIdUsuario());

                if($usuario != false && ($usuario->GetRol() == $rol || $usuario->GetTipo() == $rol))
                {
                    $contador++;
                    $retorno.=("<tr align='center'>");
                    $retorno.=("<td>".$contador."</td>");
                    $retorno.=("<td>".$log->GetFechaOperacion()."</td>");
                    $retorno.=("<td>".$log->GetOperacion()."</td>");
                    $retorno.=("</tr>");
                    $flag=1;
                }
            }

            $retorno.=("</table>");
		}

		if($flag==0)
		{
			$retorno="No hay ningun elemento en la lista para ese rol";
		}

		return $retorno;
    }

    public static function RetornarListaDeLogsOperacionesPorRolSeparadaPorUsuario($rol)
	{
		$flag=0;

        $rol == "socio" ? $listaUsuarios = Usuario::ObtenerUsuariosPorTipo($rol) :
        $listaUsuarios = Usuario::ObtenerUsuariosPorRol($rol);
        
		$len = count($listaUsuarios);

        $contador = 0;
        $contadorUsuario = 0;

		if($len>0)
		{
            $retorno=("<h2>Muestro las operaciones de todos los $rol por usuario </h2>");
            
            foreach($listaUsuarios as $usuario)
            {
                $listaLogs = Logs::ObtenerLogsOperacionPorId($usuario->GetID());
                $len = count($listaLogs);

                if($len > 0)
                {
                    $contadorUsuario++;

                    $retorno.=("<h3>$contadorUsuario-$usuario->nombre $usuario->apellido </h3>");

                    $retorno.=("<table>");
                    $retorno.=("<th>Nro de Operacion</th><th>Hora de Operacion</th><th>[Operacion]</th>");
                    foreach($listaLogs as $log)
                    {
                        $usuario = Usuario::ObtenerUsuario($log->GetIdUsuario());
        
                        if($usuario != false && ($usuario->GetRol() == $rol || $usuario->GetTipo() == $rol))
                        {
                            $contador++;
                            $retorno.=("<tr align='center'>");
                            $retorno.=("<td>".$contador."</td>");
                            $retorno.=("<td>".$log->GetFechaOperacion()."</td>");
                            $retorno.=("<td>".$log->GetOperacion()."</td>");
                            $retorno.=("</tr>");
                            $flag=1;
                        }
                    }
                    $retorno.=("</table>");
                }
            }
		}

		if($flag==0)
		{
			$retorno="No hay ningun elemento en la lista para ese rol";
		}

		return $retorno;
    }

    public static function AgregarLogOperacion($usuario,$operacion)
    {
        $mensaje = "";
        if($usuario != false)
        {
          $usuario->GetTipo() == "socio" ? 
          $mensaje = "El socio $usuario->nombre $usuario->apellido con mail $usuario->email "
          : $mensaje = "El empleado $usuario->rol $usuario->nombre $usuario->apellido con mail $usuario->email ";
        
          $mensaje .= $operacion;   
          
          Logs::AgregarLogOperacionDatabase($usuario->GetID(),$mensaje);
        }
    }

    //METODOS DATABASE

	public static function AgregarLogLogin($idUsuario)
    {
        $ahora = date("Y-m-j H:i:s");
        $objetoAccesoDato = AccesoDatos::obtenerInstancia(); 
        $consulta = $objetoAccesoDato->prepararConsulta("INSERT INTO loglogin (idUsuario,fechaLogin) VALUES ('$idUsuario', '$ahora');");
        $consulta->execute();
    }

	public static function AgregarLogOperacionDatabase($idUsuario,$operacion)
    {
        $ahora = date("Y-m-j H:i:s");
        $objetoAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDato->prepararConsulta("INSERT INTO logoperaciones (idUsuario, operacion, fechaOperacion) VALUES ('$idUsuario', '$operacion', '$ahora');");
        $consulta->execute();
    }

    public static function ObtenerLogsLoginPorId($idUsuario)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id,idUsuario,fechaLogin FROM loglogin WHERE idUsuario = '$idUsuario'");
        
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Logs');
    }

    public static function ObtenerLogsLogin()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id,idUsuario,fechaLogin FROM loglogin");
        
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Logs');
    }

    public static function ObtenerLogsOperacionPorId($idUsuario)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id,idUsuario,operacion,fechaOperacion FROM logoperaciones WHERE idUsuario = '$idUsuario'");
        
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Logs');
    }

    public static function ObtenerLogsOperaciones()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id,idUsuario,operacion,fechaOperacion FROM logoperaciones");
        
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Logs');
    }

}

?>