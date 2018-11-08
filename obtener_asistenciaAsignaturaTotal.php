<?php
/**
 * Obtiene todas las metas de la base de datos
 */

require 'School.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

	$id = $_GET['id'];
	$Id_Asignatura = $_GET['Id_Asignatura'];
	
    // Manejar petición GET
    //
	$asistencia = Meta::getAsistenciaMateriaById($id,$Id_Asignatura);
	

    if ($asistencia) {
		$datos["estado"] = 1;
		
		$datos["asistencia"] = $asistencia;
		
		
		$conteo = Meta::getNumeroAsistenciaById($id,$Id_Asignatura);
		$datos["conteo"] = $conteo;
        print json_encode($datos);


    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

