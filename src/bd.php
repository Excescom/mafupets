<?php
function conection()
{
    // datos de conexión
    $server = "localhost";
    $usuario = "root";
    $passwd = "";
    $db = "mafupets";

    try
    {
        $conexion = new PDO("mysql:host=$server;dbname=$db;charset=utf8mb4", $usuario, $passwd);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conexion->exec("SET NAMES utf8mb4");
        
    }catch(PDOException $exp)
    {
        echo("fallo en la conexión db: $db, error: $exp");
    }

    return $conexion;
 
}
//  consultas 
function obtenerUsuarios()
{
    $conexion = conection();

    if ($conexion === null) {
        return "error"; // si no hay conexión, devolvemos un array vacío
    }

    try {
        $stmt = $conexion->query("SELECT * FROM usuarios");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener usuarios: " . $e->getMessage();
        return [];
    }
}

function obtenerAnimales()
{
    $conexion = conection();

    if ($conexion === null) {
        return "error"; // si no hay conexión, devolvemos un array vacío
    }

    try {
        $stmt = $conexion->query("SELECT * FROM animales");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener usuarios: " . $e->getMessage();
        return [];
    }
}

function usuarioReservas()
{
    $conexion = conection();

    if ($conexion === null) {
        return "error"; // si no hay conexión, devolvemos un array vacío
    }

    try {
        $stmt = $conexion->query("SELECT * FROM usuariosreservas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener usuariosreservas: " . $e->getMessage();
        return [];
    }
}

function obtenerReservasProtectora($ID)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("SELECT * FROM reservas WHERE IDProtectora = :id");
        $stmt->bindParam(':id', $ID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener reservas de la protectora: " . $e->getMessage();
        return [];
    }
}

function eliminarReserva($ID)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("DELETE FROM reservas WHERE UniqueID = :id");
        $stmt->bindParam(':id', $ID, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error al eliminar reserva: " . $e->getMessage();
    }
}

function obtenerProtectoras()
{
    $conexion = conection();

    if ($conexion === null) {
        return "error"; // si no hay conexión, devolvemos un array vacío
    }

    try {
        $stmt = $conexion->query("SELECT * FROM protectoras");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener usuarios: " . $e->getMessage();
        return [];
    }
}


function obtenerNombreProtectora($ID)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error"; // si no hay conexión, devolvemos un array vacío
    }

    try 
    {
        $stmt = $conexion->prepare("SELECT Nombre FROM protectoras WHERE UniqueID = :id");
        $stmt->bindParam(':id', $ID, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado && isset($resultado['Nombre'])) {
            return $resultado['Nombre'];
        } else {
            return "no encontrada";
        }
    } catch (PDOException $e) {
        echo "Error al obtener nombre de protectora: " . $e->getMessage();
        return "error";
    }
}

function obtenerNombreUsuario($ID)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("SELECT Nombre FROM usuarios WHERE UniqueID = :id");
        $stmt->bindParam(':id', $ID, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado && isset($resultado['Nombre'])) {
            return $resultado['Nombre'];
        } else {
            return "no encontrado";
        }
    } catch (PDOException $e) {
        echo "Error al obtener nombre de usuario: " . $e->getMessage();
        return "error";
    }
}

function obtenerNombreAnimal($ID)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("SELECT Nombre FROM animales WHERE UniqueID = :id");
        $stmt->bindParam(':id', $ID, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado && isset($resultado['Nombre'])) {
            return $resultado['Nombre'];
        } else {
            return "no encontrado";
        }
    } catch (PDOException $e) {
        echo "Error al obtener nombre del animal: " . $e->getMessage();
        return "error";
    }
}

function obtenerComentarios()
{
    $conexion = conection();

    if ($conexion === null) {
        return "error"; // si no hay conexión, devolvemos un array vacío
    }

    try {
        $stmt = $conexion->query("SELECT * FROM comentarios");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener usuarios: " . $e->getMessage();
        return [];
    }
}

function obtenerTicketsU()
{
    $conexion = conection();

    if ($conexion === null) {
        return "error"; // si no hay conexión, devolvemos un array vacío
    }

    try {
        $stmt = $conexion->query("SELECT * FROM tiketsusuarios");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener usuarios: " . $e->getMessage();
        return [];
    }
}

function obtenerTicketsP()
{
    $conexion = conection();

    if ($conexion === null) {
        return "error"; // si no hay conexión, devolvemos un array vacío
    }

    try {
        $stmt = $conexion->query("SELECT * FROM tiketsprotectoras");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener usuarios: " . $e->getMessage();
        return [];
    }
}

