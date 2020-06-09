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

require_once '../../BOL/institucion.php';
require_once '../../DAO/institucionDAO.php';

require_once '../../BOL/area.php';
require_once '../../DAO/areaDAO.php';

require_once '../../BOL/nivel.php';
require_once '../../DAO/nivelDAO.php';


if(isset($_POST['codigoModular'])){
	//acceso a la archivo bd
	$dba = new DBAccess();

	//Resoluciones
	$institucion = new Institucion();
	$institucionDAO = new InstitucionDAO();

	$institucion->__SET('cod_modular', $_POST['codigoModular']);

	$resultado_institucion = $institucionDAO->Buscar_institucion_ajax($institucion);

	if (count($resultado_institucion)>0) {
		$jsondata["success"] = 1;
	    $jsondata["data"] = array(
	      'id_institucion'=>  $resultado_institucion[0]->id_institucion,
	      'cod_modular' => $resultado_institucion[0]->cod_modular,
	      'nombre'=> $resultado_institucion[0]->nombre,
	      'nivel' => $resultado_institucion[0]->id_nivel->nombre_nivel
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