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

$resultadoNiveles = $nivelDAO->listar_niveles();

//SE CREA UNA CONDICIONAL PARA VALIDAR SI EL BOTON CON NAME "btnGuardar" ESTA RECIBIENDO VALORES, DE SER ASI, SE BUSCARA LOS SIGUIENTES DATOS EN EL SISTEMA
if(isset($_POST['btnGuardar']))
{
    $Instituciones->__SET('cod_modular',   $_POST['CodModular']);
    $Instituciones->__SET('nombre',       $_POST['Nombre']);
    $Instituciones->__GET('id_nivel')->__SET('id_nivel',        $_POST['Nivel']);
    $resultado_Instituciones = $institucionesDAO->Buscar_i_nombres_nivel($Instituciones);
}
?>

<!-- SE COMIENZA A CREAR LA ESTRUCTURA CENTRAL DEL FORMULARIO -->
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <h5 class="text-center title-container">
                <i class="glyphicon glyphicon-search"></i> BUSCAR INSTITUCIÓN
            </h5>
        </div>
        <div class="box-res-add">
            <div class="row">
                <!-- LA FUNCIÓN "htmlspecialchars()" CONVIERTE CARACTERES ESPECIALES A ENTIDADES HTML -->   
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                    <div class="col-md-3 col-lg-3 col-md-3">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon" for="NumDoc">Código Modular</span>    
                                <input class="form-control input-xs" type="text" name="CodModular" id="CodModular" >
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3 col-md-3">
                        <div class="input-group">
                            <span class="input-group-addon" for="NumDoc">Nombre</span>    
                            <input class="form-control input-xs" type="text" name="Nombre" id="Nombre">
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3 col-md-3">
                        <div class="input-group">
                            <span class="input-group-addon">Nivel</span>    
                            <td>
                                <select class="form-control" name="Nivel">
                                    <!-- REALIZA UN RECORRIDO A LA BASE DE DATOS PARA MOSTAR EL REGISTRO DEL CAMPO "nombre_nivel" -->
                                    <?php foreach($resultadoNiveles as $r_g): ?>
                                        <option value="<?php echo $r_g->__GET('id_nivel');?>">
                                          <?php echo $r_g->__GET('nombre_nivel');?>
                                        </option>
                                      <?php endforeach;?>
                                </select>
                            </td>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3 col-md-3">
                        <div class="form-inline">
                         <button class="btn btn-success" name="btnGuardar">Buscar</button>
                     </div>
                 </div>
             </form>  
         </div>
         <br>
         <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Código Modular</th>
                    <th>Nombre</th>
                    <th>Nivel</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <!-- AQUI SE OBTIENE Y SE MUESTRA EN UNA TABLA LOS SIGUIENTES DATOS DE LA INSTITUCION --> 
                <?php if(isset($resultado_Instituciones)):?>
                    <?php foreach($resultado_Instituciones as $r_g): ?>
                        <tr>
                            <td>
                                <?php echo $r_g->__GET('id_institucion');?>
                            </td>
                            <td>
                                <?php echo $r_g->__GET('cod_modular');?>
                            </td>
                            <td>
                                <?php echo $r_g->__GET('nombre');?>
                            </td>
                            <td>
                                <?php echo $r_g->__GET('id_nivel')->__GET('nombre_nivel');?>
                            </td>
                            <td>
                                <a target="_blank" href="editar_institucion.php?id=<?php echo $r_g->__GET('id_institucion');?>" class="btn btn-primary" data-toggle="modal">Editar Institución</a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                <?php endif;?>
            </tbody>
        </table>
    </div>
</div>
</div>

<!-- Importación del footer -->
<?php require '../secciones/admin/footer.php'; ?>