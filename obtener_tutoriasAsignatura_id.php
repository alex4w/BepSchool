<?php
/**
 * Obtiene todas las metas de la base de datos
 */

require 'School.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

	$id = $_GET['id'];
	$id_Docente= $_GET['id_Docente'];
	
    // Manejar petición GET
    $tutorias = Meta::getTutoriasAsignaturaById($id,$id_Docente);
	
	

    if ($tutorias) {
		$datos["estado"] = 1;
		$datos["tutorias"] = $tutorias;
		

        print json_encode($datos);


    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

