<?php
//CREACIÓN DE LA CLASE RESOLUCIONDAO
class ResolucionDAO
{
	//SE CREA LA VARIABLE QUE HACE REFERENCIA A LA CONEXION A LA BASE DE DATOS
	private $pdo;

    //SE CREA LA FUNCION PARA OBTENER LA CONEXION
	public function __construct()
	{
		$dba = new DBAccess();
		$this->pdo = $dba->get_connection();
	}

    //SE CREA LA FUNCION PARA EL REGISTRO DE RESOLUCIONES A LA BASE DE DATOS
	public function Registrar(Resolucion $resolucion)
	{
		$mensajeFinalS = file_get_contents('../msj/mensaje_general_error2.php');
		try
		{
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$statement = $this->pdo->prepare("CALL up_registrar_resolucion(?,?,?,?,?,?,?,?,?)");

			$tempTipoResolucion = $resolucion->__GET('id_tipo_resolucion')->__GET('id_tipo_resolucion');
			$tempConceptoResolucion = $resolucion->__GET('id_concepto')->__GET('id_concepto');
			$tempEstado = $resolucion->__GET('id_estado');
			$tempProyecto = $resolucion->__GET('proyecto');
			$tempIdUsuariosAmbientes = $resolucion->__GET('id_usuario_ambiente');
			$tempNumero = $resolucion->__GET('numero');
			$tempFechaEmision = $resolucion->__GET('fecha_emision');
			$tempAnio = $resolucion->__GET('anio');
			//$tempArchivo = file_get_contents($resolucion->__GET('Archivo'));
			$tempArchivo = fopen($resolucion->__GET('archivo'), 'rb');
			
			$statement->bindParam(1, $tempTipoResolucion);
			$statement->bindParam(2, $tempEstado);
			$statement->bindParam(3, $tempIdUsuariosAmbientes);
			$statement->bindParam(4, $tempConceptoResolucion);
			$statement->bindParam(5, $tempProyecto);
			$statement->bindParam(6, $tempNumero);
			$statement->bindParam(7, $tempAnio);
			$statement->bindParam(8, $tempFechaEmision);
			$statement->bindParam(9, $tempArchivo, PDO::PARAM_LOB);

			$statement->execute();

		} catch (Exception $e)
		{
			$msj = $e->getMessage();
			$mensajeFinalS = str_replace('{{msj}}', $msj,$mensajeFinalS);
			echo $mensajeFinalS;
			die();
		}
	}

    //SE CREA LA FUNCION PARA LISTAR LAS RESOLUCIONES QUE EXISTEN EN LA BASE DE DATOS
	public function Listar()
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_listar_resoluciones()");
			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Resolucion();

				$per->__SET('id_resolucion', $r->id_resolucion);
				$per->__SET('numero', $r->numero);
				$per->__SET('anio', $r->anio);

				$result[] = $per;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

    //SE CREA LA FUNCION PARA BUSCAR LAS RESOLUCIONES QUE EXISTEN POR AÑO, TIPO Y NUMERO
	public function Listar_Resolucion(Resolucion $resolucion)
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("CALL up_buscar_resolucion_anio_tipo_numero(?,?,?)");

			$tempTipoResolucion = $resolucion->__GET('id_tipo_resolucion')->__GET('id_tipo_resolucion');
			$tempNumero = $resolucion->__GET('numero');
			$tempAnio = $resolucion->__GET('anio');

			$statement->bindParam(1, $tempTipoResolucion);
			$statement->bindParam(2, $tempNumero);
			$statement->bindParam(3, $tempAnio);

			$statement->execute();


			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$res = new Resolucion();

				$res->__SET('id_resolucion', $r->id_resolucion);
				$res->__SET('tipo_resolucion', $r->tipo_resolucion);
				$res->__SET('tipo_estado', $r->tipo_estado);
				$res->__SET('usuario', $r->usuario);
				$res->__SET('proyecto', $r->proyecto);
				$res->__SET('concepto', $r->concepto);
				$res->__SET('numero', $r->numero);
				$res->__SET('fecha_emision', $r->fecha_emision);
				$res->__SET('anio', $r->anio);

