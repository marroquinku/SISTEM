<?php
//CREACIÓN DE LA CLASE PERSONADAO
class PersonaDAO
{
	//SE CREA LA VARIABLE QUE HACE REFERENCIA A LA CONEXION A LA BASE DE DATOS
	private $pdo;

    //SE CREA LA FUNCION PARA OBTENER LA CONEXION
	public function __construct()
	{
		$dba = new DBAccess();
		$this->pdo = $dba->get_connection();
	}

    //SE CREA LA FUNCION PARA EL REGISTRO DE PERSONAS A LA BASE DE DATOS
	public function Registrar_per(Persona $persona,Correo $correo, Telefono $telefono)
	{
		$mensajeFinalS = file_get_contents('../msj/mensaje_general_error2.php');
		try
		{
			$statement = $this->pdo->prepare("CALL up_insert_personas(?,?,?,?,?,?,?,?)");

			$tempDoc = $persona->__GET('documento');
			$tempNombre = $persona->__GET('nombre');
			$tempApaterno = $persona->__GET('apellido_paterno');
			$tempAmaterno = $persona->__GET('apellido_materno');
			$tempFnacimiento = $persona->__GET('fecha_nacimiento');
			$tempSexo = $persona->__GET('sexo');

			$tempCorreo = $correo->__GET('correo');
			$tempNumero = $telefono->__GET('numero');

			$statement->bindParam(1,$tempDoc);
			$statement->bindParam(2,$tempNombre);
			$statement->bindParam(3,$tempApaterno);
			$statement->bindParam(4,$tempAmaterno);
			$statement->bindParam(5,$tempFnacimiento);
			$statement->bindParam(6,$tempSexo);
			$statement->bindParam(7,$tempCorreo);
			$statement->bindParam(8,$tempNumero);

			$statement->execute();

		} catch (Exception $e)
		{
			$msj = $e->getMessage();
			$mensajeFinalS = str_replace('{{msj}}', $msj,$mensajeFinalS);
			//$mensajeFinalS = str_replace('SQLSTATE[45000]', '',$mensajeFinalS);
			$mensajeFinalS = str_replace('1644', '',$mensajeFinalS);
			$mensajeFinalS = preg_replace('/SQLSTATE\[([^)]+?)\]:/', '',$mensajeFinalS);
			echo $mensajeFinalS;
			die();
		}
	}

    //SE CREA LA FUNCION PARA EDITAR AL MODULO DE PERSONAS QUE EXISTEN EN LA BASE DE DATOS
	public function Actualizar_persona(Persona $persona,Correo $correo, Telefono $telefono)
	{
		$mensajeFinalS = file_get_contents('../msj/mensaje_general_error2.php');
		try
		{
			$statement = $this->pdo->prepare("CALL up_actualizar_personas(?,?,?,?,?,?,?,?,?)");

			$tempIdPersona = $persona->__GET('id_persona');
			$tempDoc = $persona->__GET('documento');
			$tempNombre = $persona->__GET('nombre');
			$tempApaterno = $persona->__GET('apellido_paterno');
			$tempAmaterno = $persona->__GET('apellido_materno');
			$tempFnacimiento = $persona->__GET('fecha_nacimiento');
			$tempSexo = $persona->__GET('sexo');

			$tempCorreo = $correo->__GET('correo');
			$tempNumero = $telefono->__GET('numero');

			$statement->bindParam(1,$tempIdPersona);
			$statement->bindParam(2,$tempDoc);
			$statement->bindParam(3,$tempNombre);
			$statement->bindParam(4,$tempApaterno);
			$statement->bindParam(5,$tempAmaterno);
			$statement->bindParam(6,$tempFnacimiento);
			$statement->bindParam(7,$tempSexo);

			$statement->bindParam(8,$tempCorreo);
			$statement->bindParam(9,$tempNumero);

			$statement->execute();

		} catch (Exception $e)
		{
			$msj = $e->getMessage();
			$mensajeFinalS = str_replace('{{msj}}', $msj,$mensajeFinalS);
			echo $mensajeFinalS;
			die();
		}
	}

