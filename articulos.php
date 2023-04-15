<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Articulos</title>
</head>

<body>
	<h1>Lista de artículos </h1>
	<?php
	include "funciones.php";

	if (isset($_COOKIE['userLoggedIn'])) {  // Comprobando quien realiza el acceso.
		$userAcces = $_COOKIE['userLoggedIn'];
		/*echo '<br>Tipo de usuario ' . $userAcces . '<br>';*/
		if ($userAcces == 'registrado' || $userAcces == 'autorizado') {
			$autorizado = true;
		} else {
			echo '<br>No tiene permisos de acceso.';
			$autorizado = false;
		}
		if ($autorizado) {
			if (!isset($_GET["orden"])) { /* Si no hay definido un orden */
				$orden = "name"; /* Ordenar por nombre */
			} else {
				/* 
					Tomamos el valor de la variable orden pasada en el index.php.
					Solo se comprueba el valor de $orden,
					asumiendo que tiene uno (articulos.php?orden=loquesea).
					No contempla valores vacios como articulos.php?orden
				*/
				$orden = $_GET["orden"];
			}
			/* 
				Si tenemos permiso de management, antes de 
				imprimir los listados, meter enlace para añadir producto
				mediante get.
			*/

			if (getPermisos() == 1)
				echo "<a href='formArticulos.php?accion=annadir'>Añadir producto</a>";

			pintaProductos($orden);
		}
	} else {
		echo "<h2>No tiene permisos para estar aquí.</h2>";
	}
	?>
	<a href="index.php">Volver al inicio.</a>

</body>

</html>