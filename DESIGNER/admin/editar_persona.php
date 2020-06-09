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


require_once '../../BOL/correo.php';
require_once '../../DAO/correoDAO.php';


require_once '../../BOL/telefono.php';
require_once '../../DAO/telefonoDAO.php';

//importando header
require '../secciones/admin/header.php';

//CREACIÓN DE OBJETOS QUE REPRESENTEN A LAS CLASES A UTILIZAR 
$usuariosAmbientes = new Usuario_ambiente();
$usuariosAmbientesDAO = new Usuario_ambiente();

$Personas = new Persona();
$PersonaDAO = new PersonaDAO();

$correo = new Correo();
$correoDAO = new CorreoDAO();


$telefono = new Telefono();
$telefonoDAO = new TelefonoDAO();

$idPersona = isset($_GET['id']) ? $_GET['id'] : 0 ;
$Personas->__SET('id_persona',       $idPersona);

$correo->__GET('id_persona')->__SET('id_persona',       $idPersona);
$resultadoCorreo = $correoDAO->Listar($correo);

$telefono->__GET('id_persona')->__SET('id_persona',       $idPersona);
$resultadoNumero = $telefonoDAO->Listar($telefono);

$resultado_personas = $PersonaDAO->Buscar_p_id($Personas);
$mensajeFinalS = file_get_contents('../msj/mensaje_general.php');

//SE CREA UNA CONDICIONAL PARA VALIDAR SI EL BOTON CON NAME "btnGuardar" ESTA RECIBIENDO VALORES, DE SER ASI, SE GUARDAN EN EL SISTEMA
if(isset($_POST['btnGuardar']))
{
    $Personas->__SET('id_persona',        $_POST['idPersona']);
    $Personas->__SET('documento',        $_POST['Documento']);
    $Personas->__SET('nombre',           $_POST['Nombre']);
    $Personas->__SET('apellido_paterno',  $_POST['ApellidoPaterno']);
    $Personas->__SET('apellido_materno',  $_POST['ApellidoMaterno']);
    $Personas->__SET('fecha_nacimiento',  $_POST['FechaNacimiento']);
    $Personas->__SET('sexo',             $_POST['Sexo']);

    //CORREO Y NUMERO NO OBLIGATORIOS
    $correo->__SET('correo',           $_POST['correoPersona']);
    $telefono->__SET('numero',             $_POST['numeroPersona']);

    $PersonaDAO->Actualizar_persona($Personas,$correo,$telefono);

    echo $mensajeFinalS;
    DBAccess::rederigir("lista_persona.php");
}
?>
<?php foreach($resultado_personas as $r_g): ?>

<!-- SE COMIENZA A CREAR LA ESTRUCTURA CENTRAL DEL FORMULARIO -->
<div class="row">
    <div class="col-md-6">
        <div class="box-res-add">
            <div class="form-group">
                <h5 class="text-center title-container">
                    <i class="glyphicon glyphicon-user"></i> EDITAR PERSONA
                </h5>
            </div>
        <!-- LA FUNCIÓN "htmlspecialchars()" CONVIERTE CARACTERES ESPECIALES A ENTIDADES HTML -->
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data">
            
            <div class="form-group">
                <label>Documento de Identidad:</label>  
                <td><input type="text" class="form-control" name="Documento" id="Documento" value="<?php echo $r_g->__GET('documento');?>"></td>     
            </div>
            <div class="form-group">
                <label>Nombre (s):</label>
                <td><input type="text" class="form-control" name="Nombre" id="Nombre" value="<?php echo $r_g->__GET('nombre');?>"></td>
            </div>
            <div class="form-group">
                <label>Apellido Paterno:</label>
                <td><input type="text" class="form-control" name="ApellidoPaterno" id="ApellidoPaterno" value="<?php echo $r_g->__GET('apellido_paterno');?>"></td>
            </div>
            <div class="form-group">
                <label>Apellido Materno:</label>
                <td><input type="text" class="form-control" name="ApellidoMaterno" id="ApellidoMaterno" value="<?php echo $r_g->__GET('apellido_materno');?>"></td>
            </div>

            <?php foreach ($resultadoCorreo as $r_correo):?>
            <div class="form-group">
                <label>Correo Electrónico:</label>
                <td>
                    <input type="text" class="form-control" name="correoPersona" id="correoPersona" value="<?php echo $r_correo->__GET('correo');?>">
                </td>
                <td><div id="emailOK"></div></td>
            </div>
            <?php endforeach;?>

            <?php foreach ($resultadoNumero as $r_numero):?>
            <div class="form-group">
                <label>Numero de celular</label>
                <td><input type="text" class="form-control" name="numeroPersona" id="numeroPersona" value="<?php echo $r_numero->__GET('numero');?>"></td>
            </div>
            <?php endforeach;?>

            <div class="form-group">
                <label>Fecha de Nacimiento:</label>
                <td><input type="date" class="form-control" name="FechaNacimiento" id="FechaNacimiento" value="<?php echo $r_g->__GET('fecha_nacimiento');?>"></td>
            </div>
            <input type="hidden" name="idPersona" value="<?php echo $r_g->__GET('id_persona');?>">
            <div class="form-group">
                <label>Sexo:</label>
                <td>
                    <select class="form-control" name="Sexo">
                        <option selected id="M">Masculino</option>
                        <option id="F">Femenino</option>
                    </select>
                </td>
            </div>
            
            <button type="submit" class="btn btn-primary" name="btnGuardar" id="btnGuardar">Actualizar Persona</button>
        </form>
    </div>
    </div>

</div>

<?php endforeach;?>

<?php require '../secciones/admin/footer.php'; ?>