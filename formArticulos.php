<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Formulario de artículos</title>
</head>

<body>

	<?php

	include "funciones.php";

	/* Comprobar acceso por usuario con permisos */
	if (isset($_COOKIE['userLoggedIn'])) {
		$userAcces = $_COOKIE['userLoggedIn'];
		/*echo '<br>Tipo de usuario: ' . $userAcces . '<br><br>';*/

		if ($userAcces == 'registrado' || $userAcces == 'autorizado') {
			$autorizado = true;
		} else {
			echo '<br>No tiene permisos de acceso.';
			$autorizado = false;
		}
	} else {
		$autorizado = false;
		echo "<h2> No tiene permisos para estar aquí. </h2>";
		echo "<a href = 'index.php'> Volver al index </a>";
	}
	if ($autorizado) {
		/* Tomamos la acción enviada desde articulos.php */
		if (isset($_GET['accion'])) {

			$acciones = $_GET['accion']; // Localizar la acción.

			if ($acciones == 'editar')
				formulario("Editar");
			else if ($acciones == 'annadir')
				formulario("Anadir");
			else if ($acciones == 'borrar')
				formulario("Borrar");
		}

		/* Si la acción se realiza desde el propio formArticulos.php (Formulario Añadir, Editar, Borrar) */
		if (isset($_GET['sendForm'])) {
			$accion = $_GET['sendForm'];
			$nombre = $_GET['nombre'];
			$coste = $_GET['coste'];
			$precio = $_GET['precio'];
			$categoria = $_GET['categoria'];

			switch ($accion) {
				case 'Editar':
					$id = $_GET['id'];
					if (editarProducto($id, $nombre, $coste, $precio, $categoria)) echo "<h2>Producto actualizado de forma satisfactoria</h2>";
					else echo "<br>Error en la Actualización<br>";
					break;
				case 'Anadir':
					if (anadirProducto($nombre, $coste, $precio, $categoria)) echo "<h2>Producto añadido de forma satisfactoria</h2>";
					else echo "<br>Error añadiendo registro<br>";
					break;
				case 'Borrar':
					$id = $_GET['id'];
					if (borrarProducto($id)) echo "<h2>Producto eliminado de forma satisfactoria</h2>";
					else echo "<br>Error eliminando registro<br>";
					break;
				default:
					break;
			}
		}
		echo "<a href = 'articulos.php'> Volver al listado de articulos.</a>";
	}

	function formulario($tipo)
	{
		/* Si la acción viene de Editar o Borrar (tiene ID) */
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			$datos = getProducto($id);
			$nombre = $datos['name'];
			$coste = $datos['cost'];
			$precio = $datos['price'];
			$categoria = $datos['category_id'];
		} else { // Si estamos en Añadir (valores por defecto a 0).
			$id = NULL;
			$nombre = "";
			$coste = "";
			$precio = "";
			$categoria = "PANTALÓN";
		}

		// Etiquetas e inputs del formulario.
		if ($tipo == 'Borrar') // Si es Borrar, ponemos las opciones a solo lectura.
			$readOnly = 'readonly';
		else
			$readOnly = '';
		echo "	<form action = '#' method = 'get'>";
		if ($id) echo "<label>ID </label>		<input type = 'text' name = 'id' size = '5' value = '$id' readonly>	<br>";
		echo "         <label>Nombre </label>	<input type = 'text' name = 'nombre' size = '20' value = '$nombre' $readOnly>	<br>
					   <label>Coste </label>	<input type = 'text' name = 'coste' size = '12' value = '$coste' $readOnly>	<br>
					   <label>Precio </label>	<input type = 'text' name = 'precio' size = '11' value = '$precio' $readOnly><br>
			";

		pintaCategorias($categoria);

		/*
		 * Para evitar que al enviar el formulario aparezcan la eñe, pero que en el botón del formulario aparezca Añadir.
		 * 
		 */
		if ($tipo == 'Anadir') // Añadimos un input oculto con un value de Anadir y un input submit con 'Añadir'. El valor recogido será el del input oculto.
			echo "		
					   <input type = 'hidden' name = 'sendForm' value = 'Anadir'>
					   <input type = 'submit' value = 'Añadir'>
				</form>
			<br>
			";
		else
			echo "		
					   <!--<input type = 'hidden' name = 'sendForm' value = 'Anadir'>-->
					   <input type = 'submit' name = 'sendForm' value = '$tipo'>
				</form>
			<br>
			";
	}
	?>
</body>

</html>