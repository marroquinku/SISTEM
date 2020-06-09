<?php 

//INICIA UNA NUEVA SESIÓN O REANUDA LA ACTUAL 
session_start();

//IMPORTACIÓN DE TODAS LAS CLASES NECESARIAS PARA EL CORRECTO FUNCIONAMIENTO DEL FORMULARIO
//importando el DBacces
require_once '../../DAL/DBAccess.php';
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
$usuariosAmbientesDAO = new Usuario_ambiente();

$Personas = new Persona();
$PersonaDAO = new PersonaDAO();

//SE CREA UNA CONDICIONAL PARA VALIDAR SI EL BOTON CON NAME "btnGuardar" ESTA RECIBIENDO VALORES, DE SER ASI, SE BUSCARA LOS SIGUIENTES DATOS EN EL SISTEMA
if(isset($_POST['btnGuardar']))
{
    $Personas->__SET('documento',         $_POST['documento']);
    $Personas->__SET('nombre',            $_POST['nombre']);
    $Personas->__SET('apellido_paterno',  $_POST['apellidoP']);
    $Personas->__SET('apellido_materno',  $_POST['apellidoM']);
    $resultado_personas = $PersonaDAO->Buscar_p_nombres_apellidos($Personas);
}
?>

<!-- SE COMIENZA A CREAR LA ESTRUCTURA CENTRAL DEL FORMULARIO -->
<div class="row">
    <div class="form-group">
        <h5 class="text-center title-container">
            <i class="glyphicon glyphicon-search"></i> BUSCAR PERSONA
        </h5>
    </div>
    <div class="col-md-12">
        <div class="box-res-add">
            <div class="row">
                <!-- LA FUNCIÓN "htmlspecialchars()" CONVIERTE CARACTERES ESPECIALES A ENTIDADES HTML -->   
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                    <div class="col-md-3 col-lg-3 col-md-3">
                        <div class="input-group">
                            <span class="input-group-addon" for="ProcessNum">DNI</span>    
                            <input type="text" class="form-control" name="documento"  id="Documento">
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3 col-md-3">
                        <div class="input-group">
                            <span class="input-group-addon" for="ProcessNum">Nombres</span>    
                            <input type="text" class="form-control" name="nombre" id="Nombre">
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3 col-md-3">
                        <div class="input-group">
                            <span class="input-group-addon" for="ProcessNum">Apellido Paterno</span>    
                            <input type="text" class="form-control" name="apellidoP" id="ApellidoPaterno">
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3 col-md-3">
                        <div class="input-group">
                            <span class="input-group-addon" for="ProcessNum">Apellido Materno</span>    
                            <input type="text" class="form-control" name="apellidoM" id="ApellidoMaterno">
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3 col-md-3">
                        <div class="form-group">
                            <br>
                            <button class="btn btn-success" name="btnGuardar">Buscar</button>
                        </div>
                    </div>
                </form>  
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Documento</th>
                            <th>Nombre (s)</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Sexo</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- AQUI SE OBTIENE Y SE MUESTRA EN UNA TABLA LOS SIGUIENTES DATOS DE LA PERSONA --> 
                        <?php if(isset($resultado_personas)):?>
                            <?php foreach($resultado_personas as $r_g): ?>
                                <tr>
                                    <td>
                                        <?php echo $r_g->__GET('id_persona');?>
                                    </td>
                                    <td>
                                        <?php echo $r_g->__GET('documento');?>
                                    </td>
                                    <td>
                                        <?php echo $r_g->__GET('nombre');?>
                                    </td>
                                    <td>
                                        <?php echo $r_g->__GET('apellido_paterno');?>
                                    </td>
                                    <td>
                                        <?php echo $r_g->__GET('apellido_materno');?>
                                    </td>
                                    <td>
                                        <?php echo $r_g->__GET('fecha_nacimiento');?>
                                    </td>
                                    <td>
                                        <?php echo $r_g->__GET('sexo');?>
                                    </td>
                                    <td><a href="editar_persona.php?id=<?php echo $r_g->__GET('id_persona');?>" class="btn btn-primary" data-toggle="modal">Editar Persona</a></td>
                                </tr>
                            <?php endforeach;?>
                        <?php endif;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Importación del footer -->
<?php require '../secciones/admin/footer.php'; ?>