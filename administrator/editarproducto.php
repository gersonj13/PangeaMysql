<?php
session_start();

include("../recursos/funciones.php");
$conex=conectar();
if(!isset($_GET["id"])){
	iraURL('producto.php');
	}
if(!isset($_SESSION["usuarioadmin"]) || !isset($_SESSION["passwordadmin"])){
	iraURL('../administrator/index.php');
	}
			
if(isset($_POST["guardar"])){
	if(isset($_POST["nombre"]) && $_POST["nombre"]!="" && isset($_POST["redactor"]) && $_POST["redactor"]!="" && isset($_POST["enlace"]) && $_POST["enlace"]!="" ){		

		$id=$_GET['id'];
		$nombre=$_POST['nombre'];
		$descripcion=$_POST['redactor'];
		$enlace=$_POST['enlace'];
        $update="UPDATE producto SET nombre='$nombre', descripcion='$descripcion' , enlace='$enlace' where productoid=$id";
		$resultado=mysql_query($update,$conex) or die (mysql_error($conex));
		if($resultado){
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
			$sql_update="update PRODUCTO set imagen='".$uploadfile2."' where productoid=".$_GET['id'];
		$resultado=mysql_query($sql_update,$conex) or die (mysql_error($conex));
																													
			}		
		 }			
		llenarLog(2, "Producto");
		javaalert("El producto fue modificado con éxito");
		iraURL("producto.php");
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
             <li class="active"><a href="producto.php"> <span class="add-on"><i class="icon-arrow-left"></i></span> Atrás</a></li> 
          </ul>
      </div>
    </div>
    <div class="span9">
      <div class="well well-large">
       <?php
        $cons="SELECT * FROM producto WHERE productoid=".$_GET['id'];
		$resulta = mysql_query($cons,$conex) or die(mysql_error($conex));
		$registros=mysql_num_rows($resulta);
		
						if($registros!=1){
							iraURL("producto.php");
							}
					$row = mysql_fetch_array($resulta);
		?>
      <form enctype="multipart/form-data" method="post">
          <div class="row-fluid">
            <dl class="dl-horizontal">
              <dt>
                <div class=" well well-small" align="left"> Nombre </div>
              </dt>
              <dd>
                <div class=" well well-small">
                  <input id="nombre" name="nombre"  type="text" value="<?php echo $row['nombre'];?>" maxlength="249" contenteditable=true required/>
                </div>
              </dd>
              <dt>
                <div class=" well well-small" align="left"> Descripción </div>
              </dt>
              <dd>
                <div class="well well-small">
                <textarea id="redactor" name="redactor" contenteditable="true" maxlength="2499" required><?php echo $row['descripcion'];?></textarea>
                </div>
              </dd>
               <dt>
                <div class=" well well-small" align="left"> Enlace </div>
              </dt>
              <dd>
                <div class=" well well-small">
                  <input id="enlace" name="enlace"  type="text" value="<?php echo $row['enlace'];?>" maxlength="249" contenteditable=true required/>
                </div>
              </dd>
               <dt>
                <div class=" well well-small" align="left"> Imagen </div>
              </dt>
              <dd>
                <div class=" well well-small">
                  <img width="200" height="100" src="<?php echo "../".$row['imagen'];?> ">
			<input id="imagen" name="imagen" type="file" maxlength="249"/>
                </div>
              </dd>
                <div class="well well-small" align="center">
                  <button id="guardar" name="guardar" class="btn btn-primary" type="submit"> <span class="add-on"></span>Modificar</button>
                </div>
             
            </dl>
          </div>
        </form>

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
 
</body>
</html>
