<?php

/*

Clase Mesa

Fernández Mariano

*/

define('PAGANDO',2);
define('COMIENDO',1);
define('ESPERANDO',0);
define('CERRADA',-1);

require_once "./db/AccesoDatos.php";
require_once "Pedido.php";


class Mesa
{
	//ATRIBUTOS

	public $codigo;
	public $estado;
	public $fechaDeCreacion;

	//GETTERS

	public function GetCodigo()
	{
		$retorno=0;

		if(!(is_null($this->codigo)))
		{
			$retorno=$this->codigo;
		}

		return $retorno;
	}

    public function GetEstado()
    {
        $retorno=0;

		if(!(is_null($this->estado)))
		{
			$retorno=$this->estado;
		}

		return $retorno;
    }

    public function GetFechaDeCreacion()
    {
        $retorno="1/1/1970";

        if(!(is_null($this->fechaDeCreacion)))
		{
			$retorno=$this->fechaDeCreacion;
		}

		return $retorno;
    }

    //SETTERS

	public function SetCodigo($value)
	{
        $this->codigo=$value;
	}

	public function SetEstado($value)
	{
        $this->estado=$value;
	}

	public function SetFechaDeCreacion($value)
	{
        $this->fechaDeCreacion=$value;
	}

	//CONSTRUCTOR

	function __construct()
	{

	}

	public static function ConstruirMesa($estado,$fechaDeCreacion)
	{
		$mesa=new Mesa();


		$codigo=Mesa::CrearCodigoAlfaNumerico();
		while(Pedido::ValidarAlfaNumerico($codigo))
		{
			$codigo=Mesa::CrearCodigoAlfaNumerico();
		}

		$mesa->SetCodigo($codigo);

		$mesa->SetEstado($estado);
		$mesa->SetFechaDeCreacion($fechaDeCreacion);

		return $mesa;
	}

	//METODOS

	public static function AltaMesa($mesa)
	{
		$retorno=0;
		$lista=Mesa::ObtenerTodasLasMesas();

		if(!(is_null($mesa->GetCodigo()) || is_null($mesa->GetEstado()) || is_null($mesa->GetFechaDeCreacion())))
		{
			$mesa->AgregarMesaDatabase();
			$retorno=1;
		}

		return $retorno;
	}

