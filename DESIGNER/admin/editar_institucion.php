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

require_once '../../BOL/nivel.php';
require_once '../../DAO/nivelDAO.php';

//importando header
require '../secciones/admin/header.php'; 

//CREACIÓN DE OBJETOS QUE REPRESENTEN A LAS CLASES A UTILIZAR 
$usuariosAmbientes = new Usuario_ambiente();
$usuariosAmbientesDAO = new Usuario_ambiente();

$nivel = new Nivel();
$nivelDAO = new NivelDAO();

$Instituciones = new Institucion();
$institucionesDAO = new institucionDAO();

$id_institucion = isset($_GET['id']) ? $_GET['id'] : 0 ;
$Instituciones->__SET('id_institucion',       $id_institucion);

$resultadoNiveles = $nivelDAO->listar_niveles();
$resultado_institucion = $institucionesDAO->Buscar_i_id($Instituciones); 

$mensajeFinalS = file_get_contents('../msj/mensaje_general.php');

//SE CREA UNA CONDICIONAL PARA VALIDAR SI EL BOTON CON NAME "btnGuardar" ESTA RECIBIENDO VALORES, DE SER ASI, SE GUARDAN EN EL SISTEMA
if(isset($_POST['btnGuardar']))
{
    $Instituciones->__SET('id_institucion',        $_POST['idInstituciones']);
    $Instituciones->__SET('cod_modular',        $_POST['CodModular']);
    $Instituciones->__SET('nombre',           $_POST['Nombre']);
    $Instituciones->__GET('id_nivel')->__SET('id_nivel',  $_POST['Nivel']);

    $institucionesDAO->Actualizar_institucion($Instituciones);

    echo $mensajeFinalS;
    DBAccess::rederigir("lista_institucion.php");

}
?>
<?php foreach($resultado_institucion as $r_g): ?>

<!-- SE COMIENZA A CREAR LA ESTRUCTURA CENTRAL DEL FORMULARIO -->
<div class="row">
    <div class="col-md-6">
        <div class="box-res-add">
        <!-- LA FUNCIÓN "htmlspecialchars()" CONVIERTE CARACTERES ESPECIALES A ENTIDADES HTML -->   
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Codigo Modular:</label>  
                <td><input type="text" class="form-control" name="CodModular" id="CodModular" value="<?php echo $r_g->__GET('cod_modular');?>"></td>     
            </div>

            <div class="form-group">
                <label>Nombre:</label>
                <td><input type="text" class="form-control" name="Nombre" id="Nombre" value="<?php echo $r_g->__GET('nombre');?>"></td>
            </div>

            <input type="hidden" name="idInstituciones" value="<?php echo $r_g->__GET('id_institucion');?>">

            <div class="form-group">
                <label>Nivel:</label>
                <td>
                    <select class="form-control" name="Nivel">
                    <!-- REALIZA UN RECORRIDO A LA BASE DE DATOS PARA MOSTAR EL REGISTRO DEL CAMPO "nombre_nivel" -->
                    <?php foreach($resultadoNiveles as $r_n): ?>
                        <?php if($r_n->__GET('id_nivel') == $r_g->__GET('id_nivel')->__GET('id_nivel')):?>
                            <option value="<?php echo $r_n->__GET('id_nivel');?>" selected>
                                <?php echo $r_n->__GET('nombre_nivel');?>                  
                            </option>
                                <?php else:?>
                           <option value="<?php echo $r_n->__GET('id_nivel');?>">
                                <?php echo $r_n->__GET('nombre_nivel');?>
                            </option>
                        <?php endif;?>
                    <?php endforeach;?>
                    </select>
                </td>
            </div>
            
            <button type="submit" class="btn btn-primary" name="btnGuardar" id="btnGuardar">Actualizar Institucion</button>
        </form>
    </div>
    </div>

</div>
<?php endforeach;?>

<!-- Importación del footer -->
<?php require '../secciones/admin/footer.php'; ?>