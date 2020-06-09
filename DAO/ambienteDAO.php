<?php
//CREACIÓN DE LA CLASE AMBIENTEDAO
class ambienteDAO
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
			$statement->execute();

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	
	//SE CREA LA FUNCION PARA LISTAR LOS AMBIENTES QUE EXISTEN EN LA BASE DE DATOS
	public function Listar()
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_listar_ambientes()");
			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Ambiente();

				$per->__SET('id_ambiente', $r->id_ambiente);
				$per->__SET('nombre_ambiente', $r->nombre_ambiente);

				$result[] = $per;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	//SE CREA LA FUNCION PARA REGISTRAR EL AMBIENTE Y EN QUE ROL PERTENECE
	public function Reg_ambiente_rol(Ambiente $ambientes)
	{
		try
		{
			$statement = $this->pdo->prepare("call up_registrar_rolambientes (?,?,?)");
			$tempid_tipo_rol = $ambientes->__GET('id_tipo_rol')->__GET('id_tipo_rol');
			$tempid_Area = $ambientes->__GET('id_area')->__GET('id_area');
			$tempNomre = $ambientes->__GET('nombre_ambiente');

			$statement->bindParam(1, $tempid_tipo_rol);
			$statement->bindParam(2, $tempid_Area);
			$statement->bindParam(3, $tempNomre);
			$statement->execute();

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

    //SE CREA LA FUNCION PARA BUSCAR LOS AMBIENTES QUE EXISTEN EN LA BASE DE DATOS
	public function Buscar_ambientes(Ambiente $ambientes)
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_buscar_ambientes(?,?)");
			
			$tempid_tipo_rol = $ambientes->__GET('id_tipo_rol')->__GET('id_tipo_rol');
			$tempNombre_Ambiente = $ambientes->__GET('nombre_ambiente');

			$statement->bindParam(1,$tempNombre_Ambiente);
			$statement->bindParam(2,$tempid_tipo_rol);

			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Ambiente();

				$per->__SET('id_ambiente',         $r->id_ambiente);
				$per->__SET('nombre_ambiente',     $r->nombre_ambiente);
				$per->__SET('id_tipo_rol',         $r->id_tipo_rol);

				$result[] = $per;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	//SE CREA LA FUNCION PARA EDITAR LOS AMBIENTES QUE EXISTEN
	public function Modificar_amb(Ambiente $ambientes)
	{
		$mensajeFinalS = file_get_contents('../msj/mensaje_general_error2.php');
		try
		{
			$statement = $this->pdo->prepare("CALL up_modificar_ambientes(?,?,?,?)");

			$tempid_ambiente = $ambientes->__GET('id_ambiente');
			$tempid_tipo_rol = $ambientes->__GET('id_tipo_rol')->__GET('id_tipo_rol');
			$tempid_Area = $ambientes->__GET('id_area')->__GET('id_area');
			$tempnombre_ambiente = $ambientes->__GET('nombre_ambiente');

			$statement->bindParam(1,$tempid_ambiente);
			$statement->bindParam(2,$tempid_tipo_rol);
			$statement->bindParam(3,$tempid_Area);
			$statement->bindParam(4,$tempnombre_ambiente);

			$statement->execute();

		} catch (Exception $e)
		{
			$msj = $e->getMessage();
			$mensajeFinalS = str_replace('{{msj}}', $msj,$mensajeFinalS);
			echo $mensajeFinalS;
			die();
		}
	}

    //SE CREA LA FUNCION PARA BUSCAR LOS AMBIENTES QUE EXISTEN MEDIENTE SU IDENTIFICADOR
	public function Buscar_amb_id(Ambiente $ambientes)
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_buscar_amb_id(?)");
			$tempid_ambiente = $ambientes->__GET('id_ambiente');
			$statement->bindParam(1,$tempid_ambiente);

			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Ambiente();

				$per->__SET('id_ambiente',         $r->id_ambiente);
				$per->__GET('id_tipo_rol')->__SET('tipo_rol',         $r->tipo_rol);
				$per->__GET('id_tipo_rol')->__SET('id_tipo_rol',         $r->id_tipo_rol);
				$per->__GET('id_area')->__SET('id_area',         $r->id_area);
				$per->__SET('nombre_ambiente',            $r->nombre_ambiente);

				$result[] = $per;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	//SE CREA LA FUNCION PARA FILTRAR LA CANTIDAD DE AMBIENTES QUE EXISTEN
	public function Filtrar_ambiente_rol(Ambiente $ambientes)
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("CALL up_filtrar_ambientes(?,?)");

			$tempnombre_ambiente = $ambientes->__GET('nombre_ambiente');
			$tempid_tipo_rol = $ambientes->__GET('id_tipo_rol')->__GET('id_tipo_rol');

			$statement->bindParam(1, $tempnombre_ambiente);
			$statement->bindParam(2, $tempid_tipo_rol);

			$statement->execute();


			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$amb = new Ambiente();

				$amb->__SET('id_ambiente', $r->id_ambiente);
				$amb->__SET('nombre_ambiente', $r->nombre_ambiente);
				$amb->__SET('tipo_rol', $r->tipo_rol);

				$result[] = $amb;
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
