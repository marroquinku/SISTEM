<?php
//CREACIÓN DE LA CLASE CONCEPTODAO
class conceptoDAO
{
	//SE CREA LA VARIABLE QUE HACE REFERENCIA A LA CONEXION A LA BASE DE DATOS
	private $pdo;

    //SE CREA LA FUNCION PARA OBTENER LA CONEXION
	public function __construct()
	{
		$dba = new DBAccess();
		$this->pdo = $dba->get_connection();
	}

    //SE CREA LA FUNCION PARA LISTAR LOS CONCEPTOS QUE EXISTEN EN LA BASE DE DATOS
	public function Listar()
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_listar_conceptos()");
			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Concepto();

				$per->__SET('id_concepto', $r->id_concepto);
				$per->__SET('concepto', $r->concepto);
				
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
