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

$idUsuario = isset($_GET['id']) ? $_GET['id'] : 0 ;
$usuarios->__SET('id_usuario',       $idUsuario);

$resultado_usuarios = $usuarioDAO->Buscar_u_id($usuarios);

$mensajeFinalS = file_get_contents('../msj/mensaje_general.php');

//SE CREA UNA CONDICIONAL PARA VALIDAR SI EL BOTON CON NAME "btnGuardar" ESTA RECIBIENDO VALORES, DE SER ASI, SE GUARDAN EN EL SISTEMA
if(isset($_POST['btnGuardar']))
{
    $usuarios->__SET('id_usuario',     $_POST['idUsuario']);
    $usuarios->__SET('usuario',        $_POST['Usuario']);
    $usuarios->__SET('contrasenia',    $_POST['Contrasenia']);

    $usuarioDAO->Actualizar_usuario($usuarios);

    echo $mensajeFinalS;
    DBAccess::rederigir("lista_usuario.php");
}
?>
<?php foreach($resultado_usuarios as $r_g): ?>

<!-- SE COMIENZA A CREAR LA ESTRUCTURA CENTRAL DEL FORMULARIO -->
<div class="row">
    <div class="col-md-6">
        <div class="box-res-add">
        <!-- LA FUNCIÓN "htmlspecialchars()" CONVIERTE CARACTERES ESPECIALES A ENTIDADES HTML -->   
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data">

            <input type="hidden" name="idUsuario" value="<?php echo $r_g->__GET('id_usuario');?>">

            <div class="form-group">
                <label>Usuario:</label>
                <!-- OBTENEMOS EL VALOR DEL CAMPO "usuario" PARA MOSTRARLO EN LA CAJA DE TEXTO -->   
                <td><input type="text" class="form-control" name="Usuario" id="Usuario" value="<?php echo $r_g->__GET('usuario');?>"></td>
            </div>
            
            <div class="form-group">
                <label>Contrasenia</label>  
                <!-- OBTENEMOS EL VALOR DEL CAMPO "contrasenia" PARA MOSTRARLO EN LA CAJA DE TEXTO -->  
                <td><input type="text" class="form-control" name="Contrasenia" id="Contrasenia" value="<?php echo $r_g->__GET('contrasenia');?>"></td>    
            </div>     
            <button type="submit" class="btn btn-primary" name="btnGuardar" id="btnGuardar">Actualizar Usuario</button>

        </form>
    </div>
    </div>

</div>
<?php endforeach;?>

<!-- Importación del footer -->
<?php require '../secciones/admin/footer.php'; ?>