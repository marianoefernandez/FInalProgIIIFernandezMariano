<?php

/*

Clase Producto

Fernández Mariano

*/

require_once "./db/AccesoDatos.php";


class Producto
{
	//ATRIBUTOS
	public $id;
	public $nombre;
	public $tipo;//Bebida, comida, etc
	public $rol;//A que rol pertence por ejemplo mozo/bartender/etc
    public $fechaDeCreacion;
	public $precio;

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

	
	public function GetPrecio()
	{
		$retorno=0;

		if(!(is_null($this->precio)))
		{
			$retorno=$this->precio;
		}

		return $retorno;
	}

    public function GetFechaCreacion()
    {
        $retorno="1/1/1970";

        if(!(is_null($this->fechaDeCreacion)))
		{
			$retorno=$this->fechaDeCreacion;
		}

		return $retorno;
    }

    //SETTERS

	public function SetNombre($value)
	{
        $this->nombre=$value;
	}
    
	public function SetTipo($value)
	{
        $this->tipo=$value;
	}

	public function SetRol($value)
	{
        $this->rol=$value;
	}

	public function SetFechaDeCreacion($value)
	{
        $this->fechaDeCreacion=$value;
	}

	public function SetPrecio($value)
	{
        $this->precio=$value;
	}

	public function SetID($value)
	{
        $this->id=$value;
	}

	//CONSTRUCTOR
	public static function CrearProducto($nombre,$tipo,$rol,$fechaDeCreacion,$precio)
	{
		$producto = new Producto;

        $tipo = strtolower($tipo);
		$rol = strtolower($rol);

		$producto->SetNombre($nombre);
		$producto->SetTipo($tipo);
		$producto->SetRol($rol);
		$producto->SetFechaDeCreacion($fechaDeCreacion);
		$producto->SetPrecio($precio);

		return $producto;
	}

	//METODOS

	//Retorna -1 si hubo error, 0 si el producto es repetido y 1 si todo ok
	public static function AltaProducto($producto)
	{
		$retorno=-1;
		$lista=Producto::ObtenerTodosLosProductos();

		if(!(is_null($producto->GetNombre()) || is_null($producto->GetTipo()) || is_null($producto->GetRol()) || is_null($producto->GetFechaCreacion()) || is_null($producto->GetPrecio())))
		{
			$retorno=0;
			if(!($producto->EstaEnLista()))
			{
				$retorno=1;
				$producto->AgregarProductoDatabase();
			}
		}

		return $retorno;
	}

	public static function ModificarProducto($producto)
	{
		$retorno=-1;
		$lista=Producto::ObtenerTodosLosProductos();

		if(!(is_null($producto->GetNombre()) || is_null($producto->GetTipo()) || is_null($producto->GetRol()) || is_null($producto->GetFechaCreacion()) || is_null($producto->GetPrecio())))
		{
			$retorno=0;
			if(($producto->EstaEnLista()))
			{
				$retorno=1;
				$producto->ModificarProductoDatabase();
			}
		}

		return $retorno;
	}

	
	public static function ObtenerCantidadVendidosProductoMayor()
	{
		$listaProductos = Producto::ObtenerTodosLosProductos();
		
		$maximo = false;

		foreach ($listaProductos as $producto) 
		{
			$contador = $producto->CantidadDeVentas();

			if($contador > $maximo || $maximo == false)
			{
				$maximo = $contador;
			}
		}

		return $maximo;
	}

	public static function ObtenerCantidadVendidosProductoMenor()
	{
		$listaProductos = Producto::ObtenerTodosLosProductos();
		
		$minimo = false;

		foreach ($listaProductos as $producto) 
		{
			$contador = $producto->CantidadDeVentas();

			if($contador < $minimo || $minimo == false)
			{
				$minimo = $contador;
			}
		}

		return $minimo;
	}

	public static function RetornarProductosPorCantidadDeVentas($cantidad)
	{
		$listaProductos = Producto::ObtenerTodosLosProductos();
		$productos = false;

		if(isset($cantidad) && is_numeric($cantidad))
		{
			$productos = array();
			foreach ($listaProductos as $producto) 
			{
				$contador = $producto->CantidadDeVentas();

				if($contador == $cantidad)
				{
					array_push($productos,$producto);
				}
			}
		}

		return $productos;
	}

