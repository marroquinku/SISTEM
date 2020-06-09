<?php 
//CREACIÓN DE LA CLASE USUARIO_AMBIENTEDAO
class Usuario_ambienteDAO
{
	//SE CREA LA VARIABLE QUE HACE REFERENCIA A LA CONEXION A LA BASE DE DATOS
	private $pdo;

    //SE CREA LA FUNCION PARA OBTENER LA CONEXION
	public function __construct()
	{
		$dba = new DBAccess();
		$this->pdo = $dba->get_connection();
	}

    //SE CREA LA FUNCION PARA EL LOGEO DE LOS USUARIOS AL APLICATIVO
	public function Login_Usuario(Usuario_ambiente $usuariosAmbientes)
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("CALL up_login_usuario(?,?)");


			$tempUsuario = $usuariosAmbientes->__GET('id_usuario')->__GET('usuario');
			$tempContrasenia = $usuariosAmbientes->__GET('id_usuario')->__GET('contrasenia');

			$statement->bindParam(1, $tempUsuario);
			$statement->bindParam(2, $tempContrasenia);
			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Usuario_ambiente();

				$per->__SET('id_usuario_ambiente', $r->id_usuario_ambiente);
				$per->__GET('id_ambiente')->__SET('id_ambiente', $r->id_ambiente);
				//$per->__GET('id_ambiente')->__SET('NombreAmbiente', $r->NombreAmbiente);

				$per->__GET('id_usuario')->__SET('id_usuario', $r->id_usuario);
				$per->__GET('id_usuario')->__SET('usuario', $r->usuario);
				$per->__GET('id_usuario')->__SET('contrasenia', $r->contrasenia);
				$per->__GET('id_usuario')->__SET('tipo_usuario', $r->tipo_usuario);

				$per->__GET('id_usuario')->__GET('id_persona')->__SET('id_persona', $r->id_persona);
				$per->__GET('id_usuario')->__GET('id_persona')->__SET('nombre', $r->nombre);
				$per->__GET('id_usuario')->__GET('id_persona')->__SET('apellido_paterno', $r->apellido_paterno);
				$per->__GET('id_usuario')->__GET('id_persona')->__SET('apellido_materno', $r->apellido_materno);

