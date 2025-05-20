<?php
function comprobar_sesion(){
	if (!isset($_SESSION)) {
		session_start();
	}
	// Verificar si existe una sesión de usuario O una sesión de protectora
	if(!isset($_SESSION['Usuario']) && !isset($_SESSION['Protectora'])){	
		// No hay ninguna sesión activa
		return false;	
	}
	return true;		
}

function comprobar_admin(){
	if (!isset($_SESSION)) {
		session_start();
	}
    if (!isset($_SESSION["Usuario"]['Admin']) ||$_SESSION["Usuario"]['Admin'] == 0) {    
        header("Location: index.php?redirigido=true");
        exit; // Añadir exit para detener la ejecución después de redireccionar
    }     
}

function comprobar_sesion_protectora(){
	if (!isset($_SESSION)) {
		session_start();
	}
	if (!isset($_SESSION["Protectora"])) {    
		header("Location: index.php?redirigido=true");
		exit; // Añadir exit para detener la ejecución después de redireccionar
	}  
}