	public static function DarDeBajaUnProducto($idProducto)
	{
		$retorno=0;
		$producto = Producto::ObtenerProducto($idProducto);

		if($producto != false)
		{
			$retorno=1;
			$producto->BorrarProductoDatabase();
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

	function Equals($producto)
	{
		return $this->GetNombre() == $producto->GetNombre() && $this->GetTipo() == $producto->GetTipo() && $this->GetRol() == $producto->GetRol(); 
	}

	function EstaEnLista()
	{
		$lista = Producto::ObtenerTodosLosProductos();
		$retorno=0;

		foreach ($lista as $productoAux) 
		{
			if($this->Equals($productoAux))
			{
				$retorno=1;
				break;
			}
		}

		return $retorno;
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

	public static function RetornarListaDeProductosString($listaProductos)
	{
		$len = count($listaProductos);
		$retorno="<h1>No hay productos dados de alta<h1>";


		if($len>0)
		{
			$retorno=("<table>");
			$retorno.=("<th>[Nombre]</th><th>[Tipo]</th><th>[Rol]</th><th>[Precio]</th><th>[Fecha de Creación]</th>");
			foreach($listaProductos as $producto)
			{
				$retorno.=("<tr align='center'>");
				$retorno.=("<td>[".$producto->GetNombre()."]</td>");
				$retorno.=("<td>[".$producto->GetTipo()."]</td>");
				$retorno.=("<td>[".$producto->GetRol()."]</td>");
				$retorno.=("<td>[".$producto->GetPrecio()."]</td>");
				$retorno.=("<td>[".$producto->GetFechaCreacion()."]</td>");
				$retorno.=("</tr>");
			}
			$retorno.=("</table>");
		}

		return $retorno;
    }

	

    //METODOS DATABASE

    public function AgregarProductoDatabase()
    {
       $objetoAccesoDato = AccesoDatos::obtenerInstancia(); 
       $consulta = $objetoAccesoDato->prepararConsulta("INSERT into productos (nombre,tipo,rol,fechaDeCreacion,precio)values('$this->nombre','$this->tipo','$this->rol','$this->fechaDeCreacion','$this->precio')");
       $consulta->execute();
    }

    public function ModificarProductoDatabase()
    {
       $objetoAccesoDato = AccesoDatos::obtenerInstancia(); 

       $consulta = $objetoAccesoDato->prepararConsulta("UPDATE productos SET nombre = '$this->nombre' , tipo = '$this->tipo', rol = '$this->rol', fechaDeCreacion = '$this->fechaDeCreacion', precio = '$this->precio' WHERE id = '$this->id' ");
	   $consulta->execute();
    }

	public function BorrarProductoDatabase()
    {
       $objetoAccesoDato = AccesoDatos::obtenerInstancia(); 
       $consulta = $objetoAccesoDato->prepararConsulta("DELETE FROM productos WHERE id = '$this->id'");
       $consulta->execute();
    }


    public static function ObtenerTodosLosProductos()
    {
		$retorno=array();
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id,nombre,tipo,rol,fechaDeCreacion,precio FROM productos");
        $consulta->execute();

		if($consulta->execute())
		{
			$retorno = $consulta->fetchAll(PDO::FETCH_CLASS, 'Producto');
		}

        return $retorno;
    }

    public static function ObtenerProducto($id)
    {
		$retorno=false;
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id,nombre,tipo,rol,fechaDeCreacion,precio FROM productos WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);
        
		if($consulta->execute())
		{
			$retorno = $consulta->fetchObject('Producto');
		}

        return $retorno;
    }

	public function CantidadDeVentas()
    {
		$retorno=false;
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT SUM(pp.cantidad) FROM pedprod pp INNER JOIN PRODUCTOS p ON p.id = pp.idProducto WHERE p.id = $this->id;");

		if($consulta->execute())
		{
			$retorno = $consulta->fetch(PDO::FETCH_NUM);
			$retorno = $retorno[0];
		}

		if(isset($retorno) == false)
		{
			$retorno = 0;
		}

        return $retorno;
    }

}

?>