<?php

//conexión de la base de dattos  
function conectar(){{  
	   if (!($conexion = mysql_connect("localhost","root","p4ng34","pangea"))){
	       echo "No pudo conectarse al servidor";
	       exit();
	   }
	    $bd = mysql_select_db("pangea", $conexion);
      if (! $bd ){die ("ERROR AL CONECTAR CON LA BASE DE DATOS: ".mysql_error() );
	  
	  }
	   
	    return $conexion;
	}
}
//desconectar la base de datos
function desconectar($conexion){
	pg_close($conexion);
	
}

//creación de sesiones de administradores
function crearsesion($u,$p){
	if($u!="" && $p!=""){
		$_SESSION["usuarioadmin"] = $u;
		$_SESSION["passwordadmin"] = $p;

		return true;
	}else
		return false;
}
//creación de sesiones de clientes
function crearsesioncliente($u,$p){
	if($u!="" && $p!=""){
		$_SESSION["usuario_cliente"] =$u;
		$_SESSION["passwordcliente"] = $p;
		
		return true;
	}else
		return false;
}

// validación de usuario de administradores
function validarlogin(){

	if(existesesion()){
		$conex = conectar();
		$usu = $_SESSION["usuarioadmin"];
		$pass = $_SESSION["passwordadmin"];
		$query="SELECT * FROM administrador WHERE usuario='$usu' AND contrasena='$pass'";
		$Qlogin = pg_query($conex,$query) or die(pg_last_error($conex));
		$fila = pg_fetch_array($Qlogin);
		
		if(pg_num_rows($Qlogin) == 0){
			javaalert('Usuario o Contraseña invalida!');
			quitarsesion();
			return false;
		}else{ 	
			$_SESSION["id_usuario"]=$fila["administradorid"];
			$_SESSION["admin"]=$fila["tipoadministradorid"];			
			return true;			
		}
	}else
		return false;
	
	
}
// validación de usuario de clientes
function validarlogincliente(){

	if(existesesioncliente()){
		$conex = conectar();
		$usu = $_SESSION["usuario_cliente"];
		$pass = $_SESSION["passwordcliente"];	
		$query="SELECT * FROM usuario WHERE usuario='$usu' AND contrasena='$pass'";
		$Qlogin = pg_query($conex,$query) or die(pg_last_error($conex));
		$fila = pg_fetch_array($Qlogin);	
		if(pg_num_rows($Qlogin) == 0){
			javaalert('Usuario o Contraseña invalida!');
			quitarsesioncliente();
			return false;
		}else{ 
		//guardo información del cliente
			$_SESSION["id_cliente"]=$fila["usuarioid"];	
			$_SESSION["nombre"]=$fila["nombre"];	
			if($fila["apellido"]==""){
			$_SESSION["apellido"]="";	
				}else{
					$_SESSION["apellido"]=$fila["apellido"];	
					}
					
			return true;	
		}
	}else
		return false;
}
//verificando  sesiones de administradores
function existesesion(){
	if(isset($_SESSION["usuarioadmin"]) && isset($_SESSION["passwordadmin"]))
		return true;
	else
		return false;
}
//verificando  sesiones de clientes
function existesesioncliente(){
	if(isset($_SESSION["usuario_cliente"]) && isset($_SESSION["passwordcliente"]))
		return true;
	else
		return false;
}


function iraURL($url){
	$ini='<script language="javascript">
				window.location = "';
	$fin='"; </script>';
	
	echo $ini.$url.$fin;
}

//eliminando variables de sesion de cuenta de administradores
function quitarsesion(){
    if(isset($_SESSION["id_usuario"]))
	llenarLog(5,"EN CUENTA DE ADMINISTRADORES");
	unset($_SESSION["usuarioadmin"]);
	unset($_SESSION["passwordadmin"]);
	unset($_SESSION["id_usuario"]);
	
}
//eliminando variables de sesion de cuenta de clientes
function quitarsesioncliente(){
	unset($_SESSION["usuario_cliente"]);
	unset($_SESSION["passwordcliente"]);		
	unset($_SESSION["id_cliente"]);
	unset($_SESSION["nombre"]);
	unset($_SESSION["apellido"]);	
	
}
//alertas
function javaalert($msj){
	$ini='<script language="javascript">	alert("';
	$fin='"); </script>';
	echo $ini.$msj.$fin;
}

