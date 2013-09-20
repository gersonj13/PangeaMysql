<?php
session_start();

include("../recursos/funciones.php");
$conn=conectar();
if(!isset($_SESSION["usuarioadmin"]) || !isset($_SESSION["passwordadmin"])){
	iraURL('../administrator/index.php');
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
            <li class="dropdown">
             <a  class="dropdown-toggle" data-target="#" data-toggle="dropdown">
              Gestión Información <b class="caret"></b> </a>
              <ul class="dropdown-menu">
                <li><a href="tipoinfo.php">Tipo Infomación</a></li>
                <li><a href="info.php">Información</a></li>
              </ul>
            </li>
           <?php if(supera($_SESSION["admin"])){
            ?><li class="active"><a href="bitacora.php"> Bitácora</a></li>
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
              <li class="active"> <a href="eliminarbitacora.php">  <span class="add-on"><i class="icon-trash"></i> </span> Vaciar Bitácora  </a> </li>
              <li><a href="principal.php"> <span class="add-on"><i class="icon-arrow-left"></i></span> Atrás</a></li>
            </ul>
      </div>
    </div>
    <div class="span9">
    
      <?php 
		$SQL="SELECT * FROM bitacora order by bitacoraid desc";
		$result = mysql_query ($SQL, $conn) or die("Error en la consulta SQL");
		$registros= mysql_num_rows($result);
		
	if($registros == 0){
    ?>
    <div class="well alert alert-block">
    <h2 class="alert alert-block">Atención</h2>
    <h4>No Existen Registros en Bitácora</h4>
    </div>
     <?php 
	}else{
	
	?>
      <div class="well well-large">
        <p>
        <?php

	//mostrar resultados
	?>
	 <table class="footable table-striped table-hover" data-page-size="10">
			  <thead>
				<tr>
				  <th data-class="expand" data-sort-initial="true" data-type="numeric">
					<span>Id</span>
				  </th>
				  <th>
					<span>Acción</span>
				  </th>
                    <th data-hide="phone" data-sort-ignore="true">
				Descripción 
				  </th>
				  <th data-hide="phone,mediatablet" data-sort-ignore="true">
					Fecha
				  </th>
				  <th data-hide="phone,mediatablet" data-sort-ignore="true">
					 Hora
				  </th>
				  <th data-hide="phone,mediatablet" data-sort-ignore="true">
				Administrador
				  </th>
                
				</tr>
			  </thead>
				<tbody>
    <form method="get"> 
   
      <?php   
	  
		for ($i=0;$i<$registros;$i++){

			$row = mysql_fetch_array ($result);
			
			echo '<tr>';
			echo '<td width="10%" align="center">'.$row["bitacoraid"].'</td>';
			echo '<td width="20%" align="center">'.$row["accion"].'</td>';
			echo '<td width="20%" align="center">'.$row["descripcion"].'</td>';
			echo '<td width="20%" align="center">'.$row["fecha"].'</td>';
			echo '<td width="20%" align="center">'.$row["hora"].'</td>';
			
			$SQL3="SELECT nombre FROM administrador WHERE administradorid=".$row["administradorid"];
			$result3 = mysql_query ($SQL3, $conn) or die("Error en la consulta SQL");
			$row3 = mysql_fetch_array ($result3);
		
			echo '<td width="20%" align="center">'.$row3["nombre"].'</td>';
		    echo '</tr>';
            
			}  
		?>
      
	 </form> 	
	</tbody>	  
    </table>
    <?php
    }
	?>

    <ul id="pagination" class="footable-nav"><span>Pages:</span></ul>
        
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