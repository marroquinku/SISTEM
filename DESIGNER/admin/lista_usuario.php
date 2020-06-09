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
$persona = new Persona();
$personaDAO = new PersonaDAO();

$usuario = new Usuario();
$usuarioDAO = new usuarioDAO();

//SE CREA UNA CONDICIONAL PARA VALIDAR SI EL BOTON CON NAME "btnGuardar" ESTA RECIBIENDO VALORES, DE SER ASI, SE BUSCARA LOS SIGUIENTES DATOS EN EL SISTEMA
if(isset($_POST['btnGuardar']))
{

    $usuario->__GET('id_persona')->__SET('documento',  $_POST['documento']);
    $usuario->__GET('id_persona')->__SET('nombre',  $_POST['nombre']);

    $resultado_usuarios = $usuarioDAO->Buscar_usuarios($usuario);
}
?>

<!-- SE COMIENZA A CREAR LA ESTRUCTURA CENTRAL DEL FORMULARIO -->
<div class="row">
	<div class="col-md-10">	
        <!-- REALIZA UN RECORRIDO A LA BASE DE DATOS PARA MOSTAR EL REGISTRO DEL CAMPO "tipo_rol" -->
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <h5 class="text-center title-container"><i class="glyphicon glyphicon-search"></i> BUSCAR USUARIO</h5>
            </div>
            <div class="box-res-add">
                <div class="form-group">
                    <label>Documento:</label>
                    <td><input type="text" class="form-control" name="documento" id="Documento"></td>
                </div> 
                <div class="form-group">
                    <label>Nombres:</label>
                    <td><input type="text" class="form-control" name="nombre" id="Nombre"></td>
                </div>
                <button type="submit" class="btn btn-primary" name="btnGuardar" id="btnGuardar">Buscar</button>
                <br>
                <br>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Documento</th>
                            <th>Nombre</th>
                            <th>ApellidoP</th>
                            <th>ApellidoM</th>
                            <th>Usuario</th>
                            <th>Contraseña</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- AQUI SE OBTIENE Y SE MUESTRA EN UNA TABLA LOS SIGUIENTES DATOS DEL USUARIO --> 
                        <?php if(isset($resultado_usuarios)):?>
                            <?php foreach($resultado_usuarios as $r_g): ?>
                                <tr>
                                    <td>
                                        <?php echo $r_g->__GET('id_usuario');?>
                                    </td> 
                                    <td>
                                        <?php echo $r_g->__GET('id_persona')->__GET('documento');?>
                                    </td>
                                    <td>
                                        <?php echo $r_g->__GET('id_persona')->__GET('nombre');?>
                                    </td>
                                    <td>
                                        <?php echo $r_g->__GET('id_persona')->__GET('apellido_paterno');?>
                                    </td>
                                    <td>
                                        <?php echo $r_g->__GET('id_persona')->__GET('apellido_materno');?>
                                    </td>
                                    <td>
                                        <?php echo $r_g->__GET('usuario');?>
                                    </td>
                                    <td>
                                        <?php echo $r_g->__GET('contrasenia');?>
                                    </td>
                                    <td><a href="editar_usuario.php?id=<?php echo $r_g->__GET('id_usuario');?>" class="btn btn-primary" data-toggle="modal">Editar Usuario</a></td>
                                </tr>
                            <?php endforeach;?>
                        <?php endif;?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

<!-- Importación del footer -->
<?php require '../secciones/admin/footer.php'; ?>