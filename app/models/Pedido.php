<?php

/*

Clase Pedido

Fernández Mariano

*/

use Illuminate\Support\Facades\Date;

require_once "./db/AccesoDatos.php";
require_once "Archivos.php";
require_once "Producto.php";
require_once "Mesa.php";
define('CANCELADO',-2);
define('PENDIENTE',-1);
define('ENPREPARACION',0);
define('TERMINADO',1);
define('ENTREGADO',2);

class Pedido
{
	//ATRIBUTOS

	public $codigo;//Codigo de pedido
	public $codigoMesa;
	public $idUsuario;
	public $horaInicio;
	public $horaFinal;
	public $estado;//En preparacion - terminado

	//GETTERS
	public function GetCodigoMesa()
	{
		$retorno=0;

		if(!(is_null($this->codigoMesa)))
		{
			$retorno=$this->codigoMesa;
		}

		return $retorno;
	}

	public function GetIDUsuario()
	{
		$retorno=0;

		if(!(is_null($this->idUsuario)))
		{
			$retorno=$this->idUsuario;
		}

		return $retorno;
	}

	public function GetHoraInicio()
	{
		$retorno=date("H:i:s");

		if(!(is_null($this->horaInicio)))
		{
			$retorno= new Datetime($this->horaInicio);
		}

		return $retorno;
	}

	public function GetHoraFinal()
	{
		$retorno=date("H:i:s");

		if(!(is_null($this->horaFinal)))
		{
			$retorno= new DateTime($this->horaFinal);
		}

		return $retorno;
	}

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

    //SETTERS

	public function SetCodigoMesa($value)
	{
        $this->codigoMesa=$value;
	}

	public function SetIDUsuario($value)
	{
        $this->idUsuario=$value;
	}

	public function SetHoraInicio($value)
	{
        $this->horaInicio=$value;
	}

	public function SetHoraFinal($value)
	{
        $this->horaFinal=$value;
	}

	public function SetCodigo($value)
	{
        $this->codigo=$value;	
	}

	public function SetEstado($value)
	{
        $this->estado=$value;	
	}

	//CONSTRUCTOR

	function __construct()
	{

	}

	public static function ConstruirPedido($codigoMesa,$idUsuario,$horaInicio,$horaFinal)
	{
		$pedido=new Pedido();
		$pedido->SetCodigoMesa($codigoMesa);
		$pedido->SetIDUsuario($idUsuario);
		$pedido->SetHoraInicio($horaInicio);
		$pedido->SetHoraFinal($horaFinal);

		$codigo=Pedido::CrearCodigoAlfaNumerico();
		while(Pedido::ValidarAlfaNumerico($codigo))
		{
			$codigo=Pedido::CrearCodigoAlfaNumerico();
		}

		$pedido->SetCodigo($codigo);
		$pedido->SetEstado(PENDIENTE);

		return $pedido;
	}

	//METODOS
	public static function AltaPedido($pedido)
	{
		$retorno=-1;
		$mesa = Mesa::ObtenerMesa($pedido->GetCodigoMesa());
		$usuario = Usuario::ObtenerUsuario($pedido->GetIDUsuario());
		if(!(is_null($pedido->GetCodigo()) || is_null($pedido->GetEstado())))
		{
			$retorno=0;//Si no está dada de alta la mesa, el producto o el usuario.
			if($mesa != false && $usuario != false)
			{
				$retorno=1;
				$pedido->AgregarPedidoDatabase();
				$mesa->SetEstado(ESPERANDO);
				$mesa->CambiarEstadoMesaDatabase($mesa->GetEstado());
			}
		}

		return $retorno;
	}

	public static function ServirPedido($listaPedidos,$listaMesas,$pedido,$mesa)
	{
		$retorno=-1;
		if(count($listaPedidos) > 0) 
		{
			$retorno = 0;
			if(count($listaMesas) > 0 && $pedido != false && $mesa != false && $mesa->GetEstado() != "CERRADA")
			{
				$retorno = 1;
				if($pedido->GetEstado() != ENTREGADO)
				{
					$pedido->SetEstado(ENTREGADO);
					$mesa->SetEstado(COMIENDO);
					$pedido->EntregarPedidoDatabase();
					$pedido->ModificarHoraFinalDatabase(date("Y-m-j H:i:s"));
					$mesa->CambiarEstadoMesaDatabase($mesa->GetEstado());
					$retorno = 2;
				}
			}
		}

		return $retorno;
	}

