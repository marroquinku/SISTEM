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
$usuariosAmbientesDAO = new Usuario_ambienteDAO();

$usuarios = new Usuario();
$usuarioDAO = new usuarioDAO();

$Ambientes = new Ambiente();
$ambienteDAO = new ambienteDAO();
$resultado_ambientes = $ambienteDAO->Listar();

$Personas = new Persona();
$PersonaDAO = new PersonaDAO();

$mensajeFinalS = file_get_contents('../msj/mensaje_general.php');

//SE CREA UNA CONDICIONAL PARA VALIDAR SI EL BOTON CON NAME "btnAgregarUsuario" ESTA RECIBIENDO VALORES, DE SER ASI, SE GUARDAN EN EL SISTEMA
if(isset($_POST['btnAgregarUsuario'])){
    $usuariosAmbientes->__GET('id_usuario')->__GET('id_persona')->__SET('id_persona', $_POST['idPersona']);
    $usuariosAmbientes->__GET('id_usuario')->__SET('usuario', $_POST['usuarioPersona']);
    $usuariosAmbientes->__GET('id_usuario')->__SET('contrasenia', $_POST['contraseniaPersona']);
    $usuariosAmbientes->__GET('id_usuario')->__SET('estado', $_POST['estadoUsuario']);
    $usuariosAmbientes->__GET('id_ambiente')->__SET('id_ambiente', $_POST['NombreAmbiente']);

    $usuariosAmbientesDAO->Registrar_usuario_ambiente_estado($usuariosAmbientes);

    echo $mensajeFinalS;
    DBAccess::rederigir("lista_usuario.php");

}
?>

<!-- SE COMIENZA A CREAR LA ESTRUCTURA CENTRAL DEL FORMULARIO -->
<div class="row">
    <!-- LA FUNCIÓN "htmlspecialchars()" CONVIERTE CARACTERES ESPECIALES A ENTIDADES HTML -->   
    <form class="col-md-6" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
        <div class="form-group">
            <h5 class="text-center title-container">
                <i class="glyphicon glyphicon-user"></i> AGREGAR USUARIO
            </h5>
        </div>
        <div class="box-res-add">
            <div class="form-group">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">DNI</span>    
                        <input type="number" class="form-control" name="numeroDeDNI" id="numeroDeDNI">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button" id="btn-buscar-persona-ru">Buscar</button>
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
                        <label>Fecha de Nacimiento:</label>
                        <td><input type="date" class="form-control" id="FechaNacimiento" disabled></td>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Documento de Identidad:</label>  
                        <td><input type="text" class="form-control" id="Documento" disabled></td>    
                    </div>
                    <div class="form-group col-md-6">
                        <label>Sexo:</label>
                        <td><input type="text" class="form-control" id="sexo" disabled></td> 
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon" for="email">Nombre del Usurario</span>    
                    <input type="text" class="form-control" name="usuarioPersona">
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon" for="email">Contraseña del Usurario</span>    
                    <input type="text" class="form-control" name="contraseniaPersona">
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon" for="email">Estado</span>    
                    <select class="form-control" name="estadoUsuario">
                        <option value="1">Activo</option>
                        <option value="1">No activo</option>
                    </select>
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
             Agregar Usuario
         </button>
     </form>
 </div>
</div>
</div>

<!-- Importación del footer -->
<?php require '../secciones/admin/footer.php'; ?>