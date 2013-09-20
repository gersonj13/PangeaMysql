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
	
	$SQL="DELETE FROM bitacora WHERE administradorid=".$_GET['id'];
	$result = mysql_query ($SQL, $conn) or die("Error en la consulta SQL");
	javaalert("La Bitacora para ese Administrador fue Vaciada");
	llenarLog(6, "Bitacora");
	iraURL('../administrator/admin.php');


?>