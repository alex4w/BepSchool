<?php

/**
 * Representa el la estructura de las metas
 * almacenadas en la base de datos
 */
require 'Database.php';

class Meta
{
    function __construct()
    {
    }

    /**
     * Retorna en la fila especificada de la tabla 'meta'
     *
     * @param $idMeta Identificador del registro
     * @return array Datos del registro
     */
    public static function getAsignaturas()
    {
        $consulta = "SELECT 	id, 
					id_Especialidad, 
					id_Nivel, 
					nombre, 
					id_Paralelo 
					FROM 
					beptechn_school.asignaturas ";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();

            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return false;
        }
    }

	
	public static function getUserByCorreo($Correo)
    {
        // Consulta de la meta
         $consulta = "SELECT 	u.id, 
					u.name, 
					u.email, 
					u.gender, 
					u.direccion, 
					u.celular, 
					u.id_Estado, 
					u.id_UnidadEducativa, 
					u.remember_token, 
					u.username, 
					u.cedula, 
					u.representante, 
					u.Url_Foto, 
					u.imagen, 
					u.ruta_imagen, 
					e.nombre AS unidadEducativa,
					ru.id_Roles,
					r.`nombre` AS rol	 
					FROM 
					users u,unidadeseducativas e,`rolusers` ru,`roles` r 
					WHERE u.id_UnidadEducativa=e.id 
					AND u.id=ru.`id_User` 
					AND ru.`id_Roles`=r.`id` 
					AND (u.email=? or u.username=?)
					AND (ru.id_Roles=2 or ru.id_Roles=3)";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($Correo,$Correo));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;

        } catch (PDOException $e) {
            // Aqu� puedes clasificar el error dependiendo de la excepci�n
            // para presentarlo en la respuesta Json
            return false;
        }
    }
	
	public static function getPerfilById($Id)
    {
        // Consulta de la meta
        $consulta = "SELECT 	u.id, 
					u.name, 
					u.email, 
					u.gender, 
					u.direccion, 
					u.celular, 
					u.id_Estado, 
					u.id_UnidadEducativa, 
					u.remember_token, 
					u.username, 
					u.cedula, 
					u.representante, 
					u.Url_Foto, 
					u.imagen, 
					u.ruta_imagen, 
					e.nombre AS unidadEducativa,
					ru.id_Roles,
					r.`nombre` AS rol				
					FROM 
					users u,unidadeseducativas e,`rolusers` ru,`roles` r 
					WHERE u.id_UnidadEducativa=e.id 
					AND u.id=ru.`id_User` 
					AND ru.`id_Roles`=r.`id` 
					AND u.id=? 
					AND (ru.id_Roles=2 or ru.id_Roles=3)";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($Id));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;

        } catch (PDOException $e) {
            // Aqu� puedes clasificar el error dependiendo de la excepci�n
            // para presentarlo en la respuesta Json
            return false;
        }
    }
	
	public static function getAsignaturasById($Id)
    {
        // Consulta de la meta
        $consulta = "SELECT 	a.id, 
							a.nombre, 
							p.nombre AS paralelo,
							n.nombre AS nivel,
							e.nombre AS especialidad,
							ue.nombre AS unidadEducativa,
							u.`name`,
							u.`username`,
							u.`cedula`,
							pa.nombre AS periodoAcademico 
							FROM 
							asignaturas a,`paralelos` p,`niveles` n,`registroasignaturaestudiantes` re,
							`users` u,`periodosacademicos` pa ,`especialidades` e,`unidadeseducativas` ue 
							WHERE a.id_Paralelo=p.id 
							AND p.id_nivel=n.id 
							AND re.`id_Paralelo`=p.id 
							AND re.`id_Estudiante`=u.id 
							AND re.`id_Periodo`=pa.id 
							AND pa.id_Estado=1 
							AND u.id_Estado=1 
							AND a.id_Especialidad= e.id 
							AND u.id_unidadEducativa= ue.id 
							AND u.id=? 
							ORDER BY a.nombre ";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($Id));
            // Capturar primera fila del resultado
            $row = $comando->fetchAll(PDO::FETCH_ASSOC);
			
            return $row;

        } catch (PDOException $e) {
            // Aqu� puedes clasificar el error dependiendo de la excepci�n
            // para presentarlo en la respuesta Json
            return false;
        }
    }
	
	public static function getProfesoresAsignaturasById($Id)
    {
        // Consulta de la meta
        $consulta = "SELECT DISTINCT	a.id, 
							a.nombre, 
							u.name AS Profesor,
							u.username,
							u.cedula 	
							FROM 
							asignaturas a,registroasignaturadocentes rd,users u 
							WHERE rd.id_Docente=u.id 
							AND rd.id_Asignatura=a.id 
							AND a.id_Paralelo=(SELECT id_Paralelo FROM `registroasignaturaestudiantes` WHERE id_Estudiante=3) 
							AND rd.`id_Periodo`=(SELECT id FROM `periodosacademicos` WHERE id_Estado=1)
							ORDER BY a.nombre ";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($Id));
            // Capturar primera fila del resultado
            $row = $comando->fetchAll(PDO::FETCH_ASSOC);
			
            return $row;

        } catch (PDOException $e) {
            // Aqu� puedes clasificar el error dependiendo de la excepci�n
            // para presentarlo en la respuesta Json
            return false;
        }
    }
	
	public static function getFotoById($Id)
    {
        // Consulta de la meta
        $consulta = "SELECT perfil_logins.imagen
			FROM perfil_logins 
			where perfil_logins.Id = ? or Id_Perfil=?";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($Id,$Id));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
			$result=base64_encode($row['imagen']);
            return $result;

        } catch (PDOException $e) {
            // Aqu� puedes clasificar el error dependiendo de la excepci�n
            // para presentarlo en la respuesta Json
            return false;
        }
    }
	
	public static function getFotoByCorreo($Correo)
    {
        // Consulta de la meta
        $consulta = "SELECT perfil_logins.imagen
			FROM perfil_logins 
			where perfil_logins.Correo = ?";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($Correo));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
			$result=base64_encode($row['imagen']);
            return $result;

        } catch (PDOException $e) {
            // Aqu� puedes clasificar el error dependiendo de la excepci�n
            // para presentarlo en la respuesta Json
            return false;
        }
    }
	
	public static function insert(
        $Nombres,
        $Correo,
        $Clave,
        $bytesArchivo,
        $url
    )
    {
		//persona generada
		 $comando = "INSERT INTO personas ( " .
            "nombres," .
            " correo," .
            " created_at)" .
            " VALUES(?,?,now())";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
		$sentencia->execute(
            array(
                $Nombres,
                $Correo
            )
        );
		$id_persona= Database::getInstance()->getDb()->lastInsertId();
		
		//perfil
	
            $comando = "INSERT INTO perfil_logins ( " .
            "nombres," .
            " correo," .
            " password," .
            " imagen," .
            " ruta_imagen,id_persona, created_at,provider)" .
            " VALUES(?,?,?,?,?,?,now(),'laravel')";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
		$sentencia->execute(
            array(
                $Nombres,
                $Correo,
                $Clave,
                $bytesArchivo,
				$url,$id_persona
            )
        );
		echo Database::getInstance()->getDb()->lastInsertId().';'.$id_persona.';';
        return $sentencia;

    }
	
	public static function insert_perfil(
		$Nombres,
		$Correo,
		$Id_Perfil,
		$Url_Foto,
		$bytesArchivo,
		$url
    )
    {
		//persona generada
		 $comando = "INSERT INTO personas ( " .
            "nombres," .
            " correo," .
            " created_at)" .
            " VALUES(?,?,now())";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
		$sentencia->execute(
            array(
                $Nombres,
                $Correo
            )
        );
		$id_persona= Database::getInstance()->getDb()->lastInsertId();
		
		//perfil
            $comando = "INSERT INTO perfil_logins ( " .
            "nombres," .
            " correo," .
            " id_perfil," .
			 " url_foto," .
            " imagen," .
            " ruta_imagen,id_persona, created_at)" .
            " VALUES(?,?,?,?,?,?,?,now())";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
		$sentencia->execute(
            array(
                $Nombres,
                $Correo,
                $Id_Perfil,
				$Url_Foto,
                $bytesArchivo,
				$url,
				$id_persona
            )
        );
		echo Database::getInstance()->getDb()->lastInsertId().';'.$id_persona.';';
		
		
		
        return $sentencia;

    }
	
	public static function insert_persona(
        $Nombres,
        $Ci,
        $Telefono,
        $Id_Canton,
		$Id_Perfil
    )
    {
		 $consulta2 = "select Correo from perfil_logins where Id_Persona = ?  ";

       
            // Preparar sentencia
            $comando2 = Database::getInstance()->getDb()->prepare($consulta2);
            // Ejecutar sentencia preparada
            $comando2->execute(array($Id_Perfil));
            // Capturar primera fila del resultado
            $row = $comando2->fetch(PDO::FETCH_ASSOC);
		
			$Correo=$row['Correo'];
		
		
		$id_estado=1;
            $comando =  "UPDATE personas" .
            " SET Ci=?, Telefono=?, Id_Canton=?, Id_Estado=?, Correo=? " .
            "WHERE Id=?";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
		$sentencia->execute(
            array(
				$Ci,
				$Telefono,
				$Id_Canton,
				$id_estado,
				$Correo,
				$Id_Perfil
            )
        );
		$id=Database::getInstance()->getDb()->lastInsertId();
		echo $id.';';
		
        return $sentencia;

    }
	
	
	
	public static function update_clave(
				$Id_Perfil,
				$password
    )
    {
		$comando = "UPDATE perfil_logins" .
            " SET password=? " .
            " WHERE Id=? ";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
		$sentencia->execute(
            array(
				$password,
                $Id_Perfil				
            )
        );
		//echo Database::getInstance()->getDb()->lastInsertId().';';
        return $sentencia;

    }
	
	/**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     *
     */
    public static function update_perfil_foto(
        $Correo,
		$bytesArchivo,
		$url
    )
    {
        // Creando consulta UPDATE
        $consulta = "UPDATE perfil_logins" .
            " SET imagen=?, ruta_imagen=? " .
            "WHERE Correo=?";

        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);

        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($bytesArchivo, $url, $Correo));

        return $cmd;
    }


    /**
     * Eliminar el registro con el identificador especificado
     *
     */
    public static function delete_detalleorden($Id)
    {
        // Sentencia DELETE
        $comando = "DELETE FROM detalleordenes WHERE id=?";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($Id));
    }
}

?>