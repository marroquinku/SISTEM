<?php 

//INICIA UNA NUEVA SESIÓN O REANUDA LA ACTUAL 
session_start();

//IMPORTACIÓN DE TODAS LAS CLASES NECESARIAS PARA EL CORRECTO FUNCIONAMIENTO DEL FORMULARIO
//importando el DBacces
require_once '../../DAL/DBAccess.php';

//importando header
require '../secciones/mesa_parte/header.php';

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

require_once '../../BOL/area.php';
require_once '../../DAO/areaDAO.php';

$usuariosAmbientes = new UsuariosAmbientes();
$usuariosAmbientesDAO = new usuarioAmbienteDAO();

//SE REFIERE A QUE CARGO SOLO PUEDE INGRESAR A ESTA PAGINA 
//EN ESTE CASO SOLO EL ADMINISTRADOR
$usuariosAmbientesDAO->seguridadLogin("MESA DE PARTES");
//FINALIZA ACA

//CREACIÓN DE OBJETOS QUE REPRESENTEN A LAS CLASES A UTILIZAR 
$ambientes = new Ambientes();
$ambientesDAO = new ambienteDAO();
$resultado_ambientes = $ambientesDAO->Listar();

//SE CREA UNA CONDICIONAL PARA VALIDAR SI EL BOTON CON NAME "btnGuardar" ESTA RECIBIENDO VALORES, DE SER ASI, SE GUARDAN EN EL SISTEMA
if(isset($_POST['btnGuardar']))
{
	$resolucion->__GET('idTipoResolucion')->__SET('idTipoResolucion', $_POST['ambientes']);
	$resolucionDAO->Registrar($resolucion);

	header("Refresh:0");
}
?>

<!-- SE COMIENZA A CREAR LA ESTRUCTURA CENTRAL DEL FORMULARIO -->
<form action="/action_page.php" class="col-md-4">
	<div class="form-group">
		<label for="email">Nombre del Usurario</label>
		<input type="text" class="form-control">
	</div>
	<div class="form-group">
		<label for="email">Contraseña del Usurario</label>
		<input type="password" class="form-control">
	</div>
	<div class="form-group">
		<label for="email">Lugar de ambiente</label>
		<select class="form-control" name="NombreAmbiente">
			<!-- REALIZA UN RECORRIDO A LA BASE DE DATOS PARA MOSTAR EL REGISTRO DEL CAMPO "NombreAmbiente" -->
			<?php foreach($resultado_ambientes as $r_g): ?>
				<option value="<?php echo $r_g->__GET('idAmbientes');?>">
					<?php echo $r_g->__GET('NombreAmbiente');?>
				</option>
			<?php endforeach;?>
		</select>
	</div>
	<!-- CREACION DE LOS BOTONES -->
	<div class="col-md-12">
		<button type="submit" class="btn btn-success" name="btnGuardar">Guardar</button>
		<button type="submit" class="btn btn-primary" name="btnGuardar" id="btnGuardarRes" disabled>Guardar</button>
	</div>

<!-- Importación del footer -->
<?php require '../secciones/mesa_parte/footer.php'; ?>