//superusuario
function supera($tipoad){
	$conn = Conectar();
	$SQL9="SELECT * FROM administrador WHERE tipoadministradorid=".$tipoad;
		$result9 = pg_query ($conn, $SQL9) or die("Error en la consulta SQL");
		$row9 = pg_fetch_array ($result9);
		$reg= pg_num_rows($result9);
		      if($reg= pg_num_rows($result9)){
				  if($row9['tipoadministradorid']==1){
					  return true;
				  }else{
						return false;
				  }
				}else{
						return false;
				}
	
}
//bitacora del  sitio web
function llenarLog($accion,$descripcion){

	$conex = Conectar();
		switch($accion){
		case 1:
			$accion="INSERCIÓN";
			break;
		case 2:
			$accion="MODIFICACIÓN";
		break;
		case 3:
			$accion="BORRADO";
			break;
		case 4:
			$accion="INICIO DE SESIÓN";
			break;
		case 5:
			$accion="FIN DE SESIÓN";
			break;
		case 6:
			$accion="VACIO DE BITACORA";
			break;	
		}
		
pg_query($conex,"INSERT INTO bitacora values(nextval('bitacora_bitacoraid_seq'),'".$accion."',current_date,current_time,".$_SESSION["id_usuario"].",'".$descripcion."')") or die(pg_last_error($conex));

}
//Traer Menu principal
function menu_principal($idm,$activo)
{
	
	$conex = conectar();
		
			
		$query="SELECT a.menuid,a.nombre,a.submenu,a.enlace,a.orden,count(b.menuid) as cant 
FROM menu a left join menu b on a.menuid=b.submenu WHERE a.submenu=".$idm."  group by a.menuid,a.nombre,a.submenu,a.enlace,a.orden order by orden asc,nombre asc";
		
		$Qmenu = mysql_query($query,$conex) or die(mysql_error());
		$numerof=mysql_num_rows($Qmenu);
		
		if($numerof > 0){ 
	
		
		      for($i=0;$i<$numerof;$i++)
			  {
				    mysql_data_seek($Qmenu,$i);
				  	$row = mysql_fetch_array($Qmenu);
	
				     if($row["cant"]==0)
					 {
						 
						if(strtolower($activo)==strtolower($row['nombre']))
						   echo '<li class="active"><a href="'.$row['enlace'].'">'.$row['nombre'].'</a></li>';
               			else
			  			  echo '<li><a href="'.$row['enlace'].'">'.$row['nombre'].'</a></li>';
						 
						 
					 }
					 else
					 {
						 if(strtolower($activo)==strtolower($row['nombre']))
							echo '<li class="dropdown active">';
						 else
							echo '<li class="dropdown">';
								
						echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						'.$row['nombre'].'
						<b class="caret"></b></a>
                        <ul class="dropdown-menu">';
						menu_principal($row['menuid'],$activo);
						echo ' </ul></li>';
						
						 
						 
					 }
				  
				  
			  }
		
		
		
		  }
	
}
function obtenerQuote()
{
	$conex = conectar();
	$query="select informacion.titulo,informacion.descripcion
from informacion,tipoinformacion 
where lower(tipoinformacion.nombre)='quotes' and informacion.tipoinformacionid=tipoinformacion.tipoinformacionid
order by rand() limit 1 ;";
	$Qmenu = mysql_query($query,$conex) or die(mysql_error());
	mysql_data_seek($Qmenu,0);				  	
	return $row = mysql_fetch_array($Qmenu);
	
	
}
function obtenerSucursal($id)
{
	$conex = conectar();
	$query="select * from sucursal where sucursalid=".$id;
	$Qmenu = mysql_query($query,$conex) or die(mysql_error());
	mysql_data_seek($Qmenu,0);	
	return $row = mysql_fetch_array($Qmenu);
}
function obtenerBanners()
{
	
$conex = conectar();
	
	$query="select informacion.titulo,informacion.descripcion,informacion.imagen
from informacion,tipoinformacion 
where lower(tipoinformacion.nombre)='noticia' and informacion.tipoinformacionid=tipoinformacion.tipoinformacionid;";
$Qmenu = mysql_query($query,$conex) or die(mysql_error());
	
$numerof=mysql_num_rows($Qmenu);
		
		if($numerof > 0){ 
	
		
		      for($i=0;$i<$numerof;$i++)
		{	
		mysql_data_seek($Qmenu,$i);		  	
		$row = mysql_fetch_array($Qmenu);
	
	
       echo ' <div class="item';
	   echo' slide'.($i+1);
	  
	   if($i==0)
	      echo' active">';
		else  
		 echo '">';
			if($i%2==0)
			{
			 
			 echo'
					<div class="row-fluid">
					  <div class="span6 animated fadeInDownBig">
						<h2>'.$row[0].'</h2>
						'.$row[1].'
					  </div>
					  <div class="span6 animated slide2 fadeInUpBig">
					  <img style="width:330px; height:240px" src="'.$row[2].'" /></div>
					</div>
				  </div>';
			}
			else
			{
				echo'
					<div class="row-fluid">
					 
					  <div class="span6 animated slide2 fadeInUpBig">
					  <img style="width:330px; height:240px;" src="'.$row[2].'" /></div>
					   <div class="span6 animated fadeInDownBig">
						<h2>'.$row[0].'</h2>
						'.$row[1].'
					  </div>
					</div>
				  </div>';
				
			}
		}
	}
	
	
}
function obtenerBannermovil()
{
	
$conex = conectar();
	
	$query="select informacion.titulo,informacion.descripcion,informacion.imagen
from informacion,tipoinformacion 
where lower(tipoinformacion.nombre)='noticia' and informacion.tipoinformacionid=tipoinformacion.tipoinformacionid order by rand() limit 1;";
$Qmenu = mysql_query($query,$conex) or die(mysql_error());
mysql_data_seek($Qmenu,0);				  	
$row = mysql_fetch_array($Qmenu);
echo
 ' <div class="span6 animated fadeInDownBig">
           	<h2>'.$row[0].'</h2>
			'.$row[1].'
          </div>
          <div class="span6 animated slide2 fadeInUpBig" style="text-align:center">
		   <img style="width:330px; height:240px" src="'.$row[2].'" />
           </div>';
	



}
function iniciosesion_cliente($user,$pass){
    if (crearsesioncliente($user, $pass)) {
        if (validarlogincliente()) {
			iraURL("#");
        }
    }else {
	javaalert("Debe agregar el usuario y contraseña");
		}
}
	
