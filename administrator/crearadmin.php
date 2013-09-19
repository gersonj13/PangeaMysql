<?php
session_start();

include("../recursos/funciones.php");
$conn=conectar();

if(!isset($_SESSION["usuarioadmin"]) || !isset($_SESSION["passwordadmin"])){
	iraURL('../administrator/index.php');
}
	

if(isset($_POST["guardar"]) || isset($_POST["guardar2"])){

	if(isset($_POST["nombre"]) &&  isset($_POST["apellido"]) && isset($_POST["usuario1"]) && isset($_POST["contrasena"]) && isset($_POST["contrasena_c"]) && $_POST["nombre"]!="" && $_POST["apellido"]!="" && $_POST["usuario1"]!="" && $_POST["contrasena"]!="" && $_POST["contrasena_c"]!="" && $_POST["tipoadmin"]>0){
	
		$nombre=$_POST['nombre'];
		$apellido=$_POST['apellido'];
		$usuario=$_POST['usuario1'];
		$contrasena=$_POST['contrasena'];
		$tipoadmin=$_POST['tipoadmin'];

		$SQL="SELECT * FROM administrador where usuario='$usuario'";
		$result = pg_query ($conn, $SQL ) or die("Error en la consulta SQL");
		$registros= pg_num_rows($result);
	
		if($registros == 0){

			if($_POST["contrasena"]==$_POST["contrasena_c"]){
				$resultado=pg_query($conn,"INSERT INTO administrador values( nextval('administrador_administradorid_seq'),'$nombre','$apellido','$usuario','$contrasena',".$_SESSION["id_usuario"].",'$tipoadmin')") or die(pg_last_error($conn));
	
				if($resultado){
					javaalert('Se Creo un Administrador');
					llenarLog(1, "Administrador");
					if(isset($_POST["guardar"])){
						iraURL('../administrator/admin.php');
					}
					else{
						iraURL('../administrator/crearadmin.php');
					}
				}
			}else{
				javaalert("Las contraseñas no coinciden, por favor verifique");
			}
		}else{
			javaalert("El nombre de usuario ya esta registrado, por favor verfique");
		}
	}else{
		javaalert("Ingrese todos los campos");
	}
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<title>:: Pangea Technologies ::</title>
<meta name="description" content="Pagina Web"/>
<meta name="author" content="Pangea Technologies"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta charset="utf-8">
<link href="../recursos/css/bootstrap.css" rel="stylesheet">
<link href="../recursos/css/bootstrap.min.css" rel="stylesheet">
<link href="../recursos/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="../recursos/css/estiloadmin.css" rel="stylesheet">
</head>

<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">
<form method="post">
<div class="container">
  <div class="navbar">
    <div class="navbar-inner">
      <div class="container" style="width: auto;"> <a class="btn btn-navbar" href="#nav" data-toggle="collapse" data-target="#barrap"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a> <a  class="brand" id="brand-admin" href="principal.php">PANGEATECH</a>
        <div id="barrap" class="nav-collapse collapse">
         <ul class="nav">
            <li class="dropdown active"> <a  class="dropdown-toggle" data-target="#" data-toggle="dropdown"> Gestión Usuarios <b class="caret"></b> </a>
              <ul class="dropdown-menu">
                <li><a href="tipoadmin.php"> Tipo Administrador </a></li>
                <li><a href="admin.php">Administrador</a></li>
                <li><a href="usuario.php">Usuario</a></li>
              </ul>
            </li>
            <li><a href="menu.php"> Menú</a></li>
            <li><a href="producto.php">Producto</a></li>
            <li><a href="sucursal.php">Sucursal</a></li>
            <li class="dropdown">
             <a  class="dropdown-toggle" data-target="#" data-toggle="dropdown">
              Gestión Información <b class="caret"></b> </a>
              <ul class="dropdown-menu">
                <li><a href="tipoinfo.php">Tipo Infomación</a></li>
                <li><a href="info.php">Información</a></li>
              </ul>
            </li>
            <?php if(supera($_SESSION["admin"])){
            ?><li><a href="bitacora.php"> Bitácora</a></li>
           <?php }?>
            <li><a href="cerrarsesion.php">Cerrar Sesión</a></li>
          </ul>
        </div>
        <!-- /.nav-collapse --> 
      </div>
    </div>
    <!-- /navbar-inner --> 
  </div>
</div>
<!-- /container -->
<div class="container">
   <div class="row-fluid">
                       
    <div class="span3">
      <div style="text-align:center">
          <ul class="nav  nav-pills nav-stacked">
              <li class="active"><a href="admin.php"> <span class="add-on"><i class="icon-arrow-left"></i></span> Atrás</a></li>
          </ul>
      </div>
    </div>
    
    <div class="span9 well well-large">
        <p>
            <div class="span3 well well-small"><b>Nombre</b></div>
            <div class="span6 well well-small"><input id="nombre" name="nombre" type="text" placeholder="Ej. Niuska Jenireé" maxlength="34" pattern="[A-Za-z,ñ,Ñ,á,é,í,ó,ú,Á,É,Í,Ó,Ú, ]{1,34}" required autofocus/></div>
            <div class="span3 well well-small"><b>Apellido</b></div>
            <div class="span6 well well-small"><input id="apellido" name="apellido" type="text" placeholder="Ej. Mora Hurtado"  maxlength="34" pattern="[A-Za-z,ñ,Ñ,á,é,í,ó,ú,Á,É,Í,Ó,Ú, ]{1,34}" required/></div>
            <div class="span3 well well-small"><b>Usuario</b></div>
            <div class="span6 well well-small"><input id="usuario1" name="usuario1" type="text" placeholder="Ej. niuska.mora" maxlength="34" pattern="[a-z.ñ]{1,34}" required/></div>
            <div class="span3 well well-small"><b>Contraseña</b></div>
            <div class="span6 well well-small"><input id="contrasena" name="contrasena" type="password" maxlength="34" pattern="[A-Za-z.0-9ñÑ]{1,34}" required/></div>
            <div class="span3 well well-small"><b>Confirmar Contrseña</b></div>
            <div class="span6 well well-small"><input id="contrasena_c" name="contrasena_c" type="password" maxlength="34" pattern="[A-Za-z.0-9ñÑ]{1,34}" required/></div>
			<div class="span3 well well-small"><b>Tipo de Administrador</b></div>
            <div class="span6 well well-small">
            <select id="tipoadmin" name="tipoadmin">
                    	<option value="0">Seleccione Opción</option>
                        <?php
		
						$SQL="SELECT * FROM tipoadministrador";
						$result = pg_query ($conn, $SQL ) or die("Error en la consulta SQL");
						
						while($row=pg_fetch_array($result)){
							echo '<option value="'.$row['tipoadministradorid'].'">'.$row['nombre'].'</option>';

							}

						?>
                    </select>
                    </div>
      <div class="span9 well well-small" align="center">
      <button name="guardar" id="guardar" type="submit" class="btn btn-primary text-center">Guardar</button>
      </div>
      
      <div class="span9 well well-small" align="center">
      <button id="guardar2" name="guardar2" class="btn btn-primary text-center" type="submit">Guardar y añadir otro</button>
      </div>
                
         </p>
    </div>
  </div>
</div>

<!-- Le javascript
================================================== --> 
<script type="text/javascript" src="../recursos/js/jquery-2.0.2.js" ></script> 
<script type="text/javascript">
$(document).ready(function() {
 
$('.dropdown-toggle').click(function(e) {
  e.preventDefault();
  setTimeout($.proxy(function() {
    if ('ontouchstart' in document.documentElement) {
      $(this).siblings('.dropdown-backdrop').off().remove();
    }
  }, this), 0);
});
 
 
});



</script> 
<script src="../recursos/js/bootstrap.js"></script> 

</form>
</body>
</html>
