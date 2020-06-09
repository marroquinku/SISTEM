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

//importando header
require '../secciones/admin/header.php'; 

//CREACIÓN DE OBJETOS QUE REPRESENTEN A LAS CLASES A UTILIZAR 
$usuariosAmbientes = new Usuario_ambiente();
$usuariosAmbientesDAO = new Usuario_ambiente();

$tipoResolucion = new Tipo_resolucion();
$tipoResolucionDAO = new Tipo_resolucionDAO();
$resultado_tipoResolucion = $tipoResolucionDAO->Listar();

$concepto = new Concepto();
$conceptoDAO = new ConceptoDAO();
$resultado_concepto = $conceptoDAO->Listar();

$resolucion = new Resolucion();
$resolucionDAO = new ResolucionDAO();
$resultado_resolucion = $resolucionDAO->Listar();

$mensajeFinalS = file_get_contents('../msj/mensaje_general.php');

//SE CREA UNA CONDICIONAL PARA VALIDAR SI EL BOTON CON NAME "btnGuardar" ESTA RECIBIENDO VALORES, DE SER ASI, SE GUARDAN EN EL SISTEMA
if(isset($_POST['btnGuardar']))
{
	$resolucion->__GET('id_tipo_resolucion')->__SET('id_tipo_resolucion', $_POST['tipoResolucion']);
	$resolucion->__GET('id_concepto')->__SET('id_concepto', $_POST['conceptoResolucion']);
	$resolucion->__SET('id_estado', 1);
	$resolucion->__SET('proyecto', $_POST['proyectoResolucion']);
	$resolucion->__SET('id_usuario_ambiente', $_SESSION['id_usuario_ambiente']);
	$resolucion->__SET('numero', $_POST['numeroResolucion']);
	$resolucion->__SET('anio', $_POST['anioResolucion']);
	$resolucion->__SET('fecha_emision', $_POST['fecha_emision']);
	$resolucion->__SET('archivo', realpath($_FILES["fileResolucion"]["tmp_name"]));

	$resolucionDAO->Registrar($resolucion);

	echo $mensajeFinalS;
	DBAccess::rederigir("agregar_resolucion.php");
}

?>

<!-- SE COMIENZA A CREAR LA ESTRUCTURA CENTRAL DEL FORMULARIO -->
<div class="row">
	<div class="col-md-6">
		<!-- LA FUNCIÓN "htmlspecialchars()" CONVIERTE CARACTERES ESPECIALES A ENTIDADES HTML -->	
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<h5 class="text-center title-container">
					<i class="glyphicon glyphicon-file"></i> AGREGAR RESOLUCIÓN
				</h5>
			</div>
			<div class="box-res-add">
				<div class="form-group">
					<label>Tipo de resolución</label>
					<select class="form-control" name="tipoResolucion" id="tipoResolucion">
						<!-- REALIZA UN RECORRIDO A LA BASE DE DATOS PARA MOSTAR EL REGISTRO DEL CAMPO "tipo_resolucion" -->
						<?php foreach($resultado_tipoResolucion as $r_g): ?>
							<option value="<?php echo $r_g->__GET('id_tipo_resolucion');?>">
								<?php echo $r_g->__GET('tipo_resolucion');?>
							</option>
						<?php endforeach;?>
					</select>
				</div>
				<div class="form-group">
					<label>Año:</label>
					<select name="anioResolucion" class="form-control" id="anioResolucion">
						<!-- SE CREA UN BUCLE PARA QUE NOS MUESTRE UNA LISTA DE AÑOS DESDE 1988 HASTA LA ACTUALIDAD --> 
						<?php for($i = 1988 ; $i < date('Y')+1; $i++):?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php endfor;?>
					</select>
				</div>
				<div class="form-group">
					<label>Número:</label>
					<div class="input-group"> 
						<input type="number" class="form-control" onblur="ponerCeros(this)" onkeyup="PasarValor();" name="numeroResolucion" id="numeroResolucion">
						<span class="input-group-btn">
							<button class="btn btn-primary" type="button" id="btn-verificar">Verificar</button>
						</span>
					</div>
					<div class="alert alert-danger collapse" id="alerta-resolucion">
						<strong>Peligro!</strong> El numero de la resolución que desea ingresar ya existe !!!
					</div>
					<div class="alert alert-success collapse" id="alerta-resolucion2">
						<strong>Correcto!</strong> Puede subir esta resolución
					</div>
				</div>
				<div class="form-group">
					<label>Concepto</label>
					<select class="form-control" name="conceptoResolucion" id="conceptoResolucion">
						<!-- REALIZA UN RECORRIDO A LA BASE DE DATOS PARA MOSTAR EL REGISTRO DEL CAMPO "concepto" -->
						<?php foreach($resultado_concepto as $r_g): ?>
							<option value="<?php echo $r_g->__GET('id_concepto');?>">
								<?php echo $r_g->__GET('concepto');?>
							</option>
						<?php endforeach;?>
					</select>
				</div>
				<div class="form-group">
					<label>Proyecto:</label>
					<td><input type="number" class="form-control" name="proyectoResolucion" id="proyectoResolucion"></td>
				</div>
				<div class="form-group">
					<label>Fecha de Emision:</label>
                	<td><input type="date" class="form-control" name="fecha_emision" id="fecha_emision"></td>
				</div>
				<div class="form-group">
					<label>Resolución</label>
					<input id="subirResolucion" type="file" class="filestyle" name="fileResolucion">
				</div>
				<button type="submit" class="btn btn-primary" name="btnGuardar" id="btnGuardarRes" disabled>Subir Resolución</button>
				<a class="btn btn-warning"  id="btnResetearRes">Resetear</a>
			</form>
		</div>

		<div class="col-md-12">
			<h2>Lista de resoluciones</h2>
			<br>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Número</th>
						<th>Año</th>
						<th>Archivo</th>
					</tr>
				</thead>
				<tbody>
					<!-- REALIZA UN RECORRIDO A LA BASE DE DATOS PARA MOSTAR LOS REGISTRO DEL CAMPO "numero, anio" -->
					<?php foreach($resultado_resolucion as $r_g): ?>
						<tr>
							<td><?php echo $r_g->__GET('numero');?></td>
							<td><?php echo $r_g->__GET('anio');?></td>
							<td>
								<a target="_blank" href="../utilidades/visualizar_pdf.php?id=<?php echo $r_g->__GET('id_resolucion');?>">Visualizar</a>
							</td>
						</tr>
					<?php endforeach;?>
				</tbody>
			</table>
		</div>
	</div>

</div>

<!-- Importación del footer -->
<?php require '../secciones/admin/footer.php'; ?>