	public static function CargarPedido($codigoPedido,$idProducto,$cantidad)
	{
		$retorno = -1;
		$pedido = Pedido::ObtenerPedido($codigoPedido);
		$producto = Producto::ObtenerProducto($idProducto);

		if($pedido != false)
		{
			$retorno = 0;
			if($producto != false)
			{
				$precio = $producto->GetPrecio() * $cantidad;
				$pedido->CargarPedidoDatabase($idProducto,$cantidad,$precio);
				$retorno = 1;
			}
		}

		return $retorno;
	}

	public static function DarDeBajaUnPedido($codigoPedido)
	{
		$retorno=0;
		$pedido = Pedido::ObtenerPedido($codigoPedido);

		if($pedido != false)
		{
			$retorno=1;
			$pedido->BorrarPedidoDatabase();
		}

		return $retorno;
	}


	public static function SacarFoto($codigoPedido,$foto)
	{
		$retorno = -1;
		$pedido = Pedido::ObtenerPedido($codigoPedido);
		if($pedido != false && isset($foto) && $foto != "")
		{
			$extension=(explode('/', $_FILES["foto"]["type"]));
			if($extension[0] == "image")
			{
				$nombreArchivo=$pedido->GetCodigo();
				$destino = "ImagenesPedidos/" . $pedido->GetCodigoMesa() . "/";
				$retorno = $pedido->SubirFotos($_FILES["foto"]["tmp_name"], $destino,$nombreArchivo,$extension[1]);
			}
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
			if($pedido->GetCodigo() == $alfaNumerico)
			{
				$retorno=true;
				break;
			}
		}

		return $retorno;
	}

	public static function ObtenerMayorRecaudacion($listaPedidos)
	{
		$maximo = false;

		foreach ($listaPedidos as $pedido) 
		{
			if($pedido->GetEstado()==ENTREGADO)
			{
				$recaudacion = Pedido::ObtenerValorTotalPedido($pedido->GetCodigo())[0];

				if($recaudacion > $maximo || $maximo == false)
				{
					$maximo = $recaudacion;
				}
			}
		}

		return $maximo;
	}

	public static function ObtenerMenorRecaudacion($listaPedidos)
	{
		$minimo = false;

		foreach ($listaPedidos as $pedido) 
		{
			if($pedido->GetEstado()==ENTREGADO)
			{
				$recaudacion = Pedido::ObtenerValorTotalPedido($pedido->GetCodigo())[0];
				if($recaudacion < $minimo || $minimo == false)
				{
					$minimo = $recaudacion;
				}
			}
		}

		return $minimo;
	}

	public static function RetornarPedidosPorRecaudacion($listaPedidos,$recaudacion)
	{
		$pedidos = false;

		if(isset($recaudacion) && is_numeric($recaudacion))
		{
			$pedidos = array();
			foreach ($listaPedidos as $pedido) 
			{
				$totalRecaudadoPedido = Pedido::ObtenerValorTotalPedido($pedido->GetCodigo())[0];
	
				if($totalRecaudadoPedido == $recaudacion)
				{
					array_push($pedidos,$pedido);
				}
			}
		}

		return $pedidos;
	}

	function Equals($pedido)
	{
		return $this->GetCodigo() == $pedido->GetCodigo(); 
	}

	function SubirArchivo($origen,$destino,$nombreArchivo,$extension)
	{
		if (!file_exists($destino)) 
		{
			mkdir($destino, 0777, true);
		}
	
		$destino .= $nombreArchivo . "." . $extension;
	
		move_uploaded_file($origen,$destino);
	}

