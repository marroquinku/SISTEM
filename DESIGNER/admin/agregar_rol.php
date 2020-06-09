<?php 

//INICIA UNA NUEVA SESIÓN O REANUDA LA ACTUAL 
session_start();

//IMPORTACIÓN DE TODAS LAS CLASES NECESARIAS PARA EL CORRECTO FUNCIONAMIENTO DEL FORMULARIO
//importando el DBacces
require_once '../../DAL/DBAccess.php';

//SEGURIDAD DE ACCESO DESDE ACA
//importando las clases y los dao
require_once '../../BOL/tipo_rol.php';
require_once '../../DAO/tipo_rolDAO.php';

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

//importando header
require '../secciones/admin/header.php'; 

//CREACIÓN DE OBJETOS QUE REPRESENTEN A LAS CLASES A UTILIZAR 
$tipo_rol = new Tipo_rol();
$Tipo_rolDAO = new Tipo_rolDAO();
$mensajeFinalS = file_get_contents('../msj/mensaje_general.php');

//SE CREA UNA CONDICIONAL PARA VALIDAR SI EL BOTON CON NAME "btnGuardar" ESTA RECIBIENDO VALORES, DE SER ASI, SE GUARDAN EN EL SISTEMA
if(isset($_POST['btnGuardar']))
{
	$tipo_rol->__SET('tipo_rol',        $_POST['tipo_rol']);
	$Tipo_rolDAO->Registrar_tipo_rol($tipo_rol);
	echo $mensajeFinalS;
	DBAccess::rederigir("mantenimiento_usuario.php");
}
?>

<!-- SE COMIENZA A CREAR LA ESTRUCTURA CENTRAL DEL FORMULARIO -->
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<h5 class="text-center title-container">
				<i class="glyphicon glyphicon-pencil"></i> AGREGAR ROL
			</h5>
		</div>
		<div class="box-res-add">
			<!-- LA FUNCIÓN "htmlspecialchars()" CONVIERTE CARACTERES ESPECIALES A ENTIDADES HTML -->	
			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<div class="form-group">
						<label>Tipo de rol:</label>
						<td><input type="text" class="form-control" name="tipo_rol" id="tipo_rol"></td>
					</div>
					<button type="submit" class="btn btn-primary" name="btnGuardar" id="btnGuardar">Guardar Rol</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Importación del footer -->
<?php require '../secciones/admin/footer.php'; ?>