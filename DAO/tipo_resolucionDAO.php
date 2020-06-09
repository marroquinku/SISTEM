<?php
//CREACIÓN DE LA CLASE TIPO_RESOLUCIONDAO
class Tipo_resolucionDAO
{
	//SE CREA LA VARIABLE QUE HACE REFERENCIA A LA CONEXION A LA BASE DE DATOS
	private $pdo;

    //SE CREA LA FUNCION PARA OBTENER LA CONEXION
	public function __construct()
	{
		$dba = new DBAccess();
		$this->pdo = $dba->get_connection();
	}

    //SE CREA LA FUNCION PARA LISTAR LOS TIPOS DE RESOLUCIONES QUE EXISTEN EN LA BASE DE DATOS
	public function Listar()
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_listar_tipo_resoluciones()");
			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Tipo_resolucion();

				$per->__SET('id_tipo_resolucion', $r->id_tipo_resolucion);
				$per->__SET('tipo_resolucion', $r->tipo_resolucion);

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
