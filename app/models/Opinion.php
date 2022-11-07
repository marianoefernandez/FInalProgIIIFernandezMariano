<?php

/*

Clase Mesa

Fernández Mariano

*/
require_once "./db/AccesoDatos.php";
require_once "Mesa.php";
require_once "Pedido.php";


class Opinion
{
	//ATRIBUTOS

	public $id;
	public $codigoMesa;
	public $codigoPedido;
    public $notaMesa;
	public $notaRestaurante;
    public $notaCocinero;
    public $notaMozo;
    public $comentario;


	//GETTERS

	public function GetID()
	{
		$retorno=0;

		if(isset($this->id))
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

    public function GetCodigoPedido()
	{
		$retorno=0;

		if(!(is_null($this->codigoPedido)))
		{
			$retorno=$this->codigoPedido;
		}

		return $retorno;
	}

    public function GetNotaMesa()
	{
		$retorno=0;

		if(!(is_null($this->notaMesa)))
		{
			$retorno=$this->notaMesa;
		}

		return $retorno;
	}

    public function GetNotaRestaurante()
	{
		$retorno=0;

		if(!(is_null($this->notaRestaurante)))
		{
			$retorno=$this->notaRestaurante;
		}

		return $retorno;
	}

    public function GetNotaMozo()
	{
		$retorno=0;

		if(!(is_null($this->notaMozo)))
		{
			$retorno=$this->notaMozo;
		}

		return $retorno;
	}

    public function GetNotaCocinero()
	{
		$retorno=0;

		if(!(is_null($this->notaCocinero)))
		{
			$retorno=$this->notaCocinero;
		}

		return $retorno;
	}

    public function GetComentario()
	{
		$retorno="";

		if(!(is_null($this->comentario)))
		{
			$retorno=$this->comentario;
		}

		return $retorno;
	}

    //SETTERS

	public function SetID($value)
	{
        $this->id=$value;
	}

    public function SetCodigoMesa($value)
	{
        $this->codigoMesa=$value;
	}

    public function SetCodigoPedido($value)
	{
        $this->codigoPedido=$value;
	}

    public function SetNotaMesa($value)
	{
        $this->notaMesa=$value;
	}

    public function SetNotaRestaurante($value)
	{
        $this->notaRestaurante=$value;
	}

    public function SetNotaMozo($value)
	{
        $this->notaMozo=$value;
	}

    public function SetNotaCocinero($value)
	{
        $this->notaCocinero=$value;
	}

    public function SetComentario($value)
	{
        $this->comentario=$value;
	}

	//CONSTRUCTOR

    
    function __construct()
	{

	}
    
	public static function ConstruirOpinion($id,$codigoMesa,$codigoPedido,$notaCocinero,$notaMesa,$notaMozo,$notaRestaurante,$comentario)
	{
        $opinion = new Opinion();

        $opinion->SetID($id);
        $opinion->SetCodigoMesa($codigoMesa);
        $opinion->SetCodigoPedido($codigoPedido);
        $opinion->SetNotaCocinero($notaCocinero);
        $opinion->SetNotaMesa($notaMesa);
        $opinion->SetNotaMozo($notaMozo);
        $opinion->SetNotaRestaurante($notaRestaurante);
        $opinion->SetComentario($comentario);

        return $opinion;
	}

	//METODOS

	public static function AltaOpinion($listaOpiniones,$opinion)
	{
		$retorno=-4;

		if(!(is_null($opinion->GetID()) || is_null($opinion->GetCodigoMesa()) 
        || is_null($opinion->GetCodigoPedido()) || is_null($opinion->GetNotaCocinero())
        || is_null($opinion->GetNotaMesa()) || is_null($opinion->GetNotaMozo())
        || is_null($opinion->GetNotaRestaurante()) || is_null($opinion->GetComentario())
        ))
		{
            $mesa = Mesa::ObtenerMesa($opinion->GetCodigoMesa());
            $pedido = Pedido::ObtenerPedido($opinion->GetCodigoPedido());

            $retorno = -3;

            if($mesa != false)
            {
                $retorno = -2;

                if($pedido != false)
                {
                    $retorno = -1;
                    if($pedido->GetEstado() == TERMINADO)
                    {
                        $retorno = 0;
                        if(Opinion::VerificarOpiniones($listaOpiniones,$opinion))
                        {
                            $opinion->AgregarOpinionDatabase();
                            $retorno = 1;
                        }
                    }
                }
            }
		}

		return $retorno;
	}

    public static function ValidarParametros($notaCocinero,$notaMesa,$notaMozo,$notaRestaurante,$comentario)
    {
        $retorno = false;

        if  
        (
            Opinion::ValidarNota($notaCocinero) && Opinion::ValidarNota($notaMesa) 
            && Opinion::ValidarNota($notaMozo) && Opinion::ValidarNota($notaRestaurante)
            && strlen($comentario) < 67
        )
        {
            $retorno = true;
        }

        return $retorno;
    }

    public static function ValidarNota($nota)
    {
        return $nota > 10 || $nota < 1 ? false : true; 
    }

    public static function VerificarOpiniones($listaOpiniones,$opinion)
    {
        $retorno = 1;

        foreach ($listaOpiniones as $opinionABuscar) 
        {
            if($opinionABuscar->GetCodigoPedido() == $opinion->GetCodigoPedido())
            {
                $retorno = 0;
                break;
            }
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

    public function AgregarOpinionDatabase()
    {
       $objetoAccesoDato = AccesoDatos::obtenerInstancia(); 
       $consulta = $objetoAccesoDato->prepararConsulta("INSERT into calificaciones (codigoMesa,codigoPedido,notaMesa,notaRestaurante,notaMozo,notaCocinero,comentario)values('$this->codigoMesa','$this->codigoPedido','$this->notaMesa','$this->notaRestaurante','$this->notaMozo','$this->notaCocinero','$this->comentario')");
       $consulta->execute();
    }

    public static function ObtenerTodasLasOpiniones()
    {
		$retorno=array();
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id,codigoMesa,codigoPedido,notaMesa,notaRestaurante,notaMozo,notaCocinero,comentario FROM calificaciones;");
       	if($consulta->execute())
		{
			$retorno = $consulta->fetchAll(PDO::FETCH_CLASS, 'Opinion');
	   	}
        return $retorno;
    }

    public static function ObtenerOpinion($id)
    {
		$retorno=false;
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, codigoMesa,codigoPedido,notaMesa,notaRestaurante,notaMozo,notaCocinero,comentario FROM calificaciones WHERE id = $id;");
        
		if($consulta->execute())
		{
			$retorno = $consulta->fetchObject('Opinion');
	   	}

        return $retorno;
    }

	public static function ObtenerMejoresOPeoresComentariosPorMesa($codigoMesa,$filtro)
	{
		$retorno=array();
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, codigoMesa,codigoPedido,notaMesa,notaRestaurante,notaMozo,notaCocinero,comentario FROM calificaciones WHERE codigoMesa = '$codigoMesa' AND notaMesa = (SELECT $filtro(notaMesa) FROM calificaciones);");
       	if($consulta->execute())
		{
			$retorno = $consulta->fetchAll(PDO::FETCH_CLASS, 'Opinion');
	   	}
        return $retorno;
	}	

	public static function ObtenerMejoresOPeoresComentarios($filtroUno,$filtroDos)
	{
		$retorno=array();
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT codigoMesa,codigoPedido,notaMesa,notaRestaurante,notaMozo,notaCocinero,comentario FROM calificaciones WHERE $filtroUno = (SELECT $filtroDos($filtroUno) FROM calificaciones);");
       	if($consulta->execute())
		{
			$retorno = $consulta->fetchAll(PDO::FETCH_OBJ);
	   	}
        return $retorno;
	}	
}

?>