<?php
/**
 * Insertar una nueva meta en la base de datos
 */

require 'School.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Decodificando formato Json

	$Correo = $_POST['Correo'];
	$imagen = $_POST['imagen'];
	$path = "imagenes/$Correo.jpg";

	//$url = "http://$hostname_localhost/ejemploBDRemota/$path";
	$url = "imagenes/".$Correo.".jpg";

	file_put_contents($path,base64_decode($imagen));
	$bytesArchivo=file_get_contents($path);
	
	
    // Insertar
		 $retorno = Meta::update_perfil_foto(
				$Correo,
				$bytesArchivo,
				$url);

    if ($retorno) {
        // Código de éxito
        echo "registra";
    } else {
        // Código de falla
		echo "noRegistra";
    }
}