	function SubirFotos($origen,$destino,$nombreArchivo,$extension)
	{
		$retorno = 0;
		$ubicacionFinal = $destino . $nombreArchivo . "." . $extension;

		if (count(glob($destino . $nombreArchivo . "*")) == 0)  
		{
			$this->SubirArchivo($origen,$destino,$nombreArchivo,$extension);
			$this->GuardarFoto($origen,$destino);
			$retorno = 1;
		}
		return $retorno;
	}

	public static function RetornarInfoPedidoString($pedido)
	{
		$retorno=false;
		$usuario = Usuario::ObtenerUsuario($pedido->GetIDUsuario());

		if($pedido != false && $usuario != false)
		{
			$retorno.=("<tr align='center'>");
			$retorno.=("<td>".$pedido->GetCodigo()."</td>");
			$retorno.=("<td>".$usuario->GetNombre() . " ". $usuario->GetApellido() ."</td>");
			$retorno.=("<td>".$pedido->GetCodigoMesa()."</td>");

			if($pedido->GetEstado() != PENDIENTE)
			{
				$retorno.=("<td>".$pedido->CalcularTiempoDePreparacion()."</td>");
			
				if($pedido->GetEstado() == CANCELADO)
				{
					$tiempoRestante = "El pedido fue cancelado";
				}
				else
				{
					$pedido->VerificarSiTerminoElPedido() 
					? $tiempoRestante = "Terminado"
					: $tiempoRestante = $pedido->CalcularTiempoDeRestante();
				}
				
				$retorno.=("<td>".$tiempoRestante."</td>");
			}
			
			$retorno.=("</tr>");
		}

		return $retorno;
    }

	public static function RetornarUnPedidoString($pedido)
	{
		$retorno=false;
		$infoPedido = Pedido::RetornarInfoPedidoString($pedido);

		if($infoPedido != false)
		{
			$retorno=("<table>");
			$retorno.=("<th>[Pedido Codigo]</th><th>[Atendio]</th><th>[Mesa Codigo]</th><th>[Tiempo de Preparación Aproximado]</th><th>[Tiempo Restante Aproximado]</th>");
			$retorno.= $infoPedido;
			$retorno.=("</table>");
		}

		return $retorno;
    }

	public static function RetornarTiempoDemora($pedido)
	{
		$retorno=false;

		if($pedido != false)
		{
			$retorno.=("<h3>Tiempo de preparación (Aproximado) : ".$pedido->CalcularTiempoDePreparacion()."<h3>");

			if($pedido->GetEstado() == CANCELADO)
			{
				$tiempoRestante = "El pedido fue cancelado";
			}
			else
			{

				if($pedido->VerificarSiTerminoElPedido())
				{
					$pedido->GetEstado() == TERMINADO ?
					$tiempoRestante = "Terminado" :
					$tiempoRestante = "Entregado";
				}
				else
				{
					$tiempoRestante = $pedido->CalcularTiempoDeRestante();
				}

			}
			
			$retorno.=("<h3>Tiempo restante (Aproximado) : ".$tiempoRestante."<h3>");
		}

		return $retorno;
    }

	public static function RetornarListaDePedidosString($listaPedidos,$estado)
	{
		$flag=0;
		$len = count($listaPedidos);
		$contador = 0;
		$retorno=false;

		if($len>0)
		{
			$retorno=("<table>");
			
			if($estado == PENDIENTE)
			{
				$retorno.=("<th>[Pedido Codigo]</th><th>[Atendio]</th><th>[Mesa Codigo]</th>");
			}
			else
			{
				$retorno.=("<th>[Pedido Codigo]</th><th>[Atendio]</th><th>[Mesa Codigo]</th><th>[Tiempo de Preparación Aproximado]</th><th>[Tiempo Restante Aproximado]</th>");
			}
			
			foreach($listaPedidos as $pedido)
			{
				if($pedido->GetEstado() == $estado)
				{
					$infoPedido = Pedido::RetornarInfoPedidoString($pedido);

					if($infoPedido != false)
					{
						$retorno.=$infoPedido;
						$flag=1;
					}
				}
			}
			$retorno.=("</table>");
		}

		if($flag == 0)
		{
			$retorno = false;
		}

		return $retorno;
    }

