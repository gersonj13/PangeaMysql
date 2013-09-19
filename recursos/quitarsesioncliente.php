<?php 
//eliminando variables de sesion de cuenta de clientes
session_start();
include("funciones.php");

	unset($_SESSION["usuario_cliente"]);
	unset($_SESSION["passwordcliente"]);	
	unset($_SESSION["id_cliente"]);
	unset($_SESSION["nombre"]);
	unset($_SESSION["apellido"]);
	iraURL($_GET['pagina']);
?>