<?php
//CREACIÓN DE LA CLASE NIVELDAO
class NivelDAO
{
	//SE CREA LA VARIABLE QUE HACE REFERENCIA A LA CONEXION A LA BASE DE DATOS
	private $pdo;

    //SE CREA LA FUNCION PARA OBTENER LA CONEXION
	public function __construct()
	{
		$dba = new DBAccess();
		$this->pdo = $dba->get_connection();
	}

    //SE CREA LA FUNCION PARA EL REGISTRO DE LOS NIVELES A LA BASE DE DATOS
	public function Registrar(Nivel $nivel)
	{
		try
		{
			$statement = $this->pdo->prepare("CALL PRO_REGISTRAR_AMBIENTE(?,?)");


			$tempIdNivel = $nivel->__GET('id_nivel');
			$tempNomre = $nivel->__GET('nombre_nivel');

			$statement->bindParam(1, $tempIdNivel);
			$statement->bindParam(2, $tempNomre);
			$statement->execute();

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

    //SE CREA LA FUNCION PARA LISTAR LOS NIVELES QUE EXISTEN EN LA BASE DE DATOS
	public function listar_niveles()
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_listar_niveles()");
			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Nivel();

				$per->__SET('id_nivel', $r->id_nivel);
				$per->__SET('nombre_nivel', $r->nombre_nivel);

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
