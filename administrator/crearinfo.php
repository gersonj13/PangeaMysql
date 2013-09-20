<?php
session_start();

include("../recursos/funciones.php");
$conn=conectar();

if(!isset($_SESSION["usuarioadmin"]) || !isset($_SESSION["passwordadmin"])){
	iraURL('../administrator/index.php');
}


if(isset($_POST["guardar"]) || isset($_POST["guardar2"])){
	
	if(isset($_POST["titulo"]) && isset($_POST["redactor"]) && $_POST["titulo"]!="" && $_POST["redactor"]!="" && $_POST["tipoinfo"]>0){
	
		$titulo=$_POST['titulo'];
		$descripcion=$_POST['redactor'];
		$enlace=$_POST['enlace'];
		$tipoinfo=$_POST['tipoinfo'];
		
		$resultado=mysql_query($conn,"INSERT INTO informacion values( nextval('informacion_informacionid_seq'),'$titulo','$descripcion','$enlace','','$tipoinfo',".$_SESSION["id_usuario"].")") or die(pg_last_error($conn));
	
		$sql_select="SELECT last_value FROM informacion_informacionid_seq;";
		$results=mysql_query($conn, $sql_select);
		$arreglo=mysql_fetch_array($results,0);
	
		if($_FILES['imagen']['name']!=""){
		
			$caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"; //posibles caracteres a usar
			$numerodeletras=5; //numero de letras para generar el texto
			$cadena = ""; //variable para almacenar la cadena generada
			for($i=0;$i<$numerodeletras;$i++){
    			$cadena .= substr($caracteres,rand(0,strlen($caracteres)),1); /*Extraemos 1 caracter de los caracteres 
				entre el rango 0 a Numero de letras que tiene la cadena */
			}
		
			$direccion="../recursos/img/informacion";
			$direccion2="recursos/img/informacion";
			$tipo = explode('/',$_FILES['imagen']['type']);
			$uploadfile =$direccion."/".$cadena.".".$tipo[1];
			$uploadfile2 =$direccion2."/".$cadena.".".$tipo[1];
			$error = $_FILES['imagen']['error'];
			
			//Agregar esta linea
			$imagen=$_FILES['imagen']['tmp_name'];
		
			if($error==UPLOAD_ERR_OK){
				
				//Nueva función
			   	move_uploaded_file($imagen,$uploadfile);			
				$sql_update="update informacion set imagen='".$uploadfile2."' where informacionid=".$arreglo[0]."";
				$result= mysql_query($conn, $sql_update);																									
			}		
		 }
	
		if($resultado || $result){
			javaalert('Se Creo la Información');
			llenarLog(1, "Información");
			if(isset($_POST["guardar"])){
				iraURL('../administrator/info.php');
			}
			else{
				iraURL('../administrator/crearinfo.php');
			}
				
		}
	}else{
		javaalert("Ingrese todos los campos");
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
<form enctype="multipart/form-data" method="post">
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
            <li class="dropdown active">
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
             <li class="active"><a href="info.php"> <span class="add-on"><i class="icon-arrow-left"></i></span> Atrás</a></li>          
          </ul>
      </div>
    </div>
        
        <div class="span9 well well-large">
        <p>
        
            <div class="span3 well well-small"><b>Título</b></div>
            <div class="span6 well well-small"><input id="titulo" name="titulo" type="text" maxlength="249" pattern="[A-Za-z,ñ,Ñ,á,é,í,ó,ú,Á,É,Í,Ó,Ú, 0-9]{1,249}" required autofocus/></div>
            <div class="span3 well well-small"><b>Descripción</b></div>
            <div class="span6 well well-small"><textarea id="redactor" name="redactor" maxlength="2499"></textarea></div>
            <div class="span3 well well-small"><b>Enlace</b></div>
            <div class="span6 well well-small"><input id="enlace" name="enlace" type="text" maxlength="249"/></div>
            <div class="span3 well well-small"><b>Imagen</b></div>
            <div class="span6 well well-small"><input id="imagen" name="imagen" type="file"/>
            	</br>
                <h5>Tamaños Recomendados</h5>
                <ul>
                	<li>Redes Sociales 40*40</li>
                    <li>Tecnología 180*130</li>
                    <li>Información 320*420</li>
                </ul>
            </div>
            <div class="span3 well well-small"><b>Tipo de Información</b></div>
            <div class="span6 well well-small"><select id="tipoinfo" name="tipoinfo">
                    	<option value="0">Seleccione Opción</option>
                        <?php
		
						$SQL="SELECT * FROM tipoinformacion";
						$result = mysql_query ($conn, $SQL ) or die("Error en la consulta SQL");
						
						while($row=mysql_fetch_array($result)){
							echo '<option value="'.$row['tipoinformacionid'].'">'.$row['nombre'].'</option>';

							}

						?>
                    </select></div>
                 <div class="span9 well well-small" align="center">
      <button name="guardar" id="guardar" type="submit" class="btn btn-primary text-center">Guardar</button>
      </div>
      
      <div class="span9 well well-small" align="center">
      <button id="guardar2" name="guardar2" class="btn btn-primary text-center" type="submit">Guardar y añadir otro</button>
      </div>
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
