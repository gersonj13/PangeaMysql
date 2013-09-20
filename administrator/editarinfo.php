<?php
session_start();

include("../recursos/funciones.php");
$conn=conectar();

if(!isset($_GET['id'])){
	iraURL('info.php');
}

if(!isset($_SESSION["usuarioadmin"]) || !isset($_SESSION["passwordadmin"])){
	iraURL('../administrator/index.php');
}
	
$id=$_GET['id'];


if(isset($_POST["guardar"])){
	
	if(isset($_POST["titulo"]) && isset($_POST["redactor"]) && $_POST["titulo"]!="" && $_POST["redactor"]!="" && $_POST["tipoinfo"]>0){
	
		$titulo=$_POST['titulo'];
		$descripcion=$_POST['redactor'];
		$enlace=$_POST['enlace'];
		$tipoinfo=$_POST['tipoinfo'];
	
		$resultado=mysql_query("UPDATE informacion SET titulo='$titulo', descripcion='$descripcion', enlace='$enlace', tipoinformacionid='$tipoinfo' WHERE informacionid=$id", $conn) or die(mysql_error($conn));
	
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
				$sql_update="update informacion set imagen='".$uploadfile2."' where informacionid=$id";
				$result= mysql_query($sql_update, $conn);																									
			}	
		 }
		 
		 if($resultado || $result){
			javaalert('Se Modifico la Información');
			llenarLog(2, "Información");
			iraURL('../administrator/info.php');	
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
<div class="container">
  <div class="navbar">
    <div class="navbar-inner">
      <div class="container" style="width: auto;"> <a class="btn btn-navbar" href="#nav" data-toggle="collapse" data-target="#barrap"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a> <a  class="brand" id="brand-admin" href="#">PANGEATECH</a>
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
        
     <div class="span9">
      <div class="well well-large">
        <p>
        
        <?php
        	$cons="SELECT * FROM informacion WHERE informacionid=$id";
			$resulta = mysql_query ($cons, $conn) or die("Error en la consulta SQL");
			
			if($row=mysql_fetch_array($resulta)){
		?>
	
      <form enctype="multipart/form-data" method="post">
          <div class="row-fluid">
            <dl class="dl-horizontal">
              <dt>
                <div class=" well well-small" align="left">Título</div>
              </dt>
              <dd>
                <div class=" well well-small">
                  <input id="titulo" name="titulo" type="text" value="<?php echo $row['titulo']; ?>" contenteditable="true"  maxlength="249" pattern="[A-Za-z,ñ,Ñ,á,é,í,ó,ú,Á,É,Í,Ó,Ú, 0-9]{1,249}" required/>
                </div>
              </dd>
              <dt>
                <div class=" well well-small" align="left">Descripción</div>
              </dt>
              <dd>
                <div class="well well-small">
                  <textarea id="redactor" name="redactor" contenteditable="true"  maxlength="2499"><?php echo $row['descripcion']; ?></textarea>
                </div>
              </dd>
              <dt>
                <div class=" well well-small" align="left">Enlace</div>
              </dt>
              <dd>
                <div class="well well-small">
                  <input id="enlace" name="enlace" type="text" value="<?php echo $row['enlace']; ?>" contenteditable="true"  maxlength="249"/>
                </div>
              </dd>
              <dt>
                <div class=" well well-small" align="left">Imagen</div>
              </dt>
              <dd>
                <div class="well well-small">
                <?php if($row['imagen']!=""){?>
                  <img src="<?php echo "../".$row['imagen'];?> ">
                  <?php }?>
                	<input id="imagen" name="imagen" type="file"/>
                	</br>
                    <ul>
                		<li>Redes Sociales 40*40</li>
                    	<li>Tecnología 180*130</li>
                    	<li>Información 320*420</li>
                	</ul>
                </div>
              </dd>
              <dd>
              <dt>
                <div class=" well well-small" align="left">Tipo Información</div>
              </dt>
              <dd>
                <div class="well well-small">
                  <select id="tipoinfo" name="tipoinfo" contenteditable="true">
                    <?php 
						
						$consu1="SELECT * FROM tipoinformacion WHERE tipoinformacionid=".$row['tipoinformacionid'];
						$resulta3 = mysql_query ($consu1, $conn) or die("Error en la consulta SQL");
						if($row3=mysql_fetch_array($resulta3)){
							echo '<option value="'.$row3['tipoinformacionid'].'">'.$row3['nombre'].'</option>';
                        
                        }
		
						$SQL="SELECT * FROM tipoinformacion WHERE tipoinformacionid!=".$row['tipoinformacionid'];
						$resulta4= mysql_query ($SQL, $conn) or die("Error en la consulta SQL");
						
						while($row4=mysql_fetch_array($resulta4)){
							echo '<option value="'.$row4['tipoinformacionid'].'">'.$row4['nombre'].'</option>';

							}

						?>
                    </select>
                </div>
              </dd>
                <div class="well well-small" align="center">
                  <button id="guardar" name="guardar" class="btn btn-primary text-center" type="submit">Modificar</button>
                </div>
            </dl>
          </div>
        </form>
    
        <?php } else{
				if($row==0){
					iraURL('info.php');
				}
			}?>
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
</body>
</html>