	public static function RetornarUnPedidoConProductosString($listaProductos,$pedido,$usuario,$estado)
	{
		$retorno = false;
		$flag = 0;

		if($pedido != false)
		{
			$retorno = "<h2>No hay ningun producto cargado a ese pedido o el estado del pedido es diferente a solicitado<h2>";

			if(count($listaProductos) > 0)
			{
				$retorno = "<h2>Muestro los productos para el pedido $pedido->codigo <h2>";

				$retorno.=("<table>");
				$retorno.=("<th>[Id Producto]</th><th>[Nombre]</th><th>[Tipo]</th><th>[Rol]</th><th>[Precio]</th><th>[Cantidad]</th>");

				foreach ($listaProductos as $producto) 
				{
					if(($usuario->GetRol() == $producto->GetRol() || $usuario->GetTipo() == "socio"))
					{
						$retorno.=("<tr align='center'>");
						$retorno.=("<td>". $producto->id ."</td>");
						$retorno .= Producto::RetornarUnProductoString($producto);
						$retorno.=("<td>". Producto::CantidadVentasPedidoProducto($pedido->GetCodigo(),$producto->GetID(),$estado)."</td>");
						$retorno.=("</tr>");
						$flag = 1;
					}
				}
				$retorno.=("</table>");
			}
		}

		if($flag == 0)
		{
			$retorno = false;
		}

		return $retorno;
    }

	public static function RetornarListaDePedidosConProductosString($listaPedidos,$usuario,$estado)
	{
		$retorno = "<h2>No hay pedidos dados de alta en el sistema<h2>";
		$flag = 0;

		if(count($listaPedidos) > 0)
		{
			$retorno = "";
			foreach ($listaPedidos as $pedido) 
			{
				if($pedido->GetEstado() == $estado)
				{
					$listaProductos = Producto::ObtenerTodosLosProductosPorPedido($pedido->GetCodigo(),$estado);
					$retorno .= Pedido::RetornarUnPedidoConProductosString($listaProductos,$pedido,$usuario,$estado);
					if($retorno != false)
					{
						$flag = 1;
					}
				}
			}
		}

		if($flag == 0)
		{
			$retorno = false;
		}

		return $retorno;

    }

	public static function ObtenerEstadoInt($estado)
	{
		switch($estado)
		{
			case "entregado":
				return 2;
			break;

			case "terminado":
				return 1;
			break;
			
			case "enpreparacion":
				return 0;
			break;
			
			case "pendiente":
				return -1;
			break;

			case "cancelado":
				return -2;
			break;
			
			default:
				return -3;
			break;
		}
	}

	public static function TraerPedidosPorFecha($fecha1,$fecha2)
	{
        if($fecha1 == "" && $fecha2 == "")
        {
          $listaPedidos = Pedido::ObtenerTodosLosPedidos();
        }
        else
        {
          $listaPedidos = Pedido::ObtenerTodosLosPedidosPorFecha($fecha1,$fecha2);
        }

		return $listaPedidos;
	}

	public function CalcularTiempoDeRestante()
	{
		$retorno = "Pendiente";
		$horaFinal = new DateTime($this->ObtenerHoraMayor()["hora"]);
		$horaActual = new DateTime(date("Y-m-j H:i:s"));

		if(isset($horaFinal))
		{
			$retorno = $horaFinal->getTimestamp() - $horaActual->getTimestamp() > 0 ? $horaFinal->getTimestamp() - $horaActual->getTimestamp() . " segundos" : "Aguarde un momento el pedido está tardando más de lo estimado";
		}

		return $retorno;
	}

	public function VerificarSiTerminoElPedido()
	{
		$listaEstados = $this->ObtenerEstadosDelPedido();

		if(count($listaEstados)> 0 && $listaEstados != false)
		{
			foreach ($listaEstados as $estado) 
			{
				if($estado->estado != TERMINADO && $estado->estado != ENTREGADO)
				{
					return false;
				}
			}
		}
		else
		{
			return false;
		}

		return true;
	}

