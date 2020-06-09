<?php 
session_start();
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

require '../secciones/mesa_parte/header.php';

$usuariosAmbientes = new Usuario_ambiente();
$usuariosAmbientesDAO = new Usuario_ambiente();

$tipoResolucion = new Tipo_resolucion();
$tipoResolucionDAO = new Tipo_resolucionDAO();
$resultado_tipoResolucion = $tipoResolucionDAO->Listar();

$resolucion = new Resolucion();
$resolucionDAO = new ResolucionDAO();

if(isset($_POST['btnBuscar']))
{
	$resolucion->__GET('id_tipo_resolucion')->__SET('idTipoResolucion', $_POST['TipoResolucion']);
	$resolucion->__SET('numero', $_POST['numeroResolucion']);
	$resolucion->__SET('anio', $_POST['anioResolucion']);
	$resultado_resolucion = $resolucionDAO->Listar_Resolucion($resolucion);
}
?>

<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<h5 class="text-center title-container">
				<i class="glyphicon glyphicon-list-alt"></i> LISTA DE RESOLUCIÓN
			</h5>
		</div>
		<div class="box-res-add">
			<div class="row">

				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
					<div class="col-md-3 col-lg-3 col-md-3">
						<div class="form-inline">
							<label class="control-label" for="NumDoc">Numero de RD</label>
							<input class="form-control input-sm" type="text" onblur="ponerCeros(this)"  name="numeroResolucion" id="numeroResolucion">
						</div>
					</div>
					<div class="col-md-3 col-lg-3 col-md-3">
						<div class="form-inline">
							<label class="control-label" for="ProcessNum">Tipo de resolucion</label>
							<select class="form-control" name="TipoResolucion" id="TipoResolucion">
								<option>Seleccionar</option>
								<?php foreach($resultado_tipoResolucion as $r_g): ?>
									<option value="<?php echo $r_g->__GET('id_tipo_resolucion');?>">
										<?php echo $r_g->__GET('tipo_resolucion');?>
									</option>
								<?php endforeach;?>
							</select>
						</div>
					</div>

					<div class="col-md-3 col-lg-3 col-md-3">
						<div class="form-inline">
							<label class="control-label" for="ProcessNum">Año de resolucion &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
							<select name="anioResolucion" class="form-control" id="anioResolucion11">
								<option>Seleccionar</option>
								<?php for($i = 1988 ; $i < date('Y')+1; $i++):?>
									<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
								<?php endfor;?>
							</select>
						</div>
					</div>

					<div class="col-md-3 col-lg-3 col-md-3">
						<div class="form-inline">
							<br>
							<button class="btn btn-success" name="btnBuscar">Buscar</button>
						</div>
					</div>
				</form>  
			</div>
			<br>

			<table class="table table-bordered">
				<thead>
					<tr>
						<th>ID</th>
						<th>Tipo de Resolucion</th>
						<th>Tipo de Estado</th>
						<th>Usuario</th> 
						<th>Proyecto</th>    
						<th>Concepto</th>                   
						<th>Numero</th>
						<th>Año</th>
						<th>Archivo</th>
						<th>Accion</th>
					</tr>
				</thead>
				<tbody>
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
								<td><?php echo $r_g->__GET('anio');?></td>
								<td>
									<a href="../utilidades/visualizar_pdf.php?id=<?php echo $r_g->__GET('id_resolucion');?>">Visualizar
									</a>
								</td>
								<td><a href="editar_resolucion.php?id=<?php echo $r_g->__GET('id_resolucion');?>" class="btn btn-primary" data-toggle="modal">Editar Resolucion</a></td>
							</tr>
						<?php endforeach;?>
					<?php endif;?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php require '../secciones/mesa_parte/footer.php'; ?>