				$result[] = $per;
			}

			return $result;

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

    //SE CREA LA FUNCION PARA LISTAR LOS AMBIENTES QUE PERTENECEN AL USUARIO A LA BASE DE DATOS
	public function Listar_ambientes_usuario(Usuario_ambiente $usuariosAmbientes)
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("CALL up_listar_ambiente_usuarios(?)");


			$tempIdUsuario = $usuariosAmbientes->__GET('id_usuario')->__GET('id_usuario');
			$statement->bindParam(1, $tempIdUsuario);

			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Usuario_ambiente();

				$per->__SET('id_usuario_ambiente', $r->id_usuario_ambiente);
				$per->__GET('id_ambiente')->__SET('id_ambiente', $r->id_ambiente);
				$per->__GET('id_ambiente')->__SET('nombre_ambiente', $r->nombre_ambiente);

				$per->__GET('id_usuario')->__SET('id_usuario', $r->id_usuario);
				$per->__GET('id_usuario')->__SET('usuario', $r->usuario);
				$per->__GET('id_usuario')->__SET('contrasenia', $r->contrasenia);
				$per->__GET('id_usuario')->__SET('tipo_usuario', $r->tipo_usuario);

				$result[] = $per;
			}

			return $result;

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

    //SE CREA LA FUNCION PARA DESIGNAR EL AMBIENTE AL QUE PERTENECE UN USUARIO A LA BASE DE DATOS
	public function Registrar_usuario_ambiente(Usuario_ambiente $usuariosAmbientes)
	{
		$mensajeFinalS = file_get_contents('../msj/mensaje_general_error2.php');
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("CALL up_designar_ambientes(?,?)");

			$tempIdAmbiente = $usuariosAmbientes->__GET('id_ambiente')->__GET('id_ambiente');
			$tempIdUsuario = $usuariosAmbientes->__GET('id_usuario')->__GET('id_usuario');


			$statement->bindParam(1, $tempIdUsuario);
			$statement->bindParam(2, $tempIdAmbiente);
			$statement->execute();

		} catch (Exception $e)
		{
			$msj = $e->getMessage();
			$mensajeFinalS = str_replace('{{msj}}', $msj,$mensajeFinalS);
			echo $mensajeFinalS;
			die();
		}
	}

    //SE CREA LA FUNCION PARA EL ESTADO EN QUE SE ENCUENTRAN LOS USUARIOS A LA BASE DE DATOS
	public function Registrar_usuario_ambiente_estado(Usuario_ambiente $usuariosAmbientes)
	{
		$mensajeFinalS = file_get_contents('../msj/mensaje_general_error2.php');
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("CALL up_registrar_usuario_ambiente_estado(?,?,?,?,?)");

			$tempIdPersona = $usuariosAmbientes->__GET('id_usuario')->__GET('id_persona')->__GET('id_persona');
			$tempUsuario = $usuariosAmbientes->__GET('id_usuario')->__GET('usuario');
			$tempContrasenia = $usuariosAmbientes->__GET('id_usuario')->__GET('contrasenia');
			$tempEstado = $usuariosAmbientes->__GET('id_usuario')->__GET('estado');
			$tempIdAmbiente = $usuariosAmbientes->__GET('id_ambiente')->__GET('id_ambiente');

			$statement->bindParam(1, $tempIdPersona);
			$statement->bindParam(2, $tempUsuario);
			$statement->bindParam(3, $tempContrasenia);
			$statement->bindParam(4, $tempEstado);
			$statement->bindParam(5, $tempIdAmbiente);
			$statement->execute();

		} catch (Exception $e)
		{
			$msj = $e->getMessage();
			$mensajeFinalS = str_replace('{{msj}}', $msj,$mensajeFinalS);
			echo $mensajeFinalS;
			die();
		}
	}

    //SE CREA LA FUNCION PARA DESIGNAR QUE ROLES PERTENECEN AL USUARIO
	public function getUrlPanelDesing($tipoDeRol){
		$url =  DBAccess::getUrl();
		$urlRed = "";
		switch ($tipoDeRol) {
			case 1:
			$urlRed .= "$url/DESIGNER/admin/index.php";
			break;
			case 2:
			$urlRed .= "$url/DESIGNER/mesa_parte/index.php";
			break;
			default:
			$urlRed .= "$url/DESIGNER/oficina/index.php";
		}
		return $urlRed;
	}

    //SE CREA LA FUNCION PARA LA SEGURIDAD DE ROLES QUE PERTENECEN A CADA USUARIO
	public function seguridadLoginSuccess($tipoDeRol){
		$url =  DBAccess::getUrl();
		switch ($tipoDeRol) {
			case 1:
			header("Location:$url/DESIGNER/admin/index.php");
			break;
			case 2:
			header("Location:$url/DESIGNER/mesa_parte/index.php");
			break;
			case 3:
			header("Location:$url/DESIGNER/oficina/index.php");
			break;
		}
	}

    //SE CREA LA FUNCION PARA LISTAR A LOS USUARIS PERTENECIENTES A CADA AMBIENTE QUE EXISTEN EN LA BASE DE DATOS
	public function Listar()
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_listar_usuario_ambientes()");
			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Usuario_ambiente();

				$per->__SET('id_usuario_ambiente', $r->id_usuario_ambiente);
				$per->__GET('id_ambiente')->__SET('id_ambiente', $r->id_ambiente);
				$per->__GET('id_ambiente')->__SET('nombre_ambiente', $r->nombre_ambiente);
				$per->__GET('id_usuario')->__SET('usuario', $r->usuario);
				$per->__GET('id_usuario')->__SET('id_usuario', $r->id_usuario);

				$result[] = $per;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

    //SE CREA LA FUNCION PARA BUSCAR A LAS PERSONAS QUE EXISTEN EN LA BASE DE DATOS
	public function Buscar(Persona $persona)
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_buscar_persona(?,?,?,?,?)");
			$tempid_persona = $persona->__GET('id_persona');
			$tempNombre = $persona->__GET('nombre');
			$tempapellido_paterno = $persona->__GET('apellido_paterno');
			$tempapellido_materno = $persona->__GET('apellido_materno');
			$tempNumeroDocumento = $persona->__GET('numero_documento');

			$statement->bindParam(1,$tempid_persona);
			$statement->bindParam(2,$tempNombre);
			$statement->bindParam(3,$tempapellido_paterno);
			$statement->bindParam(4,$tempapellido_materno);
			$statement->bindParam(5,$tempNumeroDocumento);

			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Persona();

				$per->__SET('id_persona', $r->id_persona);
				$per->__SET('nombre', $r->nombre);
				$per->__SET('apellido_paterno', $r->apellido_paterno);
				$per->__SET('apellido_materno', $r->apellido_materno);
				$per->__SET('numero_documento', $r->numero_documento);
				$per->__SET('fecha_nacimiento', $r->fecha_nacimiento);
				$per->__SET('sexo', $r->sexo);
				$per->__SET('direccion', $r->direccion);
				$per->__SET('telefono', $r->telefono);
				$per->__GET('id_tdocumento')->__SET('id_tdocumento', $r->id_tdocumento);
				$per->__GET('id_ecivil')->__SET('id_ecivil', $r->id_ecivil);

				$result[] = $per;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

    //SE CREA LA FUNCION PARA BUSCAR A LAS PERSONAS QUE EXISTEN MEDIANTE LA RENIEC
	public function Buscar_Reniec(Persona $persona)
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_buscar_persona_reniec(?,?,?,?,?)");
			$tempid_persona = $persona->__GET('id_persona');
			$tempNombre = $persona->__GET('nombre');
			$tempapellido_paterno = $persona->__GET('apellido_paterno');
			$tempapellido_materno = $persona->__GET('apellido_materno');
			$tempNumeroDocumento = $persona->__GET('numero_documento');

			$statement->bindParam(1,$tempid_persona);
			$statement->bindParam(2,$tempNombre);
			$statement->bindParam(3,$tempapellido_paterno);
			$statement->bindParam(4,$tempapellido_materno);
			$statement->bindParam(5,$tempNumeroDocumento);

			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Persona();

				$per->__SET('id_persona', $r->id_persona);
				$per->__SET('nombre', $r->nombre);
				$per->__SET('apellido_paterno', $r->apellido_paterno);
				$per->__SET('apellido_materno', $r->apellido_materno);
				$per->__SET('numero_documento', $r->numero_documento);
				$per->__SET('fecha_nacimiento', $r->fecha_nacimiento);
				$per->__SET('sexo', $r->sexo);
				$per->__SET('direccion', $r->direccion);
				$per->__SET('telefono', $r->telefono);
				$per->__GET('id_tdocumento')->__SET('id_tdocumento', $r->id_tdocumento);
				$per->__GET('id_ecivil')->__SET('id_ecivil', $r->id_ecivil);

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
