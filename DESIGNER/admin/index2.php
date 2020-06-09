<?php 

//INICIA UNA NUEVA SESIÓN O REANUDA LA ACTUAL 
session_start();

//IMPORTACIÓN DE TODAS LAS CLASES NECESARIAS PARA EL CORRECTO FUNCIONAMIENTO DEL FORMULARIO
//importando el DBacces
require_once '../../DAL/DBAccess.php';
//importando header
require '../secciones/admin/header.php';

//importando las clases y los dao
require_once '../../BOL/tipo_resolucion.php';
require_once '../../DAO/tipo_resolucionDAO.php';

//importando las clases y los dao
require_once '../../BOL/resolucion.php';
require_once '../../DAO/resolucionDAO.php';

require_once '../../BOL/estado.php';
require_once '../../BOL/usuario_ambiente.php';
require_once '../../BOL/usuario.php';
require_once '../../BOL/persona.php';
require_once '../../BOL/ambiente.php';

//CREACIÓN DE OBJETOS QUE REPRESENTEN A LAS CLASES A UTILIZAR 
$tipoResolucion = new TipoResolucion();
$tipoResolucionDAO = new TipoResolucionDAO();
$resultado_tipoResolucion = $tipoResolucionDAO->Listar();

$resolucion = new Resoluciones();
$resolucionDAO = new resolucionDAO();
$resultado_resolucion = $resolucionDAO->Listar();

//SE CREA UNA CONDICIONAL PARA VALIDAR SI EL BOTON CON NAME "btnGuardar" ESTA RECIBIENDO VALORES, DE SER ASI, SE GUARDAN EN EL SISTEMA
if(isset($_POST['btnGuardar']))
{
	$resolucion->__GET('idTipoResolucion')->__SET('idTipoResolucion', $_POST['tipoResolucion']);
	$resolucion->__SET('idEstados', 1);
	$resolucion->__SET('idUsuariosAmbientes', 1);
	$resolucion->__SET('Numero', $_POST['numeroResolucion']);
	$resolucion->__SET('Anio', $_POST['anioResolucion']);
	$resolucion->__SET('Archivo', realpath($_FILES["fileResolucion"]["tmp_name"]));
	$resolucionDAO->Registrar($resolucion);

	header("Refresh:0");
}
?>

<!-- SE COMIENZA A CREAR LA ESTRUCTURA CENTRAL DEL FORMULARIO -->
<div class="row">
	<div class="col-md-6">
		<!-- LA FUNCIÓN "htmlspecialchars()" CONVIERTE CARACTERES ESPECIALES A ENTIDADES HTML -->	
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label>Tipo de resolucion</label>
				<select class="form-control" name="tipoResolucion" id="tipoResolucion">
					<!-- REALIZA UN RECORRIDO A LA BASE DE DATOS PARA MOSTAR EL REGISTRO DEL CAMPO "TipoResolucion" -->
					<?php foreach($resultado_tipoResolucion as $r_g): ?>
						<option value="<?php echo $r_g->__GET('idTipoResolucion');?>">
							<?php echo $r_g->__GET('TipoResolucion');?>
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
				</select>C
			</div>
			<div class="form-group">
				<label>Numero:</label>
				 <div class="input-group"> 
					<input type="number" class="form-control" name="numeroResolucion" id="numeroResolucion">
					<span class="input-group-btn">
				    	<button class="btn btn-primary" type="button" id="btn-verificar">Verificar</button>
				 	</span>
				 </div>
				<br>
				<div class="alert alert-danger collapse" id="alerta-resolucion">
				  <strong>Peligro!</strong> El numero de la resolucion que desea ingresar ya existe !!!
				</div>
				<div class="alert alert-success collapse" id="alerta-resolucion2">
				  <strong>Correcto!</strong> Puede subir esta resolucion
				</div>
			</div>
			<div class="form-group">
				<label>Resolucion</label>
				<input id="subirResolucion" type="file" class="filestyle" name="fileResolucion">
			</div>
			<button type="submit" class="btn btn-primary" name="btnGuardar" id="btnGuardarRes" disabled>Subir Resolucion</button>
			<a class="btn btn-warning"  id="btnResetearRes">Resetear</a>
		</form>
	</div>

	<div class="col-md-12">
		<h2>Lista de resoluciones</h2>
		<p>Resoluciones subidas por el momento</p> 
		<br>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Numero</th>
					<th>Año</th>
					<th>Archivo</th>
				</tr>
			</thead>
			<tbody>
				<!-- AQUI SE OBTIENE Y SE MUESTRA EN UNA TABLA LOS SIGUIENTES DATOS DE LA RESOLUCION --> 
				<?php foreach($resultado_resolucion as $r_g): ?>
					<tr>
						<td><?php echo $r_g->__GET('Numero');?></td>
						<td><?php echo $r_g->__GET('Anio');?></td>
						<td><a href="../utilidades/visualizar_pdf.php?id=<?php echo $r_g->__GET('idResoluciones');?>">Visualizar</a></td>
					</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	</div>

</div>

<!-- Importación del footer -->
<?php require '../secciones/admin/footer.php'; ?>