	public static function CambiarEstadoMesa($mesa,$estado)
	{	
		$mesa->CambiarEstadoMesaDatabase($estado);
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

	public static function ObtenerEstadoInt($estado)
	{
		switch($estado)
		{
			case "pagando":
				return 2;
			break;
			
			case "comiendo":
				return 1;
			break;
			
			case "esperando":
				return 0;
			break;

			case "cerrada":
				return -1;
			break;
			
			default:
				return -2;
			break;
		}
	}

	public function ContarPedidos($listaPedidos)
	{
		$contador = 0;

		foreach ($listaPedidos as $pedido) 
		{
			if($pedido->GetCodigoMesa() == $this->GetCodigo() && $pedido->GetEstado() == 2)
			{
				$contador++;
			}
		}

		return $contador;
	}

	public function AcumularRecaudacionMesa($listaPedidos)
	{
		$acumulador = 0;

		foreach ($listaPedidos as $pedido) 
		{
			if($pedido->GetCodigoMesa() == $this->GetCodigo() && $pedido->GetEstado() == 2)
			{
				$acumulador+= Pedido::ObtenerValorTotalPedido($pedido->GetCodigo())[0];
			}
		}

		if(isset($acumulador) && is_float($acumulador))
		{
			$acumulador = number_format($acumulador, 2, '.', '');
		}

		return $acumulador;
	}

	public static function ObtenerMayorRecaudacionPorMesa($listaPedidos,$listaMesas)
	{
		$maximo = false;

		foreach ($listaMesas as $mesa) 
		{
			$acumulador = $mesa->AcumularRecaudacionMesa($listaPedidos);

			if($acumulador > $maximo || $maximo == false)
			{
				$maximo = $acumulador;
			}
		}

		return $maximo;
	}

	public static function ObtenerMenorRecaudacionPorMesa($listaPedidos,$listaMesas)
	{
		$minimo = false;

		foreach ($listaMesas as $mesa) 
		{
			$acumulador = $mesa->AcumularRecaudacionMesa($listaPedidos);

			if($acumulador < $minimo || $minimo == false)
			{
				$minimo = $acumulador;
			}
		}

		return $minimo;
	}

	public static function ObtenerMayorCantidadPedidosPorMesa($listaPedidos,$listaMesas)
	{
		$maximo = false;

		foreach ($listaMesas as $mesa) 
		{
			$contador = $mesa->ContarPedidos($listaPedidos);

			if($contador > $maximo || $maximo == false)
			{
				$maximo = $contador;
			}
		}

		return $maximo;
	}

	public static function ObtenerMenorCantidadPedidosPorMesa($listaPedidos,$listaMesas)
	{
		$minimo = false;

		foreach ($listaMesas as $mesa) 
		{
			$contador = $mesa->ContarPedidos($listaPedidos);

			if($contador < $minimo || $minimo == false)
			{
				$minimo = $contador;
			}
		}

		return $minimo;
	}

	public static function OrdenarMesasPorRecaudacion($fechaInicio,$fechaFinal)
	{
		$existeFecha = ($fechaInicio != "" && $fechaFinal != "");

		if($existeFecha)
		{
			$retorno = Producto::ObtenerTodosLosProductosOrdenadosPorCantidadEntreDosFechas($fechaInicio,$fechaFinal,"DESC");
		}
		else
		{
			$retorno = Producto::ObtenerTodosLosProductosOrdenadosPorCantidad("DESC");
		}

		return $retorno;
    }


	public static function RetornarMesasPorCantidadPedidos($listaPedidos, $listaMesas,$cantidad)
	{
		$mesas = false;

		if(isset($cantidad) && is_numeric($cantidad))
		{
			$mesas = array();
			foreach ($listaMesas as $mesa) 
			{
				$contador = $mesa->ContarPedidos($listaPedidos);

				if($contador == $cantidad)
				{
					array_push($mesas,$mesa);
				}
			}
		}

		return $mesas;
	}

	public static function RetornarMesasAsignadasAPedidos($listaPedidos,$listaMesas)
	{
		$mesas = false;

		if(isset($listaPedidos) && count($listaPedidos) > 0 && count($listaMesas) > 0)
		{
			$mesas = array();
			foreach ($listaMesas as $mesa) 
			{
				if(Mesa::EncontrarPedido($listaPedidos,$mesa->GetCodigo()))
				{
					array_push($mesas,$mesa); 
				}
			}
		}

		return $mesas;
	}

	public static function EncontrarPedido($listaPedidos,$codigoMesa)
	{
		$retorno = 0;

		foreach ($listaPedidos as $pedido) 
		{
			if($codigoMesa == $pedido->GetCodigoMesa() && $pedido->GetEstado() == 2)
			{
				$retorno = 1;
				break;
			}
		}

		return $retorno;
	}

	public static function RetornarMesasPorRecaudacion($listaPedidos,$listaMesas,$recaudacion)
	{
		$mesas = false;

		if(isset($recaudacion) && is_numeric($recaudacion))
		{
			$mesas = array();
			foreach ($listaMesas as $mesa) 
			{
				$acumulador = $mesa->AcumularRecaudacionMesa($listaPedidos);

				if($acumulador == $recaudacion)
				{
					array_push($mesas,$mesa);
				}
			}
		}

		return $mesas;
	}

	public static function ObtenerMesasOrdenadasPorRecaudacion($fechaInicio,$fechaFinal)
	{
		$existeFecha = ($fechaInicio != "" && $fechaFinal != "");

		if($existeFecha)
		{
			$retorno = Mesa::ObtenerTodasLasMesasOrdenadasPorRecaudacionEntreDosFechas($fechaInicio,$fechaFinal,"DESC");
		}
		else
		{
			$retorno = Mesa::ObtenerTodasLasMesasOrdenadasPorRecaudacion("DESC");
		}

		return $retorno;
    }

	public static function CrearCodigoAlfaNumerico()
	{
		$codigoAlfanumerico="";
		$numeroOLetra=random_int(0,2);//0 Numero, 1 letra

		for ($i=0;$i<5;$i++)
		{
			if($numeroOLetra==0)
			{
				$codigoAlfanumerico .= chr(random_int(48,57));
			}
			else
			{
				$codigoAlfanumerico .= chr(random_int(65,90));
			}

			$numeroOLetra=random_int(0,2);
		}

		return$codigoAlfanumerico;
	}

	public static function ValidarAlfaNumerico($alfaNumerico)
	{
		$retorno=false;

		$lista = Pedido::ObtenerTodosLosPedidos();

		foreach ($lista as $pedido) 
		{
			$pedido->GetCodigo() == $alfaNumerico;
			$retorno=true;
		}

		return $retorno;
	}


	function Equals($mesa)
	{
		return $this->GetCodigo() == $mesa->GetCodigo(); 
	}
/*
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
*/
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

	public function RetornarInfoDeMesaString()
	{
		$estadoText = "Cerrada";

		$retorno=("<td>".$this->GetCodigo()."</td>");

		switch($this->GetEstado())
		{
			case 0:
				$estadoText = "Esperando";
				break;

			case 1:
				$estadoText = "Comiendo";
				break;

			case 2:
				$estadoText = "Pagando";
				break;
		}

		$retorno.=("<td>".$estadoText."</td>");
		$retorno.=("<td>".$this->GetFechaDeCreacion()."</td>");

		return $retorno;
	}


	public static function RetornarListaDeMesasString($listaMesas)
	{
		$len = count($listaMesas);
		$retorno="<h1>No hay mesas dadas de altaa<h1>";

		if($len>0)
		{
			$retorno=("<table>");
			$retorno.=("<th>[Codigo]</th><th>[Estado]</th><th>[Fecha de Creación]</th>");
			foreach($listaMesas as $mesa)
			{
				$retorno.=("<tr align='center'>");
				$retorno.=$mesa->RetornarInfoDeMesaString();
				$retorno.=("</tr>");
			}
			$retorno.=("</table>");
		}

		return $retorno;
    }

	public static function RetornarListaDeMesasConRecaudacionString($listaMesas,$fechaInicio,$fechaFinal)
	{
		$len = count($listaMesas);
		$retorno="<h1>No hay mesas en la lista<h1>";
		$tieneFecha = ($fechaInicio != "" && $fechaFinal != "");

		if($len>0)
		{
			$retorno=("<table>");
			$retorno.=("<th>[Codigo]</th><th>[Estado]</th><th>[Fecha de Creación]</th><th>[Recaudación]</th>");
			foreach($listaMesas as $mesa)
			{
				$retorno.=("<tr align='center'>");
				$retorno.=$mesa->RetornarInfoDeMesaString();
				$tieneFecha ? $listaPedidos = Pedido::ObtenerTodosLosPedidosPorFecha($fechaInicio,$fechaFinal) :
				$listaPedidos = Pedido::ObtenerTodosLosPedidos();
				$retorno.=("<td>$ ".$mesa->AcumularRecaudacionMesa($listaPedidos)."</td>");
				$retorno.=("</tr>");
			}
			$retorno.=("</table>");
		}

		return $retorno;
    }
	

	
	public static function RetornarListaComentarios($listaComentarios)
	{
		$len = count($listaComentarios);
		$retorno="<h1>No hay ningun comentario dado de alta<h1>";

		if($len>0)
		{
			$retorno=("<table>");
			$retorno.=("<th>[Codigo Mesa]</th><th>[Codigo Pedido]</th><th>[Nota Mesa]</th><th>[Nota Restaurante]</th><th>[Nota Mozo]</th><th>[Nota cocinero]</th><th>[Comentario]</th>");
			foreach($listaComentarios as $comentario)
			{
				$retorno.=("<tr align='center'>");
				$retorno.=("<td>".$comentario->codigoMesa."</td>");
				$retorno.=("<td>".$comentario->codigoPedido."</td>");
				$retorno.=("<td>".$comentario->notaMesa."/10</td>");
				$retorno.=("<td>".$comentario->notaRestaurante."/10</td>");
				$retorno.=("<td>".$comentario->notaMozo."/10</td>");
				$retorno.=("<td>".$comentario->notaCocinero."/10</td>");
				$retorno.=("<td>".$comentario->comentario."</td>");
				$retorno.=("</tr>");
			}
			$retorno.=("</table>");
		}

		return $retorno;
    }

    //METODOS DATABASE

    public function AgregarMesaDatabase()
    {
       $objetoAccesoDato = AccesoDatos::obtenerInstancia(); 
       $consulta = $objetoAccesoDato->prepararConsulta("INSERT into mesas (codigo,estado,fechaDeCreacion)values('$this->codigo','$this->estado','$this->fechaDeCreacion')");
       $consulta->execute();
    }

	public function CambiarEstadoMesaDatabase($estado)
    {
       $objetoAccesoDato = AccesoDatos::obtenerInstancia(); 

       $consulta = $objetoAccesoDato->prepararConsulta("UPDATE mesas SET estado = '$estado' WHERE codigo = '$this->codigo' ");
	   $consulta->execute();
    }

    public static function ObtenerTodasLasMesas()
    {
		$retorno=array();
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT codigo,estado,fechaDeCreacion FROM mesas");
       	if($consulta->execute())
		{
			$retorno = $consulta->fetchAll(PDO::FETCH_CLASS, 'Mesa');
	   	}
        return $retorno;
    }

	public static function ObtenerTodasLasMesasOrdenadasPorRecaudacion($condicion)
    {
		$retorno=array();
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta
		("SELECT m.codigo,m.estado,m.fechaDeCreacion, SUM(pp.precio) FROM mesas m LEFT JOIN pedidos p ON p.codigoMesa = m.codigo LEFT JOIN pedprod pp ON p.codigo = pp.codigoPedido AND p.estado = 2;
		GROUP BY m.codigo
		ORDER BY SUM(pp.precio) $condicion;");
       	if($consulta->execute())
		{
			$retorno = $consulta->fetchAll(PDO::FETCH_CLASS, 'Mesa');
	   	}
        return $retorno;
    }

	public static function ObtenerTodasLasMesasOrdenadasPorRecaudacionEntreDosFechas($fecha1,$fecha2,$condicion)
    {
		$retorno=array();
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta
		("SELECT m.codigo,m.estado,m.fechaDeCreacion, SUM(pp.precio) FROM mesas m LEFT JOIN pedidos p ON p.codigoMesa = m.codigo LEFT JOIN pedprod pp ON p.codigo = pp.codigoPedido AND p.estado = 2
		AND p.horaFinal BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59'
		GROUP BY m.codigo
		ORDER BY SUM(pp.precio) $condicion;");       	
		if($consulta->execute())
		{
			$retorno = $consulta->fetchAll(PDO::FETCH_CLASS, 'Mesa');
	   	}
        return $retorno;
    }

    public static function ObtenerMesa($codigo)
    {
		$retorno=false;
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT codigo,estado,fechaDeCreacion FROM mesas WHERE codigo = :codigo");
        $consulta->bindValue(':codigo', $codigo, PDO::PARAM_STR);
        
		if($consulta->execute())
		{
			$retorno = $consulta->fetchObject('Mesa');
	   	}

        return $retorno;
    }

	public static function ObtenerFacturacionMesaPorFecha($codigoMesa,$fecha1,$fecha2)
	{
		$retorno=false;
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT SUM(precio) FROM pedprod p INNER JOIN pedidos ped ON ped.codigo = p.codigoPedido WHERE ped.codigoMesa = '$codigoMesa' AND p.horaFinal BETWEEN '$fecha1' AND '$fecha2' AND ped.estado = 2;");

		if($consulta->execute())
		{
			$retorno = $consulta->fetch(PDO::FETCH_NUM);
		}

        return $retorno;
	}
}

?>