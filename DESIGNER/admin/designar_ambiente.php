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
$usuarios = new Usuario();
$usuarioDAO = new usuarioDAO();

$Ambientes = new Ambiente();
$ambienteDAO = new AmbienteDAO();
$resultado_ambientes = $ambienteDAO->Listar();

$Personas = new Persona();
$PersonaDAO = new PersonaDAO();

$usuariosAmbientes = new Usuario_ambiente();
$usuariosAmbientesDAO = new usuario_ambienteDAO();

$resultadoUsuarioAmbiente = null;

$mensajeFinalS = file_get_contents('../msj/mensaje_general.php');

//SE CREA UNA CONDICIONAL PARA VALIDAR SI EL BOTON CON NAME "btnGuardar" ESTA RECIBIENDO VALORES, DE SER ASI, SE GUARDAN EN EL SISTEMA
if(isset($_POST['btnAgregarUsuario'])){

    $usuariosAmbientes->__GET('id_usuario')->__SET('id_usuario', $_POST['idUsuario']);
    $usuariosAmbientes->__GET('id_ambiente')->__SET('id_ambiente', $_POST['NombreAmbiente']);

    $usuariosAmbientesDAO->Registrar_usuario_ambiente($usuariosAmbientes);
    
    echo $mensajeFinalS;
    DBAccess::rederigir("lista_usuario.php");
}
?>

<!-- SE COMIENZA A CREAR LA ESTRUCTURA CENTRAL DEL FORMULARIO -->
<div class="form-group">
    <h5 class="text-center title-container">
        <i class="glyphicon glyphicon-pencil"></i> DESIGNAR AMBIENTE
    </h5>
</div>
<div class="box-res-add">
    <!-- LA FUNCIÓN "htmlspecialchars()" CONVIERTE CARACTERES ESPECIALES A ENTIDADES HTML -->   
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
        <div class="form-group">
            <br>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon">DNI</span>    
                    <input type="number" class="form-control" name="numeroDeDNI" id="numeroDeDNI">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="button" id="btn-buscar-usuario-persona">Buscar</button>
                    </span>
                </div>
            </div>

            <div class="contenido-persona">
                <div class="form-group col-md-6">
                    <label for="email">Nombres:</label>
                    <input type="text" class="form-control" id="nombresApellidos" disabled>
                    <input type="hidden" class="form-control" name="idPersona" id="idPersona">
                </div>
                <div class="form-group col-md-6">
                    <label for="email">Usuario:</label>
                    <input type="text" class="form-control" id="usuarioPersona" disabled>
                    <input type="hidden" class="form-control" name="idUsuario" id="idUsuario">
                </div>
                <div class="form-group col-md-6">
                    <label>Fecha de Nacimiento:</label>
                    <td><input type="date" class="form-control" id="FechaNacimiento" disabled></td>
                </div>
                <div class="form-group col-md-6">
                    <label>Documento de Identidad:</label>  
                    <td><input type="text" class="form-control" id="Documento" disabled></td>    
                </div>
            </div>

        </div>
        <div class="form-group">
            <label for="email">Lugar de ambiente</label>
            <select class="form-control ambiente-select" name="NombreAmbiente" data-live-search="true">
                <!-- REALIZA UN RECORRIDO A LA BASE DE DATOS PARA MOSTAR EL REGISTRO DEL CAMPO "nombre_ambiente" -->
                <?php foreach($resultado_ambientes as $r_g): ?>
                    <option data-tokens="<?php echo $r_g->__GET('nombre_ambiente');?>" value="<?php echo $r_g->__GET('id_ambiente');?>">
                        <?php echo $r_g->__GET('nombre_ambiente');?>
                    </option>
                <?php endforeach;?>
            </select>
        </div>
        <button type="submit" class="btn btn-success" name="btnAgregarUsuario">
           Designar Ambiente
       </button>
   </form>
</div>

<!-- Importación del footer -->
<?php require '../secciones/admin/footer.php'; ?>