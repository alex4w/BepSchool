<?php
/**
 * Obtiene todas las metas de la base de datos
 */

require 'School.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

	$id = $_GET['id'];
	
    // Manejar petición GET
    $perfil = Meta::getAsignaturasById($id);
	
	

    if ($perfil) {
		$datos["estado"] = 1;
		$datos["asignaturas"] = $perfil;
		

        print json_encode($datos);


    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

