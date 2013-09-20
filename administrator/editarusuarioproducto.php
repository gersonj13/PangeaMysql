<?php
session_start();

include("../recursos/funciones.php");
$conn=conectar();
if(!isset($_GET["id"])){
	iraURL('usuario.php');
	}

if(!isset($_SESSION["usuarioadmin"]) || !isset($_SESSION["passwordadmin"])){
	iraURL('../administrator/index.php');
	}
	
$id=$_GET['id'];
if(isset($_POST["guardar"])){
		$producto=$_POST['producto'];
		$resultado=pg_query($conn,"UPDATE usuarioproducto SET  productoid='$producto' WHERE usuarioproductoid=$id") or die(pg_last_error($conn));
		 if($resultado){
			javaalert('Se Modifico el producto asignado');
			llenarLog(2, "usuarioproducto");
			iraURL('usuarioproducto.php?id='.$_GET['idusuario']);	
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
<!-- Importanto plantilla del Redactor -->
	<link rel="stylesheet" href="../recursos/redactor/redactor.css" />
</head>

<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">
<div class="container">
  <div class="navbar">
    <div class="navbar-inner">
      <div class="container" style="width: auto;"> <a class="btn btn-navbar" href="#nav" data-toggle="collapse" data-target="#barrap"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a> <a  class="brand" id="brand-admin" href="#">PANGEATECH</a>
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
             <li class="active"><a href="usuarioproducto.php?id=<?php echo $_GET['idusuario'];?>"> <span class="add-on"><i class="icon-arrow-left"></i></span> Atrás</a></li>          
          </ul>
      </div>
    </div>
        
     <div class="span9">
      <div class="well well-large">
        <p>	
      <form enctype="multipart/form-data" method="post">
          <div class="row-fluid">
            <dl class="dl-horizontal">
          
              <dd>
              <dt>
                <div class=" well well-small" align="left"><b>Nombre</b> del producto</div>
              </dt>
              <dd>
                <div class="well well-small">
                  <select id="producto" name="producto">
                        <?php
						$consu1="SELECT producto.productoid,nombre FROM producto,usuarioproducto where usuarioproducto.productoid=producto.productoid and usuarioproductoid=".$_GET["id"];
						$resulta3 = pg_query ($conn, $consu1) or die("Error en la consulta SQL");
						$registros= pg_num_rows($resulta3);
						if($registros!=1){
							iraURL("usuario.php");
							}
						if($row3=pg_fetch_array($resulta3)){
							echo '<option value="'.$row3['productoid'].'">'.$row3['nombre'].'</option>';
                        
                        }
						$SQL="SELECT producto.productoid,nombre FROM producto where productoid NOT IN (SELECT productoid FROM usuarioproducto where usuarioid=".$_SESSION["usuarioid"].")";
						$resultpro = pg_query ($conn, $SQL ) or die("Error en la consulta SQL");
						while($rowpro=pg_fetch_array($resultpro)){
							echo '<option value="'.$rowpro['productoid'].'">'.$rowpro['nombre'].'</option>';
							}
						?>
                    </select>
                </div>
              </dd>
                <div class="well well-small" align="center">
                  <button id="guardar" name="guardar" class="btn btn-primary text-center" type="submit">Modificar</button>
                </div>
            </dl>
          </div>
        </form>
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