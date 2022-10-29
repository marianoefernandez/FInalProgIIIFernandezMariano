<?php

/*

Clase Pedido

Fernández Mariano

*/

use Illuminate\Support\Facades\Date;

require_once "./db/AccesoDatos.php";
require_once "Archivos.php";
require_once "Producto.php";
define('CANCELADO',-2);
define('PENDIENTE',-1);
define('ENPREPARACION',0);
define('TERMINADO',1);



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
		if(!(is_null($pedido->GetHoraFinal()) || is_null($pedido->GetHoraInicio()) || is_null($pedido->GetCodigo()) || is_null($pedido->GetEstado())))
		{
			$retorno=0;//Si no está dada de alta la mesa, el producto o el usuario.
			if($mesa != false && $usuario != false)
			{
				$retorno=1;
				$pedido->AgregarPedidoDatabase();
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

	public static function ObtenerMayorRecaudacion()
	{
		$listaPedidos = Pedido::ObtenerTodosLosPedidos();
		$maximo = false;

		foreach ($listaPedidos as $pedido) 
		{
			$recaudacion = Pedido::ObtenerValorTotalPedido($pedido->GetCodigo())[0];

			if($recaudacion > $maximo || $maximo == false)
			{
				$maximo = $recaudacion;
			}
		}

		return $maximo;
	}

	public static function ObtenerMenorRecaudacion()
	{
		$listaPedidos = Pedido::ObtenerTodosLosPedidos();
		$minimo = false;

		foreach ($listaPedidos as $pedido) 
		{
			$recaudacion = Pedido::ObtenerValorTotalPedido($pedido->GetCodigo())[0];

			if($recaudacion < $minimo || $minimo == false)
			{
				$minimo = $recaudacion;
			}
		}

		return $minimo;
	}

	public static function RetornarPedidosPorRecaudacion($recaudacion)
	{
		$listaPedidos = Pedido::ObtenerTodosLosPedidos();
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

		if (!file_exists($ubicacionFinal)) 
		{
			$this->SubirArchivo($origen,$destino,$nombreArchivo,$extension);
			$this->GuardarFoto($origen,$destino);
			$retorno = 1;
		}

		return $retorno;
	}

	public static function RetornarListaDePedidosString($listaPedidos,$listaUsuarios,$listaMesas,$estado)
	{
		$flag=0;
		$len = count($listaPedidos);
		$retorno=false;

		if($len>0)
		{
			$retorno=("<table>");
			$retorno.=("<th>[Pedido Codigo]</th><th>[Atendio]</th><th>[Mesa Codigo]</th><th>[Tiempo de Preparación Aproximado]</th><th>[Tiempo Restante Aproximado]</th>");
			foreach($listaPedidos as $pedido)
			{
				$usuario = Usuario::ObtenerUsuario($pedido->GetIDUsuario());

				if($pedido->GetEstado()==$estado && $usuario != false)
				{
					
					$retorno.=("<tr align='center'>");
					$retorno.=("<td>".$pedido->GetCodigo()."</td>");
					$retorno.=("<td>".$usuario->GetNombre() . " ". $usuario->GetApellido() ."</td>");
					$retorno.=("<td>".$pedido->GetCodigoMesa()."</td>");
					$retorno.=("<td>".$pedido->CalcularTiempoDePreparacion(). " segundos" ."</td>");
					
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
					$retorno.=("</tr>");
					$flag=1;
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

	public function CalcularTiempoDePreparacion()
	{
		return $this->GetHoraFinal()->getTimestamp()-$this->GetHoraInicio()->getTimestamp();
	}

	public function CalcularTiempoDeRestante()
	{
		$horaActual = new DateTime(date("Y-m-j H:i:s"));

		return $this->GetHoraFinal()->getTimestamp() - $horaActual->getTimestamp() > 0 ? $this->GetHoraFinal()->getTimestamp() - $horaActual->getTimestamp() . " segundos" : "Aguarde un momento el pedido está tardando más de lo estimado";
	}

	public function VerificarSiTerminoElPedido()
	{
		$listaEstados = $this->ObtenerEstadosDelPedido();

		if(count($listaEstados)> 0 && $listaEstados != false)
		{
			foreach ($listaEstados as $estado) 
			{
				if($estado->estado != TERMINADO)
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

    //METODOS DATABASE

    public function AgregarPedidoDatabase()
    {
       $objetoAccesoDato = AccesoDatos::obtenerInstancia(); 
       $consulta = $objetoAccesoDato->prepararConsulta("INSERT into pedidos (codigoMesa,idUsuario,horaInicio,horaFinal,estado,codigo)values('$this->codigoMesa','$this->idUsuario','$this->horaInicio','$this->horaFinal','$this->estado','$this->codigo')");
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
       $consulta = $objetoAccesoDato->prepararConsulta("UPDATE pedidos SET estado = '$this->estado'");
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

	public static function ObtenerTodosLosPedidosQueNoLlegaronATiempo()
    {
		$retorno=array();
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT codigoMesa,idUsuario,horaInicio,horaFinal,codigo,estado FROM pedidos WHERE codigo IN (SELECT DISTINCT p.codigo FROM pedidos p INNER JOIN pedprod pp ON pp.codigoPedido = p.codigo AND pp.horaFinal > p.horaFinal);");
		
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
}

?>