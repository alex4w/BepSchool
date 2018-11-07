<?php
/**
 * Obtiene todas las metas de la base de datos
 */

require 'School.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

	$id = $_GET['id'];
	
    // Manejar petición GET
    //
	$asistencia = Meta::getAsistenciaById($id);
	

    if ($asistencia) {
		$datos["estado"] = 1;
		
		$datos["asistencia"] = $asistencia;
		
		
		$conteo = Meta::getNumeroAsistenciaById($id);
		$datos["conteo"] = $conteo;
        print json_encode($datos);


    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

