<?php
/**
 * Obtiene todas las metas de la base de datos
 */

require 'School.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

	$correo = $_GET['correo'];
	
    // Manejar petición GET
    $perfil = Meta::getUserByCorreo($correo);
	
	

    if ($perfil) {
		$imagen = Meta::getFotoByCorreo($correo);
		$perfil["imagen"] = $imagen;
        $datos["estado"] = 1;
		$datos["perfil"] = $perfil;
		

        print json_encode($datos);


    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}