	public static function CargaForzada($pedidos)
	{
		$contador = 0;

		foreach ($pedidos as $pedido) 
		{
			if(Pedido::VerificarExistencia($pedido) && count((array)$pedido) == 6 && Pedido::ValidarPedido($pedido))
			{
				$pedidoAux = new Pedido();
				$pedidoAux->SetCodigoMesa($pedido->codigoMesa);
				$pedidoAux->SetIDUsuario($pedido->idUsuario);
				$pedidoAux->SetHoraInicio($pedido->horaInicio);
				$pedidoAux->SetHoraFinal($pedido->horaFinal);
				$pedidoAux->SetCodigo($pedido->codigo);
				$pedidoAux->SetEstado($pedido->estado);

				$pedidoAux->AgregarPedidoDatabase();
				$contador++;
			}
		}

		return $contador;
	}

	//Retorna 1 si el usuario ya tiene asignado un mail no disponible o si su id corresponde con otro 0 si existe en la database
	public static function VerificarExistencia($pedido)
	{
		$listaPedidos = Pedido::ObtenerTodosLosPedidos();

		foreach ($listaPedidos as $pedidoAux) 
		{
			if($pedidoAux->codigo == $pedido->codigo)
			{
				return 0;
			}
		}

		return 1;
	}

	public static function VerificarExistenciaMesa($listaMesas,$pedido)
	{
		foreach ($listaMesas as $mesa) 
		{
			if($mesa->GetCodigo() == $pedido->codigoMesa)
			{
				return 1;
			}
		}

		return 0;
	}

	public static function VerificarExistenciaPedido($listaPedidos,$codigoPedido)
	{
		foreach ($listaPedidos as $pedidoAux) 
		{
			if($pedidoAux->GetCodigo() == $codigoPedido)
			{
				return 1;
			}
		}

		return 0;
	}

	public static function ValidarPedido($pedido)
	{
		$listaMesas = Mesa::ObtenerTodasLasMesas();

		foreach ($pedido as $key => $value) 
		{
			if(!isset($pedido->$key) || $pedido->$key == "")
			{
				return 0;
			}
		}

		return (strlen($pedido->codigo) == 5 && strlen($pedido->codigoMesa) == 5 && Pedido::VerificarExistenciaMesa($listaMesas,$pedido) && is_numeric($pedido->idUsuario) && is_numeric($pedido->estado) && ($pedido->estado > -3 && $pedido->estado < 3));
	}

    //METODOS DATABASE

    public function AgregarPedidoDatabase()
    {
       $objetoAccesoDato = AccesoDatos::obtenerInstancia(); 

	   $consulta = $objetoAccesoDato->prepararConsulta("INSERT into pedidos (codigoMesa,idUsuario,horaInicio,horaFinal,estado,codigo)values('$this->codigoMesa','$this->idUsuario','$this->horaInicio',NULL,'$this->estado','$this->codigo')");

	   if(isset($this->horaFinal))
	   {
		$consulta = $objetoAccesoDato->prepararConsulta("INSERT into pedidos (codigoMesa,idUsuario,horaInicio,horaFinal,estado,codigo)values('$this->codigoMesa','$this->idUsuario','$this->horaInicio','$this->horaFinal','$this->estado','$this->codigo')");
	   }

       $consulta->execute();
    }

	public function BorrarPedidoDatabase()
    {
       $objetoAccesoDato = AccesoDatos::obtenerInstancia(); 
       $consulta = $objetoAccesoDato->prepararConsulta("DELETE FROM pedidos WHERE codigo = '$this->codigo'");
       $consulta->execute();
    }

	public function GuardarFoto($origen,$destino)
	{	
		$this->BorrarFoto();
		$objetoAccesoDato = AccesoDatos::obtenerInstancia(); 
		$consulta = $objetoAccesoDato->prepararConsulta("INSERT into fotospedidos (codigoPedido,origen,destino)values('$this->codigo','$origen','$destino')");
		$consulta->execute();
	}

