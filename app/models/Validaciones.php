<?php
	function ValidarFechas($fecha1,$fecha2)
	{
		return ((strlen($fecha1) == 10 && strlen($fecha2) == 10 &&
        preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$fecha1) &&
        preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$fecha2)) || ($fecha1 == "" && $fecha2 == "") );
	}

	function ValidarSectores($rol)
	{
		return ($rol == "socio" || $rol == "bartender" || $rol == "cocinero" || $rol == "mozo" || $rol == "cervecero" || $rol == "todos");
	}
?>