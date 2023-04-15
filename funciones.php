<?php

include "consultas.php";

/* Pintar categoria */
function pintaCategorias($defecto)
{
	// Completar...	
	/*
 	 * En este bloque de código llamamos a la función getCategorias(), la cual devuelve una tabla con todas las categorias.
 	 * Las va insertando en las opciones del SELECT y activa la que coincida con la categoría que estamos editando.
 	 *********************************************************************************************************************
	 *	 
	 *
	 *
	 * Array asociativo usado para validar que categoria debe de estar SELECTED en el SELECT del formulario.
	 */
	$prendas = [1 => "PANTALÓN", 2 => "CAMISA", 3 => "JERSEY", 4 => "CHAQUETA"];
	echo "
		<label> Categoria </label>
		<select name = 'categoria'>
	";
	$categorias = getCategorias(); /* Optiene las catagorias de la table category */
	while ($resultado = mysqli_fetch_assoc($categorias)) {
		$nombreCategoria = $resultado['name'];
		if ($nombreCategoria == $prendas[$defecto]) // $defecto contiene el valor numerico correspondiente a la categoría.
			echo "<option selected> $nombreCategoria </option>";
		else
			echo "<option> $nombreCategoria </option>";
	}
	echo "	
		</select>
		<br>
		<br>
	";
}


function pintaTablaUsuarios()
{
	// Completar...	
	$resultado_consulta = getListaUsuarios();
	echo "<br>
	<form method='get' action='#'>
		<input type='submit' name='Cambiar' value='Cambiar permisos'>
	</form>
	<br>
	<table border='1' cellpadding='5' cellspacing='0'>
		<th> Nombre </th>
		<th> Email </th>
		<th> Enabled </th>
	";

	while ($elementos = mysqli_fetch_array($resultado_consulta)) {
		echo "<tr>";
		if (!$elementos['enabled']) {
			echo "<td>" . $elementos['full_name'] . "</td>";
			echo "<td>" . $elementos['email'] . "</td>";
			echo "<td>" . $elementos['enabled'] . "</td>";
		} else {
			echo "<td><b>" . $elementos['full_name'] . "</b></td>";
			echo "<td><b>" . $elementos['email'] . "</b></td>";
			echo "<td><b>" . $elementos['enabled'] . "</b></td>";
		}
		echo "</tr>";
	}
	echo "</table>";
}

function pintaProductos($orden)
{
	// Completar...	
	$resultado = getProductos($orden);

	echo "
		<!--<h1>Lista de artículos </h1>-->
		<table border='1' cellpadding='5' cellspacing='0'>
			<tr>
				<th><a href='articulos.php?orden=id'>ID</a></th>
				<th><a href='articulos.php?orden=name'>Nombre</a></th>
				<th><a href='articulos.php?orden=cost'>Coste</a></th>
				<th><a href='articulos.php?orden=price'>Precio</a></th>
				<th><a href='articulos.php?orden=categoria'>Categoria</a></th>
				<th>Acciones</th>
			</tr>
		";

	while ($elementos = mysqli_fetch_assoc($resultado)) {
		echo '<tr>';
		echo "<td>" . $elementos['id'] . "</td>";
		echo "<td>" . $elementos['name'] . "</td>";
		echo "<td>" . $elementos['cost'] . "</td>";
		echo "<td>" . $elementos['price'] . "</td>";
		echo "<td>" . $elementos['categoria'] . "</td>";

		$id = $elementos['id'];

		if ($management = getPermisos() == 1) { /* Si los permisos management están activos */
			echo "<td>" . "<a href='formArticulos.php?accion=editar&id=$id'>Editar</a>
		                   <a href='formArticulos.php?accion=borrar&id=$id'>Borrar</a>" .
				"</td>";
		} else {
			echo "<td>Permisos Editar/Borrar Desactivados. Management " . ($management ? '1' : '0') . "</td>";
		}
		echo '</tr>';
	}
	echo "</table>";
}
