<?php 

//INICIA UNA NUEVA SESIÓN O REANUDA LA ACTUAL 
session_start();

//IMPORTACIÓN DE TODAS LAS CLASES NECESARIAS PARA EL CORRECTO FUNCIONAMIENTO DEL FORMULARIO
//importando el DBacces
require_once '../../DAL/DBAccess.php';

//importando las clases y los dao de usuario
require_once '../../BOL/usuario.php';
require_once '../../DAO/usuarioDAO.php';

//importando las clases y los dao de persona
require_once '../../BOL/persona.php';
require_once '../../DAO/personaDAO.php';

//importando las clases y los dao de ambiente
require_once '../../BOL/ambiente.php';
require_once '../../DAO/ambienteDAO.php';

//importando las clases y los dao de ambiente
require_once '../../BOL/usuario_ambiente.php';
require_once '../../DAO/usuario_ambienteDAO.php';

//importando las clases y los dao de ambiente
require_once '../../BOL/estado.php';
require_once '../../DAO/estadoDAO.php';

//importando las clases y los dao de ambiente
require_once '../../BOL/concepto.php';
require_once '../../DAO/conceptoDAO.php';

//importando las clases y los dao
require_once '../../BOL/tipo_resolucion.php';
require_once '../../DAO/tipo_resolucionDAO.php';

//importando las clases y los dao
require_once '../../BOL/resolucion.php';
require_once '../../DAO/resolucionDAO.php';

//importando las clases y los dao de ambiente
require_once '../../BOL/buzon_entrada.php';
require_once '../../DAO/buzon_entradaDAO.php';

require_once '../../BOL/tipo_rol.php';
require_once '../../DAO/tipo_rolDAO.php';

require_once '../../BOL/area.php';
require_once '../../DAO/areaDAO.php';

//importando header
require '../secciones/mesa_parte/header.php';

//IMPORTAMOS LA CLASE "PHPMailerAutoload" PARA EL ENVIO DE CORREOS
require 'PHPMailer/PHPMailerAutoload.php';

//CREACIÓN DE OBJETOS QUE REPRESENTEN A LAS CLASES A UTILIZAR 
$persona = new Persona();
$personaDAO = new PersonaDAO();

$usuario = new Usuario();
$usuarioDAO = new UsuarioDAO();

$ambiente = new Ambiente();
$ambienteDAO = new AmbienteDAO();

$buzonDeEntrada = new Buzon_Entrada();
$buzonDeEntradaDAO = new Buzon_EntradaDAO();

$usuariosAmbientes = new Usuario_ambiente();
$usuariosAmbientesDAO = new Usuario_ambienteDAO();
$resultado_usuariosAmbientes = $usuariosAmbientesDAO->Listar();

$tipoResolucion = new Tipo_resolucion();
$tipoResolucionDAO = new Tipo_resolucionDAO();
$resultado_tipoResolucion = $tipoResolucionDAO->Listar();

$resolucion = new Resolucion();
$resolucionDAO = new ResolucionDAO();
$resultado_resolucion = $resolucionDAO->Listar_Resolucion_pendiente();

$bodyAs = file_get_contents('msj/card_msj.phtml');
$mensajeFinalS = file_get_contents('msj/mensaje_general.php');
$mensajeFinalW = file_get_contents('msj/mensaje_general_error.php');

$msj = null;
$contador = 0;

//SE CREA UNA CONDICIONAL PARA VALIDAR SI EL BOTON CON NAME "btnGuardar" ESTA RECIBIENDO VALORES, DE SER ASI, SE GUARDAN EN EL SISTEMA
if(isset($_POST['btnGuardar']))
{
	$correos = array();

	if (isset($_POST['CBgroupUsuario'])) {
		foreach($_POST['CBgroupUsuario'] as $key=>$value){

			$chb_array = explode(",",$value);

			$buzonDeEntrada->__GET('id_ambiente')->__SET('id_ambiente', $chb_array[0]);
			$correos[] = $chb_array[1];
			$buzonDeEntrada->__GET('id_estado')->__SET('id_estado', 2);
			$buzonDeEntrada->__GET('id_resolucion')->__SET('id_tipo_resolucion', $_POST['tipoResolucion']);
			$buzonDeEntrada->__GET('id_resolucion')->__SET('anio', $_POST['anioResolucion']);
			$buzonDeEntrada->__GET('id_resolucion')->__SET('numero',  $_POST['numeroResolucion']);
			
			$buzonDeEntradaDAO->Registrar($buzonDeEntrada);
		}

		$resolucion2 = new Resolucion();
		$resolucion2->__SET('anio',  $_POST['anioResolucion']);
		$resolucion2->__SET('numero', $_POST['numeroResolucion']);
		$resolucion2->__SET('id_tipo_resolucion', $_POST['tipoResolucion']);
		$resolucion2->__GET('id_estado')->__SET('id_estado', 2);

		$resolucionDAO->cambiar_estado_resolucion($resolucion2);

	}else{
		echo $mensajeFinalW;
		die();
	}

	$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 
	$hoyFecha = $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;

	$bodyAs = str_replace('{{numero}}', $_POST['numeroResolucion'], $bodyAs);
	$bodyAs = str_replace('{{anio}}', $_POST['anioResolucion'], $bodyAs);
	$bodyAs = str_replace('{{fecha}}', $hoyFecha, $bodyAs);
	$bodyAs = str_replace('{{fecha_emision}}', $_POST['fechaemisionres'], $bodyAs);
	$bodyAs = str_replace('{{nombre}}', $_SESSION['nombreApellidos'], $bodyAs);
	$bodyAs = str_replace('{{tipo_resolucion}}', $_POST['tipoResolucionNombre'], $bodyAs);

	$buzonDeEntradaDAO->EnviarMensage($correos,$bodyAs);
	
	echo $mensajeFinalS;
	DBAccess::rederigir("operaciones_resolucion.php");
}
?>

