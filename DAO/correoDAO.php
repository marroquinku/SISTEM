<?php
//CREACIÓN DE LA CLASE CORREODAO
class CorreoDAO
{
	//SE CREA LA VARIABLE QUE HACE REFERENCIA A LA CONEXION A LA BASE DE DATOS
	private $pdo;

    //SE CREA LA FUNCION PARA OBTENER LA CONEXION
	public function __construct()
	{
		$dba = new DBAccess();
		$this->pdo = $dba->get_connection();
	}

    //SE CREA LA FUNCION PARA EL REGISTRO DE CORREOS ELECTRONICOS A LA BASE DE DATOS
	public function Registrar(Correos $correos)
	{
		try
		{
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$statement = $this->pdo->prepare("CALL PRO_INSERT_CORREOS(?,?)"); ///////////////
			$tempIdPersona = $correos->__GET('idPersona')->__GET('idPersona');
			$tempCorreo = $correos->__GET('Correo');

			$statement->bindParam(1, $tempIdPersona);
			$statement->bindParam(2, $tempCorreo);

			$statement->execute();

		} catch (Exception $e)
		{
				//die($e->getMessage());
			echo $e->getMessage();
		}
	}

    //SE CREA LA FUNCION PARA LISTAR LOS CORREOS ELECTRONICOS QUE EXISTEN EN LA BASE DE DATOS
	public function Listar(Correo $correo)
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_listar_correos_id_persona(?)");

			$tempIdPersona = $correo->__GET('id_persona')->__GET('id_persona');
			$statement->bindParam(1, $tempIdPersona);
			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Correo();

				$per->__SET('id_correo', $r->id_correo);
				$per->__SET('correo', $r->correo);
				$per->__GET('id_persona')->__SET('id_persona', $r->id_persona);

				$result[] = $per;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

    //SE CREA LA FUNCION PARA LA BUSQUEDA DE CORREOS ELECTRONICOS EN LA BASE DE DATOS
	public function Buscar(Correos $correos)
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_buscar_correos(?,?,?,?,?)");///////////////
			$tempIdCorreos = $correos->__GET('idCorreos');
			$statement->bindParam(1,$tempIdCorreos);
			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Correos();

				$per->__SET('idCorreos', $r->idCorreos);
				$per->__GET('idPersona')->__SET('idPersona', $r->idPersona);
				$per->__SET('Correo', $r->Correo);

				$result[] = $per;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

}
?>