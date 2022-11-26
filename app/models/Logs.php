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

    public static function RetornarListaDeLogsLogin($listaLogs)
	{
		$flag=0;
		$len = count($listaLogs);
        $contador = 0;

		if($len>0)
		{
			$retorno=("<table>");
			$retorno.=("<th>[Nro Operacion]</th><th>[Nombre]</th><th>[Apellido]</th><th>[Email]</th><th>[Tipo]</th><th>[Rol]</th><th>[Hora de Ingreso]</th>");
			foreach($listaLogs as $log)
			{
                $usuario = Usuario::ObtenerUsuario($log->idUsuario);
                if($usuario->GetEstado() != ELIMINADO)
                {
                    $contador++;
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
			}
			$retorno.=("</table>");
		}

		if($flag==0)
		{
			$retorno="No hay ningun elemento en la lista";
		}

		return $retorno;
    }

    public static function RetornarListaDeLogsLoginPorId($listaLogs,$idUsuario)
	{
		$flag=0;
		$len = count($listaLogs);
        $contador = 0;

		if($len>0)
		{
            $usuario = Usuario::ObtenerUsuario($idUsuario);

            if($usuario->GetEstado() != ELIMINADO)
            {
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
            }
		if($flag==0)
		{
			$retorno="No hay ningun elemento en la lista para ese id";
		}

		return $retorno;
    }
    
    public static function RetornarInfoLogOperacion($log,$contador)
    {
        $retorno=("<tr align='center'>");
        $retorno.=("<td>".$contador."</td>");
        $retorno.=("<td>".$log->GetFechaOperacion()."</td>");
        $retorno.=("<td>".$log->GetOperacion()."</td>");
        $retorno.=("</tr>");
        
        return $retorno;
    }

    public static function RetornarListaDeLogsOperacionesPorId($listaLogs,$idUsuario)
	{
		$flag=0;
        $contador = 0;
		$len = count($listaLogs);

		if($len>0)
		{
            $usuario = Usuario::ObtenerUsuario($idUsuario);
            
            if($usuario->GetEstado() != ELIMINADO)
            {
                $usuario->rol == "todos" ? 
                $retorno=("<h2>Muestro los logs para el $usuario->tipo $usuario->nombre $usuario->apellido</h2>") :
                $retorno=("<h2>Muestro los logs para el $usuario->rol $usuario->nombre $usuario->apellido</h2>");
    
                $retorno.=("<table>");
                $retorno.=("<th>[Nro Operacion]</th><th>[Hora de Operacion]</th><th>[Operacion]</th>");
                foreach($listaLogs as $log)
                {
                    $contador++;
                    $retorno.=Logs::RetornarInfoLogOperacion($log,$contador);
                    $flag=1;
                }
                $retorno.=("</table>");
            }
		}

		if($flag==0)
		{
			$retorno="No hay ningun elemento en la lista para ese id";
		}

		return $retorno;
    }

    public static function RetornarListaDeLogsOperacionesPorRol($listaLogs,$rol)
	{
		$flag=0;
        $retorno = "";
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

                if($usuario != false && ($usuario->GetRol() == $rol || $usuario->GetTipo() == $rol) && $usuario->GetEstado() != ELIMINADO)
                {
                    $contador++;
                    $retorno.=Logs::RetornarInfoLogOperacion($log,$contador);
                    $flag=1;
                }
            }

            $retorno.=("</table>");
		}

		if($flag==0)
		{
            $retorno=("<h2>No hay ningun log para el sector $rol</h2>");
		}

		return $retorno;
    }

    public static function RetornarListaDeLogsOperacionesPorRolSeparadaPorUsuario($rol,$fechaInicio,$fechaFinal)
	{
        $rol == "socio" ? $listaUsuarios = Usuario::ObtenerUsuariosPorTipo($rol) :
        $listaUsuarios = Usuario::ObtenerUsuariosPorRol($rol);
        $retorno = "";
		$len = count($listaUsuarios);
        $contador = 0;
        $contadorUsuario = 0;
        $flagFecha = true;

        if($fechaInicio == "" && $fechaFinal == "")
        {
            $flagFecha = false;
        }

		if($len>0)
		{
            $retorno=("<h2>Muestro las operaciones de todos los $rol por usuario </h2>");
            
            foreach($listaUsuarios as $usuario)
            {
                if($usuario->GetEstado() != ELIMINADO)
                {
                    if($flagFecha)
                    {
                        $listaLogs = Logs::ObtenerLogsOperacionPorIdEntreDosFechas($usuario->GetID(),$fechaInicio,$fechaFinal);
                    }
                    else
                    {
                        $listaLogs = Logs::ObtenerLogsOperacionPorId($usuario->GetID());
                    }
                    $len = count($listaLogs);
    
                    $contadorUsuario++;
                    $retorno.=("<h3>$contadorUsuario-$usuario->nombre $usuario->apellido </h3>");
    
                    if($len > 0)
                    {
                        $retorno.=("<table>");
                        $retorno.=("<th>Nro de Operacion</th><th>Hora de Operacion</th><th>[Operacion]</th>");
                        foreach($listaLogs as $log)
                        {
                            //$usuario = Usuario::ObtenerUsuario($log->GetIdUsuario());
            
                            if($usuario != false && ($usuario->GetRol() == $rol || $usuario->GetTipo() == $rol))
                            {
                                $contador++;
                                $retorno.=Logs::RetornarInfoLogOperacion($log,$contador);
                            }
                        }
                        $retorno.=("</table>");
                    }
                    else
                    {
                        $retorno.=("<h4>No hay ningun log para este usuario</h4>");
                    }
                }
            }
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

    public static function ObtenerLogsLoginEntreDosFechas($fecha1,$fecha2)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id,idUsuario,fechaLogin FROM loglogin WHERE fechaLogin BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59'");
        
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Logs');
    }

    public static function ObtenerLogsLoginPorIdEntreDosFechas($idUsuario,$fecha1,$fecha2)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id,idUsuario,fechaLogin FROM loglogin WHERE idUsuario = '$idUsuario' AND fechaLogin BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59'");
        
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

    public static function ObtenerLogsOperacionPorIdEntreDosFechas($idUsuario,$fecha1,$fecha2)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id,idUsuario,operacion,fechaOperacion FROM logoperaciones WHERE idUsuario = '$idUsuario' AND fechaOperacion BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59'");
        
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

    public static function ObtenerLogsOperacionesEntreDosFechas($fecha1,$fecha2)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id,idUsuario,operacion,fechaOperacion FROM logoperaciones WHERE fechaOperacion BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59'");
        
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Logs');
    }

}

?>