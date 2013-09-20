<?php
session_start();

include("../recursos/funciones.php");
$conn=conectar();
if(!isset($_SESSION["usuarioadmin"]) || !isset($_SESSION["passwordadmin"])){
	iraURL('../administrator/index.php');
	}
	//codigo para guardar 
	if(isset($_POST["crear_uno"]) || isset($_POST["crear_otro"])){

	if(isset($_POST["nombre"]) && $_POST["nombre"]!="" && isset($_POST["redactor"]) && $_POST["redactor"]!="" && isset($_POST["enlace"]) && $_POST["enlace"]!="" ){		
				$insertar = "insert into producto values(default,'".$_POST['nombre']."','".$_POST['redactor']."','".$_POST['enlace']."','');";
				$conex=conectar();
				mysql_query($insertar,$conex) or die (mysql_error($conex));
			/*	$sql_select="SELECT last_value FROM producto_productoid_seq;";				
				$results = mysql_query($sql_select,$conn) or die(mysql_error());
				mysql_data_seek($results,0);
				$arreglo = mysql_fetch_array($results);*/
				if($_FILES['imagen']['name']!=""){
					
					$caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"; //posibles caracteres a usar
					$numerodeletras=5; //numero de letras para generar el texto
					$cadena = ""; //variable para almacenar la cadena generada
					for($i=0;$i<$numerodeletras;$i++){
						$cadena .= substr($caracteres,rand(0,strlen($caracteres)),1); /*Extraemos 1 caracter de los caracteres 
						entre el rango 0 a Numero de letras que tiene la cadena */
					}
					
					$direccion="../recursos"; //para cargar
					$direccion2="recursos";//para guardar
					$tipo = explode('/',$_FILES['imagen']['type']);
					$uploadfile =$direccion."/img/producto/".$cadena.".".$tipo[1];
					$uploadfile2 =$direccion2."/img/producto/".$cadena.".".$tipo[1];
					$error = $_FILES['imagen']['error']; 
					
					//Agregar esta linea
					$imagen=$_FILES['imagen']['tmp_name'];
					
					
					if($error==UPLOAD_ERR_OK){ 
							
							//Nueva función
			   				move_uploaded_file($imagen,$uploadfile);	
							$rs = mysql_query("SELECT MAX(productoid) AS id FROM producto");
								if ($row = mysql_fetch_row($rs)) {
								$id = trim($row[0]);	
								}
							$sql_update="update PRODUCTO set imagen='".$uploadfile2."' where productoid=$id";
							$result=mysql_query($sql_update,$conn) or die (mysql_error($conn));

																																
						}		
					 }
				
			
						llenarLog(1,"PRODUCTO");
						if(isset($_POST["crear_uno"])){
						iraURL('../administrator/producto.php');		
						}else{
						iraURL('../administrator/crearproducto.php');	
							}	
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
<meta charset="utf-8">
<link href="../recursos/css/bootstrap.css" rel="stylesheet">
<link href="../recursos/css/bootstrap.min.css" rel="stylesheet">
<link href="../recursos/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="../recursos/css/estiloadmin.css" rel="stylesheet">
	<!-- Importanto plantilla del Redactor -->
	<link rel="stylesheet" href="../recursos/redactor/redactor.css" />
	
</head>

<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">
		<form enctype="multipart/form-data"  method="POST">

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
              <li class="active"><a href="producto.php"> <span class="add-on"><i class="icon-arrow-left"></i></span> Atrás </a></li>
          </ul>
      </div>
    </div>
     <div class="span9 well well-large" >
 			<p>
        <div class="span3 well well-small"><b>Nombre</b></div>
            <div class="span6 well well-small "><input type="text" name="nombre" id="nombre" maxlength="249" title="Ingrese el nombre" placeholder="Ej. Sistema de Comercialización" autofocus required/></div>
            <div class="span3 well well-small"><b>Descripción</b></div>
            <div class="span6 well well-small"><textarea id="redactor" name="redactor" maxlength="2499" required></textarea></div>
             <div class="span3 well well-small"><b>Enlace</b></div>
            <div class="span6 well well-small"><input type="text" name="enlace" id="enlace" maxlength="249" title="Ingrese el enlace" placeholder="Ej. http:/..."  required/></div>
             <div class="span3 well well-small"><b>Imagen</b></div>
            <div class="span6 well well-small"><input id="imagen" name="imagen" type="file" maxlength="249" required/></div>
            <div class="span9 well well-small" align="center"><button class="btn btn-primary" id="crear_uno" name="crear_uno" type="submit">Guardar</button></div>
			<div class="span9 well well-small" align="center"> <button class="btn btn-primary" id="crear_otro" name="crear_otro" type="submit">Guardar y añadir otro</button></div>

            </p>
    </div>
    
    
    </div>

  
</div>
<!-- Javascript
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

<!--Jquery para el Redactor
================================================== --> 
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
    		</form >

</body>
</html>
