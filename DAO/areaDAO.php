<?php
//CREACIÓN DE LA CLASE AREADAO
class AreaDAO
{
	//SE CREA LA VARIABLE QUE HACE REFERENCIA A LA CONEXION A LA BASE DE DATOS
	private $pdo;

    //SE CREA LA FUNCION PARA OBTENER LA CONEXION
	public function __construct()
	{
		$dba = new DBAccess();
		$this->pdo = $dba->get_connection();
	}
    
    //SE CREA LA FUNCION PARA EL REGISTRO DE AMBIENTES A LA BASE DE DATOS
	public function Registrar(Ambiente $ambientes)
	{
		try
		{
			$statement = $this->pdo->prepare("CALL PRO_REGISTRAR_AMBIENTE(?,?)");


			$tempIdAmbiente = $ambientes->__GET('id_ambiente');
			$tempNomre = $ambientes->__GET('nombre_ambiente');

			$statement->bindParam(1, $tempIdAmbiente);
			$statement->bindParam(2, $tempNomre);
			$statement -> execute();

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

    //SE CREA LA FUNCION PARA LISTAR LAS AREAS QUE EXISTEN EN LA BASE DE DATOS
	public function Listar()
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_listar_areas()");
			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Area();

				$per->__SET('id_area', $r->id_area);
				$per->__SET('nombre_area', $r->nombre_area);

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
