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
		//EN DESARROLLO
	  }
	}
}

?>