<?php
session_start();

include("recursos/funciones.php");

if(!isset($_GET['ids']))
{
   	iraURL("index.php");
	
}
$sucursal=obtenerSucursal($_GET['ids']);
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
<meta charset="utf-8" />
<link rel=StyleSheet href="recursos/css/bootstrap.min.css" type="text/css" />
<link rel=StyleSheet href="recursos/animate/animate.css" type="text/css" />
<link rel=StyleSheet href="recursos/css/estilogeneral.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="recursos/circular/css/jquery.jscrollpane.css" media="all" />
<link rel="stylesheet" type="text/css" href="recursos/circular/css/style.css" media="all" />
<style></style>
<link rel=StyleSheet href="recursos/css/bootstrap-responsive.min.css" type="text/css" />
<link rel=StyleSheet href="recursos/slide/jquery.pageslide.css" type="text/css" />
<script type="text/javascript" src="recursos/js/jquery-2.0.2.js" ></script> 
<script type="text/javascript" src="recursos/js/bootstrap.min.js" ></script> 
<script type="text/javascript" src="recursos/slide/jquery.pageslide.min.js" ></script> 
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>

</head>
<body onLoad="setTimeout('initialize( <?php echo $sucursal[6]; ?>, <?php echo $sucursal[7]; ?>)',1000);">


     
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
              <?php   menu_principal(0,"Sucursales"); ?>  
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
						<li><a href="recursos/quitarsesioncliente.php?pagina=../index.php">Cerrar Sesión</a></li>
						  </ul></li>';			
				  }else{ ?>
                
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
                
                
                <?php } ?>    
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
  <div id="hero2" >
    <div class="container">
      <div class="row-fluid animated fadeInDown">
        <div class="span12"> </div>
        <div class="span12 ">
           <div class="span1"></div>
           <div class="span10">
               <div class="span3" style="text-align:center;">
                 <img src="<?php echo $sucursal[5]; ?>" class="img-rounded" />
                 </br>  </br>
               </div>
               <div class="span9 well well-small">
                   <div class="span12">
                        <div class="span4"> 
                            <h3>
                               <?php echo $sucursal[1]; ?>
                            </h3>
                        </div>
                       
                   </div> 
                   
                  
                    <div class="span8">
                       <p style="font-size:18px;"> <?php echo $sucursal[8]; ?></p>
                    </div>
                    <div class="span3"> </div>
                
                </div>
           </div>     
          <div class="span1"></div>
        </div>
        <div class="span12"> </div>
        <div class="span12 ">
           <div class="span1"></div>
           <div class="span10">
               <div id="derecha" class="span3">
              
               </div>
               <div class="span9 well well-small">
                   <div class="span12">
                        <div class="span3"> 
                            <h3>
                               Contacto
                            </h3>
                        </div>
                       
                   </div> 
                   
                  
                    <div class="span9">
                       <p style="font-size:18px;"> 
                     	 <address>
                        <?php echo $sucursal[2]; ?> <br>
                          <abbr title="Telefono">P:</abbr> <?php echo $sucursal[3]; ?>
                        </address>
                         
                        <address>
                          <strong>Correo Electronico</strong><br>
                          <a href="mailto:#"><?php echo $sucursal[4]; ?></a>
                        </address>
                       
                       
                       </p>
                    </div>
                    <div class="span3"> </div>
                
                </div>
           </div>     
          <div class="span1"></div>
        </div>
        
      </div>
    </div>
  </div>
  
</div>
<div id="cont2" class="container" >
<?php 
 $frase=obtenerQuote();

?>
  <div id="intro">
    <div class="container">
      <h1> "<?php echo $frase[1]; ?>" </h1>
    </div>
  </div>
  <br>
  <h2 class="section_header">
    <hr class="left visible-desktop">
    <span><?php echo $frase[0]; ?></span>
    <hr class="right visible-desktop">
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
<script type="text/javascript" src="recursos/js/funcionesmapa.js" ></script> 
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
 <script>
            google.maps.event.addDomListener(window, 'load', initialize);               
</script>  
<!-- the jScrollPane script -->

<body>
</html>
