<?php
session_start();

include("recursos/funciones.php");
$conn=conectar();
//inicio de sesión 
if (isset($_POST["inicio"])) {
   iniciosesion_cliente($_POST["usuario"],$_POST["password"]);
}

?>
<!DOCTYPE html>

<head>
<title>:: Pangea Technologies ::</title>
<meta name="description" content="Pagina Web"/>
<meta name="author" content="Pangea Technologies"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta charset="iso-8859-1" />
<link rel=StyleSheet href="recursos/css/bootstrap.min.css" type="text/css" />
<link rel=StyleSheet href="recursos/animate/animate.css" type="text/css" />
<link rel=StyleSheet href="recursos/css/estilogeneral.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="recursos/circular/css/jquery.jscrollpane.css" media="all" />
<link rel="stylesheet" type="text/css" href="recursos/circular/css/style.css" media="all" />
<style></style>
<link rel=StyleSheet href="recursos/css/bootstrap-responsive.min.css" type="text/css" />
<link rel=StyleSheet href="recursos/slide/jquery.pageslide.css" type="text/css" />
<head>
<body>
<script type="text/javascript" src="recursos/js/jquery-2.0.2.js" ></script> 
<script type="text/javascript" src="recursos/js/bootstrap.min.js" ></script> 
<script type="text/javascript" src="recursos/slide/jquery.pageslide.min.js" ></script> 
<a href="#" class="scrolltop" style="display: none;"> <span>up</span> </a>
<div  class="container-fluid" style="background-image: url('recursos/img/back.jpg'); background-repeat: repeat;">
<div id="fullp">
<div class="container" style="background-color:white;">
  <div class="row-fluid">
    <div class="span12"> 
      
      <!--Nav bar content-->
      <div  class="row-fluid headerg hidden-desktop">
        <div class="headera" style="text-align: left;" >
           <img  src="recursos/img/izquierdasuperior.png" style="margin-bottom: 3px;" />
           </div>
        <div  class="headerb" style="text-align: center;"><a href="index.php" > <img  src="recursos/img/logo.png" style="margin-bottom: 3px;" height="160" /></a>
           </div>
        <div class="headerc"  style="text-align: right;">
           <img  src="recursos/img/derechainferior.png" style="margin-bottom: 3px; text-align: left;" />
           </div>
      </div>
      <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner">
          <div class="container"><a id="open" href="#nav" class="btn btn-navbar" data-toggle="collapse" data-target="#barrac"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a>
          <a id="open2" href="#" class="btn btn-navbar" data-toggle="collapse" data-target="#login"><i class="icon-user icon-white"></i></a> <a class="brand visible-desktop" style="float:left" href="index.php"><img  src="recursos/img/logop.png" width="140" height="20"/></a>
            <div id="barrac" class="nav-collapse collapse">
              <ul id="nav" class="nav slidernav">
                        <?php   menu_principal(0,"productos"); ?>  

              </ul>
            </div>
            <!--/.nav-collapse -->
            <div id="login" class="nav-collapse collapse">
              <ul id="log" class="nav pull-right">
                <li class="divider-vertical"></li>
               	 <?php  
			  	if(existesesioncliente()){
					echo '<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						'.$_SESSION["nombre"].' '.$_SESSION["apellido"].'
						<b class="caret"></b></a>
                        <ul class="dropdown-menu">
						<li><a href="recursos/quitarsesioncliente.php?pagina=../productos.php">Cerrar Sesión</a></li>
						  </ul></li>';			
				  }else{ ?>
 				<li>
				<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						Iniciar Sesión
						<b class="caret"></b></a> <ul class="dropdown-menu">
                    <li>
                      <div class="well well-small" align="center"> 
                      <form method="post">
                        <dl>
                          <dt><span>Nombre de usuario</span></dt>
                          <dd><input type="text"  placeholder="Usuario" name="usuario" id="usuario"  title="El formato es Mayúscula(letras, puntos o números)" maxlength="34" pattern="[A-ZÑ]{1}[a-z.ñ0-9]{1,33}" autofocus required></dd>
                          <dt>    <span>Contraseña</span></dt>
                         <dd>     <input type="password"  placeholder="Contraseña" name="password" id="password" maxlength="34"  title="Debe agregar la contraseña" required></dd>
                         <dt>         </dt>
                         <dd><button type="submit" id="inicio" name="inicio" class="btn submit">Iniciar Sesión</button>
                     </dd>
                        </dl>
                      </form>
                     </div>
                    </li>
                  </ul></li>
                
                </li>                <?php } ?>    
              </ul>
            </div>
            <!--/.nav-collapse --> 
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container" style="background-color:white;">
 <!-- aqui estaba el carusel-->
 <div> 
 	<h2 class="well" align="left">
  		<br>
        Productos
  	</h2>

  </div>
 <div class="span12">
            <p><blockquote>Pangeatech pone a su disposición el mejor software adpatable a su empresa. Continue leyendo y enterese acerca de nuestros principales productos.</blockquote></p>
</div> 
 <div class="row-fluid">

         <?php 
		$SQL="SELECT * FROM producto";
		$result = mysql_query ($SQL,$conn) or die("Error en la consulta SQL");
		$registros= mysql_num_rows($result);	
		if($registros != 0){				 		
		for ($i=0;$i<$registros;$i++)
			{	
			mysql_data_seek($result,$i);	
			$row = mysql_fetch_array ($result);
			if(strlen ($row[2])>200){
				$descripcion=substr($row[2],0,200)."...";
			}else{
				$descripcion=$row[2];
			}
			echo '
			 <div class="row-fluid">
			<div class="span12" align="center">
			<div class="span1"></div>
			<div class="span10 well" align="center">
			<div class="span2"><img width="100" height="100" src="'.$row[4].'"> </div>
			<div class="span8" align="justify"><p><b>'.$row[1].'</b></p>'.$descripcion.'<p><a href="verproducto.php?id='.$row[0].'"><button class="btn btn-inverse"> <span class="add-on"><i class="icon-eye-open"></i></span> Ver más</button></a></p></div>
			</div>
			<div class="span1"></div>			
			 </div>
			 </div>

			';
			}//fin del for
		}else{
	?>
     <div class="alert alert-block" align="center">
   			<h2 style="color:rgb(255,255,255)"> Atención</h2>
    <h4>No existen registros en producto</h4>
    </div>
    <?php 
	}
	?>

</div><!--cierre de div container -->
<div id="cont2" class="container" >

  <h2 class="section_header">
    <span><!-- aqui iba el autor --></span>
  </h2>
   
  
  <br>
  <div class="row-fluid">
     <div class="span12 visible-desktop" style="padding:5px">
      <div id="ca-container" class="ca-container">
        <div class="ca-wrapper">
        <?php carrusel(); ?> 
        </div>
      </div>
      <hr/>
    </div>
    <div class="span12 hidden-desktop" style="padding:5px">
     <?php carruselMovil(); ?>
      <hr/>
    </div>
    <!-- /container -->
    
    <div id="footer" class="container" style="background-color: white; text-align: center;">
      <div class="container">
        <div class="well well-small">
          <p class="muted credit">Pangea Technologies | RIF: J-29521849-0
            Copyright © 2013. All rights reserved.</p>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="recursos/circular/js/jquery.contentcarousel.js"></script> 
<script type="text/javascript" src="recursos/js/funciones.js" ></script> 
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
<script type="text/javascript" src="recursos/circular/js/jquery.easing.1.3.js"></script> 
<!-- the jScrollPane script -->

<body>
</html>
