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

$buzonDeEntrada->__GET('id_ambiente')->__SET('id_ambiente',	$_SESSION['id_ambiente']);
$resultadBbuzonDeEntrada = $buzonDeEntradaDAO->Listar_buzon_ambiente_aceptados_todo($buzonDeEntrada);


if(isset($_POST['btnBuscar'])){
	$buzonDeEntrada->__GET('id_ambiente')->__SET('id_ambiente',	$_SESSION['id_ambiente']);
	$buzonDeEntrada->__GET('id_resolucion')->__SET('numero', 	$_POST['numeroResolucion']);
	$buzonDeEntrada->__GET('id_resolucion')->__SET('anio',	$_POST['anioResolucion']);
	$resultadBbuzonDeEntrada = $buzonDeEntradaDAO->Listar_buzon_ambiente_aceptados($buzonDeEntrada);
}

?>
	<div class="box-res-add">
		<div class="row"> 
			<h2>Buzon de entrada</h2>
			<p>Lista de toda las Resoluciones aprobadas previamente</p>  
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">

			<div class="col-md-3 col-lg-3 col-md-3">
				<div class="form-inline">
					<label class="control-label" for="NumDoc">Nº RD: </label>
					<input class="form-control input-sm" type="text" onblur="ponerCeros(this)" name="numeroResolucion" id="numeroResolucion">
				</div>
			</div>
			<div class="col-md-3 col-lg-3 col-md-3">
				<div class="form-inline">
					<label class="control-label" for="ProcessNum">Nº Año: </label>
					<select name="anioResolucion" class="form-control" id="anioResolucion">
						<?php for($i = 1988 ; $i < date('Y')+1; $i++):?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php endfor;?>
					</select>
				</div>
			</div>
			<div class="col-md-3 col-lg-3 col-md-3">
				<div class="form-inline">
					<button class="btn btn-success" name="btnBuscar">Buscar</button>
				</div>
			</div>
		</form> 
		</div> 
	</div>
	<br>
	<table class="table table-bordered col-md-12">
		<thead>
			<tr>
				<th>N° Buzon</th>
				<th>Número Resolución</th>
				<th>Año Resolución</th>
				<th>Tipo de Resolución</th>
				<th>Concepto Resolución</th>
				<th>Estado Resolución</th>
				<th>Archivo</th>
			</tr>
		</thead>
		<tbody>
			<?php if(isset($resultadBbuzonDeEntrada)):?>
				<?php foreach($resultadBbuzonDeEntrada as $r_g): ?>
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
							<a target="_blank" href="../utilidades/visualizar_pdf.php?id=<?php echo $r_g->__GET('id_resolucion')->__GET('id_resolucion');?>">
								Ver
							</a>
						</td>
					</tr>
				<?php endforeach;?>
			<?php endif;?>
		</tbody>
	</table>

<?php require '../secciones/oficina/footer.php'; ?>