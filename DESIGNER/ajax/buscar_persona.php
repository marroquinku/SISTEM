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

require_once '../../BOL/persona.php';
require_once '../../DAO/personaDAO.php';

require_once '../../BOL/ambiente.php';

require_once '../../BOL/area.php';
require_once '../../DAO/areaDAO.php';

if(isset($_POST['documentoPersona'])){
	//acceso a la archivo bd
	$dba = new DBAccess();

	//Resoluciones
	$persona = new Persona();
	$personaDAO = new PersonaDAO();

	$persona->__SET('documento', $_POST['documentoPersona']);

	$resultado_persona = $personaDAO->Buscar_persona_ajax($persona);
	if (count($resultado_persona)>0) {
		$jsondata["success"] = 1;
	    $jsondata["data"] = array(
	      'nombre'=>  $resultado_persona[0]->nombre,
	      'apellido_paterno' => $resultado_persona[0]->apellido_paterno,
	      'apellido_materno'=> $resultado_persona[0]->apellido_materno,
	      'FechaNacimiento' => $resultado_persona[0]->fecha_nacimiento,
	      'Sexo' => $resultado_persona[0]->sexo,
	      'Documento' => $resultado_persona[0]->documento,
	      'idPersona' => $resultado_persona[0]->id_persona
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