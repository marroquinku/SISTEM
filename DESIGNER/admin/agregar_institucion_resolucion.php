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

//importando las clases y los dao
require_once '../../BOL/Detalle_resolucion_institucion.php';
require_once '../../DAO/Detalle_resolucion_institucionDAO.php';

//importando las clases y los dao
require_once '../../BOL/resolucion.php';
require_once '../../DAO/resolucionDAO.php';

require_once '../../BOL/tipo_rol.php';
require_once '../../DAO/tipo_rolDAO.php';

require_once '../../BOL/tipo_resolucion.php';
require_once '../../DAO/tipo_resolucionDAO.php';

require_once '../../BOL/estado.php';
require_once '../../DAO/estadoDAO.php';

require_once '../../BOL/concepto.php';
require_once '../../DAO/conceptoDAO.php';

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

$institucion = new Institucion();
$InstitucionDAO = new InstitucionDAO();

$tipoResolucion = new Tipo_resolucion();
$tipoResolucionDAO = new Tipo_resolucionDAO();
$resultado_tipoResolucion = $tipoResolucionDAO->Listar();

$resolucion = new Resolucion();
$resolucionDAO = new ResolucionDAO();

$detalle_resolucion_institucionDAO = new Detalle_resolucion_institucionDAO();

$mensajeFinalS = file_get_contents('../msj/mensaje_general.php');

//SE CREA UNA CONDICIONAL PARA VALIDAR SI EL BOTON CON NAME "btn-guardar-ir-a" ESTA RECIBIENDO VALORES, DE SER ASI, SE GUARDAN EN EL SISTEMA
if(isset($_POST['btn-guardar-ir-a']))
{
    if (isset($_POST['id_resolucion_pr']) && !empty($_POST['id_resolucion_pr'])) {
        $idInsticion = $_POST['idInsticion'];
        $idResolucion = $_POST['id_resolucion_pr'];

        foreach($idInsticion as $key => $n ) {
          $detalle_resolucion_institucion = new Detalle_resolucion_institucion();
          $detalle_resolucion_institucion->__GET('id_institucion')->__SET('id_institucion',$n);
          $detalle_resolucion_institucion->__GET('id_resolucion')->__SET('id_resolucion',$idResolucion);
          $detalle_resolucion_institucionDAO->Registrar($detalle_resolucion_institucion);
        }
        echo $mensajeFinalS;
        DBAccess::rederigir("mantenimiento_resolucion.php");
    }else{
        echo "error";
    }
}
?>

