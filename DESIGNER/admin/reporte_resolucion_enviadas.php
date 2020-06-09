<?php 

//INICIA UNA NUEVA SESIÓN O REANUDA LA ACTUAL 
session_start();

//IMPORTACIÓN DE TODAS LAS CLASES NECESARIAS PARA EL CORRECTO FUNCIONAMIENTO DEL FORMULARIO
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

require_once '../../BOL/tipo_rol.php';
require_once '../../DAO/tipo_rolDAO.php';

require_once '../../BOL/area.php';
require_once '../../DAO/areaDAO.php';

require 'fpdf/fpdf.php';
require_once 'plantilla_reporte.php';


//importando header
require '../secciones/admin/header.php'; 

//CREACIÓN DE OBJETOS QUE REPRESENTEN A LAS CLASES A UTILIZAR 
$usuariosAmbientes = new Usuario_ambiente();
$usuariosAmbientesDAO = new Usuario_ambiente();

//SE CREA UNA CONDICIONAL PARA VALIDAR SI EL BOTON CON NAME "btnGenerarReporte" ESTA RECIBIENDO VALORES, DE SER ASI, SE BUSCARA EN EL SISTEMA
if(isset($_POST['btnGenerarReporte'])){
	$pdf = new PDF();

	$fDesde = new DateTime($_POST['fDesde']);
	$fHasta = new DateTime($_POST['fHasta']);

	$pdf->Body($fDesde->format('Y-m-d'),$fHasta->format('Y-m-d'));
}
//https://stackoverflow.com/questions/6978631/how-to-set-date-format-in-html-date-input-tag
?>

<!-- SE COMIENZA A CREAR LA ESTRUCTURA CENTRAL DEL FORMULARIO -->
<div class="row">
	<div class="form-group">
		<h5 class="text-center title-container">
			<i class="glyphicon glyphicon-search"></i> GENERAR REPORTE
		</h5>
	</div>
	<div class="box-res-add">
		<div class="row">
			<!-- LA FUNCIÓN "htmlspecialchars()" CONVIERTE CARACTERES ESPECIALES A ENTIDADES HTML -->   
			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">

				<div class="table-responsive">
					<table class="table">
						<thead>
							<td>
								<label class="control-label">Desde Fecha</label>
								<input class="form-control input-sm" type="date" name="fDesde"> 
							</td>
							<td>
								<label class="control-label">Hasta Fecha</label>
								<input class="form-control input-sm" type="date" name="fHasta">
							</td>
							<td>
								<button class="btn btn-success" name="btnGenerarReporte" style="margin-top: 24px;">Buscar</button>
							</td>
						</thead>
					</table>
				</div>
			</form>  
		</div>
		<br>
		
	</div>

</div>

<!-- Importación del footer -->
<?php require '../secciones/admin/footer.php'; ?>