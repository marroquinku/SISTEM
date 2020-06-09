
k<?php 
require_once '../../DAL/DBAccess.php';

require_once '../../BOL/tipo_rol.php';
require_once '../../DAO/tipo_rolDAO.php';

require_once '../../BOL/area.php';
require_once '../../DAO/areaDAO.php';

require_once '../../BOL/ambiente.php';
require_once '../../DAO/ambienteDAO.php';

//importando las clases y los dao
require_once '../../BOL/persona.php';
require_once '../../DAO/personaDAO.php';

//importando las clases y los dao
require_once '../../BOL/usuario.php';
require_once '../../DAO/usuarioDAO.php';

//importando las clases y los dao
require_once '../../BOL/telefono.php';
require_once '../../DAO/telefonoDAO.php';

//importando las clases y los dao
require_once '../../BOL/correo.php';
require_once '../../DAO/correoDAO.php';

//importando las clases y los dao
require_once '../../BOL/institucion.php';
require_once '../../DAO/institucionDAO.php';

//importando las clases y los dao
require_once '../../BOL/nivel.php';
require_once '../../DAO/nivelDAO.php';

$ambiente = new Ambiente();
$ambienteDAO = new ambienteDAO();

$tipo_rol = new Tipo_rol();
$tipo_rolDAO = new Tipo_rolDAO();

$Personas = new Persona();
$PersonaDAO = new PersonaDAO();

$correo = new Correo();
$correoDAO = new CorreoDAO();

$telefono = new Telefono();
$telefonoDAO = new TelefonoDAO();

$nivel = new Nivel();
$nivelDAO = new NivelDAO();

$instituciones = new Institucion();
$institucionesDAO = new InstitucionDAO();

$usuarios = new Usuario();
$usuarioDAO = new usuarioDAO();

$dataSrc = "insitucionesCetpro.csv";
$dataDest = "PU33.csv";

if (!file_exists($dataSrc)) {
    echo "ERROR ARCHIVO NO ENCONTRADO!!";
    die();
}

$dataFile = fopen($dataSrc, "r") or die("Unable to open file!");
$outFile = fopen($dataDest, "w") or die("Unable to open file!");

$i=1;  //index for the array
while(false !== ($csv = fgetcsv($dataFile))) {

    /*$usuarios->__GET('idPersona')->__SET('idPersona', $i);
    $usuarios->__SET('Usuario', str_replace_first(".", "", $csv[4]));
    $usuarios->__SET('Contrasenia', 123456789);
    $usuarioDAO->Registrar($usuarios);*/

    $instituciones->__SET('cod_modular',  $csv[0]);
    $instituciones->__SET('nombre',      $csv[1]);
    $instituciones->__GET('id_nivel')->__SET('id_nivel',  $csv[2]);

    $institucionesDAO->Registrar_Institucion($instituciones);

    //echo str_replace_first(".", "", $csv[4])."<br>";

    
    /*$Personas->__SET('idPersona', $i);
    $newDate = date("Y-m-d", strtotime($csv[5]));
    $Personas->__SET('documento',$csv[3]);
    $Personas->__SET('nombre', $csv[2]);
    $Personas->__SET('apellido_paterno', $csv[0]);
    $Personas->__SET('apellido_materno', $csv[1]);
    $Personas->__SET('FechaNacimiento', $newDate);
    $Personas->__SET('Sexo', $csv[6]);
    $PersonaDAO->Registrar_per($Personas,$correo,$telefono);*/


    //echo $i." ".$csv[0]." ".$csv[1]." ".$csv[2]." - ".$csv[3]." - ".$csv[4]." ".$csv[5]." ".$csv[6]."<br>";
    //$csv = [ANE WILLIAMS,6/8/1998,55846874E,4323];
    //$csv = [1,15,1,UNIDAD DE PERSONAL,0];
    //$csv = [NOMBRE,APELLIDOP,APELLIDOM,DNI,CORREO,FECHA_NAC,SEXO];
    //add check to remove row
    //if($csv[3] == '55846874E') continue; //skip to next itteration

    //fputcsv($outFile, $csv);*/
    /*$ambiente->__SET('idAmbientes', $i);
    $ambiente->__SET('NombreAmbiente', $csv[0]);
	$ambienteDAO->Registrar($ambiente);*/
	
    $i++;
}

fclose($dataFile);
fclose($outFile);

function str_replace_first($from, $to, $content)
{
    $from = '/'.preg_quote($from, '/').'/';

    return preg_replace($from, $to, $content, 1);
}

?>