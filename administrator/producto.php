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
<link href="../recursoscss/bootstrap-responsive.css" rel="stylesheet">
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
            <li class="active"><a href="producto.php">Producto</a></li>
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
              <li class="active"><a href="crearproducto.php"> <span class="add-on"><i class="icon-plus "></i></span> Crear </a></li>
              <li><a href="principal.php"> <span class="add-on"><i class="icon-arrow-left"></i></span> Atrás</a></li>
          </ul>
      </div>
    </div>
    <div class="span9">
    <?php 
	$SQL="SELECT * FROM producto";
	
	$result = mysql_query($SQL,$conn) or die(mysql_error());
	$registros=mysql_num_rows($result);
	
	$result = pg_query ($conn, $SQL ) or die("Error en la consulta SQL");
	$registros= pg_num_rows($result);
	if($registros == 0){
    ?>
    <div class="alert alert-block" align="center">
   			<h2 style="color:rgb(255,255,255)"> Atención</h2>
    <h4>No existen registros en producto</h4>
   
   
    </div>
     <?php 
	}else{
	
	?>
      <div class="well well-large">
        <p>
	<table width="100%" class="footable table-striped table-hover" data-page-size="5">
      <thead>
				<tr>
				  <th data-class="expand" data-sort-initial="true" data-type="numeric">
					<span>Id</span>
				  </th>
				  <th>
					<span>Nombre</span>
				  </th>
				  <th data-hide="phone" data-sort-ignore="true">
					Descripción
				  </th>
                    <th data-hide="phone" data-sort-ignore="true">
					Enlace
				  </th>
				  <th data-hide="phone,mediatablet" data-sort-ignore="true">
					<span class="add-on"> <i class="icon-pencil"></i> </span> Editar 
				  </th>
				  <th data-hide="phone,mediatablet" data-sort-ignore="true">
				<span class="add-on"><i class="icon-trash"></i></span> Eliminar 
				  </th>
          		 <th data-hide="phone,mediatablet" data-sort-ignore="true">
				<span class="add-on"><i class="icon-eye-open"></i></span> Ver 
				  </th>
				</tr>
	 </thead>
  <tbody>
      <?php    
		for ($i=0;$i<$registros;$i++)
			{
					mysql_data_seek($result,$i);
				  	$row = mysql_fetch_array($result);			
			echo '<tr>';
			echo '<td width="7%">'.$row[0].'</td>';
			echo '<td width="15%">'.$row[1].'</td>';
			if(strlen ($row[2])>40){
				$descripcion=substr($row[2],0,40)."...";
				}else{
					$descripcion=$row[2];
					}
				if(strlen ($row[3])>20){
				$enlace=substr($row[3],0,20)."...";
				}else{
					$enlace=$row[3];
				}
			echo '<td width="19%">'.$descripcion.'</td>';
			echo '<td width="15%">'.$enlace.'</td>';
			echo '<td width="15%"><a href="editarproducto.php?id='.$row[0].'"><button class="btn btn-primary"> <span class="add-on"><i class="icon-pencil"></i> </span> Editar  </button> </td>';
			echo '<td width="16%"><a href="eliminarproducto.php?id='.$row[0].'"> <button class="btn btn-primary" type="button"  name="eliminar"> <span class="add-on"><i class="icon-trash"></i></span> Eliminar</button> </td>';
			echo '<td width="13%"><a href="verproducto.php?id='.$row[0].'"> <button class="btn btn-primary"> <span class="add-on"><i class="icon-eye-open"></i></span> Ver</button> </td>';
			echo '</tr>';
			}
		?>
	</tbody>	
</table>
 <ul id="pagination" class="footable-nav"><span>Pages:</span></ul>

<?php 
	}
?>
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
