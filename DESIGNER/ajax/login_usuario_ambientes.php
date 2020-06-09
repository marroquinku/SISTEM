<?php 
session_start();
//importando el DBacces
require_once '../../DAL/DBAccess.php';

//importando las clases y los dao
require_once '../../BOL/tipo_resolucion.php';
require_once '../../DAO/tipo_resolucionDAO.php';

require_once '../../BOL/concepto.php';

//importando las clases y los dao
require_once '../../BOL/resolucion.php';
require_once '../../DAO/resolucionDAO.php';

require_once '../../BOL/estado.php';
require_once '../../DAO/estadoDAO.php';

require_once '../../BOL/usuario_ambiente.php';
require_once '../../DAO/usuario_ambienteDAO.php';

require_once '../../BOL/tipo_rol.php';
require_once '../../DAO/tipo_rolDAO.php';

require_once '../../BOL/usuario.php';
require_once '../../DAO/usuarioDAO.php';

require_once '../../BOL/persona.php';
require_once '../../DAO/personaDAO.php';

require_once '../../BOL/ambiente.php';

require_once '../../BOL/area.php';
require_once '../../DAO/areaDAO.php';

function generate_ambiente($ambientes){
	$separado = explode(",",$ambientes);
	$separar_n = array();
	for($i=0; $i<count($separado); $i++){
		$separar_n[] = explode("-",$separado[$i]);
	}
	return $separar_n;
}



if(isset($_POST['usuario']) && isset($_POST['contrasenia'])){
	//acceso a la archivo bd
	$dba = new DBAccess();

	//Usuarios
	$usuario = new Usuario();
	$usuarioDAO = new usuarioDAO();

	//UsuarioAmbiente
	$usuario_ambiente = new Usuario_ambiente();
	$usuario_ambienteDAO = new Usuario_ambienteDAO();

	$usuario->__SET('usuario', $_POST['usuario']);
	$usuario->__SET('contrasenia', $_POST['contrasenia']);

	$resultado_usuario = $usuarioDAO->Login_usuario_contrasenia_ajax($usuario);

	if (count($resultado_usuario)>0) {
		
		if(strlen($resultado_usuario[0]->id_persona->nombre) > 10){
		   $nuevoNombre =  substr($resultado_usuario[0]->id_persona->nombre, 0, 10).'...';
		}else{
		   $nuevoNombre =  $resultado_usuario[0]->id_persona->nombre;
		}

		$nombreSession = $nuevoNombre." ".$resultado_usuario[0]->id_persona->apellido_paterno;
		$nombres = $resultado_usuario[0]->id_persona->nombre." ".$resultado_usuario[0]->id_persona->apellido_paterno." ".$resultado_usuario[0]->id_persona->apellido_materno;

		$_SESSION['idUsuarios'] = $resultado_usuario[0]->id_usuario;
		$_SESSION['idPersona'] = $resultado_usuario[0]->id_persona->id_persona;
		$_SESSION['nombreApellidos'] = $nombreSession;
		$_SESSION['id_usuario_ambiente'] = $resultado_usuario[0]->id_usuario_ambiente;

		$jsondata["success"] = 1;
		$jsondata["data"] = array(
			'nombreApellidos' => $nombres,
			'Documento' => $resultado_usuario[0]->id_persona->documento,
			'idPersona' => $resultado_usuario[0]->id_persona->id_persona,
			'Usuario' => $resultado_usuario[0]->usuario,
			'idUsuarios' => $resultado_usuario[0]->id_usuario,
			'Ambientes' => generate_ambiente($resultado_usuario[0]->ambientes),
			'id_usuario_ambiente' => $resultado_usuario[0]->id_usuario_ambiente
		);
	}else{
		$jsondata["success"] = 0;
		$jsondata["data"] = array(
			'message' => 'Error'
		);
	}

	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);

}


if(isset($_POST['id_ambiente']) && isset($_POST['id_tipo']) && isset($_POST['nombre_ambiente'])){

	//UsuarioAmbiente
	$usuario_ambiente = new Usuario_ambiente();
	$usuario_ambienteDAO = new Usuario_ambienteDAO();

	
	if (isset($_SESSION['idUsuarios'])) {

		$_SESSION['id_ambiente'] = $_POST['id_ambiente'];
		$_SESSION['id_tipo'] = $_POST['id_tipo'];
		$_SESSION['nombre_ambiente'] = $_POST['nombre_ambiente'];
		
		$urlRedic = $usuario_ambienteDAO->getUrlPanelDesing($_SESSION['id_tipo']);
		
		$jsondata["success"] = 1;
		$jsondata["urlRedic"] = $urlRedic;
	}else{
		$jsondata["success"] = 0;
	}

	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
}

?>