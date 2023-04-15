<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Usuarios</title>
</head>

<body>

	<?php

	include "funciones.php";

	/* Comprobación de si el acceso fue realizado por el usuario superadmin */
	/* Para ello leemos el valor almacenado en la cookie */
	if (isset($_COOKIE['userLoggedIn'])) {  // Comprobando si el acceso fue realizado por el usuario superadmin le
		//echo "<br>La cookie existe.";
		//echo "el valor de la cookie es " . $_COOKIE['userLoggedIn'];
		echo '<br>Permisos Actuales: (Campo management) ';
		echo getPermisos();
		echo '<br>';
		/*echo "<br>Cambiar permisos de la aplicación (campo management)<br>";*/
		if (isset($_GET['Cambiar'])) {
			echo "<br>boton cambiar pulsado... Llamando a la funcion cambiarPermisos()";
			cambiarPermisos();
			header("location:usuarios.php");
		}
		pintaTablaUsuarios();
		
	} else
		echo '<h2>Lo sentimos, pero no tiene permisos de acceso.</h2>';

	echo "<a href='index.php'> Volver al inicio.</a>";
	?>
</body>

</html>