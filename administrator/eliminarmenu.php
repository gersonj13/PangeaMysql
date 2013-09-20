<?php
session_start();

include("../recursos/funciones.php");
$conn=conectar();
if(!isset($_SESSION["usuarioadmin"]) || !isset($_SESSION["passwordadmin"])){
	iraURL('../administrator/index.php');
	}
	 if($_GET['id']==''){
	 iraURL('../administrator/menu.php'); 
  }else {
	  
	  $SQLi="SELECT * FROM menu WHERE menuid=".$_GET['id'];
		$resulti = mysql_query ( $SQLi,$conn ) or die("Error en la consulta SQL");
		$registrosi= mysql_num_rows($resulti);
		if($registrosi==0){
		  iraURL('../administrator/menu.php');	
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
            <li class="dropdown"> <a  class="dropdown-toggle" data-target="#" data-toggle="dropdown"> Gestión Usuarios <b class="caret"></b> </a>
              <ul class="dropdown-menu">
                <li><a href="tipoadmin.php"> Tipo Administrador </a></li>
                <li><a href="admin.php">Administrador</a></li>
                <li><a href="usuario.php">Usuario</a></li>
              </ul>
            </li>
            <li class="active"><a href="menu.php"> Menú</a></li>
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
              <li class="active"><a href="menu.php"> <span class="add-on"><i class="icon-arrow-left"></i></span> Atrás </a></li>

          </ul>
          

        
      </div>
    </div>
    <div class="span9">
   
      <?php 
		
		 $SQL="SELECT * FROM menu WHERE menuid=".$_GET['id'];
		$result = mysql_query ( $SQL ,$conn) or die("Error en la consulta SQL");
		$registros= mysql_num_rows($result);
		$row = mysql_fetch_array ($result);
		
		
		$SQL2="SELECT * FROM menu WHERE submenu=".$_GET['id'];
		$result2 = mysql_query ( $SQL2,$conn ) or die("Error en la consulta SQL");
		$registros2= mysql_num_rows($result2);
		
	
		
		if($registros2!=0){
		 
			?>  
            
            <div class="well alert alert-danger" align="center">
    			<h2 style="color:rgb(255,255,255)"> Atención</h2>
    			<h4>No se puede Eliminar el Menú</h4>
	 		</div>
     
     
     <?php
		  }
		else if($registros2==0){
		
    ?>
    
    <div align="center" class="well well-small alert alert-block">
    	<h2 style="color:rgb(255,255,255)"> Atención</h2>
    	<h4>Desea Eliminar el Menú</h4>
    </div>

      <div class="well well-large">
      <br><br>
      
      <form method="post">
	    <table class="footable table-striped table-hover" data-page-size="5">
			  <thead>
				<tr>
				  <th data-sort-ignore="true">
					<span>Nombre</span>
				  </th>
				  <th data-sort-ignore="true">
					<span>Submenú</span>
				  </th>
                   <th data-sort-ignore="true">
					<span>Enlace</span>
				  </th>
                
				 
				</tr>
			  </thead>
				<tbody>
	  
      <?php   
	  echo '<tr>';
		echo '<td width="30%">  <label>'.$row["nombre"].' </label></td>';
			
			echo ' <td width="30%"> <label>'.$row["submenu"].' </label></td>';
			echo ' <td width="40%"> <label>'.$row["enlace"].' </label></td>';
			
			
			echo '</tr>';
		?>
 </tbody>	  
    </table>
    
    <button id="si" name="si" class="btn btn-primary text-center " type="submit">  Si  </button>
     <button id="no" name="no" class="btn btn-primary text-center " type="submit">  No </button>
	 </form> 
    
     	<?php
		   
		
		
		
		}
		
if(isset($_POST["si"])){
	   $SQL="DELETE FROM menu WHERE menuid=".$_GET['id'];
		$result = mysql_query ( $SQL,$conn ) or die("Error en la consulta SQL");
		llenarLog(3, "menu");
		javaalert("El menu fue eliminado");
		iraURL("menu.php");
		
	
}
if(isset($_POST["no"])){
		iraURL("menu.php");  
	
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