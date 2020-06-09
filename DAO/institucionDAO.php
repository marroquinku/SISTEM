<?php
//CREACIÓN DE LA CLASE INSTITUCIONDAO
class institucionDAO
{
	//SE CREA LA VARIABLE QUE HACE REFERENCIA A LA CONEXION A LA BASE DE DATOS
	private $pdo;

    //SE CREA LA FUNCION PARA OBTENER LA CONEXION
	public function __construct()
	{
		$dba = new DBAccess();
		$this->pdo = $dba->get_connection();
	}

	//SE CREA LA FUNCION PARA EL REGISTRO DE INSTITUCIONES A LA BASE DE DATOS
	public function Registrar_Institucion(Institucion $instituciones)
	{
		$mensajeFinalS = file_get_contents('../msj/mensaje_general_error2.php');
		try
		{
			$statement = $this->pdo->prepare("CALL up_registrar_institucion(?,?,?)");

			$tempCod_modular = $instituciones->__GET('cod_modular');
			$tempNombre = $instituciones->__GET('nombre');
			$tempNivel = $instituciones->__GET('id_nivel')->__GET('id_nivel');

			$statement->bindParam(1,$tempCod_modular);
			$statement->bindParam(2,$tempNombre);
			$statement->bindParam(3,$tempNivel);

			$statement->execute();

		} catch (Exception $e)
		{
			$msj = $e->getMessage();
			$mensajeFinalS = str_replace('{{msj}}', $msj,$mensajeFinalS);
			echo $mensajeFinalS;
			die();
		}
	}

    //SE CREA LA FUNCION PARA LISTAR LAS INSTITUCIONES QUE EXISTEN EN LA BASE DE DATOS
	public function Listar_institucion()
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_listar_instituciones()");
			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$ins = new Institucion();

				$ins->__SET('id_institucion',         $r->id_institucion);
				$ins->__SET('cod_modular',         $r->cod_modular);
				$ins->__SET('nombre',            $r->nombre);
				$ins->__GET('id_nivel')->__SET('nombre_nivel',   $r->nombre_nivel);
				$ins->__GET('id_nivel')->__SET('id_nivel',   $r->id_nivel);

				$result[] = $ins;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}
	
    //SE CREA LA FUNCION PARA BUSCAR LAS INSTITUCIONES QUE EXISTEN EN LA BASE DE DATOS
	public function Buscar_institucion_ajax(Institucion $institucion)
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("CALL up_buscar_institucion_cModular_ajax(?)");
			
			$tempCodModular = $institucion->__GET('cod_modular');

			$statement->bindParam(1,$tempCodModular);
			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$ins = new Institucion();

				$ins->__SET('id_institucion',         $r->id_institucion);
				$ins->__SET('cod_modular',         $r->cod_modular);
				$ins->__SET('nombre',            $r->nombre);
				$ins->__GET('id_nivel')->__SET('nombre_nivel',   $r->nombre_nivel);

				$result[] = $ins;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	//SE CREA LA FUNCION PARA BUSCAR INSTITUCIONES, MEDIANTE EL CODIGO MODULAR, EL NOMBRE Y EL NIVEL QUE CCORRESTPONDE	
	public function Buscar_i_nombres_nivel(Institucion $institucion)
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("CALL up_buscar_institucion_codigo_nombre_nivel(?,?,?)");
			
			$tempCodModular = $institucion->__GET('cod_modular');
			$tempNombre = $institucion->__GET('nombre');
			$tempNivel = $institucion->__GET('id_nivel')->__GET('id_nivel');

			$statement->bindParam(1,$tempCodModular);
			$statement->bindParam(2,$tempNombre);
			$statement->bindParam(3,$tempNivel);


			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$ins = new Institucion();

				$ins->__SET('id_institucion',         $r->id_institucion);
				$ins->__SET('cod_modular',         $r->cod_modular);
				$ins->__SET('nombre',            $r->nombre);
				$ins->__GET('id_nivel')->__SET('nombre_nivel',   $r->nombre_nivel);
				$ins->__GET('id_nivel')->__SET('id_nivel',   $r->id_nivel);

				$result[] = $ins;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

    //SE CREA LA FUNCION PARA BUSCAR LAS INSTITUCIONES QUE EXISTEN POR MEDIO DE SU IDENTIFICADOR
	public function Buscar_i_id(Institucion $instituciones)
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_buscar_instituciones_id(?)");
			$tempIdpersona = $instituciones->__GET('id_institucion');
			$statement->bindParam(1,$tempIdpersona);

			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$ins = new Institucion();

				$ins->__SET('id_institucion',         $r->id_institucion);
				$ins->__SET('cod_modular',         $r->cod_modular);
				$ins->__SET('nombre',            $r->nombre);
				$ins->__GET('id_nivel')->__SET('nombre_nivel',   $r->nombre_nivel);
				$ins->__GET('id_nivel')->__SET('id_nivel',   $r->id_nivel);

				$result[] = $ins;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

    //SE CREA LA FUNCION PARA EDITAR LAS INSTITUCIONES QUE EXISTEN EN LA BASE DE DATO
	public function Actualizar_institucion(Institucion $instituciones)
	{
		$mensajeFinalS = file_get_contents('../msj/mensaje_general_error2.php');
		try
		{
			$statement = $this->pdo->prepare("CALL up_actualizar_instituciones(?,?,?,?)");

			$tempidInstituciones = $instituciones->__GET('id_institucion');
			$tempCodModular = $instituciones->__GET('cod_modular');
			$tempNombre = $instituciones->__GET('nombre');
			$tempNivel = $instituciones->__GET('id_nivel')->__GET('id_nivel');

			$statement->bindParam(1,$tempidInstituciones);
			$statement->bindParam(2,$tempCodModular);
			$statement->bindParam(3,$tempNombre);
			$statement->bindParam(4,$tempNivel);

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