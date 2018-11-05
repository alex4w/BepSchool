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
					u.password, 
					u.create_time, 
					u.gender, 
					u.direccion, 
					u.celular, 
					u.id_Estado, 
					u.id_UnidadEducativa, 
					u.id_Provider, 
					u.remember_token, 
					u.username, 
					u.representante, 
					u.Url_Foto, 
					u.imagen, 
					u.ruta_imagen, 
					u.provider,
					e.nombre AS unidadEducativa,
					ru.id_Roles,
					r.`nombre` AS rol	 
					FROM 
					users u,unidadeseducativas e,`rolusers` ru,`roles` r 
					WHERE u.id_UnidadEducativa=e.id 
					AND u.id=ru.`id_User` 
					AND ru.`id_Roles`=r.`id` 
					AND u.email=? 
					AND (ru.id_Roles=2 or ru.id_Roles=3)";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($Correo));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
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
					u.password, 
					u.create_time, 
					u.gender, 
					u.direccion, 
					u.celular, 
					u.id_Estado, 
					u.id_UnidadEducativa, 
					u.id_Provider, 
					u.remember_token, 
					u.username, 
					u.representante, 
					u.Url_Foto, 
					u.imagen, 
					u.ruta_imagen, 
					u.provider,
					e.nombre AS unidadEducativa,
					r.`nombre` AS rol,
					ru.id_Roles 					
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
            $comando->execute(array($Id,$Id));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
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
            // Aquí puedes clasificar el error dependiendo de la excepción
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
            // Aquí puedes clasificar el error dependiendo de la excepción
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