<!-- SE COMIENZA A CREAR LA ESTRUCTURA CENTRAL DEL FORMULARIO -->
<div class="row">
	<!-- LA FUNCIÓN "htmlspecialchars()" CONVIERTE CARACTERES ESPECIALES A ENTIDADES HTML -->
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
		<div class="col-md-6">
			<div class="form-group">
				<h5 class="text-center title-container">
					<i class="glyphicon glyphicon-paste"></i> DATOS DE LA RESOLUCIÓN
				</h5>
			</div>
			<div class="box-res-add">
				<div class="form-group">
					<label for="email">Número de la Resolución</label>
					<input type="number" class="form-control" name="numeroResolucion" id="numeroResolucion" readonly  style="pointer-events: none;">
				</div>
				<div class="form-group">
					<label>Tipo de resolución</label>
					<select class="form-control" name="tipoResolucion" id="tipoResolucion" style="pointer-events: none;" readonly>
						<!-- REALIZA UN RECORRIDO A LA BASE DE DATOS PARA MOSTAR EL REGISTRO DEL CAMPO "tipo_resolucion" -->
						<?php foreach($resultado_tipoResolucion as $r_g): ?>
							<option value="<?php echo $r_g->__GET('id_tipo_resolucion');?>">
								<?php echo $r_g->__GET('tipo_resolucion');?>
							</option>
						<?php endforeach;?>
					</select>
					<input type="hidden" id="tipoResolucionNombre" name="tipoResolucionNombre" value="">
					<input type="hidden" id="fechaemisionres" name="fechaemisionres" value="">
				</div>
				<div class="form-group">
					<label for="email">Año de la Resolución</label>
					<select name="anioResolucion" class="form-control" id="anioResolucion" readonly  style="pointer-events: none;">
						<!-- SE CREA UN BUCLE PARA QUE NOS MUESTRE UNA LISTA DE AÑOS DESDE 1988 HASTA LA ACTUALIDAD --> 
						<?php for($i = 1988 ; $i < date('Y')+1; $i++):?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php endfor;?>
					</select>
				</div>
			</div>
		</div>
		<div class="col-md-1"></div>
		<div class="col-md-5">
			<div class="form-group">
				<h5 class="text-center title-container">
					<i class="glyphicon glyphicon-list-alt"></i> LISTA DE RESOSULIONES
				</h5>
			</div>
			<div class="lista-res">
				<h4 class="text-center">RESOLUCIONES PENDIENTES</h4>
				<table class="table table-striped" style="margin-bottom: 0px;">
					<thead>
						<tr>
							<th>
								Número
							</th>
							<th>
								Tipo
							</th>
							<th>
								Emisión
							</th>
							<th>
								Año
							</th>
						</tr>
					</thead>
					<tbody class="body-lista-res">
					<!-- AQUI SE OBTIENE Y SE MUESTRA EN UNA TABLA LOS SIGUIENTES DATOS DE LA RESOLUCION --> 
					<?php foreach($resultado_resolucion as $r_g): ?>
						<tr data-numero="<?php echo $r_g->__GET('numero');?>" data-tipores="<?php echo $r_g->__GET('id_tipo_resolucion')->__GET('id_tipo_resolucion');?>" data-aniores="<?php echo $r_g->__GET('anio');?>" data-fechaemision="<?php echo $r_g->__GET('fecha_emision');?>">
							<td>
								<?php echo $r_g->__GET('numero');?> 
							</td>
							<td>
								<?php echo $r_g->__GET('id_tipo_resolucion')->__GET('tipo_resolucion');?>
							</td>
							<td>
								<?php echo $r_g->__GET('fecha_emision');?> 
							</td>
							<td>
								<?php echo $r_g->__GET('anio');?> 
							</td>
						</tr>
					<?php endforeach;?>
					</tbody>
				</table>
			</div>
		</div>
		<br>
		<div class="col-md-12">
			<div class="box-res-add">        
				<div class="table-responsive">

			<div class="form-group">
				<h5 class="text-center title-container">
					<i class="glyphicon glyphicon-list-alt"></i> LISTA DE PERSONAS
				</h5>
			</div>

				<div class="table-responsive">
					<table class="table table-bordered ">
						<thead>
							<tr>
								<th class="col-md-1">Seleccionar</th>
								<th>Nombre de usuario</th>
								<th>Ambiente</th>
							</tr>
						</thead>
						<tbody>
							<!-- SE MUESTRA LA LISTA DE PERSONAS, MENCIONANDO SU USUARIO Y AMBIENTE -->
							<?php foreach($resultado_usuariosAmbientes as $r_g): ?>
								<tr>
									<td class="col-md-1 text-center">
										<input class="myinput large" type="checkbox" value="<?php echo $r_g->__GET('id_ambiente')->__GET('id_ambiente').",".$r_g->__GET('id_usuario')->__GET('usuario');?>" name="CBgroupUsuario[]">
									</td>
									<td><?php echo $r_g->__GET('id_usuario')->__GET('usuario');?></td>
									<td><?php echo $r_g->__GET('id_ambiente')->__GET('nombre_ambiente');?></td>
								</tr>
							<?php endforeach;?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<button type="submit" class="btn btn-success" name="btnGuardar">Enviar</button>
		</div>
	</form>
</div>

<!-- Importación del footer -->
<?php require '../secciones/mesa_parte/footer.php'; ?>