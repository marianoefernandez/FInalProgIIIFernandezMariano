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
			$pedido->GetCodigo() == $alfaNumerico;
			$retorno=true;
		}

		return $retorno;
	}


	function Equals($mesa)
	{
		return $this->GetCodigo() == $mesa->GetCodigo(); 
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

	public static function RetornarListaDeMesasString($listaMesas)
	{
		$len = count($listaMesas);
		$retorno="<h1>La lista está vacia<h1>";

		if($len>0)
		{
			$retorno=("<table>");
			$retorno.=("<th>[Codigo]</th><th>[Estado]</th><th>[Fecha de Creación]</th>");
			foreach($listaMesas as $mesa)
			{
				$retorno.=("<tr align='center'>");
				$retorno.=("<td>[".$mesa->GetCodigo()."]</td>");
				$retorno.=("<td>[".$mesa->GetEstado()."]</td>");
				$retorno.=("<td>[".$mesa->GetFechaDeCreacion()."]</td>");
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
       $consulta = $objetoAccesoDato->prepararConsulta("INSERT into mesa (codigo,estado,fechaDeCreacion)values('$this->codigo','$this->estado','$this->fechaDeCreacion')");
       $consulta->execute();
    }

    public static function ObtenerTodasLasMesas()
    {
		$retorno=array();
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT codigo,estado,fechaDeCreacion FROM mesa");
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
        $consulta = $objAccesoDatos->prepararConsulta("SELECT codigo,estado,fechaDeCreacion FROM mesa WHERE codigo = :codigo");
        $consulta->bindValue(':codigo', $codigo, PDO::PARAM_STR);
        
		if($consulta->execute())
		{
			$retorno = $consulta->fetchObject('Mesa');
	   	}

        return $retorno;
    }
}

?>