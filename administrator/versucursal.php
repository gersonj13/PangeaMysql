<?php
session_start();

include("../recursos/funciones.php");
$conn=conectar();

if(!isset($_SESSION["usuarioadmin"]) || !isset($_SESSION["passwordadmin"])){
	iraURL('../administrator/index.php');
	}
	
	 if($_GET['id']==''){
	 iraURL('../administrator/sucursal.php'); 
  }else {
	  
	  $SQLi="SELECT * FROM sucursal WHERE sucursalid=".$_GET['id'];
		$resulti = mysql_query ($SQLi,$conn ) or die("Error en la consulta SQL");
		$registrosi= mysql_num_rows($resulti);
		if($registrosi==0){
		  iraURL('../administrator/sucursal.php');	
		}
	  
  }
	
$id=$_GET['id'];

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
<!-- Importanto plantilla del Redactor -->
	<link rel="stylesheet" href="../recursos/redactor/redactor.css" />
</head>

<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">
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
            <li class="active"><a href="sucursal.php">Sucursal</a></li>
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
             <li class="active"><a href="sucursal.php"> <span class="add-on"><i class="icon-arrow-left"></i></span> Atrás</a></li>          
          </ul>
      </div>
    </div>
    
    <div class="span9 well well-large">
        <p>
        
        <?php
        	$cons="SELECT * FROM sucursal WHERE sucursalid=$id";
			$resulta = mysql_query ($cons, $conn) or die("Error en la consulta SQL");
			
			if($row=mysql_fetch_array($resulta)){
		?>
        
			<div class="span3 well well-small"><b>Id</b></div>
            <div class="span6 well well-small "><?php echo $row['sucursalid'];?></div>
            <div class="span3 well well-small"><b>Nombre</b></div>
            <div class="span6 well well-small"><?php echo $row['nombre'];?></div>
            <div class="span3 well well-small"><b>Dirección</b></div>
            <div class="span6 well well-small" align="justify"><?php echo $row['direccion'];?></div>
            <div class="span3 well well-small"><b>Telefono</b></div>
            <div class="span6 well well-small"><?php echo $row['telefono'];?></div>
            <div class="span3 well well-small"><b>Correo</b></div>
            <div class="span6 well well-small"><?php echo $row['correo'];?></div>
            <div class="span3 well well-small"><b>Imagen</b></div>

            <div class="span6 well well-small"><img src="<?php echo "../".$row['imagen'];?>"></div>
            <div class="span3 well well-small"><b>Latitud</b></div>
            <div class="span6 well well-small"><?php echo $row['latitud'];?></div>
            <div class="span3 well well-small"><b>Longitud</b></div>
            <div class="span6 well well-small"><?php echo $row['longitud'];?></div>
            <div class="span3 well well-small"><b>Descripción</b></div>
            <div class="span6 well well-small"><?php echo $row['descripcion'];?></div>
 
                

     <?php }?>

         </p>
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

<script src="../recursos/redactor/redactor.js"></script>
<script src="../recursos/redactor/redactor.min.js"></script>
<script type="text/javascript">
	$(document).ready(
		function()
		{
			$('#redactor').redactor();
		}
	);
	</script>
</body>
</html>
