<?php 

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
require_once '../../BOL/usuario_ambiente.php';

require_once '../../BOL/usuario.php';
require_once '../../DAO/usuarioDAO.php';

require_once '../../BOL/persona.php';
require_once '../../DAO/personaDAO.php';

require_once '../../BOL/ambiente.php';

require_once '../../BOL/area.php';
require_once '../../DAO/areaDAO.php';

if(isset($_POST['documentoPersona'])){
	//acceso a la archivo bd
	$dba = new DBAccess();

	//Resoluciones
	$usuario = new Usuario();
	$usuarioDAO = new usuarioDAO();

	$usuario->__GET('id_persona')->__SET('documento', $_POST['documentoPersona']);

	$resultado_usuario = $usuarioDAO->Buscar_usuario_persona_ajax($usuario);
	if (count($resultado_usuario)>0) {
		$jsondata["success"] = 1;
	    $jsondata["data"] = array(
	      'nombreApellidos' => $resultado_usuario[0]->id_persona->nombre." ".$resultado_usuario[0]->id_persona->apellido_paterno." ".$resultado_usuario[0]->id_persona->apellido_materno,
	      //'FechaNacimiento' => $resultado_persona[0]->FechaNacimiento,
	      'Documento' => $resultado_usuario[0]->id_persona->documento,
	      'idPersona' => $resultado_usuario[0]->id_persona->id_persona,
	      'Usuario' => $resultado_usuario[0]->usuario,
	      'idUsuarios' => $resultado_usuario[0]->id_usuario
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

?>