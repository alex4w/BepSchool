<?php
/**
 * Obtiene todas las metas de la base de datos
 */

require 'School.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

	$id = $_GET['id'];
	
    // Manejar petici�n GET
    $perfil = Meta::getPerfilById($id);
	
	

    if ($perfil) {
		$imagen = Meta::getFotoById($id);
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

