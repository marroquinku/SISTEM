<?php
//CREACIÓN DE LA CLASE TIPO_ROLDAO
class Tipo_rolDAO
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

    //SE CREA LA FUNCION PARA EL REGISTRO DE ROLES A LA BASE DE DATOS
	public function Registrar_tipo_rol(Tipo_rol $tipo_rol)
	{
		$mensajeFinalS = file_get_contents('../msj/mensaje_general_error2.php');
		try
		{
			$statement = $this->pdo->prepare("CALL up_insert_tipo_rol(?)");

			$tempRol = $tipo_rol->__GET('tipo_rol');

			$statement->bindParam(1,$tempRol);

			$statement->execute();

		} catch (Exception $e)
		{
			$msj = $e->getMessage();
			$msj = preg_replace('/^(.+) ((?:Warning! SQLSTATE[45000]: <>:) .+)$/', '$1', $msj);
			$mensajeFinalS = str_replace('{{msj}}', $msj,$mensajeFinalS);
			echo $mensajeFinalS;
			die();
		}
	}

	//SE CREA LA FUNCION PARA LISTAR LOS ROLES QUE EXISTEN EN LA BASE DE DATOS
	public function Listar_R()
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_listar_rol()");
			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Tipo_rol();

				$per->__SET('id_tipo_rol', $r->id_tipo_rol);
				$per->__SET('tipo_rol', $r->tipo_rol);	
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
