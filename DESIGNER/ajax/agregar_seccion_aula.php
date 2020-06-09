<?php 

require '../../DAL/DBAccess.php';
require '../../BOL/grado.php';
require '../../DAO/gradoDAO.php';

require '../../BOL/aula.php';
require '../../DAO/aulaDAO.php';

require '../../BOL/seccion.php';
require '../../DAO/seccionDAO.php';

require '../../BOL/docente.php';
require '../../DAO/docenteDAO.php';

require '../../BOL/persona.php';
require '../../DAO/personaDAO.php';

require '../../BOL/funcion.php';
require '../../DAO/funcionDAO.php';

if(isset($_POST['seccion'])){

	$dba = new DBAccess();
	$aulaDAO = new AulaDAO();
	$aula = new Aula();

	$descripcion = $_POST['descripcion'];
	$numero_aula = $_POST['nuAula'];
	$numero_alumno = $_POST['nAlumnnos'];
	$turno = $_POST['turno'];
	$id_docente = $_POST['docente'];
	$id_grado = $_POST['grado'];
	$id_seccion = $_POST['seccion'];

	$aula->__SET('descripcion', $descripcion);
	$aula->__SET('numero_aula', $numero_aula);
	$aula->__SET('numero_alumno', $numero_alumno);
	$aula->__SET('turno', $turno);
	$aula->__GET('id_docente')->__GET('id_persona')->__SET('id_persona', $id_docente);
	$aula->__GET('id_grado')->__SET('id_grado', $id_grado);
	$aula->__GET('id_seccion')->__SET('id_seccion', $id_seccion);

	$aulaDAO->Registrar($aula);

	echo json_encode(array(
		"success"=>"Registro correctamente el grado"
	));
}


?>