function obtenerReservas()
{
    $conexion = conection();

    if ($conexion === null) {
        return "error"; // si no hay conexión, devolvemos un array vacío
    }

    try {
        $stmt = $conexion->query("SELECT * FROM reservas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener reservas: " . $e->getMessage();
        return [];
    }
}

function obtenerProtectoraCorreo($correo)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error"; // si no hay conexión, devolvemos un array vacío
    }

    try {
        $stmt = $conexion->prepare("SELECT * FROM protectoras WHERE Correo = :correo");
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener protectora: " . $e->getMessage();
        return [];
    }
}
function obtenerUsuarioPorCorreo($correo)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE Correo = :correo");
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener usuario: " . $e->getMessage();
        return [];
    }
}
function obtenerAnimalesProtectora($ID)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("SELECT * FROM animales WHERE IDProtectora = :id");
        $stmt->bindParam(':id', $ID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener animales de la protectora: " . $e->getMessage();
        return [];
    }
}

function obtenerDescAnimal($ID)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("SELECT Descripcion FROM animales WHERE UniqueID = :id");
        $stmt->bindParam(':id', $ID, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado && isset($resultado['Descripcion'])) {
            return $resultado['Descripcion'];
        } else {
            return "no encontrado";
        }
    } catch (PDOException $e) {
        echo "Error al obtener nombre del animal: " . $e->getMessage();
        return "error";
    }
}

function comprobarUsuario($correo,$contrasenia)
{
    $conexion = conection();

    // Primero obtenemos el usuario por su correo
    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE Correo = ?");
    $stmt->execute([$correo]);
    
    if($stmt->rowCount() === 1){
        $usuario = $stmt->fetch();
        // Verificamos si la contraseña coincide con el hash almacenado
        if(password_verify($contrasenia, $usuario['Contrasena'])){
            return $usuario;
        }
    }
    
    return FALSE;
}

function comprobarProtectora($correo,$contrasenia)
{
    $conexion = conection();

    // Primero obtenemos el usuario por su correo
    $stmt = $conexion->prepare("SELECT * FROM protectoras WHERE Correo = ?");
    $stmt->execute([$correo]);
    
    if($stmt->rowCount() === 1){
        $usuario = $stmt->fetch();
        // Verificamos si la contraseña coincide con el hash almacenado
        if(password_verify($contrasenia, $usuario['Contrasena'])){
            return $usuario;
        }
    }
    
    return FALSE;
}

function eliminarAnimal($idAnimal)
{
    $conexion = conection();

    if ($conexion === null) {
        return false;
    }

    try {
        // Primero eliminamos las entradas relacionadas en la tabla Multimedias
        $stmtMultimedia = $conexion->prepare("DELETE FROM Multimedias WHERE IDAnimal = ?");
        $stmtMultimedia->execute([$idAnimal]);
        
        // Eliminamos las entradas relacionadas en la tabla Favoritos
        $stmtFavoritos = $conexion->prepare("DELETE FROM Favoritos WHERE IDAnimal = ?");
        $stmtFavoritos->execute([$idAnimal]);
        
        // Eliminamos las entradas relacionadas en la tabla Comentarios
        $stmtComentarios = $conexion->prepare("DELETE FROM Comentarios WHERE IDAnimal = ?");
        $stmtComentarios->execute([$idAnimal]);
        
        // Finalmente eliminamos el animal
        $stmtAnimal = $conexion->prepare("DELETE FROM Animales WHERE UniqueID = ?");
        $stmtAnimal->execute([$idAnimal]);
        
        return $stmtAnimal->rowCount() > 0;
    } catch (PDOException $e) {
        echo "Error al eliminar animal: " . $e->getMessage();
        return false;
    }
}

function eliminarUsuario($idUsuario)
{
    $conexion = conection();

    if ($conexion === null) {
        return false;
    }

    try {
        // Primero eliminamos las entradas relacionadas en la tabla Favoritos
        $stmtFavoritos = $conexion->prepare("DELETE FROM Favoritos WHERE IDUsuario = ?");
        $stmtFavoritos->execute([$idUsuario]);
        
        // Eliminamos las entradas relacionadas en la tabla Comentarios
        $stmtComentarios = $conexion->prepare("DELETE FROM Comentarios WHERE IDUsuario = ?");
        $stmtComentarios->execute([$idUsuario]);
        
        // Eliminamos las entradas relacionadas en la tabla UsuariosReservas
        $stmtUsuariosReservas = $conexion->prepare("DELETE FROM UsuariosReservas WHERE IDUsuario = ?");
        $stmtUsuariosReservas->execute([$idUsuario]);
        
        // Eliminamos las entradas relacionadas en la tabla TiketsUsuarios
        $stmtTiketsUsuarios = $conexion->prepare("DELETE FROM TiketsUsuarios WHERE IDUsuario = ?");
        $stmtTiketsUsuarios->execute([$idUsuario]);
        
        // Finalmente eliminamos el usuario
        $stmtUsuario = $conexion->prepare("DELETE FROM Usuarios WHERE UniqueID = ?");
        $stmtUsuario->execute([$idUsuario]);
        
        return $stmtUsuario->rowCount() > 0;
    } catch (PDOException $e) {
        echo "Error al eliminar usuario: " . $e->getMessage();
        return false;
    }
}
?>
