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

if(isset($_POST['id_persona'])){


	$docente = new Docente();
	$docenteDAO = new DocenteDAO();


	$id_persona = trim($_POST['id_persona']);
	$id_funcion = trim($_POST['id_funcion']);
	$estado = trim($_POST['estado']);


	$docente->__GET('id_persona')->__SET('id_persona', $id_persona);
	$docente->__SET('estado', $estado);
	$docente->__GET('id_funcion')->__SET('id_funcion', $id_funcion);

	$docenteDAO->Registrar($docente);


	echo json_encode(array(
		"success"=>"1",
		"msj"=>"Registro completado"
	));


}


?>