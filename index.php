<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Index.php</title>
</head>

<body>

	<form method="get" action="#">
		Indique su nombre de usuario: <input type="text" name="userName">
		<br>
		Indique su Email: <input type="email" name="userMail" size="30">
		<br>
		<input type="submit" name="sendForm">
	</form>


	<?php
	/*
	http://localhost/pacServidor/pacDesarrolloServidor2/
	*/
	include "consultas.php";

	
	if (isset($_GET['sendForm'])) { // Si se ha enviado el formulario...
		
		// Coger y evaluar el nombre y el email suministrados.
		$usuario = $_GET['userName'];
		$email = $_GET['userMail'];

		$userType = tipoUsuario($usuario, $email);

		$userState = ["superadmin", "registrado", "autorizado", "no registrado"];
		
		switch ($userType) {
			case $userState[0]: // SuperAdmin
				$id = 0;
				echo '<br> Bienvenido ' . $usuario . '. Es usuario ' . '\'' . $userState[$id] . '\' . ';
				echo "<a href = 'usuarios.php'>Pulse aquí,</a> para administrar usuarios.";
				break;
			case $userState[1]: // Registrado
				$id = 1;
				echo '<br> Bienvenido ' . $usuario . '. Es usuario ' . '\'' . $userState[$id] . '\'' .
					', pero no tiene permisos de acceso a articulos.php.';
				break;
			case $userState[2]: // Autorizado
				$id = 2;
				echo '<br> Bienvenido ' . $usuario . '. Es usuario ' . '\'' . $userState[$id] . '\'' .
					' <a href=\'articulos.php?orden=name\'>Pulse aquí</a> para gestionar articulos.';
				break;
			default: // Usuario no autorizado
				$id = 3;
				echo "<br>Atención!!! Usted es un usuario " . $userState[$id] . ' en el sistema.';
				break;
		}
		// Cookie que almacena el tipo de usuario.
		setcookie("userLoggedIn", $userState[$id], time() + 3600); // valor 36 = 0.6 minutos. Usar para debug.
	}

	?>


</body>

</html>