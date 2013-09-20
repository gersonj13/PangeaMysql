<?php
session_start();

include("../recursos/funciones.php");
$conn=conectar();
if(!isset($_SESSION["usuarioadmin"]) || !isset($_SESSION["passwordadmin"])){
	iraURL('../administrator/index.php');
	}

		
if(isset($_POST["guardar"])){

	if(isset($_POST["nombre"]) &&  isset($_POST["submenu"]) && $_POST["nombre"]!="" && $_POST["submenu"]!=""){
		$nombre=$_POST['nombre'];
		if($_POST['submenu']==''){
			$submenu="0";
		}else{
		$submenu=$_POST['submenu'];
		}
		$enlace=$_POST['enlace'];
		$orden="100";
		$admin=$_SESSION["id_usuario"];
        mysql_query("INSERT INTO menu values(default,'$nombre','$submenu','$admin','$enlace','$orden')",$conn) or die(mysql_error($conn));
llenarLog(1, "creo menu");

javaalert("El menu fue creado con exito");
iraURL("menu.php");
	}else{
		javaalert("Debe llenar todos los campos obligatorios");
	}
	
}

if(isset($_POST["guardar2"])){
	
	if(isset($_POST["nombre"]) &&  isset($_POST["submenu"]) && $_POST["nombre"]!="" && $_POST["submenu"]!=""){
		$nombre=$_POST['nombre'];
		if($_POST['submenu']=="Principal"){
			$submenu="0";
		}else{
		$submenu=$_POST['submenu'];
		}
		$enlace=$_POST['enlace'];
		$orden="100";
		$admin=$_SESSION["id_usuario"];
        mysql_query("INSERT INTO menu values(default,'$nombre','$submenu','$admin','$enlace','$orden')",$conn) or die(mysql_error($conn));
llenarLog(1, "creo menu");
javaalert("El menu fue creado con exito");
iraURL("crearmenu.php");
	}else{
		javaalert("Debe llenar todos los campos obligatorios");
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
              <li class="active"><a href="menu.php"> <span class="add-on"><i class="icon-arrow-left "></i></span> Atrás </a></li>

          </ul>

      </div>
    </div>
    <div class="span9">
      <div class="well well-large">
        <p>
        
	 <form method="post">
          <div class="row-fluid">
            <dl class="dl-horizontal">
              <dt>
                <div class=" well well-small"> <b> Nombre</b> </div>
              </dt>
              <dd>
                <div class=" well well-small">
                  <input id="nombre" name="nombre"  type="text" value="" contenteditable="true" required/>
                </div>
              </dd>
              <dt>
                <div class=" well well-small"> <b>Submenu </b></div>
              </dt>
              <dd>
                <div class="well well-small"><select id="submenu" name="submenu">
                    	<option value="0">Principal</option>
                        <?php
		
						$SQL="SELECT * FROM menu Where submenu=0";
						$result = mysql_query ($SQL ,$conn ) or die("Error en la consulta SQL");
						
						while($row=mysql_fetch_array($result)){
							echo '<option value="'.$row['menuid'].'">'.$row['nombre'].'</option>';

							}

						?>
                    </select>
                </div>
              </dd>
              
               <dt>
                <div class=" well well-small"><b> Enlace</b> </div>
              </dt>
              <dd>
                <div class=" well well-small">
                  <input id="enlace" name="enlace"  type="text" value="" contenteditable="true" required/>
                </div>
              </dd>
            
              
                <div align="center" class="well well-small">
                  <button id="guardar" name="guardar" class="btn btn-primary text-center" type="submit"> </span>Guardar</button>
                </div>
                 <div align="center" class="well well-small">
                  <button id="guardar2" name="guardar2" class="btn btn-primary text-center" type="submit"> </span>Guardar y añadir otro</button>
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


 
	</body>
</html>
