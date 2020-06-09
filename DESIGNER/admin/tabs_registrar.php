<?php 
//importando header
require '../secciones/admin/header.php'; 

//IMPORTACIÓN DE TODAS LAS CLASES NECESARIAS PARA EL CORRECTO FUNCIONAMIENTO DEL FORMULARIO
//importando el DBacces
require_once '../../DAL/DBAccess.php';
require_once '../../BOL/usuario_ambiente.php';
require_once '../../DAO/usuario_ambienteDAO.php';

//importando las clases y los dao
require_once '../../BOL/institucion.php';
require_once '../../DAO/institucionDAO.php';

//importando las clases y los dao
require_once '../../BOL/ambiente.php';
require_once '../../DAO/ambienteDAO.php';

require_once '../../BOL/tipo_rol.php';
require_once '../../DAO/tipo_rolDAO.php';

//CREACIÓN DE OBJETOS QUE REPRESENTEN A LAS CLASES A UTILIZAR 
$Instituciones = new Instituciones();
$institucionesDAO = new institucionesDAO();
$resultado_institucion = $institucionesDAO->Listar_institucion();

$Ambientes = new Ambientes();
$ambienteDAO = new ambienteDAO();
$resultado_ambientes = $ambienteDAO->Listar();

//SE CREA UNA CONDICIONAL PARA VALIDAR SI EL BOTON CON NAME "btnGuardar" ESTA RECIBIENDO VALORES, DE SER ASI, SE INGRESA EN EL SISTEMA
if(isset($_POST['btnGuardar']))
{
    $Instituciones->__SET('CodModular',  $_POST['CodModular']);
    $Instituciones->__SET('Nombre',      $_POST['Nombre']);
    $Instituciones->__SET('Nivel',  $_POST['Nivel']);

    $institucionesDAO->Registrar_Institucion($Instituciones);

	header("Refresh:0");
}
?>

<!-- SE COMIENZA A CREAR LA ESTRUCTURA CENTRAL DEL FORMULARIO -->
<div class="row">
	<div class="col-md-6">
		<!-- LA FUNCIÓN "htmlspecialchars()" CONVIERTE CARACTERES ESPECIALES A ENTIDADES HTML -->
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data">

        <!--LISTA TAB-->	
            <ul class="nav nav-tabs">
                <li class="active"><a href="#per_usu" data-toggle="tab">Crear Persona-Usuario</a></li>
                <li><a href="#per_ins" data-toggle="tab">Crear Persona-Institucion</a></li>
            </ul>

        <!--CONTENEDOR PRINCIPAL-->    
            <div class="tab-content">
                <div class="tab-pane fade in active" id="per_usu">
                    <!--CAMPOS PERSONAS Y USUARIOS--> 
                    <div class="form-group">
		        		<label>Documento de Identidad:</label>	
                        <td><input type="text" class="form-control" name="Documento" id="Documento"></td>	 
			        </div>
                   <div class="form-group">
				        <label>Nombre (s):</label>
                        <td><input type="text" class="form-control" name="Nombre" id="Nombre"></td>
			        </div>
                    <div class="form-group">
				        <label>Apellido Paterno:</label>
                        <td><input type="text" class="form-control" name="ApellidoPaterno" id="ApellidoPaterno"></td>
			        </div>
                    <div class="form-group">
				        <label>Apellido Materno:</label>
                        <td><input type="text" class="form-control" name="ApellidoMaterno" id="ApellidoMaterno"></td>
			        </div>
                    <div class="form-group">
				        <label>Fecha de Nacimiento:</label>
                        <td><input type="date" class="form-control" name="FechaNacimiento" id="FechaNacimiento"></td>
			        </div>
                    <div class="form-group">
				        <label>Sexo:</label>
                            <td><select class="form-control" name="Sexo">
                                <option>-----------</option>
                                <option id="M">Masculino</option>
                                <option id="F">Femenino</option>
                            </select></td>
			        </div>
                    <div class="form-group">
		                <label for="email">Nombre del Usurario</label>
		                <input type="text" class="form-control">
	                </div>
                	<div class="form-group">
	                	<label for="email">Contraseña del Usurario</label>
	                	<input type="password" class="form-control">
	                </div>
	                <div class="form-group">
	                	<label for="email">Lugar de ambiente</label>
	                	<select class="form-control" name="NombreAmbiente">
	                		<!-- REALIZA UN RECORRIDO A LA BASE DE DATOS PARA MOSTAR EL REGISTRO DEL CAMPO "NombreAmbiente" -->
		            	    <?php foreach($resultado_ambientes as $r_g): ?>
			                	<option value="<?php echo $r_g->__GET('idAmbientes');?>">
					        <?php echo $r_g->__GET('NombreAmbiente');?>
				                </option>
			                <?php endforeach;?>
	                	</select>
	                </div>
                        <button type="submit" class="btn btn-primary" name="btnGuardar" id="btnGuardar">Guardar Persona</button></form>
	            </div>     
        </div>
                <div class="tab-pane fade" id="per_ins">
                
                </div>
            </div>

	</div>

<!--TOTAL DE INSTITUCIONES REGISTRADOS EN LA BASE DE DATOS-->
	<div class="col-md-12">
		<h2>Lista de Usuarios</h2>
		<p>Usuarios subidos por el momento</p> 
		<br>
		<table class="table table-bordered">
			<thead>
				<tr>
                    <th>ID</th>
					<th>Documento de Identidad</th>
					<th>Nombre</th>
					<th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Sexo</th>
                    <th>Nombre del Usurario</th>
                    <th>Contraseña del Usurario</th> 
                    <th>Ambiente</th>                                                                                                   
				</tr>
			</thead>
			<tbody>
				<!-- AQUI SE OBTIENE Y SE MUESTRA EN UNA TABLA LOS SIGUIENTES DATOS DE LA PERSONA --> 
				<?php foreach($resultado_institucion as $r_g): ?>
					<tr>
						<td><?php echo $r_g->__GET('idInstituciones');?></td>
						<td><?php echo $r_g->__GET('Documento');?></td>
                        <td><?php echo $r_g->__GET('Nombre');?></td>
						<td><?php echo $r_g->__GET('ApellidoPaterno');?></td>
                        <td><?php echo $r_g->__GET('idInstituciones');?></td>
						<td><?php echo $r_g->__GET('Documento');?></td>
                        <td><?php echo $r_g->__GET('Nombre');?></td>
						<td><?php echo $r_g->__GET('ApellidoPaterno');?></td>

					</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	</div>
</div>

<!-- Importación del footer -->
<?php require '../secciones/admin/footer.php'; ?>