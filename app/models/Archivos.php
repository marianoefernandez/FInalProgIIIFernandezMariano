<?php

require_once './pdf/dompdf/autoload.inc.php';
use Dompdf\Dompdf;


function GetExtension($nombreArchivo)
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

function GuardarArchivo($path,$contenido,$modo)
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

function InicializarPDF()
{
    $dompdf = new Dompdf();

    $options = $dompdf->getOptions();
    $options->set(array('isRemoteEnabled' => true));
    //$options->set(array('enable_remote' => true));
    $dompdf->setOptions($options);

    return $dompdf;
}

function DescargarPDF($texto,$nombreArchivo)
{
    $dompdf = InicializarPDF();
    $dompdf->loadHtml($texto);
    $dompdf->setPaper('letter');
    $dompdf->render();
    $dompdf->stream($nombreArchivo, array("Attachment" => false));
}

function GuardarCSV($lista,$nombreArchivo)
{
	$retorno = 0;

	if(!(is_array($lista)))
	{
		$array = array();
		$array[0] = $lista;
		$lista = $array;
	}

	$texto = ObtenerDatosCSV($lista);

	if(strlen($texto) > 0)
	{
		if (!file_exists("CSVDescargados/")) 
		{
			mkdir("CSVDescargados/", 0777, true);
		}

		GuardarArchivo("CSVDescargados/".$nombreArchivo . ".csv",$texto,"w");
		$retorno = 1;
	}

	return $retorno;
}

function ObtenerCabeceraCSV($lista)
{
	$texto = "";

	foreach ($lista as $objeto) 
	{
		$contador = 0;

		foreach ($objeto as $key => $value) 
		{
			$contador++;
			$len = count((array)$objeto);

			if(isset($value))
			{
				$texto .= $key . ",";
			}

			if($len == $contador)
			{
				$texto[strlen($texto)-1] = "\n";
			}
		}
		break;
	}

	return $texto;
}

function ObtenerDatosCSV($lista)
{
	$texto = ObtenerCabeceraCSV($lista);

	if(strlen($texto) > 0)
	{
		foreach ($lista as $objeto) 
		{
			$contador = 0;

			foreach ($objeto as $value) 
			{
				$contador++;
				$len = count((array)$objeto);
				
				if(isset($value))
				{
					$texto .= $value . ",";
				}
	
				if($len == $contador)
				{
					$texto[strlen($texto)-1] = "\n";
				}
			}
		}
	}

	return $texto;
}

function LeerCSV()
{
	$contador = 0;
	$lista = false;
	$archivo=fopen($_FILES["csv"]["tmp_name"], "r");


	if(isset($archivo))
	{
		$lista = array();
		$keys = ObtenerKeysCsv($archivo);
		
		while(feof($archivo) == 0)
		{
			$objeto = CrearObjetoGenericoCSV($archivo,$keys);
			if($objeto != false)
			{
				array_push($lista,$objeto);
			}
		}

		$retorno=1;
	}

	fclose($archivo);

	return $lista;
}

function CrearObjetoGenericoCSV($archivo,$keys)
{
	$texto = "";
	$contador = 0;
	$objeto = false;

	if(fscanf($archivo,"%[^\n]\n,",$texto))
	{
		$textoAux = "";
		$arrayObjeto = array();
		$len = strlen($texto);
		for($i=0;$i<$len;$i++)
		{
			if($texto[$i] == ',')
			{
				$arrayObjeto[$keys[$contador]] = $textoAux;
				$contador++;
				$textoAux = "";
			}
			else
			{
				$textoAux .= $texto[$i];
				if($i==$len-1)
				{
					$arrayObjeto[$keys[$contador]] = $textoAux;
					$textoAux = "";
				}
			}
		}
		$objeto = (object)$arrayObjeto;
	}

	return $objeto;
}

function ObtenerKeysCsv($archivo)
{
	$texto = "";
	$textoAux ="";
	fscanf($archivo,"%[^\n]\n,",$texto);
	$len = strlen($texto);
	$keys = array();
	$contador = 0;

	for($i=0;$i<$len;$i++)
	{
		if($texto[$i] == ',')
		{
			$keys[$contador] = $textoAux;
			$contador++;
			$textoAux = "";
		}
		else
		{
			$textoAux .= $texto[$i];
			if($i==$len-1)
			{
				$keys[$contador] = $textoAux;
				$textoAux = "";
			}
		}
	}

	return $keys;
}


function GestionarArchivos($parametro,$payload,$lista,$nombreArchivo)
{	
	if($parametro == "pdf")
	{
	  $logoEmpresa = "<img src='https://1000marcas.net/wp-content/uploads/2019/11/McDonalds-logo.jpg' width='128'alt='Logo'>";
	  $impresion = $logoEmpresa . $payload;

	  DescargarPDF($impresion,$nombreArchivo . ".pdf");
	}
	else
	{
	  if($parametro == "csv")
	  {
		GuardarCSV($lista,$nombreArchivo) ? 
		printf("Archivo guardado con éxito") :
		printf("No sé pudo generar el CSV");
	  }
	}
}

?>