	public function BorrarFoto()
	{	
		$objetoAccesoDato = AccesoDatos::obtenerInstancia(); 
		$consulta = $objetoAccesoDato->prepararConsulta("DELETE FROM fotospedidos WHERE codigoPedido = '$this->codigo'");
		$consulta->execute();
	}

    public function CargarPedidoDatabase($idProducto,$cantidad,$precio)
    {
       $objetoAccesoDato = AccesoDatos::obtenerInstancia(); 
       $consulta = $objetoAccesoDato->prepararConsulta("INSERT into pedprod (codigoPedido,idProducto,cantidad,horaInicio,horaFinal,estado,precio)values('$this->codigo','$idProducto','$cantidad',NULL,NULL,-1,'$precio')");
       $consulta->execute();
    }

	public function ModificarEstadoDatabase()
    {
       $objetoAccesoDato = AccesoDatos::obtenerInstancia(); 
	   $consulta = $objetoAccesoDato->prepararConsulta("UPDATE pedidos SET estado = '$this->estado' WHERE codigo = '$this->codigo'");
	   $consulta->execute();
    }

	public function ModificarHoraFinalDatabase($horaFinal)
    {
       $objetoAccesoDato = AccesoDatos::obtenerInstancia(); 
	   $consulta = $objetoAccesoDato->prepararConsulta("UPDATE pedidos SET horaFinal = '$horaFinal' WHERE codigo = '$this->codigo'");
	   $consulta->execute();
    }

    public static function ObtenerTodosLosPedidos()
    {
		$retorno=array();
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT codigoMesa,idUsuario,horaInicio,horaFinal,codigo,estado FROM pedidos");

		if($consulta->execute())
		{
			$retorno = $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
		}

        return $retorno;
    }

	public static function ObtenerTodosLosPedidosPorEstado($estado)
    {
		$retorno=array();
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT codigoMesa,idUsuario,horaInicio,horaFinal,codigo,estado FROM pedidos WHERE estado = $estado");

		if($consulta->execute())
		{
			$retorno = $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
		}

        return $retorno;
    }

    public static function ObtenerTodosLosPedidosPorEmpleado($idEmpleado)
    {
		$retorno=array();
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT codigoMesa,idUsuario,horaInicio,horaFinal,codigo,estado FROM pedidos WHERE idUsuario = $idEmpleado");

		if($consulta->execute())
		{
			$retorno = $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
		}

        return $retorno;
    }

	public static function ObtenerTodosLosPedidosPorFecha($fecha1,$fecha2)
    {
		$retorno=array();
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT codigoMesa,idUsuario,horaInicio,horaFinal,codigo,estado FROM pedidos WHERE horaFinal BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59'");

		if($consulta->execute())
		{
			$retorno = $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
		}

        return $retorno;
    }

	public static function ObtenerTodosLosPedidosPorFechaYEstado($fecha1,$fecha2,$estado)
    {
		$retorno=array();
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT codigoMesa,idUsuario,horaInicio,horaFinal,codigo,estado FROM pedidos WHERE horaFinal BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59' AND estado = $estado");

		if($consulta->execute())
		{
			$retorno = $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
		}

        return $retorno;
    }
	public static function ObtenerTodosLosPedidosQueNoLlegaronATiempo()
    {
		$retorno=array();
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT codigoMesa,idUsuario,horaInicio,horaFinal,codigo,estado FROM pedidos WHERE codigo IN (SELECT DISTINCT p.codigo FROM pedidos p INNER JOIN pedprod pp ON pp.codigoPedido = p.codigo AND p.horaFinal > pp.horaFinal);");
		
		if($consulta->execute())
		{
			$retorno = $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
		}

        return $retorno;
    }

