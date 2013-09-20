<?php
session_start();

include("../recursos/funciones.php");
$conn=conectar();
if(!isset($_SESSION["usuarioadmin"]) || !isset($_SESSION["passwordadmin"])){
	iraURL('../administrator/index.php');
	}
	//codigo para guardar y volver a la pagina de tipoinformacion.php
	if(isset($_POST["crear_uno"]) || isset($_POST["crear_otro"])){
		if(isset($_POST["nombre"]) && isset($_POST["descripcion"]) && $_POST["nombre"]!="" && $_POST["descripcion"]!="" ){
				$insertar = "insert into tipoinformacion values(nextval('tipoinformacion_tipoinformacionid_seq'),'".$_POST['nombre']."','".$_POST['descripcion']."');";
				$conex=conectar();
				pg_query($conex,$insertar) or die (pg_last_error($conex));
				if(isset($_POST["crear_uno"])){
					iraURL('../administrator/tipoinfo.php');	
				}else{
					iraURL('../administrator/creartipoinfo.php');	
					}	
				llenarLog(1,"Tipo de Información");
			}else{
				javaalert("Debe agregar todos los campos, por favor verifique");
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
<meta charset="iso-8859-1">
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
            <li class="dropdown"> <a  class="dropdown-toggle" data-target="#" data-toggle="dropdown"> Gestión Usuarios <b class="caret"></b> </a>
              <ul class="dropdown-menu">
                <li><a href="tipoadmin.php"> Tipo Administrador </a></li>
                <li><a href="admin.php">Administrador</a></li>
                <li><a href="usuario.php">Usuario</a></li>
              </ul>
            </li>
            <li><a href="menu.php"> Menú</a></li>
            <li><a href="producto.php">Producto</a></li>
            <li><a href="sucursal.php">Sucursal</a></li>
            <li class="dropdown active">
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
              <li class="active"><a href="tipoinfo.php"> <span class="add-on"><i class="icon-arrow-left"></i></span> Atrás </a></li>
          </ul>
      </div>
    </div>
                 

   <div class="span9 well well-large" >
 			<p>
        <div class="span3 well well-small"><b>Nombre</b></div>
            <div class="span6 well well-small "><input type="text" name="nombre" id="nombre" maxlength="34" title="Ingrese el nombre" placeholder="Ej. Servicios" autofocus required/></div>
            <div class="span3 well well-small"><b>Descripción</b></div>
            <div class="span6 well well-small"> <input type="text" id="descripcion" name="descripcion" maxlength="249" title="Ingrese la descripción" placeholder="Ej. Servicios que ofrece la empresa" required/></div>
          <div class="span9 well well-small" align="center"><button class="btn btn-primary" id="crear_uno" name="crear_uno" type="submit">Guardar</button></div>
			<div class="span9 well well-small" align="center"> <button class="btn btn-primary" id="crear_otro" name="crear_otro" type="submit">Guardar y añadir otro</button></div>

            </p>
    </div>
    </div>
    </div>
  
</div>

<!-- Le javascript
================================================== --> 
<script type="text/javascript" src="../recursos/js/jquery-2.0.2.js" ></script> 
<script src="../recursos/js/bootstrap.js"></script>
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

      
   </form>
</body>
</html>