    //SE CREA LA FUNCION PARA BUSCAR A LAS PERSONAS QUE EXISTEN MEDIENTE AJAX
	public function Buscar_persona_ajax(Persona $persona){
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("CALL up_buscar_persona_dni_ajax(?)");
			
			$tempDoc = $persona->__GET('documento');

			$statement->bindParam(1,$tempDoc);

			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Persona();

				$per->__SET('id_persona',         $r->id_persona);
				$per->__SET('documento',         $r->documento);
				$per->__SET('nombre',            $r->nombre);
				$per->__SET('apellido_paterno',   $r->apellido_paterno);
				$per->__SET('apellido_materno',   $r->apellido_materno);
				$per->__SET('fecha_nacimiento',   $r->fecha_nacimiento);
				$per->__SET('sexo',   $r->sexo);

				$result[] = $per;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

    //SE CREA LA FUNCION PARA LISTAR A LAS PERSONAS QUE EXISTEN EN LA BASE DE DATOS
	public function Listar_per()
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("CALL PRO_LIST_PERSONA()");
			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Persona();

				$per->__SET('idPersona',         $r->idPersona);
				$per->__SET('Documento',         $r->Documento);
				$per->__SET('Nombre',            $r->Nombre);
				$per->__SET('ApellidoPaterno',   $r->ApellidoPaterno);
				$per->__SET('ApellidoMaterno',   $r->ApellidoMaterno);
				$per->__SET('FechaNacimiento',   $r->FechaNacimiento);
				$per->__SET('Sexo',   $r->Sexo);

				$result[] = $per;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	//SE CREA LA FUNCION PARA EDITAR LAS PERSONAS QUE EXISTEN EN LA BASE DE DATOS
	public function Update_per(Persona $persona)
	{
		try
		{
			$statement = $this->pdo->prepare("CALL PRO_UPDATE_PERSONA(?,?,?,?,?,?,?)");

			$statement->bindParam(1,$persona->__GET('idPersona'));			
			$statement->bindParam(1,$persona->__GET('Documento'));
			$statement->bindParam(2,$persona->__GET('Nombre'));
			$statement->bindParam(3,$persona->__GET('ApellidoPaterno'));
			$statement->bindParam(4,$persona->__GET('ApellidoMaterno'));
			$statement->bindParam(5,$persona->__GET('FechaNacimiento'));
			$statement->bindParam(6,$persona->__GET('Sexo'));
			$statement -> execute();

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

    //SE CREA LA FUNCION PARA BUSCAR A LAS PERSONAS QUE EXISTEN MEDIANTE SUS NOMBRES Y APELLIDOS
	public function Buscar_p_nombres_apellidos(Persona $persona)
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_buscar_persona_nombre_apellidos(?,?,?,?)");
			
			$tempDocumento = $persona->__GET('documento');
			$tempNombre = $persona->__GET('nombre');
			$tempApaterno = $persona->__GET('apellido_paterno');
			$tempAmaterno = $persona->__GET('apellido_materno');

            $statement->bindParam(1,$tempDocumento);
			$statement->bindParam(2,$tempNombre);
			$statement->bindParam(3,$tempApaterno);
			$statement->bindParam(4,$tempAmaterno);

			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Persona();

				$per->__SET('id_persona',         $r->id_persona);
				$per->__SET('documento',         $r->documento);
				$per->__SET('nombre',            $r->nombre);
				$per->__SET('apellido_paterno',   $r->apellido_paterno);
				$per->__SET('apellido_materno',   $r->apellido_materno);
				$per->__SET('fecha_nacimiento',   $r->fecha_nacimiento);
				$per->__SET('sexo',   $r->sexo);

				$result[] = $per;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

    //SE CREA LA FUNCION PARA BUSCAR A LAS PERSONAS QUE EXISTEN MEDIANTE SU IDENTIFICADOR
	public function Buscar_p_id(Persona $persona)
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_buscar_persona_id(?)");

			$tempIdpersona = $persona->__GET('id_persona');
			
			$statement->bindParam(1,$tempIdpersona);

			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Persona();

				$per->__SET('id_persona',         $r->id_persona);
				$per->__SET('documento',         $r->documento);
				$per->__SET('nombre',            $r->nombre);
				$per->__SET('apellido_paterno',   $r->apellido_paterno);
				$per->__SET('apellido_materno',   $r->apellido_materno);
				$per->__SET('fecha_nacimiento',   $r->fecha_nacimiento);
				$per->__SET('sexo',   $r->sexo);

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
