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
       $consulta = $objetoAccesoDato->prepararConsulta("INSERT into producto (nombre,tipo,rol,fechaDeCreacion,precio)values('$this->nombre','$this->tipo','$this->rol','$this->fechaDeCreacion','$this->precio')");
       $consulta->execute();
    }

    public static function ObtenerTodosLosProductos()
    {
		$retorno=array();
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id,nombre,tipo,rol,fechaDeCreacion,precio FROM producto");
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
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id,nombre,tipo,rol,fechaDeCreacion,precio FROM producto WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);
        
		if($consulta->execute())
		{
			$retorno = $consulta->fetchObject('Producto');
		}

        return $retorno;
    }

}

?>