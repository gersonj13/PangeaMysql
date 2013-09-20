<?php
session_start();

include("../recursos/funciones.php");
$var=conectar();
if(isset($_SESSION["usuarioadmin"]) && isset($_SESSION["passwordadmin"])){
	iraURL('../administrator/principal.php');
	}
if (isset($_POST["Biniciar"])) {
    $user = $_POST["usuario"];
    $pass = $_POST["password"];

    if (crearsesion($user, $pass)) {
        if (validarlogin()) {
            llenarLog(4, "Inicio sesión");  
			iraURL('../administrator/principal.php');
        }
    }else {
	javaalert("Debe agregar el usuario y contraseña");
		}
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="iso-8859-1">
    <title>:: Pangea Technologies ::</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="../recursos/css/bootstrap.css" rel="stylesheet">
    <link href="../recursos/css/bootstrap.min.css" rel="stylesheet">
    <link href="../recursos/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="../recursos/css/bootstrap-responsive.min.css" rel="stylesheet">
    
    <!-- Estilos admin-->
    <link href="../recursos/css/estiloadmin.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

  </head>

  <body>

    <div class="container" align="center">

      <form class="form-signin" method="post">
        <h3 class="form-signin-heading">Por favor, inicie sesi&oacute;n</h3>
        <input type="text" class="input-block-level" placeholder="Usuario" name="usuario" id="usuario" maxlength="34" pattern="[a-z.ñ]{1,34}" title="Solo se admite minusculas y puntos" autofocus required>
        <input type="password" class="input-block-level" placeholder="Contraseña" name="password" id="password" maxlength="34" pattern="[A-Za-z.0-9ñÑ]{1,34}" required>
        <button class="btn btn-large btn-primary" type="submit" name="Biniciar">Iniciar Sesi&oacute;n</button>
      </form>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../recursos/js/jquery.js"></script>
    <script src="../recursos/js/bootstrap.js" ></script> 

  </body>
</html>