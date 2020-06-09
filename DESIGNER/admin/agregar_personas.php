<?php 

//INICIA UNA NUEVA SESIÓN O REANUDA LA ACTUAL 
session_start();
//importando el DBacces
require_once '../../DAL/DBAccess.php';

//IMPORTACIÓN DE TODAS LAS CLASES NECESARIAS PARA EL CORRECTO FUNCIONAMIENTO DEL FORMULARIO
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


require_once '../../BOL/correo.php';
require_once '../../DAO/correoDAO.php';


require_once '../../BOL/telefono.php';
require_once '../../DAO/telefonoDAO.php';

require_once '../../BOL/area.php';
require_once '../../DAO/areaDAO.php';

//importando header
require '../secciones/admin/header.php'; 

//CREACIÓN DE OBJETOS QUE REPRESENTEN A LAS CLASES A UTILIZAR 
$usuariosAmbientes = new Usuario_ambiente();
$usuariosAmbientesDAO = new Usuario_ambiente();

$persona = new Persona();
$personaDAO = new PersonaDAO();

$correo = new Correo();
$correoDAO = new CorreoDAO();

$telefono = new Telefono();
$telefonoDAO = new TelefonoDAO();

$mensajeFinalS = file_get_contents('../msj/mensaje_general.php');

//SE CREA UNA CONDICIONAL PARA VALIDAR SI EL BOTON CON NAME "btnGuardar" ESTA RECIBIENDO VALORES, DE SER ASI, SE GUARDAN EN EL SISTEMA
if(isset($_POST['btnGuardar']))
{
    $persona->__SET('documento',        $_POST['inpDocumento']);
    $persona->__SET('nombre',           $_POST['Nombre']);
    $persona->__SET('apellido_paterno',  $_POST['ApellidoPaterno']);
    $persona->__SET('apellido_materno',  $_POST['ApellidoMaterno']);
    $persona->__SET('fecha_nacimiento',  $_POST['FechaNacimiento']);
    $persona->__SET('sexo',             $_POST['Sexo']);

    //CORREO Y NUMERO NO OBLIGATORIOS
    $correo->__SET('correo',           $_POST['correoPersona']);
    $telefono->__SET('numero',             $_POST['numeroPersona']);

    $personaDAO->Registrar_per($persona,$correo,$telefono);

    echo $mensajeFinalS;
    DBAccess::rederigir("lista_persona.php");
}
?>

<!-- SE COMIENZA A CREAR LA ESTRUCTURA CENTRAL DEL FORMULARIO -->
<div class="row">
	<div class="col-md-6">
        <div class="form-group">
                <h5 class="text-center title-container">
                    <i class="glyphicon glyphicon-user"></i> AGREGAR PERSONA
                </h5>
            </div>
		<div class="box-res-add">
        <!-- LA FUNCIÓN "htmlspecialchars()" CONVIERTE CARACTERES ESPECIALES A ENTIDADES HTML -->   
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data">
			
            <div class="form-group">
            <div class="form-group">
                <label>Tipo de Documento:</label>
            <td><select class="form-control" name="TipoDocumento" id="TipoDocumento">
                                <option id="">Seleccionar tipo de documento</option>
                                <option id="DNI">DNI</option>
                                <option id="CARNET">CARNET DE EXTRANJERIA</option>
                                <option id="PASAPORTE">PASAPORTE</option>     
                </select></td><br>
                <td>
                <input type="text" class="form-control" name="inpDocumento" id="inpDocumento" disabled="">
                </td>    
            </div>	 
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
                <label>Correo Electrónico:</label>
                <td><input type="text" class="form-control" name="correoPersona" id="correoPersona"></td>
                <td><div id="emailOK"></div></td>
            </div>
            <div class="form-group">
                <label>Numero de celular</label>
                <td><input type="text" class="form-control" name="numeroPersona" id="numeroPersona"></td>
            </div>
            <div class="form-group">
				<label>Fecha de Nacimiento:</label>
                <td><input type="date" class="form-control" name="FechaNacimiento" id="FechaNacimiento" max="2002-01-01"></td>
			</div>
            <div class="form-group">
				<label>Sexo:</label>
                <td><select class="form-control" name="Sexo">
                                <option id="M">Masculino</option>
                                <option id="F">Femenino</option>
                </select></td>
			</div>
			
			<button type="submit" class="btn btn-primary" name="btnGuardar" id="btnGuardar">Guardar Persona</button>
		</form>
	</div>
	</div>

</div>

<!-- Importación del footer -->
<?php require '../secciones/admin/footer.php'; ?>