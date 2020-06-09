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
require_once '../../DAO/estadoDAO.php';

require_once '../../BOL/tipo_rol.php';
require_once '../../DAO/tipo_rolDAO.php';

require_once '../../BOL/area.php';
require_once '../../DAO/areaDAO.php';

//CREACIÓN DE OBJETOS QUE REPRESENTEN A LAS CLASES A UTILIZAR 
$usuariosAmbientes = new Usuario_ambiente();
$usuariosAmbientesDAO = new Usuario_ambiente();

$tipoResolucion = new Tipo_resolucion();
$tipoResolucionDAO = new Tipo_resolucionDAO();
$resultado_tipoResolucion = $tipoResolucionDAO->Listar();

$concepto = new Concepto();
$conceptoDAO = new ConceptoDAO();
$resultado_concepto = $conceptoDAO->Listar();

$estado = new Estado();
$estadoDAO = new EstadoDAO();
$resultado_estado = $estadoDAO->Listar();

$resolucion = new Resolucion();
$resolucionDAO = new ResolucionDAO();

$idResolucion = isset($_GET['id']) ? $_GET['id'] : 0 ;
$resolucion->__SET('id_resolucion',       $idResolucion);

$resultado_resolucion = $resolucionDAO->Listar_Resolucion_Id($resolucion);
$mensajeFinalS = file_get_contents('../msj/mensaje_general.php');

//SE CREA UNA CONDICIONAL PARA VALIDAR SI EL BOTON CON NAME "btnGuardar" ESTA RECIBIENDO VALORES, DE SER ASI, SE GUARDAN LOS NUEVOS VALORES EN EL SISTEMA
if(isset($_POST['btnGuardar']))
{
	$resolucion->__SET('id_resolucion',        $_POST['id_resolucion']);
    $resolucion->__GET('id_tipo_resolucion')->__SET('id_tipo_resolucion', $_POST['tipoResolucion']);
    $resolucion->__SET('anio',  $_POST['anioResolucion']);
    $resolucion->__SET('numero',  $_POST['numeroResolucion']);
    $resolucion->__GET('id_concepto')->__SET('id_concepto',  $_POST['conceptoResolucion']);
    $resolucion->__SET('proyecto',  $_POST['proyectoResolucion']);
    $resolucion->__GET('id_estado')->__SET('id_estado',        $_POST['estadoResolucion']);
    $resolucion->__GET('id_usuario_ambiente')->__SET('id_usuario_ambiente',           $_SESSION['id_usuario_ambiente']);

    //var_dump($_POST);
    $resolucionDAO->Actualizar_resolucion($resolucion);

    echo $mensajeFinalS;

}

?>
<?php foreach($resultado_resolucion as $r_c): ?>

<div class="row">
	<div class="col-md-6">
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label>Estado:</label>
				 <select class="form-control" name="estadoResolucion" id="estadoResolucion">
					<?php foreach($resultado_estado as $r_g): ?>
							<?php if($r_g->__GET('id_estado') == $r_c->__GET('id_estado')->__GET('id_estado')):?>
							<option value="<?php echo $r_g->__GET('id_estado');?>" selected><?php echo $r_g->__GET('tipo_estado');?></option>
							<?php else:?>
								<option value="<?php echo $r_g->__GET('id_estado');?>"><?php echo $r_g->__GET('tipo_estado');?></option>
							<?php endif;?>
					<?php endforeach;?>
				</select>
				<br>
			</div>
			<div class="form-group">
				<label>Tipo de resolucion</label>
				<select class="form-control" name="tipoResolucion" id="tipoResolucion">
					<?php foreach($resultado_tipoResolucion as $r_g): ?>
							<?php if($r_g->__GET('id_tipo_resolucion') == $r_c->__GET('id_tipo_resolucion')->__GET('id_tipo_resolucion')):?>
							<option value="<?php echo $r_g->__GET('id_tipo_resolucion');?>" selected><?php echo $r_g->__GET('tipo_resolucion');?></option>
							<?php else:?>
								<option value="<?php echo $r_g->__GET('id_tipo_resolucion');?>"><?php echo $r_g->__GET('tipo_resolucion');?></option>
							<?php endif;?>
					<?php endforeach;?>
				</select>
				<input type="hidden" name="id_resolucion" value="<?php echo $r_c->__GET('id_resolucion');?>">
			</div>
			<div class="form-group">
				<label>Año:</label>
				<select name="anioResolucion" class="form-control" id="anioResolucion">
					<?php for($i = 1988 ; $i < date('Y')+1; $i++):?>
						<?php if($i == $r_c->__GET('anio')):?>
							<option value="<?php echo $i; ?>" selected><?php echo $i; ?></option>
						<?php else:?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php endif;?>
					<?php endfor;?>
				</select>
				<!--<input type="text" class="form-control" name="anioResolucion">-->
			</div>
			<div class="form-group">
				<label>Numero:</label>
				 <div class="input-group"> 
					<input type="number" class="form-control" onblur="ponerCeros(this)" name="numeroResolucion" id="numeroResolucion" value="<?php echo $r_c->__GET('numero');?>">
				 </div>
				<br>
			</div>
			<div class="form-group">
				<label>Concepto</label>
				<select class="form-control" name="conceptoResolucion" id="conceptoResolucion">
					<?php foreach($resultado_concepto as $r_g): ?>
						<?php if($r_g->__GET('id_concepto') == $r_c->__GET('id_concepto')->__GET('id_concepto')):?>
							<option value="<?php echo $r_g->__GET('id_concepto');?>" selected>
								<?php echo $r_g->__GET('concepto');?>
							</option>
						<?php else:?>
							<option value="<?php echo $r_g->__GET('id_concepto');?>">
								<?php echo $r_g->__GET('concepto');?>
							</option>	
						<?php endif;?>
					<?php endforeach;?>
				</select>
			</div>
			<div class="form-group">
				<label>Proyecto:</label>
				 <div class="input-group"> 
					<input type="number" class="form-control" name="proyectoResolucion" value="<?php echo $r_c->__GET('proyecto');?>">
				 </div>
			</div>
			<div class="form-group">
				<label>Resolucion</label>
				<input id="subirResolucion" type="file" class="filestyle" name="fileResolucion" data-placeholder="<?php echo $r_c->__GET('numero').".pdf";?>" accept="application/pdf">
			</div>

		    <button type="submit" class="btn btn-primary" name="btnGuardar">Editar Resolucion</button>
		</form>
	</div>
</div>
<?php endforeach;?>

<?php require '../secciones/mesa_parte/footer.php'; ?>