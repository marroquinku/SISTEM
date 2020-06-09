<?php 
session_start();
//importando el DBacces
require_once '../../DAL/DBAccess.php';

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
require_once '../../BOL/tipo_rol.php';
require_once '../../DAO/tipo_rolDAO.php';

require_once '../../BOL/area.php';
require_once '../../DAO/areaDAO.php';

require '../secciones/oficina/header.php';

$usuariosAmbientes = new Usuario_ambiente();
$usuariosAmbientesDAO = new Usuario_ambienteDAO();

?>

<h2 class="text-center title-container"><i class="glyphicon glyphicon-floppy-saved"></i> MODULO DE OFICINA</h2>

	<br>

<?php require '../secciones/oficina/footer.php'; ?>