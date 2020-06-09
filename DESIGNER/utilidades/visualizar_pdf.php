<?php 

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
require_once '../../BOL/tipo_resolucion.php';
require_once '../../DAO/tipo_resolucionDAO.php';

//importando las clases y los dao
require_once '../../BOL/concepto.php';
require_once '../../DAO/conceptoDAO.php';

//importando las clases y los dao
require_once '../../BOL/resolucion.php';
require_once '../../DAO/resolucionDAO.php';

//importando las clases y los dao
require_once '../../BOL/estado.php';

require_once '../../BOL/tipo_rol.php';
require_once '../../DAO/tipo_rolDAO.php';

require_once '../../BOL/area.php';
require_once '../../DAO/areaDAO.php';

if (2 & ini_get('mbstring.func_overload')) {
    function bytes($string) {
        return mb_strlen($string, '8bit');
    }
} else {
    function bytes($string) {
        return strlen($string);
    }
}

$tipoResolucion = new Tipo_resolucion();
$tipoResolucionDAO = new Tipo_resolucionDAO();
$resultado_tipoResolucion = $tipoResolucionDAO->Listar();

$resolucion = new Resolucion();
$resolucionDAO = new ResolucionDAO();

$id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;
$resolucion->__SET('id_resolucion', $id);

$rsultadoResolucion =  $resolucionDAO->Buscar_archivo($resolucion); // your code to fetch the image

foreach($rsultadoResolucion as $r_g){
	$pdf = $r_g->__GET('archivo');
}


$mimeType = $pdf;

header('Content-Type: application/pdf');
header('Content-Description: PDF document');
header('Content-Transfer-Encoding: binary');
header('Accept-Ranges: bytes');
header('Content-Length: '.bytes($pdf));
header('Expires: 0');
header('Pragma: no-cache');
header('Cache-Control: no-cache, must-revalidate, max-age=0');

ob_clean();
flush();
echo $pdf;


?>
