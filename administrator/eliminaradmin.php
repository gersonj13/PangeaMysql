<?php
session_start();

include("../recursos/funciones.php");
$conn=conectar();

if(!isset($_GET['id'])){
	iraURL('admin.php');
}

if(!isset($_SESSION["usuarioadmin"]) || !isset($_SESSION["passwordadmin"])){
	iraURL('../administrator/index.php');
}
	
	
if(isset($_POST["si"])){
	$SQL="DELETE FROM administrador WHERE administradorid=".$_GET['id'];
	$result = mysql_query ($conn, $SQL ) or die("Error en la consulta SQL");
	javaalert("El Administrador fue Eliminado");
	llenarLog(3, "Administrador");
	iraURL('../administrator/admin.php');
}
	
if(isset($_POST["no"])){
	iraURL('../administrator/admin.php');  
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
<link href="../recursos/footable/css/footable-0.1.css" rel="stylesheet" type="text/css" />
<link href="../recursos/footable/css/footable.sortable-0.1.css" rel="stylesheet" type="text/css" />
<link href="../recursos/footable/css/footable.paginate.css" rel="stylesheet" type="text/css" />
</head>

<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">
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
    
    <div class="span9">
   
      <?php 
		
		$SQL="SELECT * FROM administrador WHERE administradorid=".$_GET['id'];
		$result = mysql_query ($conn, $SQL ) or die("Error en la consulta SQL");
		$registros= mysql_num_rows($result);
		$row = mysql_fetch_array ($result);
		
		if($row==0){
			iraURL('admin.php');
		}

		
		$SQL2="SELECT * FROM administrador WHERE creadorid=".$_GET['id'];
		$result2 = mysql_query ($conn, $SQL2 ) or die("Error en la consulta SQL");
		$registros2= mysql_num_rows($result2);
		
		$SQL3="SELECT * FROM informacion WHERE administradorid=".$_GET['id'];
		$result3 = mysql_query ($conn, $SQL3 ) or die("Error en la consulta SQL");
		$registros3= mysql_num_rows($result3);
		
		$SQL4="SELECT * FROM usuario WHERE administradorid=".$_GET['id'];
		$result4 = mysql_query ($conn, $SQL4 ) or die("Error en la consulta SQL");
		$registros4= mysql_num_rows($result4);
		
		$SQL5="SELECT * FROM bitacora WHERE administradorid=".$_GET['id'];
		$result5 = mysql_query ($conn, $SQL5 ) or die("Error en la consulta SQL");
		$registros5= mysql_num_rows($result5);
		
		if($registros2!=0 || $registros3!=0 || $registros4!=0 || $registros5!=0){
		 ?>  
            
            <div class="well alert alert-danger" align="center">
    			<h2 style="color:rgb(255,255,255)"> Atención</h2>
    			<h4>No se puede Eliminar el Administrador</h4>
	 		</div>
     
     
     <?php
		  }
		else if($registros2==0 || $registros3==0 || $registros4==0 || $registros5==0){
		
    ?>
    
    <div class="well well-small alert alert-block" align="center">
    	<h2 style="color:rgb(255,255,255)"> Atención</h2>
    	<h4>Desea Eliminar el Administrador</h4>
    </div>

      <div class="well well-large">
      <br><br>
      
      <form method="post">
	    <table class="footable table-striped table-hover" data-page-size="5">
			  <thead>
				<tr>
				  <th data-sort-ignore="true">
					<span>Nombre y Apellido</span>
				  </th>
				  <th data-sort-ignore="true">
					<span>Nombre de Usuario</span>
				  </th>
				</tr>
			  </thead>
	<tbody>
      <?php   
	  		echo '<tr>';
			echo '<td width="50%"><label>'.$row["nombre"].'  '.$row["apellido"].'</label></td>';
			echo '<td width="50%"><label>'.$row["usuario"].'</label></td>';
			echo '</tr>';
		?>
	</tbody>	  
    </table>
    
    <button id="si" name="si" class="btn btn-primary text-center" type="submit">  Si </button>
    <button id="no" name="no" class="btn btn-primary text-center" type="submit">  No </button>
	 </form> 
    
    </div>
     	<?php
		}
?>
      

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

<script src="../recursos/footable/js/footable.js" type="text/javascript"></script>
<script src="../recursos/footable/js/footable.paginate.js" type="text/javascript"></script>
<script src="../recursos/footable/js/footable.sortable.js" type="text/javascript"></script>
 
  <script type="text/javascript">
    $(function() {
      $('table').footable();
    });
  </script>
	</body>
</html>
