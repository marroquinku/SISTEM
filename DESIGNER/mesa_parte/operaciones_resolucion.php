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

require_once '../../BOL/tipo_rol.php';
require_once '../../DAO/tipo_rolDAO.php';

require_once '../../BOL/area.php';
require_once '../../DAO/areaDAO.php';

//importando header
require '../secciones/mesa_parte/header.php'; 

$usuariosAmbientes = new Usuario_ambiente();
$usuariosAmbientesDAO = new Usuario_ambienteDAO();



?>


<div class="row">

	<h2 class="text-center title-container"><i class="glyphicon glyphicon-floppy-saved"></i> OPCIONES DE MANTENIMIENTO DE PERSONA</h2>

	<br>


	<div class="col-md-4 box-card">
		<div class="card-adm2">
			<div class="col-md-12 red-title" id="titulo-card-admi">
				<center><span>Enviar Resolucion</span></center>
			</div>
			<div class="col-md-12 red-body" id="body-card-admi">
				<div class="col-md-3" id="icon-card-admi">
					<i class="glyphicon glyphicon-envelope"></i>
				</div>
				<div class="col-md-8" id="content-card-admi">
					Esta seccion le permite enviar resoluciones a las diferentes oficinas
				</div>
			</div>
			<div class="col-md-12 red-footer" id="footer-card-admi">
				<div class="col-md-9">
					<a href="enviar_resolucion.php">Realizar mantenimiento</a>
				</div>
				<div class="col-md-3 text-right">
					<i class="glyphicon glyphicon-chevron-right"></i>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-4  box-card">
		<div class="card-adm2">
			<div class="col-md-12 blue-title" id="titulo-card-admi">
				<center><span>Buscar Resoluciones</span></center>
			</div>
			<div class="col-md-12 blue-body" id="body-card-admi">
				<div class="col-md-3" id="icon-card-admi">
					<i class="glyphicon glyphicon-search"></i>
				</div>
				<div class="col-md-8" id="content-card-admi">
					Esta seccion le permite buscar las resoluciones que se encuentren en el sistema
				</div>
			</div>
			<div class="col-md-12 blue-footer" id="footer-card-admi">
				<div class="col-md-9">
					<a href="lista_resolucion.php">Realizar mantenimiento</a>
				</div>
				<div class="col-md-3 text-right">
					<i class="glyphicon glyphicon-chevron-right"></i>
				</div>
			</div>
		</div>
	</div>


</div>


<?php require '../secciones/mesa_parte/footer.php'; ?>