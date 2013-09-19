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
if(isset($_POST["guardar"])){	
	if($_POST["producto"]>0){
		$producto=$_POST["producto"];
		$usuario=$_GET["id"];
		$resultado=pg_query($conn,"INSERT INTO usuarioproducto values( nextval('usuarioproducto_usuarioproductoid_seq'),$usuario,$producto)") or die(pg_last_error($conn));
		if($resultado){			
			llenarLog(1, "USUARIOPRODUCTO");	
		}
	}else{
		javaalert("Debe seleccionar un producto");
}
}
// verificando los productos que no estan asociados a este cliente
$SQL="SELECT * FROM producto where productoid NOT IN (SELECT productoid FROM usuarioproducto where usuarioid=".$_GET['id'].")";
$resultpro = pg_query ($conn, $SQL ) or die("Error en la consulta SQL");
$nro= pg_num_rows($resultpro);
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
            <li ><a href="menu.php"> Menú</a></li>
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
              <li class="active"><a href="usuario.php"> <span class="add-on"><i class="icon-arrow-left"></i></span> Atrás </a></li>
          </ul>
      </div>
    </div>
      <?php 
		$SQL="SELECT usuarioproductoid,nombre FROM usuarioproducto,producto where usuarioproducto.productoid=producto.productoid and usuarioid=".$_GET["id"];
		$result = pg_query ($conn, $SQL ) or die("Error en la consulta SQL");
		$registros= pg_num_rows($result);
	
	?>
     <div class="span9 well well-large">
  
        <p>
        <?php
		?>
    <form method="post">
    <?php
    if($registros != 0){
		
		?>
	 <table class="footable table-striped table-hover" data-page-size="5">
			  <thead>
				<tr>
				  <th data-class="expand" data-sort-initial="true" data-type="numeric">
				
					<span>Nombre</span>
				  </th>
 <th data-hide="phone" data-sort-ignore="true">
					<span class="add-on"> <i class="icon-pencil"></i> </span> Editar 
				  </th>
                   <th data-hide="phone" data-sort-ignore="true">
					<span class="add-on"> <i class="icon-trash"></i> </span> Eliminar
				  </th>
				</tr>
			  </thead>
				<tbody>
      <?php 
		for ($i=0;$i<$registros;$i++)
			{
			$row = pg_fetch_array ($result,$i );
		    echo '<tr>';
			echo '<td width="40%">'.$row["nombre"].' </td> </a>';
			if($nro==0){
		echo '<td width="15%"> <a href="editarusuarioproducto.php?id='.$row["usuarioproductoid"].'&idusuario='.$_GET["id"].'"> <button class="btn btn-primary" type="button" name="boton" disabled> <span class="add-on"><i class="icon-pencil"></i> </span> Editar  </button>  </td></a>';
				}else{
		echo '<td width="15%"> <a href="editarusuarioproducto.php?id='.$row["usuarioproductoid"].'&idusuario='.$_GET["id"].'"> <button class="btn btn-primary"  type="button" name="boton"> <span class="add-on"><i class="icon-pencil"></i> </span> Editar  </button>  </td></a>';
	
			}
			echo '<td width="15%">  <a href="eliminarusuarioproducto.php?id='.$row["usuarioproductoid"].'&idusuario='.$_GET["id"].'"> <button class="btn btn-primary"  type="button"  name="boton"> <span class="add-on"><i class="icon-trash"></i> </span> Eliminar  </button>  </td></a>';
			echo '</tr>';
			}
		?>
        </tbody>	  
    </table>
     <?php }else{  ?>
		 <div class="well alert alert-block">
   	<h2  align="center" style="color:rgb(255,255,255)"> Atención</h2>
    <h4 align="center">No tiene productos asignados</h4>
    </div>
		 
		 
	<?php } ?>
     
   </br>
   </br>
   <button type="button" class="btn btn-warning" data-toggle="collapse" data-target="#demo">
    Presione aquí para asignar
</button>
						
<div id="demo" class="collapse">
 <?php 
						
						if($nro>0){
							?>
      <div class="row-fluid">
            <dl class="dl-horizontal">
              <dt>
                <div class=" well well-small"><b>Nombre</b> del producto</div>
              </dt>
              <dd>
                <div class=" well well-small">
					
                              <select id="producto" name="producto">
                                <option value="0">Seleccione Opción</option>
                                <?php					
                                while($rowpro=pg_fetch_array($resultpro)){
                                    echo '<option value="'.$rowpro['productoid'].'">'.$rowpro['nombre'].'</option>';
                                    }
                                ?>
                              </select>   
                           
                    </div>
            </dd>
              </dl>
                <div align="center" class="well well-small"><button id="guardar" name="guardar" class="btn btn-primary text-center" type="submit"> Guardar</button>
                 </div>
       </div>
      				 <?php 
						}else{
							  ?>
                            <div class="well alert alert-block">
                            <h2  align="center" style="color:rgb(255,255,255)"> Atención</h2>
                            <h4 align="center">Ya no quedan productos por asignar</h4>
                            </div>
 
                             <?php 
							}
					?>        
  </div> 
</form> 	
  </div>       
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
