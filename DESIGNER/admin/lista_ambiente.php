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
require_once '../../BOL/usuario.php';
require_once '../../DAO/usuarioDAO.php';

//SEGURIDAD DE ACCESO DESDE ACA
//importando las clases y los dao
require_once '../../BOL/ambiente.php';
require_once '../../DAO/ambienteDAO.php';

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
$tipo_rol = new Tipo_rol();
$tipo_rolDAO = new Tipo_rolDAO();
$resultado_tipoRol = $tipo_rolDAO->Listar_R();

$ambiente = new Ambiente();
$ambienteDAO = new ambienteDAO();
$mensajeFinalS = file_get_contents('../msj/mensaje_general.php');

//SE CREA UNA CONDICIONAL PARA VALIDAR SI EL BOTON CON NAME "btnGuardar" ESTA RECIBIENDO VALORES, DE SER ASI, SE BUSCARA LOS SIGUIENTES DATOS EN EL SISTEMA
if(isset($_POST['btnGuardar']))
{
	$ambiente->__GET('id_tipo_rol')->__SET('id_tipo_rol', $_POST['tipo_rol']);
	$ambiente->__SET('nombre_ambiente', $_POST['nombre_ambiente']);
    $resultado_ambientes = $ambienteDAO->Buscar_ambientes($ambiente);

    echo $mensajeFinalS;
}
?>

<!-- SE COMIENZA A CREAR LA ESTRUCTURA CENTRAL DEL FORMULARIO -->
<div class="row">
	<div class="col-md-6">		
        <!-- LA FUNCIÓN "htmlspecialchars()" CONVIERTE CARACTERES ESPECIALES A ENTIDADES HTML -->   
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data">		
            <div class="form-group">
                <h5 class="text-center title-container"><i class="glyphicon glyphicon-search"></i> BUSCAR AMBIENTE</h5>
            </div>
            <div class="box-res-add">
                <label>Tipo de ambiente:</label>
                <select class="form-control" name="tipo_rol" id="tipo_rol">
                   <!-- REALIZA UN RECORRIDO A LA BASE DE DATOS PARA MOSTAR EL REGISTRO DEL CAMPO "tipo_rol" -->
                   <?php foreach($resultado_tipoRol as $r_g): ?>
                      <option value="<?php echo $r_g->__GET('id_tipo_rol');?>">
                          <?php echo $r_g->__GET('tipo_rol');?>
                      </option>
                  <?php endforeach;?>
              </select><br>

              <div class="form-group">
                <label>Nombre ambiente:</label>
                <td><input type="text" class="form-control" name="nombre_ambiente" id="nombre_ambiente"></td>
            </div>
            <button type="submit" class="btn btn-primary" name="btnGuardar" id="btnGuardar">Buscar</button>

            <br>
            <br>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Tipo de Rol</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- AQUI SE OBTIENE Y SE MUESTRA EN UNA TABLA LOS SIGUIENTES DATOS DEL AMBIENTE --> 
                    <?php if(isset($resultado_ambientes)):?>
                        <?php foreach($resultado_ambientes as $r_g): ?>
                            <tr>
                               <td>
                                <?php echo $r_g->__GET('id_ambiente');?>
                            </td>
                            <td>
                                <?php echo $r_g->__GET('nombre_ambiente');?>
                            </td>
                            <td>
                                <?php echo $r_g->__GET('id_tipo_rol');?>
                            </td>
                            <td><a href="editar_ambiente.php?id=<?php echo $r_g->__GET('id_ambiente');?>" class="btn btn-primary" data-toggle="modal">Editar Ambiente</a></td>
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