<?php

/*

Clase Pedido

Fernández Mariano

*/

use Illuminate\Support\Facades\Date;

require_once "./db/AccesoDatos.php";
require_once "Archivos.php";
define('ENPREPARACION',0);
define('TERMINADO',1);


class Pedido
{
	//ATRIBUTOS

	public $id;
	public $codigoMesa;
	public $idUsuario;
	public $idProducto;
	public $idCliente;
	public $cantidad;
	public $horaInicio;
	public $horaFinal;
	public $codigo;//Codigo de pedido
	public $estado;//En preparacion - terminado
	public $foto;

	//GETTERS
	public function GetID()
	{
		$retorno=0;

		if(!(is_null($this->id)))
		{
			$retorno=$this->id;
		}

		return $retorno;
	}

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

	public function GetIDProducto()
	{
		$retorno=0;

		if(!(is_null($this->idProducto)))
		{
			$retorno=$this->idProducto;
		}

		return $retorno;
	}

	public function GetIDCliente()
	{
		$retorno=0;

		if(!(is_null($this->idCliente)))
		{
			$retorno=$this->idCliente;
		}

		return $retorno;
	}

	public function GetCantidad()
	{
		$retorno=0;

		if(!(is_null($this->cantidad)))
		{
			$retorno=$this->cantidad;
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

	public function GetFoto()
	{
		$retorno="";

		if(!(is_null($this->foto)))
		{
			$retorno=$this->foto;
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

	public function SetIDProducto($value)
	{
        $this->idProducto=$value;
	}

	public function SetIDCliente($value)
	{
        $this->idCliente=$value;
	}

    public function SetCantidad($value)
	{
        $this->cantidad=$value;
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

	public function SetFoto($value)
	{
        $this->foto=$value;	
	}

	//CONSTRUCTOR

	function __construct()
	{

	}

	public static function ConstruirPedido($codigoMesa,$idUsuario,$idProducto,$idCliente,$cantidad,$horaInicio,$horaFinal,$foto)
	{
		$pedido=new Pedido();
		$pedido->SetCodigoMesa($codigoMesa);
		$pedido->SetIDUsuario($idUsuario);
		$pedido->SetIDProducto($idProducto);
		$pedido->SetIDCliente($idCliente);
		$pedido->SetCantidad($cantidad);
		$pedido->SetHoraInicio($horaInicio);
		$pedido->SetHoraFinal($horaFinal);

		$codigo=Pedido::CrearCodigoAlfaNumerico();
		while(Pedido::ValidarAlfaNumerico($codigo))
		{
			$codigo=Pedido::CrearCodigoAlfaNumerico();
		}

		$pedido->SetCodigo($codigo);
		$pedido->SetEstado(ENPREPARACION);
		$pedido->SetFoto($foto);

		return $pedido;
	}

	//METODOS
	public static function AltaPedido($pedido)
	{
		$retorno=-1;
		$mesa = Mesa::ObtenerMesa($pedido->GetCodigoMesa());
		$producto = Producto::ObtenerProducto($pedido->GetIDProducto());
		$usuario = Usuario::ObtenerUsuario($pedido->GetIDUsuario());

		if(!(is_null($pedido->GetCantidad()) || is_null($pedido->GetHoraFinal()) || is_null($pedido->GetHoraInicio()) || is_null($pedido->GetCodigo()) || is_null($pedido->GetEstado())))
		{
			$retorno=0;//Si no está dada de alta la mesa, el producto o el usuario.
			if($mesa != false && $producto != false && $usuario != false)
			{
				$retorno=1;
				$pedido->AgregarPedidoDatabase();
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
					$codigoAlfanumerico .= chr(random_int(48,58));
				}
				else
				{
					$codigoAlfanumerico .= chr(random_int(65,91));
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

		$this->archivoFoto=$destino;
	
		move_uploaded_file($origen,$destino);
	}

	public static function RetornarListaDePedidosString($listaPedidos,$listaUsuarios,$listaMesas,$listaProductos,$estado)
	{
		$flag=0;
		$len = count($listaPedidos);
		$retorno="<h1>La lista está vacia<h1>";

		if($len>0)
		{
			$retorno=("<table>");
			$retorno.=("<th>[Pedido Codigo]</th><th>[Producto]</th><th>[Cantidad]</th><th>[Atendio]</th><th>[Mesa Codigo]</th><th>[Tiempo de Preparación]</th><th>[Tiempo Restante]</th>");
			foreach($listaPedidos as $pedido)
			{
				$usuario = Usuario::ObtenerUsuario($pedido->GetIDUsuario());
				$producto = Producto::ObtenerProducto($pedido->GetIDProducto());

				if($pedido->GetEstado()==$estado && $usuario != false && $producto != false)
				{
					$retorno.=("<tr align='center'>");
					$retorno.=("<td>[".$pedido->GetCodigo()."]</td>");
					$retorno.=("<td>[".$producto->GetNombre() ."]</td>");
					$retorno.=("<td>[".$pedido->GetCantidad()."]</td>");
					$retorno.=("<td>[".$usuario->GetNombre() . " ". $usuario->GetApellido() ."]</td>");
					$retorno.=("<td>[".$pedido->GetCodigoMesa()."]</td>");
					$retorno.=("<td>[".$pedido->CalcularTiempoDePreparacion(). " segundos" ."]</td>");
					$retorno.=("<td>[".$pedido->CalcularTiempoDeRestante()."]</td>");
					$retorno.=("</tr>");
					$flag=1;
				}
			}
			$retorno.=("</table>");
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

		return $this->GetHoraFinal()->getTimestamp() - $horaActual->getTimestamp() > 0 ? $this->GetHoraFinal()->getTimestamp() - $horaActual->getTimestamp() . " segundos" : "Terminado";
	}

    //METODOS DATABASE

    public function AgregarPedidoDatabase()
    {
       $objetoAccesoDato = AccesoDatos::obtenerInstancia(); 
       $consulta = $objetoAccesoDato->prepararConsulta("INSERT into pedido (codigoMesa,idUsuario,idProducto,idCliente,cantidad,horaInicio,horaFinal,codigo,estado,foto)values('$this->codigoMesa','$this->idUsuario','$this->idProducto','$this->idCliente','$this->cantidad','$this->horaInicio','$this->horaFinal','$this->codigo','$this->estado','$this->foto')");
       $consulta->execute();
    }

    public static function ObtenerTodosLosPedidos()
    {
		$retorno=array();
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id,codigoMesa,idUsuario,idProducto,idCliente,cantidad,horaInicio,horaFinal,codigo,estado,foto FROM pedido");

		if($consulta->execute())
		{
			$retorno = $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
		}

        return $retorno;
    }

    public static function ObtenerPedido($codigo)
    {
		$retorno=false;

        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT codigoMesa,idUsuario,idProducto,idCliente,cantidad,horaInicio,horaFinal,codigo,estado,foto FROM pedido WHERE codigo = :codigo");
        $consulta->bindValue(':codigo', $codigo, PDO::PARAM_STR);
        
		if($consulta->execute())
		{
			$retorno = $consulta->fetchObject('Pedido');
		}

        return $retorno;
    }
}

?>