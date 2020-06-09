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

$resolucion = new Resolucion();
$resolucionDAO = new ResolucionDAO();

//SE CREA UNA CONDICIONAL PARA VALIDAR SI EL BOTON CON NAME "btnBuscar" ESTA RECIBIENDO VALORES, DE SER ASI, SE BUSCARA LOS SIGUIENTES DATOS EN EL SISTEMA
if(isset($_POST['btnBuscar']))
{
	$resolucion->__GET('id_tipo_resolucion')->__SET('id_tipo_resolucion', $_POST['TipoResolucion']);
	$resolucion->__SET('numero', $_POST['numeroResolucion']);
	$resolucion->__SET('anio', $_POST['anioResolucion']);
	$resultado_resolucion = $resolucionDAO->Listar_Resolucion($resolucion);
}
?>

<!-- SE COMIENZA A CREAR LA ESTRUCTURA CENTRAL DEL FORMULARIO -->
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<h5 class="text-center title-container">
				<i class="glyphicon glyphicon-search"></i> BUSCAR RESOLUCIÓN
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
							<label class="control-label" for="NumDoc">Número de resolución</label>
							<!-- AE CREA UNA FUNCION PARA AUTOCOMPLETAR EL CAMPO DE CEROS -->
							<input class="form-control input-sm" type="text" onblur="ponerCeros(this)"  name="numeroResolucion" id="numeroResolucion">
								</td>
								<td>
							<label class="control-label" for="ProcessNum">Tipo de resolución</label>
							<select class="form-control" name="TipoResolucion" id="TipoResolucion">
								<option>Seleccionar</option>
								<!-- REALIZA UN RECORRIDO A LA BASE DE DATOS PARA MOSTAR EL REGISTRO DEL CAMPO "tipo_resolucion" -->
								<?php foreach($resultado_tipoResolucion as $r_g): ?>
									<option value="<?php echo $r_g->__GET('id_tipo_resolucion');?>">
										<?php echo $r_g->__GET('tipo_resolucion');?>
									</option>
								<?php endforeach;?>
							</select>
								</td>
								<td>
									<label class="control-label" for="ProcessNum">Año de resolución &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
							<select name="anioResolucion" class="form-control" id="anioResolucion">
								<option>Seleccionar</option>
								<!-- SE CREA UN BUCLE PARA QUE NOS MUESTRE UNA LISTA DE AÑOS DESDE 1988 HASTA LA ACTUALIDAD --> 
								<?php for($i = 1988 ; $i < date('Y')+1; $i++):?>
									<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
								<?php endfor;?>
							</select>
								</td>
								<td>
									<button class="btn btn-success" name="btnBuscar" style="margin-top: 24px;">Buscar</button>
								</td>
							</thead>
						</table>
					</div>
				</form>  
			</div>
			<br>
			<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>ID</th>
						<th>Tipo de Resolución</th>
						<th>Tipo de Estado</th>
						<th>Usuario</th> 
						<th>Proyecto</th>    
						<th>Concepto</th>                   
						<th>Número</th>
						<th>Fecha de emision</th>
						<th>Año</th>
						<th>Archivo</th>
						<th>Acción</th>
					</tr>
				</thead>
				<tbody>
					<!-- AQUI SE OBTIENE Y SE MUESTRA EN UNA TABLA LOS SIGUIENTES DATOS DE LA RESOLUCION --> 
					<?php if(isset($resultado_resolucion)):?>
						<?php foreach($resultado_resolucion as $r_g): ?>
							<tr>
								<td><?php echo $r_g->__GET('id_resolucion');?></td>
								<td><?php echo $r_g->__GET('tipo_resolucion');?></td>
								<td><?php echo $r_g->__GET('tipo_estado');?></td>
								<td><?php echo $r_g->__GET('usuario');?></td>
								<td><?php echo $r_g->__GET('proyecto');?></td>
								<td><?php echo $r_g->__GET('concepto');?></td>
								<td><?php echo $r_g->__GET('numero');?></td>
								<td><?php echo $r_g->__GET('fecha_emision');?></td>
								<td><?php echo $r_g->__GET('anio');?></td>
								<td>
									<a target="_blank" href="../utilidades/visualizar_pdf.php?id=<?php echo $r_g->__GET('id_resolucion');?>">Visualizar
									</a>
								</td>
								<td>
									<a target="_blank" href="editar_resolucion.php?id=<?php echo $r_g->__GET('id_resolucion');?>" class="btn btn-primary" data-toggle="modal">Editar Resolución</a>
								</td>
							</tr>
						<?php endforeach;?>
					<?php endif;?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>

<!-- Importación del footer -->
<?php require '../secciones/admin/footer.php'; ?>