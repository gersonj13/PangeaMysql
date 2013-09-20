<?php
session_start();

include("../recursos/funciones.php");
$conn=conectar();

if(!isset($_GET['id'])){
	iraURL('admin.php');
}

if(!isset($_SESSION["usuarioadmin"]) || !isset($_SESSION["passwordadmin"])){
	iraURL('../administrator/index.php');
}

$id=$_GET['id'];


if(isset($_POST["guardar"])){
	
	$cons="SELECT * FROM administrador WHERE administradorid=$id";
	$resulta = mysql_query ($conn, $cons) or die("Error en la consulta SQL");
			
	if($row=mysql_fetch_array($resulta)){
		$id=$row['administradorid'];
	}
	
	
	if(isset($_POST["nombre"]) &&  isset($_POST["apellido"]) && isset($_POST["usuario2"]) && isset($_POST["contrasena"]) && isset($_POST["contrasena_c"]) && $_POST["nombre"]!="" && $_POST["apellido"]!="" && $_POST["usuario2"]!="" && $_POST["contrasena"]!="" && $_POST["contrasena_c"]!="" && $_POST["tipoadmin"]>0){
	
		$nombre=$_POST['nombre'];
		$apellido=$_POST['apellido'];
		$usuario=$_POST['usuario2'];
		$contrasena=$_POST['contrasena'];
		$tipoadmin=$_POST['tipoadmin'];
		
		$SQL="SELECT * FROM administrador where usuario='$usuario' and administradorid!=$id";
		$result = mysql_query ($conn, $SQL ) or die("Error en la consulta SQL");
		$registros= mysql_num_rows($result);
	
		if($registros == 0){
	
			if($_POST["contrasena"]==$_POST["contrasena_c"]){
				$resultado=mysql_query($conn,"UPDATE administrador SET nombre='$nombre', apellido='$apellido', usuario='$usuario', contrasena='$contrasena', tipoadministradorid='$tipoadmin' WHERE administradorid=$id") or die(mysql_error($conn));
	
				if($resultado){
					javaalert('Se Modifico el Administrador');
					llenarLog(2, "Administrador");
					iraURL('../administrator/admin.php');
				}
			}else{
				javaalert("Las contraseñas no coinciden, por favor verifique");
			}
		}else{
			javaalert("El nombre de usuario ya esta registrado, por favor verfique");
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
<meta charset="iso-8859-1">
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
            <li class="dropdown active"> <a  class="dropdown-toggle" data-target="#" data-toggle="dropdown"> Gestión Usuarios <b class="caret"></b> </a>
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
              <li class="active"><a href="admin.php"> <span class="add-on"><i class="icon-arrow-left"></i></span> Atrás</a></li>
          </ul>
      </div>
    </div>
    
    <div class="span9">
      <div class="well well-large">
        <p>
        
        <?php
        	$cons="SELECT * FROM administrador WHERE administradorid=$id";
			$resulta = mysql_query ($conn, $cons) or die("Error en la consulta SQL");
			
			if($row=mysql_fetch_array($resulta)){
		?>
        
	
            <form method="post">
          <div class="row-fluid">
            <dl class="dl-horizontal">
              <dt>
                <div class=" well well-small" align="left">Nombre</div>
              </dt>
              <dd>
                <div class=" well well-small" align="left">
                  <input id="nombre" name="nombre" type="text" value="<?php echo $row['nombre']; ?>" contenteditable="true" placeholder="Ej. Niuska Jenireé" maxlength="34" pattern="[A-Za-z,ñ,Ñ,á,é,í,ó,ú,Á,É,Í,Ó,Ú, ]{1,34}" required/>
                </div>
              </dd>
              <dt>
                <div class=" well well-small" align="left">Apellido</div>
              </dt>
              <dd>
                <div class="well well-small">
                  <input id="apellido" name="apellido" type="text" value="<?php echo $row['apellido']; ?>" contenteditable="true" placeholder="Ej. Mora Hurtado" maxlength="34" pattern="[A-Za-z,ñ,Ñ,á,é,í,ó,ú,Á,É,Í,Ó,Ú, ]{1,34}" required/>
                </div>
              </dd>
              <dt>
                <div class=" well well-small" align="left">Usuario</div>
              </dt>
              <dd>
                <div class="well well-small">
                  <input id="usuario2" name="usuario2" type="text" value="<?php echo $row['usuario']; ?>" contenteditable="true" placeholder="Ej. niuska.mora" maxlength="34" pattern="[a-z.ñ]{1,34}" required/>
                </div>
              </dd>
              <dt>
                <div class=" well well-small" align="left">Contaseña</div>
              </dt>
              <dd>
                <div class="well well-small">
                  <input id="contrasena" name="contrasena" type="password" value="<?php echo $row['contrasena']; ?>" contenteditable="true" pattern="[A-Za-z.0-9ñÑ]{1,34}" required/>
                </div>
              </dd>
              <dt>
                <div class=" well well-small" align="left">Confirmar Contaseña</div>
              </dt>
              <dd>
                <div class="well well-small">
                  <input id="contrasena_c" name="contrasena_c" type="password" value="<?php echo $row['contrasena']; ?>" contenteditable="true" pattern="[A-Za-z.0-9ñÑ]{1,34}" required/>
                </div>
              </dd>
              <dt>
                <div class=" well well-small" align="left">Tipo Administrador</div>
              </dt>
              <dd>
                <div class="well well-small">
                  <select id="tipoadmin" name="tipoadmin" contenteditable="true">
                    	<?php 
						
						$consu="SELECT * FROM tipoadministrador WHERE tipoadministradorid=".$row['tipoadministradorid'];
						$resulta1 = mysql_query ($conn, $consu) or die("Error en la consulta SQL");
						if($row1=mysql_fetch_array($resulta1)){
							echo '<option value="'.$row1['tipoadministradorid'].'">'.$row1['nombre'].'</option>';
                        
                        }
								
						$SQL="SELECT * FROM tipoadministrador WHERE tipoadministradorid!=".$row['tipoadministradorid'];
						$resulta2 = mysql_query ($conn, $SQL ) or die("Error en la consulta SQL");
						
						while($row2=mysql_fetch_array($resulta2)){
							echo '<option value="'.$row2['tipoadministradorid'].'">'.$row2['nombre'].'</option>';

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
					iraURL('admin.php');
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

</body>
</html>