<?php
  session_start();
  //importando el DBacces
  require_once 'DAL/DBAccess.php';

  //importando las clases y los dao
  require_once 'BOL/persona.php';
  require_once 'DAO/personaDAO.php';

  //importando las clases y los dao
  require_once 'BOL/ambiente.php';
  require_once 'DAO/ambienteDAO.php';

  //importando las clases y los dao
  require_once 'BOL/usuario.php';
  require_once 'DAO/usuarioDAO.php';


  //importando las clases y los dao
  require_once 'BOL/tipo_rol.php';
  require_once 'DAO/tipo_rolDAO.php';

  //importando las clases y los dao
  require_once 'BOL/usuario_ambiente.php';
  require_once 'DAO/usuario_ambienteDAO.php';

  require_once 'BOL/area.php';
  require_once 'DAO/areaDAO.php';

  $usuarios = new Usuario();
  $usuariosDAO = new usuarioDAO();

  $usuariosAmbientes = new Usuario_ambiente();
  $usuariosAmbientesDAO = new usuario_ambienteDAO();

?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>INICIAR SESSION - UGEL CHINCHA</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="DESIGNER/tema/css/bootstrap.min.css">

  <!-- APP -->
  <link rel="stylesheet" href="DESIGNER/tema/css/my_css.css">
  <link rel="stylesheet" href="DESIGNER/tema/css/login.css">
<!-- <link rel="stylesheet" href="DESIGNER/tema/css/login.css"> -->
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-2">

        </div>
        <div class="col-md-4 col-sm-4 col-xs-10">


            <?php if(!isset($_SESSION['Usuario'])): ?>
    <!-- Aplicativo de Gestion y Administracion de Relozuiones - UGEL -->
<div class="container-app-login">
   <img class="img-responsive" src="DESIGNER/tema/img/logo.png">
   <br>
   <div class="login-contenido">
      <h3 class="text-center login-text">Iniciar Sesion</h3>
      <br>
      <label for="email">Correo electronico:</label>
      <div class="input-group">
         <span class="input-group-addon glyphicon glyphicon-user"></span>    
         <input type="text" class="form-control"  id="emailUsuario" name="correoUsuario">
      </div>
      <br>
      <label for="pwd">Contraseña:</label>               
      <div class="input-group">
         <span class="input-group-addon  glyphicon glyphicon-lock"></span>    
         <input type="password" class="form-control"  id="contraseniaUsuario" name="contrasenia">
      </div>
      <div class="checkbox">
         <label><input type="checkbox"> Remember me</label>
      </div>
      <button id="btnIniciarSession" class="btn btn-success">Iniciar Sesión</button>
      <br>
      <div class="response-login-fail">
      </div>
   </div>
   <div class="contenido-login-success" style="display: none;">
      <h4 class="text-center login-text">Binvenido (a)</h4>
      <strong id="u-nombre"></strong>
      <p><br>
         ¿A donde desea ingresar hoy?
      </p>
      <div class="form-group">
         <select class="form-control" id="select-ambientes"></select>
      </div>
      <button class="btn btn-success" id="ir-oficina">IR A OFICINA</button>
   </div>
</div>

          <?php else:?>

            <div class="container-app-login">
              <div class="form-group">
                <p class="text-center">
                  Usted cuenta con estas areas, por favor seleccione la oficina que desea ingresar
                </p>
              </div>
               <div class="form-group">
                <select class="form-control" name="ambientesTotal">
              <?php
                $usuariosAmbientes->__GET('id_usuario')->__SET('id_usuario',$_SESSION['id_usuario']);
                $AmbientesTotal = $usuariosAmbientesDAO->Listar_ambientes_usuario($usuariosAmbientes);
                foreach($AmbientesTotal as $r_g){
                  echo '<option value="'.$r_g->__GET("id_ambiente")->__GET("id_ambiente").'">';
                  echo $r_g->__GET("id_ambiente")->__GET("nombre_ambiente");
                  echo '</option>';
                }
               ?>                  
                </select>
              </div>
              <div class="form-group">
                <button name="btnIrAmbiente" class="btn btn-success">IR A OFICINA</button>
                <div class="response-login-success"></div>
              </div>

            </div>

          <?php endif;?>

        </div>
      </div>  
    </div>

