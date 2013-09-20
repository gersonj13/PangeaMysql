<?php
session_start();

include("../recursos/funciones.php");
$conn=conectar();
if(!isset($_SESSION["usuarioadmin"]) || !isset($_SESSION["passwordadmin"])){
	iraURL('../administrator/index.php');
	}

if(isset($_POST["guardar"])){
	
	if(isset($_POST["nombre"]) &&  isset($_POST["direccion"]) && isset($_POST["telefono"]) && isset($_POST["correo"]) && isset($_POST["latitud"]) && isset($_POST["longitud"]) && isset($_POST["redactor"]) && $_POST["nombre"]!="" && $_POST["direccion"]!="" && $_POST["telefono"]!="" && $_POST["correo"]!="" && $_POST["latitud"]!="" && $_POST["longitud"]!=""  && $_POST["redactor"]!="" ){
	
	$nombre=$_POST['nombre'];
	$direccion=$_POST['direccion'];
	$telefono=$_POST['telefono'];
	$correo=$_POST['correo'];
	$descripcion=$_POST['redactor'];
	$latitud=$_POST['latitud'];
	$longitud=$_POST['longitud'];
	

	
	$resultado=mysql_query("INSERT INTO sucursal values(default,'$nombre','$direccion','$telefono','$correo','','$latitud','$longitud','$descripcion')",$conn) or die(mysql_error($conn));
	
	$rs = mysql_query("SELECT MAX(sucursalid) AS id FROM sucursal");
        if ($row = mysql_fetch_row($rs)) {
       $arreglo = trim($row[0]); 
		}
	
	if($_FILES['imagen']['name']!=""){
		
		$caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"; //posibles caracteres a usar
		$numerodeletras=15; //numero de letras para generar el texto
		$cadena = ""; //variable para almacenar la cadena generada
		for($i=0;$i<$numerodeletras;$i++){
    		$cadena .= substr($caracteres,rand(0,strlen($caracteres)),1); /*Extraemos 1 caracter de los caracteres 
			entre el rango 0 a Numero de letras que tiene la cadena */
		}
		
		$direccion="../recursos/img/sucursal";
		$direccion2="recursos/img/sucursal";
		$tipo = explode('/',$_FILES['imagen']['type']);
		$uploadfile =$direccion."/".$cadena.".".$tipo[1];
		$uploadfile2 =$direccion2."/".$cadena.".".$tipo[1];
		$error = $_FILES['imagen']['error']; 
		
		//Agregar esta linea
		$imagen=$_FILES['imagen']['tmp_name'];
		
		if($error==UPLOAD_ERR_OK){ 
			//Nueva función
			move_uploaded_file($imagen,$uploadfile);		
			$sql_update="update sucursal set imagen='".$uploadfile2."' WHERE sucursalid=".$arreglo."";
			$result= mysql_query( $sql_update,$conn);
																													
			}		
		 }
	
	if($resultado && $result){
			llenarLog(1, "Creo sucursal");
			iraURL('../administrator/sucursal.php');
	}
	}else{
		javaalert("Debe llenar todos los campos obligatorios");
	}
}