				$result[] = $res;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}	

    //SE CREA LA FUNCION PARA BUSCAR LAS RESOLUCIONES QUE EXISTEN MEDIANTE SU IDENTIFICADOR
	public function Listar_Resolucion_Id(Resolucion $resolucion)
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("CALL up_buscar_resolucion_id(?)");

			$tempIdResolucion = $resolucion->__GET('id_resolucion');

			$statement->bindParam(1, $tempIdResolucion);

			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$res = new Resolucion();

				$res->__SET('id_resolucion', $r->id_resolucion);
				$res->__GET('id_tipo_resolucion')->__SET('id_tipo_resolucion', $r->id_tipo_resolucion);
				$res->__GET('id_estado')->__SET('id_estado', $r->id_estado);
				$res->__SET('id_usuario_ambiente', $r->id_usuario_ambiente);
				$res->__SET('proyecto', $r->proyecto);
				$res->__GET('id_concepto')->__SET('id_concepto', $r->id_concepto);
				$res->__SET('numero', $r->numero);
				$res->__SET('anio', $r->anio);
				$res->__SET('archivo', $r->archivo);
				$res->__SET('fecha_emision', $r->fecha_emision);
				
				$result[] = $res;
			}

				//$res->__GET('tipo_resolucion')->__GET('tipo_resolucion');
				//$res->__GET('tipo_estado')->__GET('tipo_estado');
			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

    //SE CREA LA FUNCION PARA LISTAR LAS RESOLUCIONES PEDIENTES QUE EXISTEN EN LA BASE DE DATOS
	public function Listar_Resolucion_pendiente()
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("CALL up_listar_resoluciones_pendientes()");
			$statement->execute();


			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$res = new Resolucion();

				$res->__SET('id_resolucion', $r->id_resolucion);
				$res->__GET('id_tipo_resolucion')->__SET('id_tipo_resolucion', $r->id_tipo_resolucion);
				$res->__GET('id_tipo_resolucion')->__SET('tipo_resolucion', $r->tipo_resolucion);
				$res->__GET('id_estado')->__SET('id_estado', $r->id_estado);
				$res->__SET('id_usuario_ambiente', $r->id_usuario_ambiente);
				$res->__SET('proyecto', $r->proyecto);
				$res->__GET('id_concepto')->__SET('id_concepto', $r->id_concepto);
				$res->__SET('numero', $r->numero);
				$res->__SET('anio', $r->anio);
				$res->__SET('fecha_emision', $r->fecha_emision);
				
				$result[] = $res;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

    //SE CREA LA FUNCION PARA BUSCAR LOS ARCHIVOS A LAS RESOLUCIONES EN LA BASE DE DATOS
	public function Buscar_archivo(Resolucion $resolucion)
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_buscar_archivo_resolucion(?)");
			$tempId = $resolucion->__GET('id_resolucion');
			$statement->bindParam(1, $tempId);
			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Resolucion();

				$per->__SET('archivo', $r->archivo);

				$result[] = $per;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

    //SE CREA LA FUNCION PARA BUSCAR LAS RESOLUCIONES QUE EXISTEN EN LA BASE DE DATOS MEDIANTE AJAX
	public function Buscar_resolucion_ajax(Resolucion $resolucion)
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_validar_resoluciones(?,?,?)");
			
			$tempNumero = $resolucion->__GET('numero');
			$tempTipo = $resolucion->__GET('id_tipo_resolucion')->__GET('id_tipo_resolucion');
			$tempAnio = $resolucion->__GET('anio');
			
			$statement->bindParam(1, $tempTipo);
			$statement->bindParam(2, $tempNumero);
			$statement->bindParam(3, $tempAnio);
			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Resolucion();

				$per->__SET('id_resolucion', $r->id_resolucion);
				$per->__GET('id_tipo_resolucion')->__SET('id_tipo_resolucion', $r->id_tipo_resolucion);
				$per->__SET('id_estado', $r->id_estado);
				$per->__SET('id_usuario_ambiente', $r->id_usuario_ambiente);
				$per->__SET('numero', $r->numero);
				$per->__SET('anio', $r->anio);

				$result[] = $per;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

    //SE CREA LA FUNCION PARA VALIDAR LAS RESOLUCIONES QUE SE ENCUENTRAN
	public function Validar_resolucion_2(Resoluciones $resolucion)
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_validad_resolucion_envio(?,?)");
			
			$tempNumero = $resolucion->__GET('Numero');
			$tempAnio = $resolucion->__GET('Anio');
			
			$statement->bindParam(1, $tempNumero);
			$statement->bindParam(2, $tempAnio);
			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Resoluciones();

				$per->__SET('idResoluciones', $r->idResoluciones);
				$per->__GET('idTipoResolucion')->__SET('idTipoResolucion', $r->idTipoResolucion);
				$per->__SET('idEstados', $r->idEstados);
				$per->__SET('idUsuariosAmbientes', $r->idUsuariosAmbientes);
				$per->__SET('Numero', $r->Numero);
				$per->__SET('Anio', $r->Anio);

				$result[] = $per;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

    //SE CREA LA FUNCION PARA CAMBIAR EL ESTADO EN QUE SE ENCUENTRAN LAS RESOLUCIONES QUE EXISTEN EN LA BASE DE DATOS
	public function cambiar_estado_resolucion(Resolucion $resolucion)
	{
		try
		{
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$statement = $this->pdo->prepare("CALL up_cambiar_estado_resolucion(?,?,?,?)");

			$tempNumero = $resolucion->__GET('numero');
			$tempTipo = $resolucion->__GET('id_tipo_resolucion');
			$tempAnio = $resolucion->__GET('anio');
			$tempEstado = $resolucion->__GET('id_estado')->__GET('id_estado');

			$statement->bindParam(1, $tempNumero);
			$statement->bindParam(2, $tempTipo);
			$statement->bindParam(3, $tempAnio);
			$statement->bindParam(4, $tempEstado);	

			$statement->execute();

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

    //SE CREA LA FUNCION PARA EDITAR LAS RESOLUCIONES QUE EXISTEN EN LA BASE DE DATOS
	public function Actualizar_resolucion(Resolucion $resolucion)
	{
		$mensajeFinalS = file_get_contents('../msj/mensaje_general_error2.php');
		try
		{
			$statement = $this->pdo->prepare("CALL up_actualizar_resoluciones(?,?,?,?,?,?,?,?,?)");

			$tempIdResolucion = $resolucion->__GET('id_resolucion');
			$tempIdTipoResolucion = $resolucion->__GET('id_tipo_resolucion')->__GET('id_tipo_resolucion');
			$tempIdConcepto = $resolucion->__GET('id_concepto')->__GET('id_concepto');
			$tempEstado = $resolucion->__GET('id_estado')->__GET('id_estado');
			$tempProyecto = $resolucion->__GET('proyecto');
			$tempIdUsuariosAmbientes = $resolucion->__GET('id_usuario_ambiente')->__GET('id_usuario_ambiente');
			$tempNumero = $resolucion->__GET('numero');
			$tempAnio = $resolucion->__GET('anio');
			$tempfecha_emision = $resolucion->__GET('fecha_emision');
			//$tempArchivo = fopen($resolucion->__GET('archivo'), 'rb');

			$statement->bindParam(1,$tempIdResolucion);
			$statement->bindParam(2,$tempIdTipoResolucion);
			$statement->bindParam(3,$tempIdConcepto);
			$statement->bindParam(4,$tempEstado);
			$statement->bindParam(5,$tempProyecto);
			$statement->bindParam(6,$tempIdUsuariosAmbientes);
			$statement->bindParam(7,$tempNumero);
			$statement->bindParam(8,$tempAnio);
			$statement->bindParam(9,$tempfecha_emision);
			//$statement->bindParam(8,$tempArchivo);

			$statement->execute();

		} catch (Exception $e)
		{
			$msj = $e->getMessage();
			$mensajeFinalS = str_replace('{{msj}}', $msj,$mensajeFinalS);
			echo $mensajeFinalS;
			die();
		}
	}

}
?>