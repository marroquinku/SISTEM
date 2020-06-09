<?php
//CREACIÓN DE LA CLASE DETALLE_RESOLUCION_INSTITUCIONDAO
class Detalle_resolucion_institucionDAO
{
	//SE CREA LA VARIABLE QUE HACE REFERENCIA A LA CONEXION A LA BASE DE DATOS
	private $pdo;

    //SE CREA LA FUNCION PARA OBTENER LA CONEXION
	public function __construct()
	{
		$dba = new DBAccess();
		$this->pdo = $dba->get_connection();
	}

    //SE CREA LA FUNCION PARA EL REGISTRO DE RESOLUCIONES A UNA INSTITUCION EN LA BASE DE DATOS
	public function Registrar(Detalle_resolucion_institucion $detalleresolucioninstitucion)
	{
		try
		{
			$statement = $this->pdo->prepare("CALL up_registrar_institucion_resolucion_rp(?,?)");

			$tempIdInstitucion = $detalleresolucioninstitucion->__GET('id_institucion')->__GET('id_institucion');
			$tempIdResolucion = $detalleresolucioninstitucion->__GET('id_resolucion')->__GET('id_resolucion');

			$statement->bindParam(1, $tempIdInstitucion);
			$statement->bindParam(2, $tempIdResolucion);
			$statement->execute();

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

    //SE CREA LA FUNCION PARA LISTAR LAS RESOLUCIONES QUE EXISTEN EN UNA INSTITUCION EN LA BASE DE DATOS
	public function Listar()
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_listar_detalleresolucioninstitucion()");//////////////////////
			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Detalle_resolucion_institucion();

				$per->__SET('idDetalleResI', $r->idDetalleResI);
				$per->__GET('idInstituciones')->__SET('idInstituciones', $r->idInstituciones);
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

    //SE CREA LA FUNCION PARA BUSCAR LAS RESOLUCIONES QUE EXISTEN EN UNA INSTITUCION EN LA BASE DE DATOS
	public function Buscar(Detalle_resolucion_institucion $detalleresolucioninstitucion)
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_buscar_detalleresolucioninstitucion(?,?,?,?,?)");
			
			$tempIdDetalleResI = $detalleresolucioninstitucion->__GET('idDetalleResI');
			$statement->bindParam(1,$tempIdDetalleResI);
			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Detalle_resolucion_institucion();

				$per->__SET('idDetalleResI', $r->idDetalleResI);
				$per->__GET('idInstituciones')->__SET('idInstituciones', $r->idInstituciones);
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