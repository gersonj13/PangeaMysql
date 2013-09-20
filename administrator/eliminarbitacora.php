<?php
session_start();

include("../recursos/funciones.php");
$conn=conectar();
if(!isset($_SESSION["usuarioadmin"]) || !isset($_SESSION["passwordadmin"])){
	iraURL('../administrator/index.php');
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
</head>

<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

<?php		
	   $SQL="DELETE FROM bitacora";
		$result = pg_query ($conn, $SQL ) or die("Error en la consulta SQL");
		llenarLog(3, "se vacio la bitacora");
		javaalert("la bitacora fue vaciada");
		iraURL('bitacora.php');
		
	

?>

	</body>
</html>