<!-- SE COMIENZA A CREAR LA ESTRUCTURA CENTRAL DEL FORMULARIO -->
​​<div class="row">
   <div class="col-md-12">
    <div class="form-group">
                <h5 class="text-center title-container">
                    <i class="glyphicon glyphicon-list-alt"></i> AGREGAR INSTITUCIÓN A RESOLUCIÓN
                </h5>
            </div>
      <div class="box-res-add">
        <!-- LA FUNCIÓN "htmlspecialchars()" CONVIERTE CARACTERES ESPECIALES A ENTIDADES HTML --> 
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
         <div class="cajas-res">
            <div class="div_res_titulo" style="color: #ffffff;">
               <h4 class="panel-title " style="font-size: 15px;">
                  <a href="#collapseOne">
                  <span class="glyphicon glyphicon-folder-open"></span> 
                  &nbsp;&nbsp;Resolución
                  </a>
               </h4>
            </div>
            <div class="div_res_contenido table-responsive">
               <table id="tabla_dxs" class="tbl_controles table">
                  <thead>
                     <tr class="Frm_Texto_pie info" valign="middle">
                        <td width="30%" align="center">
                           <strong> Año de resolución</strong>
                        </td>
                        <td width="30%" align="center">
                           <strong>Tipo de resolución</strong>
                        </td>
                        <td width="30%" align="center">
                           <strong>Número de resolución</strong>
                        </td>
                        <td width="10%" align="center">
                           &nbsp;
                        </td>
                     </tr>
                  </thead>
                  <tbody id="tbody_dxs_contenido">
                     <tr style="padding-top: 10px;">
                        <td valign="top">
                           <select class="form-control" name="anioResolucion" id="anioResolucion">
                              <option>Seleccionar</option>
                              <!-- SE CREA UN BUCLE PARA QUE NOS MUESTRE UNA LISTA DE AÑOS DESDE 1988 HASTA LA ACTUALIDAD --> 
                              <?php for($i = 1988 ; $i < date('Y')+1; $i++):?>
                              <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                              <?php endfor;?>
                           </select>
                        </td>
                        <td valign="top">
                           <select class="form-control" name="tipoResolucion" id="tipoResolucion">
                              <option>Seleccionar</option>
                              <!-- REALIZA UN RECORRIDO A LA BASE DE DATOS PARA MOSTAR EL REGISTRO DEL CAMPO "tipo_resolucion" -->
                              <?php foreach($resultado_tipoResolucion as $r_g): ?>
                              <option value="<?php echo $r_g->__GET('id_tipo_resolucion');?>">
                                 <?php echo $r_g->__GET('tipo_resolucion');?>
                              </option>
                              <?php endforeach;?>
                           </select>
                        </td>
                        <td valign="top">
                          <input type="number" value="" class="form-control" id="numeroResolucion">
                        </td>
                        <td valign="top">
                           <!-- onclick="wDiagnostico('txtDiagIng01,txtNomDiagIng01');"-->
                           <img class="imagen img_buscar" title="Buscar Resolucion" src="../img/lupa18.gif" width="18" height="16" id="btn-buscar-resolucion">
                           <img src="../img/reload.png" title="Resetear" height="20" id="btnResetearRes-buscar">
                        </td>
                     </tr>
                     <tr>
                        <input type="hidden" name="id_resolucion_pr" id="id_resolucion_pr">
                        <td colspan="4" style="border: none;padding-top: 15px;" id="message-box-pr">

                        </td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>

        <div class="div_res_titulo" style="color: #ffffff; margin-bottom: 10px;">
               <h4 class="panel-title " style="font-size: 15px;">
                  <a href="#collapseOne">
                  <span class="glyphicon glyphicon-folder-open"></span> 
                  &nbsp;&nbsp;Institución
                  </a>
               </h4>
        </div>

         <div class="div_pestania_base">
            <label class="Frm_Texto_Etiqueta etiqueta-f">
            No hay registros!
            </label>
            <div class="div_pestania">
               <span class="spanMPIAgregar maximized">
               <a href="#" id="linkMPIAgregarPro" title="" class="mostrar_ayuda data-original-title">Agregar</a>
               </span>
            </div>
            <div class="box-view minimizado"  style="display: none;">
              <br>
              <table class="table table-striped" id="institucion-rd">
                    <thead>
                        <tr class="success">
                            <td align="center" colspan="2">
                                ID
                            </td>
                            <td align="center">
                                Código Modular
                            </td>
                            <td align="center">
                                Nombre
                            </td>
                            <td align="center">
                                Nivel
                            </td>
                            <td align="center">

                            </td>
                        </tr>
                    </thead>
                <tbody>
                </tbody>
            </table>
               <div class="table-responsive principal-tb">
                  <table class="table">
                     <tr>
                        <td>
                          <input type="hidden" id="idInstituciones" value="123456">
                          <div class="input-group">
                            <span class="input-group-addon" for="ProcessNum">Código Modular</span>    
                             <input type="number" id="modularKeyEnter" class="floatLabel form-control">
                          </div>
                        </td>
                     </tr>
                     <tr>
                        <td  align="center">
                          <div class="input-group">
                            <span class="input-group-addon" for="ProcessNum">Nombre</span>    
                            <input type="text" id="pr_nombreIns" class="floatLabel form-control" readonly>
                          </div>
                        </td>
                        <td  align="center">
                           <div class="input-group">
                            <span class="input-group-addon" for="ProcessNum">Nivel</span>    
                            <input type="text" id="pr_nivelIns" class="floatLabel form-control" readonly>
                          </div>
                        </td>
                     </tr>
                     <tr>
                        <td align="left">
                            <button class="btn btn-success" id="btn_ir_institucion" disabled>Agregar Institución</button>
                        </td>
                     </tr>
                  </table>
               </div>
            </div>
         </div>

         <div class="text-right" style="margin-top: 20px;">
            <button name="btn-guardar-ir-a" class="btn btn-primary">Registrar instituciones a resolución</button>
         </div>
        </form>
      </div>
   </div>
</div>

<!-- Importación del footer -->
<?php require '../secciones/admin/footer.php'; ?>