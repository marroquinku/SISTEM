<?php
class EstadoDAO
//CREACIÓN DE LA CLASE ESTADODAO
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
			echo $e->getMessage();
		}
	}

    //SE CREA LA FUNCION PARA LISTAR LOS ESTADOS QUE EXISTEN EN LA BASE DE DATOS
	public function Listar()
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_listar_estados_res()");
			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Estado();

				$per->__SET('id_estado', $r->id_estado);
				$per->__SET('tipo_estado', $r->tipo_estado);

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