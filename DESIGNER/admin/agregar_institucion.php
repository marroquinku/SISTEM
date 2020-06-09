<?php 

//INICIA UNA NUEVA SESIÓN O REANUDA LA ACTUAL 
session_start();

//IMPORTACIÓN DE TODAS LAS CLASES NECESARIAS PARA EL CORRECTO FUNCIONAMIENTO DEL FORMULARIO
//importando el DBacces Proyecto AGAR
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
$institucionesDAO = new InstitucionDAO();

$resultadoNiveles = $nivelDAO->listar_niveles();

$mensajeFinalS = file_get_contents('../msj/mensaje_general.php');

//SE CREA UNA CONDICIONAL PARA VALIDAR SI EL BOTON CON NAME "btnGuardar" ESTA RECIBIENDO VALORES, DE SER ASI, SE GUARDAN EN EL SISTEMA
if(isset($_POST['btnGuardar']))
{
    $Instituciones->__SET('cod_modular',  $_POST['CodModular']);
    $Instituciones->__SET('nombre',      $_POST['Nombre']);
    $Instituciones->__GET('id_nivel')->__SET('id_nivel',  $_POST['Nivel']);

    $institucionesDAO->Registrar_Institucion($Instituciones);
    echo $mensajeFinalS;
    DBAccess::rederigir("lista_institucion.php");
}
?>

<!-- SE COMIENZA A CREAR LA ESTRUCTURA CENTRAL DEL FORMULARIO -->
<div class="row">
	<div class="col-md-6">
        <div class="form-group">
            <h5 class="text-center title-container">
                <i class="glyphicon glyphicon-education"></i> AGREGAR INSTITUCIÓN
            </h5>
        </div>
        <div class="box-res-add">
          <!-- LA FUNCIÓN "htmlspecialchars()" CONVIERTE CARACTERES ESPECIALES A ENTIDADES HTML -->
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data">
            <br>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon">Código Modular</span>    
                    <input type="text" class="form-control" name="CodModular" id="CodModular">
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon">Nombre</span>    
                    <input type="text" class="form-control" name="Nombre" id="Nombre">
                </div>
            </div>
            <br>
            <div class="form-group">
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
          <br>
          <button type="submit" class="btn btn-primary" name="btnGuardar" id="btnGuardar">Guardar Institución</button>
      </form>
  </div>
</div>
</div>

<!-- Importación del footer -->
<?php require '../secciones/admin/footer.php'; ?>