if(isset($_POST["guardar2"])){
	
	if(isset($_POST["nombre"]) &&  isset($_POST["direccion"]) && isset($_POST["telefono"]) && isset($_POST["correo"]) && isset($_POST["latitud"]) && isset($_POST["longitud"]) && isset($_POST["redactor"]) && $_POST["nombre"]!="" && $_POST["direccion"]!="" && $_POST["telefono"]!="" && $_POST["correo"]!="" && $_POST["latitud"]!="" && $_POST["longitud"]!=""  && $_POST["redactor"]!="" ){
	
	$nombre=$_POST['nombres'];
	$direccion=$_POST['direccion'];
	$telefono=$_POST['telefono'];
	$correo=$_POST['correo'];
	$descripcion=$_POST['redactor'];
	$latitud=$_POST['latitud'];
	$longitud=$_POST['longitud'];

	
	$resultado=mysql_query("INSERT INTO sucursal values(default,'$nombre','$direccion','$telefono','$correo','','$latitud','$longitud','$descripcion')",$conn) or die(mysql_error($conn));
	
	$rs = mysql_query("SELECT MAX(sucursalid) AS id FROM sucursal");
        if ($row = mysql_fetch_row($rs)) {
       $arreglo = trim($row[0]); 
		}
	
	if($_FILES['imagen']['name']!=""){
		
		$caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"; //posibles caracteres a usar
		$numerodeletras=5; //numero de letras para generar el texto
		$cadena = ""; //variable para almacenar la cadena generada
		for($i=0;$i<$numerodeletras;$i++){
    		$cadena .= substr($caracteres,rand(0,strlen($caracteres)),1); /*Extraemos 1 caracter de los caracteres 
			entre el rango 0 a Numero de letras que tiene la cadena */
		}
		
		$direccion="../recursos/img/sucursal";
		$direccion2="recursos/img/sucursal";
		$tipo = explode('/',$_FILES['imagen']['type']);
		$uploadfile =$direccion."/".$cadena.".".$tipo[1];
		$uploadfile2 =$direccion2."/".$cadena.".".$tipo[1];
		$error = $_FILES['imagen']['error'];
		
		//Agregar esta linea
		$imagen=$_FILES['imagen']['tmp_name'];
		
		if($error==UPLOAD_ERR_OK){ 
			
			//Nueva función
			move_uploaded_file($imagen,$uploadfile);		
			$sql_update="update sucursal set imagen='".$uploadfile2."' WHERE sucursalid=".$arreglo."";
			$result= mysql_query( $conn,$sql_update);
																													
			}		
		 }
	
	if($resultado && $result){
			llenarLog(1, "Creo sucursal");
			iraURL('../administrator/crearsucursal.php');
	}
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
<link rel="stylesheet" href="../recursos/redactor/redactor.css" />
<link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>


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
     
			<form enctype="multipart/form-data"  method="POST">
        <div class="row-fluid">
            <dl class="dl-horizontal">
              
              
              <dt>
              <div class="well well-small"><b>Nombre</b></div>
              </dt>
              <dd>
                 <div class="well well-small"><input id="nombre" name="nombre" type="text" value="" required/></div>
              
              </dd>
              
              
                <dt>
           <div class="well well-small"><b>Dirección</b></div>
              </dt>
              <dd>
                  <div class="well well-small" align="justify"><input id="direccion" name="direccion" type="text" value="" required/></div>
                
              </dd>
              
               <dt>
            <div class="well well-small"><b>Telefono</b></div>
              </dt>
              <dd>
                 <div class="well well-small"><input title="telefono"  pattern="[0-9]{11}" id="telefono" name="telefono" type="tel" placeholder="Ej. 02761234567" maxlength="11" value="" required/></div>
                
              </dd>
              
              <dt>
            <div class="well well-small"><b>Correo</b></div>
              </dt>
              <dd>
                 <div class=" well well-small"><input id="correo" placeholder="ejemplo@correo.com" name="correo" type="email" value="" required/></div>
               
              </dd>

           <dt>
            <div class=" well well-small"><b>Imagen</b></div>
              </dt>
              <dd>
<div class=" well well-small"><input id="imagen" name="imagen" type="file" /></div>
                  
              </dd>

            <dt>
            <div class="well well-small"><b>Latitud</b></div>
              </dt>
              <dd>
<div class="well well-small"><input id="latitud" name="latitud" type="text" placeholder="+38.234534" pattern="[+,-][0-9]{1,3}[.][0-9]{6}"  value="" required/></div>
                 
              </dd>
           
          <dt>
            <div class="well well-small"><b>Longitud</b></div>
              </dt>
              <dd>
<div class="well well-small"><input id="longitud" name="longitud" type="text" placeholder="-12.234534" value="" pattern="[+,-][0-9]{1,3}[.][0-9]{6}" required/></div>
                
              </dd>
           
           
             <dt>
          <div class="well well-small"><b>Descripción</b></div>
              </dt>
              <dd>
<div class=" well well-small"><textarea id="redactor" name="redactor"  required></textarea> </div>
                
              </dd>
          
  

               <div align="center" class="span12 well well-small"> 
                	<button id="guardar" name="guardar" class="btn btn-primary text-center" type="submit">Guardar</button></div>
                     <div align="center" class="span12 well well-small"> 
                	<button id="guardar2" name="guardar2" class="btn btn-primary text-center" type="submit">Guardar y añadir otro</button></div>
                
            
        </form>
       
   

        
         </p>
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
</form>
	</body>
</html>