	public static function ObtenerTodosLosPedidosQueNoLlegaronATiempoEntreDosFechas($fecha1,$fecha2)
    {
		$retorno=array();
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT codigoMesa,idUsuario,horaInicio,horaFinal,codigo,estado FROM pedidos WHERE codigo IN (SELECT DISTINCT p.codigo FROM pedidos p INNER JOIN pedprod pp ON pp.codigoPedido = p.codigo AND p.horaFinal > pp.horaFinal AND p.horaFinal BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59');");
		
		if($consulta->execute())
		{
			$retorno = $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
		}

        return $retorno;
    }

	public static function ObtenerValorTotalPedido($codigoPedido)
    {
		$retorno=false;
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT SUM(precio) FROM pedprod WHERE codigoPedido = '$codigoPedido';");

		if($consulta->execute())
		{
			$retorno = $consulta->fetch(PDO::FETCH_NUM);
		}

        return $retorno;
    }

    public static function ObtenerPedido($codigo)
    {
		$retorno=false;

        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT codigoMesa,idUsuario,horaInicio,horaFinal,codigo,estado FROM pedidos WHERE codigo = :codigo");
        $consulta->bindValue(':codigo', $codigo, PDO::PARAM_STR);
        
		if($consulta->execute())
		{
			$retorno = $consulta->fetchObject('Pedido');
		}

        return $retorno;
    }

	public function ObtenerEstadosDelPedido()
	{
		$retorno = false;

        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT estado FROM pedprod WHERE codigoPedido = '$this->codigo';");
       	if($consulta->execute())
		{
			$retorno = $consulta->fetchAll(PDO::FETCH_OBJ);
	   	}


        return $retorno;
    }

	public function ObtenerEstadoDelPedido()
	{
		$retorno = false;

        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT estado FROM pedprod WHERE codigoPedido = '$this->codigo';");
       	if($consulta->execute())
		{
			$retorno = $consulta->fetchAll(PDO::FETCH_OBJ);
	   	}

        return $retorno;
    }

	public static function VerificarEstado($pedido,$estadoInt)
	{
		$listaEstados = $pedido->ObtenerEstadosDelPedido();
		if(count($listaEstados)> 0 && $listaEstados != false)
		{
			foreach ($listaEstados as $estado) 
			{
				if($estado->estado != $estadoInt)
				{
					return false;
				}
			}
		}
		else
		{
			return false;
		}

		return true;
	}

	public function EntregarPedidoDatabase()
	{
		$this->ModificarEstadoDatabase();
		$objetoAccesoDato = AccesoDatos::obtenerInstancia(); 
		$consulta = $objetoAccesoDato->prepararConsulta("UPDATE pedprod SET estado = 2 WHERE codigoPedido = '$this->codigo'");
		$consulta->execute();
	}

	public function ObtenerHoraMayor()
	{
		$this->ModificarEstadoDatabase();
		$objetoAccesoDato = AccesoDatos::obtenerInstancia(); 
		$consulta = $objetoAccesoDato->prepararConsulta("SELECT MAX(horaFinal) hora from pedprod WHERE codigoPedido = '$this->codigo';");
		$consulta->execute();
		$retorno = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $retorno[0];
	}

	public function CalcularTiempoDePreparacion()
	{
		$retorno=false;
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT TIMESTAMPDIFF(SECOND,MIN(horaInicio), MAX(horaFinal)) FROM pedprod WHERE codigoPedido = '$this->codigo';");

		if($consulta->execute())
		{
			$retorno = $consulta->fetch(PDO::FETCH_NUM);
			$retorno = $retorno[0];
		}

		if($retorno== false)
		{
			$retorno = 0;
		}

        return $retorno;
	}
/*
	//Me permite saber si el pedido termino y establece su estado como terminado
	public static function VerificarTiempoPedidos()
	{
		$listaPedidos = Pedido::ObtenerTodosLosPedidos();
		$estadoPedido = 0;
		$tiempoRestante = 0;
		$len = count($listaPedidos);

		if($len > 0)
		{
			foreach ($listaPedidos as $pedido) 
			{
				if($pedido->GetEstado() == 0)//Si está en preparación
				{
					//Se verifica si se termino
					$horaActual = new DateTime(date("Y-m-j H:i:s"));
					$tiempoRestante = $pedido->GetHoraFinal()->getTimestamp() - $horaActual->getTimestamp();

					if($tiempoRestante < 1)
					{
						$pedido->SetEstado(1);
						$pedido->ModificarEstadoDatabase();
					}
				}
			}
		}
	}
	*/
}

?>