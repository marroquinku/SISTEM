<?php 

require '../../DAL/DBAccess.php';
require '../../BOL/grado.php';
require '../../DAO/gradoDAO.php';

if(isset($_POST['codigo'])){

	$dba = new DBAccess();
	$gradoDAO = new GradoDAO();
	$grado = new Grado();

	$valGrado = $_POST['grado'];
	$valDescripcion = $_POST['descripcion'];
	$valCodigo = $_POST['codigo'];
	$valEstado = $_POST['estado'];

	$grado->__SET('grado', $valGrado);
	$grado->__SET('descripcion', $valDescripcion);
	$grado->__SET('codigo', $valCodigo);
	$grado->__SET('estado', $valEstado);

	$gradoDAO->Registrar($grado);

	echo json_encode(array(
		"success"=>"Registro correctamente el grado"
	));
}


if(isset($_POST['idGrado'])){

	$dba = new DBAccess();
	$gradoDAO = new GradoDAO();

	$grado = new Grado();
	$grado->__SET('id_grado', $_POST['idGrado']);
	$resultadoGrado = $gradoDAO->Buscar($grado);

	foreach ($resultadoGrado as $g) {
		$grado = $g;
	}

	$grado->__SET('estado', $_POST['update']);

	$gradoDAO->Actualizar($grado);
	$grado = null;

	echo json_encode(array(
		"success"=>"Registro correctamente el grado"
	));
}

?>