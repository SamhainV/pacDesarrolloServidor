<?php 

	function crearConexion() {
		// Completar...

		// Cambiar en el caso en que se monte la base de datos en otro lugar.
		$host = "localhost";
		$user = "AntonioIII";
		$pass = "AntonioIII";
		$baseDatos = "pac_dwes";

		$conexion = mysqli_connect($host, $user, $pass, $baseDatos); // Conectamos a la BBDD.
		
		return $conexion; // Devuelve manejador de conexión.
	}


	function cerrarConexion($conexion) {
		// Completar...
		mysqli_close($conexion); // Cerramos la conexión.
	}


?>