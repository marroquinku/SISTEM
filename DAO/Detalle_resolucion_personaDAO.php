<?php
//CREACIÓN DE LA CLASE DETALLE_RESOLUCION_PERSONADAO
class Detalle_resolucion_personaDAO
{
	//SE CREA LA VARIABLE QUE HACE REFERENCIA A LA CONEXION A LA BASE DE DATOS
	private $pdo;

    //SE CREA LA FUNCION PARA OBTENER LA CONEXION
	public function __construct()
	{
		$dba = new DBAccess();
		$this->pdo = $dba->get_connection();
	}

    //SE CREA LA FUNCION PARA EL REGISTRO DE RESOLUCIONES A UNA PERSONA EN LA BASE DE DATOS
	public function Registrar(Detalle_resolucion_persona $detalleresolucionpersona)
	{
		try
		{
			$statement = $this->pdo->prepare("CALL up_registrar_persona_resolucion_rp(?,?)");

			$tempIdPersona = $detalleresolucionpersona->__GET('id_persona')->__GET('id_persona');
			$tempIdResolucion = $detalleresolucionpersona->__GET('id_resolucion')->__GET('id_resolucion');
			$statement->bindParam(1, $tempIdPersona);
			$statement->bindParam(2, $tempIdResolucion);
			$statement->execute();

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

	//SE CREA LA FUNCION PARA LISTAR LAS RESOLUCIONES QUE EXISTEN EN UNA PERSONA EN LA BASE DE DATOS
	public function Listar()
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_listar_detalleresolucionpersona()");//////////////////////
			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Detalle_resolucion_persona();

				$per->__SET('idDetalleResP', $r->idDetalleResP);
				$per->__GET('idPersona')->__SET('idPersona', $r->idPersona);
				$per->__GET('idResoluciones')->__SET('idResoluciones', $r->idResoluciones);

				$result[] = $per;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

    //SE CREA LA FUNCION PARA BUSCAR LAS RESOLUCIONES QUE EXISTEN EN UNA PERSONA EN LA BASE DE DATOS
	public function Buscar(Detalle_resolucion_persona $detalleresolucionpersona)
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_listar_detalleresolucionpersona()");//////////////////////
			$tempIdDetalleResP = $detalleresolucionpersona->__GET('idDetalleResP');
			$statement->bindParam(1,$tempIdDetalleResP);
			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Detalle_resolucion_persona();

				$per->__SET('idDetalleResP', $r->idDetalleResP);
				$per->__GET('idPersona')->__SET('idPersona', $r->idPersona);
				$per->__GET('idResoluciones')->__SET('idResoluciones', $r->idResoluciones);

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