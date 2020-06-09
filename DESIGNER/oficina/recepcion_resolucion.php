<?php 
session_start();

//importando el DBacces
require_once '../../DAL/DBAccess.php';

//SEGURIDAD DE ACCESO DESDE ACA
//importando las clases y los dao
require_once '../../BOL/persona.php';
require_once '../../DAO/personaDAO.php';

//importando las clases y los dao
require_once '../../BOL/tipo_rol.php';
require_once '../../DAO/tipo_rolDAO.php';

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
require_once '../../BOL/estado.php';
require_once '../../DAO/estadoDAO.php';

//importando las clases y los dao
require_once '../../BOL/resolucion.php';
require_once '../../DAO/resolucionDAO.php';

//importando las clases y los dao
require_once '../../BOL/tipo_resolucion.php';
require_once '../../DAO/tipo_resolucionDAO.php';

//importando las clases y los dao
require_once '../../BOL/concepto.php';
require_once '../../DAO/conceptoDAO.php';

//importando las clases y los dao
require_once '../../BOL/buzon_entrada.php';
require_once '../../DAO/buzon_entradaDAO.php';

require_once '../../BOL/area.php';
require_once '../../DAO/areaDAO.php';

require '../secciones/oficina/header.php';

$usuariosAmbientes = new Usuario_ambiente();
$usuariosAmbientesDAO = new Usuario_ambienteDAO();


$buzonDeEntrada = new Buzon_Entrada();
$buzonDeEntradaDAO = new Buzon_EntradaDAO();

$buzonDeEntrada->__GET('id_ambiente')->__SET('id_ambiente', $_SESSION['id_ambiente']);
$resultadBbuzonDeEntrada = $buzonDeEntradaDAO->Listar_buzon_ambiente_pendientes($buzonDeEntrada);

$mensajeFinalS = file_get_contents('../msj/mensaje_general.php');

if(isset($_POST['btnAceptarRes'])){
	$buzonDeEntrada->__SET('id_buzon',$_POST['idBuzon']);
	$buzonDeEntradaDAO->aceptar_resoluciones_pendientes($buzonDeEntrada);
	echo $mensajeFinalS;
	DBAccess::rederigir("buzon_resolucion.php");
}

?>

<div class="col-md-12">
	<div class="box-res-add">
	<h2>Lista de Resoluciones</h2>
	<p>
		Estas son toda las resoluciones que an sido enviado por mesa de partes, por favor recebir y aceptar 
	</p>            
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>N° Buzon</th>
				<th>Número Resolución</th>
				<th>Año Resolución</th>
				<th>Tipo de Resolución</th>
				<th>Concepto Resolución</th>
				<th>Estado Resolución</th>
				<th>Archivo</th>
				<th class="text-center">Acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php if(isset($resultadBbuzonDeEntrada)):?>
				<?php foreach($resultadBbuzonDeEntrada as $r_g): ?>
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
					<tr>
						<td>
							<?php echo $r_g->__GET('id_buzon');?>
						</td>
						<td>
							<?php echo $r_g->__GET('id_resolucion')->__GET('numero');?>
						</td>
						<td>
							<?php echo $r_g->__GET('id_resolucion')->__GET('anio');?>

						</td>
						<td>
							<?php echo $r_g->__GET('id_resolucion')->__GET('id_tipo_resolucion')->__GET('tipo_resolucion');?>
						</td>
						<td>
							<?php echo $r_g->__GET('id_resolucion')->__GET('id_concepto')->__GET('concepto');?>
						</td>
						<td>
							<?php echo $r_g->__GET('id_resolucion')->__GET('id_estado')->__GET('tipo_estado');?>
						</td>
						<td>
							<a target="__blank" href="../utilidades/visualizar_pdf.php?id=<?php echo $r_g->__GET('id_resolucion')->__GET('id_resolucion');?>">
								Ver
							</a>
						</td>
						<td class="text-center">
							<input type="hidden" name="idBuzon" value="<?php echo $r_g->__GET('id_buzon');?>">
							<button class="btn btn-success btn-sm" name="btnAceptarRes">Recibir>></button>
						</td>
					</tr>
				</form>
				<?php endforeach;?>
			<?php endif;?>
		</tbody>
	</table>
</div>
</div>
<?php require '../secciones/oficina/footer.php'; ?>