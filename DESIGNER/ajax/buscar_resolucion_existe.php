<?php 

//importando el DBacces
require_once '../../DAL/DBAccess.php';

//SEGURIDAD DE ACCESO DESDE ACA
//importando las clases y los dao
require_once '../../BOL/persona.php';
require_once '../../DAO/personaDAO.php';

//importando las clases y los dao
require_once '../../BOL/ambiente.php';
require_once '../../DAO/ambienteDAO.php';

//importando las clases y los dao
require_once '../../BOL/usuario.php';
require_once '../../DAO/usuarioDAO.php';

//importando las clases y los dao
require_once '../../BOL/usuario_ambiente.php';
require_once '../../DAO/usuario_ambienteDAO.php';

//importando las clases y los dao
require_once '../../BOL/tipo_resolucion.php';
require_once '../../DAO/tipo_resolucionDAO.php';

//importando las clases y los dao
require_once '../../BOL/concepto.php';
require_once '../../DAO/conceptoDAO.php';

//importando las clases y los dao
require_once '../../BOL/resolucion.php';
require_once '../../DAO/resolucionDAO.php';

//importando las clases y los dao
require_once '../../BOL/estado.php';

require_once '../../BOL/tipo_rol.php';
require_once '../../DAO/tipo_rolDAO.php';

require_once '../../BOL/area.php';
require_once '../../DAO/areaDAO.php';

if(isset($_POST['resolucionNumero']) && isset($_POST['anioRes']) && isset($_POST['tipoRes'])){
	//acceso a la archivo bd
	$dba = new DBAccess();

	//Tipo de resolucion
	$tipoResolucion = new Tipo_resolucion();
	$tipoResolucionDAO = new Tipo_resolucionDAO();

	//Resoluciones
	$resolucion = new Resolucion();
	$resolucion->__GET('id_tipo_resolucion')->__SET('id_tipo_resolucion', $_POST['tipoRes']);
	$resolucion->__SET('numero', $_POST['resolucionNumero']);
	$resolucion->__SET('anio', $_POST['anioRes']);

	$resolucionDAO = new resolucionDAO();
	$resultado_resolucion = $resolucionDAO->Buscar_resolucion_ajax($resolucion);

	if (count($resultado_resolucion)>0) {
		$jsondata["success"] = 1;
	    $jsondata["data"] = array(
	      'idResoluciones' => $resultado_resolucion[0]->id_resolucion,
	      'TipoResolucion' => $resultado_resolucion[0]->id_tipo_resolucion->id_tipo_resolucion,
	      'Numero' => $resultado_resolucion[0]->numero,
	      'Anio' => $resultado_resolucion[0]->anio,
	      'Concepto' => $resultado_resolucion[0]->id_concepto->id_concepto
	    );
	}else{
		$jsondata["success"] = 0;
	    $jsondata["data"] = array(
	      'message' => 'Perfecto'
	    );
	}

  	header('Content-type: application/json; charset=utf-8');
  	echo json_encode($jsondata, JSON_FORCE_OBJECT);


}

?>