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

if(isset($_POST['numero_dni'])){

	$dba = new DBAccess();
	$persona = new Persona();
	$personaDAO = new PersonaDAO();


	$nombre = trim($_POST['nombre']);
	$apellido_paterno = trim($_POST['apellido_paterno']);
	$apellido_materno = trim($_POST['apellido_materno']);
	$numero_documento = trim($_POST['numero_dni']);
	$fecha_nacimiento = trim($_POST['fecha']);
	$sexo = trim($_POST['apellido_paterno']);
	$direccion = trim($_POST['direccion']);
	$telefono = trim($_POST['telefono']);
	$id_tdocumento = trim($_POST['tipo_documento']);
	$id_ecivil = trim($_POST['estado_civil']);



	$persona->__SET('nombre', $nombre);
	$persona->__SET('apellido_paterno', $apellido_paterno);
	$persona->__SET('apellido_materno', $apellido_materno);
	$persona->__SET('numero_documento', $numero_documento);
	$persona->__SET('fecha_nacimiento', $fecha_nacimiento);
	$persona->__SET('sexo', $sexo);
	$persona->__SET('direccion', $direccion);
	$persona->__SET('telefono', $telefono);
	$persona->__GET('id_tdocumento')->__SET('id_tdocumento', $id_tdocumento);
	$persona->__GET('id_ecivil')->__SET('id_ecivil', $id_ecivil);

	$personaDAO->Registrar($persona);



	echo json_encode(array(
		"success"=>"1",
		"msj"=>"Registro completado"
	));


}


?>