<?php
session_start();

include("../recursos/funciones.php");
$conn=conectar();
if(!isset($_SESSION["usuarioadmin"]) || !isset($_SESSION["passwordadmin"])){
	iraURL('../administrator/index.php');
	}
	
if(isset($_GET['s']))
{
	
	$SQL="update menu set orden=(orden-1) where menuid=".$_GET['s']."";
    $result = mysql_query ($conn,$SQL) or die("Error en la consulta SQL");
	
	
}
if(isset($_GET['b']))
{
	
	$SQL="update menu set orden=(orden+1) where menuid=".$_GET['b']."";
    $result = mysql_query ($conn,$SQL) or die("Error en la consulta SQL");
	
	
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
          <li class="active"><a href="crearmenu.php"> <span class="add-on"><i class="icon-plus "></i></span> Crear </a></li>
          <li><a href="principal.php"> <span class="add-on"><i class="icon-arrow-left"></i></span> Atrás</a></li>
        </ul>
      </div>
    </div>
    <div class="span9">
      <?php 
		
		$SQL="SELECT * FROM menu order by orden asc,nombre asc";
		$result = mysql_query ($SQL,$conn) or die("Error en la consulta SQL");
		$registros= mysql_num_rows($result);
		
	if($registros == 0){
    ?>
      <div class="well alert alert-block">
        <h2 class="alert alert-block">Atención</h2>
        <h4>No existen registros en Menú</h4>
      </div>
      <?php 
	}else{
	
	?>
      <div class="well well-large">
        <p>
          <?php
		

	//mostrar resultados
	?>
        <table class="footable table-striped table-hover" data-page-size="5">
          <thead>
            <tr>
              <th data-class="expand" data-type="numeric"> <span>Id</span> </th>
              <th> <span>Nombre</span> </th>
              <th> <span></span> </th>
              <th data-hide="phone" data-sort-ignore="true"> Administrador </th>
              <th data-hide="phone" data-sort-ignore="true">Enlace </th>
              <th data-hide="phone" data-sort-ignore="true"> Orden </th>
              <th data-hide="phone,mediatablet" data-sort-ignore="true"> <span class="add-on"> <i class="icon-pencil"></i> </span> Editar </th>
              <th data-hide="phone,mediatablet" data-sort-ignore="true"> <span class="add-on"><i class="icon-trash"></i></span> Eliminar </th>
              <th data-hide="phone,mediatablet" data-sort-ignore="true"> <span class="add-on"><i class="icon-tasks"></i></span> Up/Down </th>
            </tr>
          </thead>
          <tbody>
          <form  method="get">
            <?php   
	  
		for ($i=0;$i<$registros;$i++)
			{

			$row = mysql_result($result,$i );
			 if($row["submenu"]=="0"){
			echo '<tr>';
			echo '<td width="10%">'.$row["menuid"].'</td>';
			echo '<td width="15%">'.$row["nombre"].' </td>';
			echo'<td width="5%"> <a href="submenu.php?id='.$row["menuid"].'"> <i id="add" class="icon-plus" /> </td> </a>';
			$SQL3="SELECT nombre FROM administrador WHERE administradorid=".$row["administradorid"];
		$result3 = mysql_query ($SQL3,$conn) or die("Error en la consulta SQL");
		$row3 = mysql_result ($result3);
		echo '<td width="10%">'.$row3["nombre"].' </td>';
		echo '<td width="15%">'.$row["enlace"].' </td>';	
		echo '<td width="4%">'.$row["orden"].' </td>';	  
			echo '<td width="15%"> <a href="editarmenu.php?id='.$row["menuid"].'"> <button class="btn btn-primary"  type="button" name="boton"> <span class="add-on"><i class="icon-pencil"></i> </span> Editar  </button>  </td></a>';
			echo '<td width="18%">  <a href="eliminarmenu.php?id='.$row["menuid"].'"> <button class="btn btn-primary"  type="button"  name="boton"> <span class="add-on"><i class="icon-trash"></i> </span> Eliminar  </button>  </td> </a>';
			echo '<td width="15%" style="text-align:center">  <a href="menu.php?s='.$row["menuid"].'"> 
			<i class="icon-circle-arrow-up"></i></a> <a href="menu.php?b='.$row["menuid"].'"> 
			<i class="icon-circle-arrow-down"></i> </td> </a> ';
			echo '</tr>';
			echo '</tr>';
		}
}
		?>
          </form>
            </tbody>
          
        </table>
        <?php
    }
	?>
        <ul id="pagination" class="footable-nav">
          <span>Pages:</span>
        </ul>
        </p>
      </div>
    </div>
  </div>
</div>

<!-- Le javascript
================================================== --> 

<script type="text/javascript" src="../recursos/js/jquery-2.0.2.js" ></script> 
<script src="../recursos/js/bootstrap.min.js"></script> 
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