function carrusel()
{
	
	$conex = conectar();
	
	$query="select informacion.titulo,informacion.descripcion,informacion.imagen,informacion.enlace
from informacion,tipoinformacion 
where lower(tipoinformacion.nombre)='carrusel' and informacion.tipoinformacionid=tipoinformacion.tipoinformacionid;";
$Qmenu = mysql_query($query,$conex) or die(mysql_error());
	
$numerof=mysql_num_rows($Qmenu);
		
		if($numerof > 0){ 
	
		
		      for($i=0;$i<$numerof;$i++)
		{	
		mysql_data_seek($Qmenu,$i);	
				$row = mysql_fetch_array($Qmenu);
	
	echo ' <div class="ca-item ca-item-'.($i+1).'">
            <div class="ca-item-main">
              <div class="ca-icon" style="background:url('."'".$row[2]."'".') no-repeat center center" ></div>
              <h2>';
			  echo $row[0];
			  echo '</h2>
              <h4> <span class="ca-quote">&ldquo;</span> <span>';
			  echo  $row[1];
			  if($row[3]!='')
			  {
              echo '<p><a class="btn" href="'.$row[3].'">'.$row[0].'</a></p>'; 
			  }
              echo '</span> </h4>
            </div>
          </div>';
	
			}
		
		}
}
function carruselMovil()
{
	
	$conex = conectar();
	
	$query="select informacion.titulo,informacion.descripcion,informacion.imagen,informacion.enlace
from informacion,tipoinformacion 
where lower(tipoinformacion.nombre)='carrusel' and informacion.tipoinformacionid=tipoinformacion.tipoinformacionid;";
$Qmenu = mysql_query($query,$conex) or die(mysql_error());
	
$numerof=mysql_num_rows($Qmenu);
		
		if($numerof > 0){ 
	
		
		      for($i=0;$i<$numerof;$i++)
		{	
	         	mysql_data_seek($Qmenu,$i);	
		
				$row = mysql_fetch_array($Qmenu);
	
	echo ' <div class="span4 ca-item ca-item-'.($i+1).'">
            <div class="ca-item-main">
              <div class="ca-icon" style="background:url('."'".$row[2]."'".') no-repeat center center; " ></div>
              <h2>';
			  echo $row[0];
			  echo '</h2>
              <h4> <span class="ca-quote">&ldquo;</span> <span>';
			  echo  $row[1];
			  if($row[3]!='')
			  {
              echo '<p><a class="btn" href="'.$row[3].'">'.$row[0].'</a></p>'; 
			  }
              echo '</span> </h4>
            </div>
          </div>';
	
			}
		
		}
}


?>