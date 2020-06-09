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

//importando las clases y los dao
require_once '../../BOL/institucion.php';
require_once '../../DAO/institucionDAO.php';

require_once '../../BOL/tipo_rol.php';
require_once '../../DAO/tipo_rolDAO.php';

require_once '../../BOL/area.php';
require_once '../../DAO/areaDAO.php';

//importando header
require '../secciones/admin/header.php'; 

//CREACIÓN DE OBJETOS QUE REPRESENTEN A LAS CLASES A UTILIZAR 
$usuariosAmbientes = new Usuario_ambiente();
$usuariosAmbientesDAO = new Usuario_ambiente();

$tipo_rol = new Tipo_rol();
$tipo_rolDAO = new Tipo_rolDAO();
$resultado_tipoRol = $tipo_rolDAO->Listar_R();

$ambiente = new Ambiente();
$ambienteDAO = new ambienteDAO();

$area = new Area();
$areaDAO = new AreaDAO();
$resultado_area = $areaDAO->Listar();

$id_ambiente = isset($_GET['id']) ? $_GET['id'] : 0 ;
$ambiente->__SET('id_ambiente',       $id_ambiente);
$resultado_ambiente = $ambienteDAO->Buscar_amb_id($ambiente); 

$mensajeFinalS = file_get_contents('../msj/mensaje_general.php');

//SE CREA UNA CONDICIONAL PARA VALIDAR SI EL BOTON CON NAME "btnGuardar" ESTA RECIBIENDO VALORES, DE SER ASI, SE GUARDAN EN EL SISTEMA
if(isset($_POST['btnGuardar']))
{
    $ambiente->__SET('id_ambiente',        $_POST['id_ambiente']);
    $ambiente->__GET('id_tipo_rol')->__SET('id_tipo_rol', $_POST['tipo_rol']);
    $ambiente->__GET('id_area')->__SET('id_area', $_POST['area']);
    $ambiente->__SET('nombre_ambiente',  $_POST['nombre_ambiente']);

    $ambienteDAO->Modificar_amb($ambiente);

    echo $mensajeFinalS;
    DBAccess::rederigir("lista_ambiente.php");
}
?>
<?php foreach($resultado_ambiente as $r_g): ?>

<!-- SE COMIENZA A CREAR LA ESTRUCTURA CENTRAL DEL FORMULARIO -->
<div class="row">
    <div class="col-md-6">
        <div class="box-res-add">
        <!-- LA FUNCIÓN "htmlspecialchars()" CONVIERTE CARACTERES ESPECIALES A ENTIDADES HTML -->     
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_ambiente" value="<?php echo $r_g->__GET('id_ambiente');?>">
            <div class="form-group">
            <label class="control-label" for="ProcessNum">Tipo de Ambiente</label>  
                <select class="form-control" name="tipo_rol" id="tipo_rol">
                <!-- REALIZA UN RECORRIDO A LA BASE DE DATOS PARA MOSTAR EL REGISTRO DEL CAMPO "tipo_rol" -->
				<?php foreach($resultado_tipoRol as $a_g): ?>
					<?php if($a_g->__GET('id_tipo_rol') == $r_g->__GET('id_tipo_rol')->__GET('id_tipo_rol')):?>
						<option value="<?php echo $a_g->__GET('id_tipo_rol');?>" selected>
                            <?php echo $a_g->__GET('tipo_rol');?>                  
                        </option>
							<?php else:?>
					   <option value="<?php echo $a_g->__GET('id_tipo_rol');?>">
                            <?php echo $a_g->__GET('tipo_rol');?>
                        </option>
					<?php endif;?>
				<?php endforeach;?>
				</select>
            </div>

            <div class="form-group">
                    <label>Area al que le pertenece:</label>
                    <select class="form-control" name="area" id="area">
                    <!-- REALIZA UN RECORRIDO A LA BASE DE DATOS PARA MOSTAR EL REGISTRO DEL CAMPO "nombre_area" -->
                    <?php foreach($resultado_area as $c_g): ?>
                            <?php if($c_g->__GET('id_area') == $r_g->__GET('id_area')->__GET('id_area')):?>
                            <option value="<?php echo $c_g->__GET('id_area');?>" selected><?php echo $c_g->__GET('nombre_area');?></option>
                            <?php else:?>
                                <option value="<?php echo $c_g->__GET('id_area');?>"><?php echo $c_g->__GET('nombre_area');?></option>
                            <?php endif;?>
                    <?php endforeach;?>
                </select>
            </div>

            <div class="form-group">
                <label>Nombre Ambiente:</label>
                <td><input type="text" class="form-control" name="nombre_ambiente" id="nombre_ambiente" value="<?php echo $r_g->__GET('nombre_ambiente');?>"></td>
            </div>
            
            <button type="submit" class="btn btn-primary" name="btnGuardar" id="btnGuardar">Actualizar Ambiente</button>
        </form>
    </div>
    </div>

</div>

<?php endforeach;?>

<!-- Importación del footer -->
<?php require '../secciones/admin/footer.php'; ?>