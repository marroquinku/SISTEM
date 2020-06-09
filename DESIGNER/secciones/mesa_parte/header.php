<?php 
if (!isset($_SESSION['idUsuarios'])) {
	$url =  DBAccess::getUrl();
	header("Location: $url/index.php");
}
$uAmb = new Usuario_ambiente();
$uAmbDAO = new Usuario_ambienteDAO();

if($_SESSION['id_tipo'] !=  2){
  $uAmbDAO->seguridadLoginSuccess($_SESSION['id_tipo']);
}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Panel de administracion Mesa de parte - UGEL</title>

    <!-- Bootstrap -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../tema/css/bootstrap.min.css">

    <!-- APP -->
    <link rel="stylesheet" href="../tema/css/my_css.css">
    <!-- APP -->
    <link rel="stylesheet" href="../tema/css/bootstrap-select.min.css">
    <!-- Metis Menu -->
    <link href="../tema/css/metisMenu.min.css" rel="stylesheet">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:500,700" rel="stylesheet">

	  <link href="../tema/css/adm.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  
  	<header>
  		<nav class="navbar navbar-default" role="navigation">
  			<div class="navbar-header">
  				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
  					<span class="icon-bar"></span>
  					<span class="icon-bar"></span>
  					<span class="icon-bar"></span>
  				</button> 
  				<a class="navbar-brand" href="#" style="padding: 0px 0px 0px 36px;">
            <img class="logo-ugel" src="../tema/img/LogoUgelChincha.png">
          </a>   
  			</div>
  			<div class="navbar-collapse collapse">
  				<ul class="nav navbar-nav navbar-left">
  					<li></li>
  					<li></li>
  					<li></li>
  					<li></li>
  				</ul>
  				<ul class="nav navbar-nav navbar-right menu-op-adm">
            <li><a href="#about"><i class="glyphicon glyphicon-search"></i>Buscar resolucion</a></li>
            <li class="divider-vertical"></li>
  					<li class="dropdown" style="cursor: pointer;">
  						<a class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['nombreApellidos'] ?>
						  <span class="caret"></span>
						</a>
						 <ul class="dropdown-menu">
						    <li><a href="../utilidades/cerrar_session.php">Cerrar Sessión</a></li>
						 </ul>
  					</li>
  				</ul>
  			</div>
  		</nav>
  	</header>

  	<div class="contenedor-app">
  		<aside class="menu-izquierdo">
  			<div class="sidebar left">
			    <div class="user-panel">
			        <div class="pull-left image">
			            <img src="http://via.placeholder.com/160x160" class="rounded-circle" alt="User Image">
			        </div>
			        <div class="pull-left info">
			            <p><?php echo $_SESSION['nombreApellidos'] ?></p>
			            <a href="#"><i class="glyphicon glyphicon-stop"></i> <?php echo $_SESSION['nombre_ambiente']; ?></a>
			        </div>
			    </div>
			    <ul class="list-sidebar bg-defoult">

              <div class="menu-close-open">
                
                <a id="menu-toggle" class="button-left">
                 <i class="glyphicon glyphicon-align-justify"aria-hidden="true" aria-hidden="true"></i> 
                </a>

              </div>

			        <li> 
			        	<a href="index.php" class="active">
			        		<i class="glyphicon glyphicon-home"></i> 
			        		<span class="nav-label">Inicio</span> 
			        	</a>
			        </li>

              <li> 
                <a href="operaciones_resolucion.php">
                  <i class="glyphicon glyphicon-wrench"></i> 
                  <span class="nav-label">Operaciones Resolucion</span> 
                </a>
              </li>
			       
			    </ul>
			</div>
  		</aside>
  		<aside class="contenedor-derecha">