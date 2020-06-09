<?php
//CREACIÓN DE LA CLASE DBACCESS
class DBAccess
{
  //SE CREAN LAS VARIABLES DE LA CLASE
  private $conn;
  
  //SE CREA LA FUNCION PARA LA CONEXION A LA BASE DE DATOS
  public function __construct()
  {

    if( defined( 'PDO::MYSQL_ATTR_MAX_BUFFER_SIZE' ) ) {
        $opt = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', PDO::MYSQL_ATTR_MAX_BUFFER_SIZE => 15*1024*1024);
    }
    else {
        $opt = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
    }

 //SE LE ASIGNA LA CONFIGURACION PARA LA CONEXION A LA BASE DE DATOS
    try {
      //$this->conn = new PDO('mysql:host=localhost;dbname=resolucion2', 'root', '',$opt);
      $this->conn = new PDO('mysql:host=localhost;dbname=resolucion', 'root', '',$opt);
      //$this->conn = new PDO('mysql:host=66.23.234.154;dbname=ugelcvda_resolucion3', 'ugelcvda', 'M*rJGp1vU@24N4#',$opt);
      //$this->conn = new PDO('mysql:host=ugelchincha.gob.pe;dbname=ugelcvda_resolucion3', 'ugelcvda_admin', 'ugelchincha1234',$opt);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e )
    {
      echo "error:" .$e->getMessage();
    }
 }

  //SE CREA LA FUNCION PARA OBTENER LA URL DONDE ESTA ALOJADO EL APLICATIVO
  public static function getUrl(){
    //$name = "ResolucionesApp";
    $name = "UGEL-CHINCHA";
    $url = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s" : "") . "://" . $_SERVER['HTTP_HOST']."/".$name;
    return $url;
  }

  //SE CREA UNA FUNCION PARA RECIBIR LA CONEXION
  public function get_connection()
  {
    return $this->conn;
  }

  //SE CREAN LA FUNCION PARA REDIRIGIR LA LOCALIZACION DE LA URL DEL APLICATIVO 
  public static function rederigir($url){
      //echo '<script language="javascript">window.location.href ="'.$url.'"</script>';
      echo '<script type="text/javascript">setTimeout(function(){window.top.location="'.$url.'"} , 1500);</script>';
  }
}
?>
