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

//importando header
require '../secciones/admin/header.php'; 

//CREACIÓN DE OBJETOS QUE REPRESENTEN A LAS CLASES A UTILIZAR 
$usuariosAmbientes = new Usuario_ambiente();
$usuariosAmbientesDAO = new Usuario_ambiente();
?>

<!-- SE COMIENZA A CREAR LA ESTRUCTURA CENTRAL DEL FORMULARIO -->
<div class="row">

	<h2 class="text-center title-container"><i class="glyphicon glyphicon-floppy-saved"></i> OPCIONES DE OPERACIONES DE RESOLUCIÓN</h2>

	<br>

	<!-- SE CREAN TODAS LAS OPCIONES QUE TENDRA EL MODULO RESOLUCION -->

    <!-- OPCION ENVIAR RESOLUCION -->
	<div class="col-md-4 box-card">
		<div class="card-adm2">
			<div class="col-md-12 red-title" id="titulo-card-admi">
				<center><span>Enviar Resolución</span></center>
			</div>
			<div class="col-md-12 red-body" id="body-card-admi">
				<div class="col-md-3" id="icon-card-admi">
					<i class="glyphicon glyphicon-paste"></i>
				</div>
				<div class="col-md-8" id="content-card-admi">
					Esta sección le permite enviar la resolución al resto de áreas
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

	<!-- OPCION REPORTES RESOLUCION -->
	<div class="col-md-4 box-card">
		<div class="card-adm2">
			<div class="col-md-12 red-title" id="titulo-card-admi">
				<center><span>Reportes Resolución</span></center>
			</div>
			<div class="col-md-12 red-body" id="body-card-admi">
				<div class="col-md-3" id="icon-card-admi">
					<i class="glyphicon glyphicon-paste"></i>
				</div>
				<div class="col-md-8" id="content-card-admi">
					Esta sección le permite generar reportes de toda las resoluciones enviadas a las diferetes areas de la ugel
				</div>
			</div>
			<div class="col-md-12 red-footer" id="footer-card-admi">
				<div class="col-md-9">
					<a href="reporte_resolucion_enviadas.php">Realizar mantenimiento</a>
				</div>
				<div class="col-md-3 text-right">
					<i class="glyphicon glyphicon-chevron-right"></i>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Importación del footer -->
<?php require '../secciones/admin/footer.php'; ?>