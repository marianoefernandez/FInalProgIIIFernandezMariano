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

    public static function RetornarListaDeLogsLogin()
	{
		$flag=0;
        $listaLogs = Logs::ObtenerLogsLogin();
		$len = count($listaLogs);

		if($len>0)
		{
			$retorno=("<table>");
			$retorno.=("<th>[Nombre]</th><th>[Apellido]</th><th>[Email]</th><th>[Tipo]</th><th>[Rol]</th><th>[Hora de Ingreso]</th>");
			foreach($listaLogs as $log)
			{
                $usuario = Usuario::ObtenerUsuario($log->idUsuario);
                $retorno.=("<tr align='center'>");
                $retorno.=("<td>[".$usuario->GetNombre()."]</td>");
                $retorno.=("<td>[".$usuario->GetApellido()."]</td>");
                $retorno.=("<td>[".$usuario->GetEmail()."]</td>");
                $retorno.=("<td>[".$usuario->GetTipo()."]</td>");
                $retorno.=("<td>[".$usuario->GetRol()."]</td>");
                $retorno.=("<td>[".$log->fechaLogin."]</td>");
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
                $retorno.=("<td> $contador- ".$log->fechaLogin."</td>");
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

    public static function RetornarListaDeLogsOperaciones()
	{
		$flag=0;
        $listaLogs = Logs::ObtenerLogsOperaciones();
		$len = count($listaLogs);

		if($len>0)
		{
			$retorno=("<table>");
			$retorno.=("<th>[Nombre]</th><th>[Apellido]</th><th>[Email]</th><th>[Tipo]</th><th>[Rol]</th><th>[Operacion]</th><th>[Hora de Operacion]</th>");
			foreach($listaLogs as $log)
			{
                $usuario = Usuario::ObtenerUsuario($log->idUsuario);
                $retorno.=("<tr align='center'>");
                $retorno.=("<td>[".$usuario->GetNombre()."]</td>");
                $retorno.=("<td>[".$usuario->GetApellido()."]</td>");
                $retorno.=("<td>[".$usuario->GetEmail()."]</td>");
                $retorno.=("<td>[".$usuario->GetTipo()."]</td>");
                $retorno.=("<td>[".$usuario->GetRol()."]</td>");
                $retorno.=("<td>[".$log->operacion."]</td>");
                $retorno.=("<td>[".$log->fechaOperacion."]</td>");
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


    public static function RetornarListaDeLogsOperacionesPorId($idUsuario)
	{
		$flag=0;
        $listaLogs = Logs::ObtenerLogsOperacionPorId($idUsuario);
		$len = count($listaLogs);
        $contador = 0;

		if($len>0)
		{
            $usuario = Usuario::ObtenerUsuario($idUsuario);
            
            $usuario->rol == "todos" ? 
            $retorno=("<h2>Muestro los logs para el $usuario->tipo $usuario->nombre $usuario->apellido</h2>") :
            $retorno=("<h2>Muestro los logs para el $usuario->rol $usuario->nombre $usuario->apellido</h2>");

			$retorno.=("<table>");
			$retorno.=("<th>Hora de Operacion</th><th>[Operacion]</th>");
			foreach($listaLogs as $log)
			{
                $contador++;
                $retorno.=("<tr align='center'>");
                $retorno.=("<td> $contador- ".$log->fechaOperacion."</td>");
                $retorno.=("<td>[".$log->operacion."]</td>");
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

    //METODOS DATABASE

	public static function AgregarLogLogin($idUsuario)
    {
        $ahora = date("Y-m-j H:i:s");
        $objetoAccesoDato = AccesoDatos::obtenerInstancia(); 
        $consulta = $objetoAccesoDato->prepararConsulta("INSERT INTO loglogin (idUsuario,fechaLogin) VALUES ('$idUsuario', '$ahora');");
        $consulta->execute();
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