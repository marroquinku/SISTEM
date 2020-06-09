<?php
//CREACIÓN DE LA CLASE TELEFONODAO
class TelefonoDAO
{
	//SE CREA LA VARIABLE QUE HACE REFERENCIA A LA CONEXION A LA BASE DE DATOS
	private $pdo;

    //SE CREA LA FUNCION PARA OBTENER LA CONEXION
	public function __construct()
	{
		$dba = new DBAccess();
		$this->pdo = $dba->get_connection();
	}

    //SE CREA LA FUNCION PARA EL REGISTRO DE TELEFONOS A LA BASE DE DATOS
	public function Registrar(Telefonos $telefonos)
	{

		try
		{
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$statement = $this->pdo->prepare("CALL PRO_INSERT_TELEFONOS(?,?)");
			$tempIdPersona = $telefonos->__GET('idPersona')->__GET('idPersona');
			$tempNumero = $telefonos->__GET('Numero');

			$statement->bindParam(1, $tempIdPersona);
			$statement->bindParam(2, $tempNumero);

			$statement->execute();

		} catch (Exception $e)
		{
				//die($e->getMessage());
			echo $e->getMessage();
		}
	}

    //SE CREA LA FUNCION PARA LISTAR LOS TELEFONOS QUE EXISTEN EN LA BASE DE DATOS
	public function Listar(Telefono $telefono)
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_listar_telefono_id_persona(?)");

			$tempIdPersona = $telefono->__GET('id_persona')->__GET('id_persona');
			$statement->bindParam(1, $tempIdPersona);

			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Telefono();

				$per->__SET('id_telefono', $r->id_telefono);
				$per->__SET('numero', $r->numero);
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

}
?>