<h3 id ="redes-sociales-log">
<a href="https://www.facebook.com/www.ugelchincha.gob.pe/" arget="_blank">
  <i class="fa fa-facebook-official">
  </i>
</a>&nbsp;
<a href="https://www.ugelchincha.gob.pe/" target="_blank">
  <i class="glyphicon glyphicon-globe">
  </i>
</h3>

    <div class="container-fluid" id="footer-app-login">
      <div class="row">
        <div class="content-footer-app-login">
          <p class="bg-success">
            © 2018 - UGEL Chincha. Todos los derechos reservados  |  UGELCH 1.0   |  Administracion@ugelchincha.gob.pe|   Canal de atención:  056-266788 - Anexo(209)| 959139843
          </p>
        </div>
      </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="DESIGNER/tema/js/jquery-3.4.0.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="DESIGNER/tema/js/bootstrap.min.js"></script>

    <script>


    function iniciarSessionGetAmbientes(){
                var parametros = {
                        "usuario" : $('#emailUsuario').val(),
                        "contrasenia" : $('#contraseniaUsuario').val()
                };
            console.log("usuario: "+parametros.usuario);
            console.log("contrasenia: "+parametros.contrasenia);

                $.ajax({
                        data:  parametros,
                        url:   'DESIGNER/ajax/login_usuario_ambientes.php',
                        type:  'post',
                        beforeSend: function () {
                                $("#contenido-login").html("Procesando, espere por favor...");
                        },
                        success:  function (data) {

                          if (data.success === 1) {
                             $('#u-nombre').text(data.data.nombreApellidos);
                             $('.login-contenido').hide();
                             $('.contenido-login-success').show();

                             for (var i = 0; i < data.data.Ambientes; i++) {
                               console.log(data.data.Ambientes[i].i);
                             }

                             for (var key in data.data.Ambientes) {
                                // skip loop if the property is from prototype
                                if (!data.data.Ambientes.hasOwnProperty(key)) continue;

                                var obj = data.data.Ambientes[key];
                                generate_select_ambientes(obj[0],obj[1],obj[2]);
                            }

                          }else{
                            var text = "Error su usuario no se encuentra en el sistema!";
                            $('.response-login-fail').text(text).css(
                              { 
                               'color': 'red',
                               'font-size': '15px',
                               'margin-top': '13px' 
                              }
                            );
                          console.log(data.data);
                          }

                        },
                      error: function(){

                      } 
                });
        }


        function irAmbienteOficina(){
            var parametros = {
                  "id_ambiente" : $('#select-ambientes option:selected').val(),
                  "id_tipo" : $('#select-ambientes option:selected').attr("data-tipo") ,
                  "nombre_ambiente" : $('#select-ambientes').find(":selected").text()
            };
            console.log("id_ambiente: "+parametros.id_ambiente);
            console.log("id_tipo: "+parametros.id_tipo);
            console.log("nombre_ambiente: "+parametros.nombre_ambiente);

                $.ajax({
                        data:  parametros,
                        url:   'DESIGNER/ajax/login_usuario_ambientes.php',
                        type:  'post',
                        beforeSend: function () {
                           $("#contenido-login").html("Procesando, espere por favor...");
                        },
                        success:  function (data) {

                          if (data.success === 1) {
                            console.log(data.urlRedic);
                            
                            var text = "En 3 segundos sera redirigido a su ambiente!";
                            $('.response-login-success').text(text).css(
                              { 
                               'color': 'green',
                               'font-size': '15px',
                               'margin-top': '13px' 
                              }
                            );

                            var url = data.urlRedic;
                            window.setTimeout(function() {
                                window.location.href = url;
                            }, 3000);
                          }else{
                            console.log(data);
                          }

                        },
                      error: function(){

                      } 
                });
        }
      

      function generate_select_ambientes(id,ambiente,tipo) {
          var option = $('<option/>');
          option.attr({ 'value': id }).text(ambiente);
          option.attr({ 'data-tipo': tipo });
          $('#select-ambientes').append(option);
      }

      $("#btnIniciarSession").click(function(e) {
        iniciarSessionGetAmbientes();
      });

      $("#ir-oficina").click(function(e) {
       irAmbienteOficina();
      });

    </script>
  </body>
  </html>