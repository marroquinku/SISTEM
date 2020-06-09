<?php
//CREACIÓN DE LA CLASE USUARIODAO
class usuarioDAO
{
	//SE CREA LA VARIABLE QUE HACE REFERENCIA A LA CONEXION A LA BASE DE DATOS
	private $pdo;

    //SE CREA LA FUNCION PARA OBTENER LA CONEXION
	public function __construct()
	{
		$dba = new DBAccess();
		$this->pdo = $dba->get_connection();
	}

    //SE CREA LA FUNCION PARA EL REGISTRO DE USUARIOS A LA BASE DE DATOS
	public function Registrar(Usuario $usuario)
	{
		$mensajeFinalS = file_get_contents('../msj/mensaje_general_error2.php');
		try
		{
			$statement = $this->pdo->prepare("CALL up_registrar_usuarios(?,?,?)");


			$tempIdPersona = $usuario->__GET('id_persona')->__GET('id_persona');
			$tempUsuario = $usuario->__GET('usuario');
			$tempContrasenia = $usuario->__GET('contrasenia');

			$statement->bindParam(1, $tempIdPersona);
			$statement->bindParam(2, $tempUsuario);
			$statement->bindParam(3, $tempContrasenia);
			$statement->execute();

		} catch (Exception $e)
		{
			$msj = $e->getMessage();
			$mensajeFinalS = str_replace('{{msj}}', $msj,$mensajeFinalS);
			echo $mensajeFinalS;
			die();
		}
	}

	//SE CREA LA FUNCION PARA BUSCAR A LAS PERRSONAS CON SU USUARIO QUE EXISTEN EN LA BASE DE DATOS MEDIANTE AJAX 
	public function Buscar_usuario_persona_ajax(Usuario $usuario)
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_buscar_usuario_persona_ajax(?)");

			$tempDocumentoPersona = $usuario->__GET('id_persona')->__GET('documento');

			$statement->bindParam(1, $tempDocumentoPersona);
			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Usuario();

				$per->__GET('id_persona')->__SET('id_persona', $r->id_persona);
				$per->__GET('id_persona')->__SET('nombre', $r->nombre);
				$per->__GET('id_persona')->__SET('apellido_paterno', $r->apellido_paterno);
				$per->__GET('id_persona')->__SET('apellido_materno', $r->apellido_materno);
				$per->__GET('id_persona')->__SET('documento', $r->documento);
				$per->__SET('usuario', $r->usuario);;
				$per->__SET('id_usuario', $r->id_usuario);;

				$result[] = $per;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
			//die();
			//$jsondata["data"]["message"] = $e->getMessage();
		}
	}

    //SE CREA LA FUNCION PARA EL LOGEO DE LOS USUARIOS AL APLICATIVO MEDIANTE AJAX
	public function Login_usuario_contrasenia_ajax(Usuario $usuario)
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_login_usuario(?,?)");

			$tempUsuario = $usuario->__GET('usuario');
			$tempContrasenia = $usuario->__GET('contrasenia');


			$statement->bindParam(1, $tempUsuario);
			$statement->bindParam(2, $tempContrasenia);
			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Usuario();

				$per->__GET('id_persona')->__SET('id_persona', $r->id_persona);
				$per->__GET('id_persona')->__SET('nombre', $r->nombre);
				$per->__GET('id_persona')->__SET('apellido_paterno', $r->apellido_paterno);
				$per->__GET('id_persona')->__SET('apellido_materno', $r->apellido_materno);
				$per->__GET('id_persona')->__SET('documento', $r->documento);
				$per->__SET('usuario', $r->usuario);;
				$per->__SET('id_usuario', $r->id_usuario);
				$per->__SET('ambientes', $r->ambientes);
				$per->__SET('id_usuario_ambiente', $r->id_usuario_ambiente);

				$result[] = $per;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
			//die();
			//$jsondata["data"]["message"] = $e->getMessage();
		}
	}

    
	public function Listar_(Persona $persona)
	{
		try
		{
			$result = array();
			$statement = $this->pdo->prepare("call up_buscar_persona(?)");
			$tempIdPersona = $persona->__GET('id_persona');
			$statement->bindParam(1,$tempIdPersona);
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

    //SE CREA LA FUNCION PARA BUSCAR A LOS USUARIOS QUE EXISTEN EN LA BASE DE DATOS
	public function Buscar_usuarios(Usuario $usuario)
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_buscar_usuarios(?,?)");
			
			$tempDocumentoPersona = $usuario->__GET('id_persona')->__GET('documento');
			$tempNombre = $usuario->__GET('id_persona')->__GET('nombre');

            $statement->bindParam(1,$tempDocumentoPersona);
			$statement->bindParam(2,$tempNombre);

			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Usuario();

                $per->__SET('id_usuario',         $r->id_usuario);
                $per->__GET('id_persona')->__SET('documento', $r->documento);
                $per->__GET('id_persona')->__SET('nombre', $r->nombre);
                $per->__GET('id_persona')->__SET('apellido_paterno', $r->apellido_paterno);
                $per->__GET('id_persona')->__SET('apellido_materno', $r->apellido_materno);
				$per->__SET('usuario',           $r->usuario);
				$per->__SET('contrasenia',       $r->contrasenia);

				$result[] = $per;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

    //SE CREA LA FUNCION PARA BUSCAR A LAS USUARIOS QUE EXISTEN EN LA BASE DE DATOS MEDIANTE SU IDENTIFICADOR
	public function Buscar_u_id(Usuario $usuario)
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("call up_buscar_usuario_id(?)");
			
			$tempIdusuario = $usuario->__GET('id_usuario');

			$statement->bindParam(1,$tempIdusuario);

			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Usuario();

				$per->__SET('id_usuario',         $r->id_usuario);
				$per->__SET('usuario',         $r->usuario);
				$per->__SET('contrasenia',         $r->contrasenia);

				$result[] = $per;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

    //SE CREA LA FUNCION PARA EDITAR A LOS USUARIOS QUE EXISTEN EN LA BASE DE DATOS
	public function Actualizar_usuario(Usuario $usuario)
	{
		$mensajeFinalS = file_get_contents('../msj/mensaje_general_error2.php');
		try
		{
			$statement = $this->pdo->prepare("CALL up_actualizar_usuarios(?,?,?)");

            $tempIdusuario = $usuario->__GET('id_usuario');
			$tempUsuario = $usuario->__GET('usuario');
			$tempContrasenia = $usuario->__GET('contrasenia');

			$statement->bindParam(1,$tempIdusuario);
			$statement->bindParam(2,$tempUsuario);
			$statement->bindParam(3,$tempContrasenia);

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
