<?php

include "conexion.php";

function tipoUsuario($nombre, $correo)
{
	// Completar...

	$conn = crearConexion($nombre, $correo);

	// Primero comprobamos si el usuario es Superadmin. En caso contrario, leemos en la bbdd para comprobar si tiene el permiso "enabled".
	if (esSuperadmin($nombre, $correo)) { 
		$retorno = "superadmin";
	} else {
		$consulta = "SELECT full_name, email, enabled FROM user WHERE full_name = '$nombre' and email = '$correo'";
		$resultado = mysqli_query($conn, $consulta);

		if ($datos = mysqli_fetch_array($resultado)) {
			if ($datos["enabled"] == 0) {
				$retorno = "registrado";
			} else if ($datos["enabled"] == 1) {
				$retorno = "autorizado";
			}
		} else {
			$retorno = "no registrado";
		}
	}

	cerrarConexion($conn);
	return $retorno;
}


function esSuperadmin($nombre, $correo)
{
	// Completar...
	$conn = crearConexion();
	$consulta = // Hacemos un INNER JOIN entre la tabla user (usuarios) y la tabla setup para comprobar 
		"SELECT user.id FROM user INNER JOIN setup ON 
		user.id = setup.superadmin_id WHERE 
		user.full_name = '$nombre' AND user.email = '$correo'";
	$resultado = mysqli_query($conn, $consulta);

	if ($datos = mysqli_fetch_array($resultado)) {
		$trueFalse = true; // Es SuperAdmin. Preparamos para devolver true. La consulta fetch_array devuelve array con el ID del superadmin (Jack Blue))
		//var_dump ($datos);
	}
	else {
		// La consulta devuelve valor nulo.
		$trueFalse = false; // no es SuperAdmin. Vamos a devolver NULL (false).
	}

	cerrarConexion($conn);
	return $trueFalse;
}

function getListaUsuarios()
{
	// Completar...	
	$conn = crearConexion();
    // Obtener lista con todos los usuarios (nombre, email y campo enabled), de la tabla user.
	$consulta =	"SELECT user.full_name, user.email, user.enabled FROM user";
	$resultado = mysqli_query($conn, $consulta);

	cerrarConexion($conn);
	return $resultado;
}

function getPermisos()
{
	// Completar...	
	$conn = crearConexion();
	// Obtenemos el valor almacenado en la columna management de la tabla setup.
	$consulta = "SELECT management FROM setup";
	// Hacemos la consulta.
	$resultado = mysqli_fetch_assoc(mysqli_query($conn, $consulta));
	cerrarConexion($conn);
	return $resultado['management'];
}

function cambiarPermisos()
{
	// Completar...	
	$conn = crearConexion();
	// Obtenemos los permisos.
	$permisos = getPermisos();
	if (($permisos == 1)) { // Si es 1 lo ponemos a 0 
		$consulta = "UPDATE setup SET management  = 0";
	} else if (($permisos == 0)) { // Si es 0 lo ponemos a 1
		$consulta = "UPDATE setup SET management = 1";
	}
	// Hacemos los cambios.
	$resultado = mysqli_query($conn, $consulta);
	echo 'Resultado del cambio ' . $resultado;

	cerrarConexion($conn);
}

function getCategorias()
{
	// Completar...	
	$conexion = crearConexion();
	// obtenemos el id y el nombre de la tabla category
	$consulta =	"select id, name from category";
	$valores = mysqli_query($conexion, $consulta); 
	//var_dump($valores);
	cerrarConexion($conexion);
	return $valores; // Devuelve objeto con los datos de la consulta.
}


function getProducto($ID)
{
	// Completar...	
	$conexion = crearConexion();
	// Consulta y devuelve tabla virtual con todos los datos que corresponden al producto indicado por el $ID
	// Para abreviar, podríamos haber utilizado SELECT *
	$consulta = "SELECT name, cost, price, category_id  FROM product WHERE id = $ID";
	$resultado = mysqli_fetch_assoc(mysqli_query($conexion, $consulta));
	cerrarConexion($conexion);
	return $resultado;
}


function getProductos($orden)
{
	// Completar...	
	$conn = crearConexion();
	// Consulta mediante INNER JOIN para enlazar las dos tablas (product y category)
	// Obtenemos el (id, nombre, coste, precio del producto en la tabla product) y el name correspondiente de la tabla categoria (PANTALÓN, CAMISA etc...).
	$consulta =	"SELECT product.id, product.name, product.cost,	product.price, category.name as categoria FROM product 
	inner join category on product.category_id = category.id order by " . $orden;
	$resultado = mysqli_query($conn, $consulta);
	cerrarConexion($conn);
	return $resultado;
}

function anadirProducto($nombre, $coste, $precio, $categoria)
{
	// Completar...	
	/*
	 * Aquí transformamos el nombre de la catagoria recibido ($categoria->PANTALON,CAMISA,JERSEY,CHAQUETA)
	 * a su correspondiente ID de la tabla category.
	 * PANTALÓN 1
	 * CAMISA 2
	 * JERSEY 3
	 * CHAQUETA 4
	*/

	/* Array asociativo usado para asociar el número de la categora (pasado por parámetro) con su correspondiente valor.
	 * $categoria = 1 = PANTALÓN.
	 * $categoria = 2 = CAMISA.
	 * $categoria = 3 = JERSEY.
	 * $categoria = 4 = CHAQUETA.
	*/
	$prendas = ["PANTALÓN" => 1, "CAMISA" => 2, "JERSEY" => 3, "CHAQUETA" => 4];

	/*
	 * A continución añadimos el producto en la base de datos.
	*/
	$conexion = crearConexion();
	$consulta = "INSERT INTO product (Name, Cost, Price, Category_ID) 
				VALUES ('$nombre' , '$coste' , '$precio' , $prendas[$categoria]);";

	$resultado = mysqli_query($conexion, $consulta);

	cerrarConexion($conexion);
	return $resultado;
	
}


function borrarProducto($id)
{
	// Completar...	
	// Creamos la conexión.
	$conn = crearConexion();
	// Acción a realizar
	$accion = "DELETE FROM product WHERE ID = $id";
	// Ejecutamos la acción
	$resultado = mysqli_query($conn, $accion);
	cerrarConexion($conn);
	return $resultado;
}


function editarProducto($id, $nombre, $coste, $precio, $categoria)
{
	// Completar...	

	// Creamos la conexión.
	$conn = crearConexion();

	/* Array asociativo usado para asociar el número de la categora (pasado por parámetro) con su correspondiente valor.
	 * $categoria = 1 = PANTALÓN.
	 * $categoria = 2 = CAMISA.
	 * $categoria = 3 = JERSEY.
	 * $categoria = 4 = CHAQUETA.
	*/
	$prendas = ["PANTALÓN" => 1, "CAMISA" => 2, "JERSEY" => 3, "CHAQUETA" => 4];

	// Sentencia UPDATE para actualizar el valor de los campos según un ID dado.
	$mysql_query = "UPDATE product SET name = '$nombre', cost = $coste, price = $precio, category_id = $prendas[$categoria] WHERE id = $id";
	$resultado = mysqli_query($conn, $mysql_query);

	// Cerramos conexión
	cerrarConexion($conn);
	// Devolvemos el resultado del QUERY.
	// No se efectua ningún tipo de comprobación. Se asume que la sentencia UPDATE está bien construida y que la tabla así como sus campos existen;
	return $resultado;
}
