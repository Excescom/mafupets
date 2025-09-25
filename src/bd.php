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

function obtenerAnimalesConfiltro($desde,$especie)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error"; // si no hay conexión, devolvemos un array vacío
    }

    if(!$especie)
    {
        $especie = "Todos";
    }

    try {
        if($especie == "Todos"){
            $stmt = $conexion->prepare("SELECT * FROM animales LIMIT 10 OFFSET $desde");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        else{
        
        $stmt = $conexion->prepare("SELECT * FROM animales WHERE Especie = :especie LIMIT 10 OFFSET $desde ");
        $stmt->bindParam(':especie', $especie, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        echo "Error al obtener animales: " . $e->getMessage();
        return [];
    }
}

function obtenerTodosAnimales()
{
    $conexion = conection();

    if ($conexion === null) {
        return "error"; // si no hay conexión, devolvemos un array vacío
    }

    try {
        $stmt = $conexion->query("SELECT * FROM animales");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener animales: " . $e->getMessage();
        return [];
    }
}

function obtenerAnimalespaginados($desde)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error"; // si no hay conexión, devolvemos un array vacío
    }

    try {
        $stmt = $conexion->prepare("SELECT * FROM animales LIMIT 10 OFFSET $desde");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener animales: " . $e->getMessage();
        return [];
    }
}


function obtenerAnimalporID($idAnimal)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error"; // si no hay conexión, devolvemos un array vacío
    }

    try {
        $stmt = $conexion->prepare("SELECT * FROM animales WHERE UniqueID = :id");
        $stmt->bindParam(':id', $idAnimal, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener usuarios: " . $e->getMessage();
        return [];
    }
}


function obtenerImagenesAnimalporID($idAnimal)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error"; // si no hay conexión, devolvemos un array vacío
    }

    try {
        $stmt = $conexion->prepare("SELECT Enlace FROM Multimedias WHERE IDAnimal = :id");
        $stmt->bindParam(':id', $idAnimal, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener usuarios: " . $e->getMessage();
        return [];
    }
}

function aniadirmultimedia($rutaArchivo, $idAnimal)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("INSERT INTO Multimedias (Enlace, IDAnimal) VALUES (:enlace, :idAnimal)");
        $stmt->bindParam(':enlace', $rutaArchivo, PDO::PARAM_STR);
        $stmt->bindParam(':idAnimal', $idAnimal, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        error_log("Error al añadir multimedia: " . $e->getMessage());
        return false;
    }
}

function eliminarMultimedia($enlace)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("DELETE FROM Multimedias WHERE Enlace = :enlace");
        $stmt->bindParam(':enlace', $enlace, PDO::PARAM_STR);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        error_log("Error al eliminar multimedia: " . $e->getMessage());
        return false;
    }
}

function seleccionarMultimediaporNombre($nombre)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("SELECT * FROM Multimedias WHERE Enlace = :nombre");
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al seleccionar multimedia: " . $e->getMessage();
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


function cancelarReserva($idReserva)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("UPDATE reservas SET estado = 0 WHERE UniqueID = :idReserva");
        $stmt->bindParam(':idReserva', $idReserva, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        echo "Error al cancelar reserva: " . $e->getMessage();
        return false;
    }
}
function obtenerUsuarioReserva($idReserva,$idUsuario)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("SELECT * FROM usuariosreservas WHERE IDReserva = :idReserva AND IDUsuario = :idUsuario");
        $stmt->bindParam(':idReserva', $idReserva, PDO::PARAM_INT);
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener usuarioreserva: " . $e->getMessage();
        return [];
    }
}
function actualizarusuarioreserva($usuarioreserva)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("UPDATE usuariosreservas SET Aceptado = :aceptado WHERE IDReserva = :idReserva AND IDUsuario = :idUsuario");
        $stmt->bindParam(':aceptado', $usuarioreserva['Aceptado'], PDO::PARAM_INT);
        $stmt->bindParam(':idReserva', $usuarioreserva['IDReserva'], PDO::PARAM_INT);
        $stmt->bindParam(':idUsuario', $usuarioreserva['IDUsuario'], PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error al actualizar usuarioreserva: " . $e->getMessage();
    }
}

function aniadirReserva($idReserva, $idUsuario)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("INSERT INTO usuariosreservas (IDReserva, IDUsuario) VALUES (:idReserva, :idUsuario)");
        $stmt->bindParam(':idReserva', $idReserva, PDO::PARAM_INT);
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        error_log("Error al aniadir reserva: " . $e->getMessage());
        return false;
    }
}

function obtenerusuariosreserva($idReserva)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error"; // si no hay conexión, devolvemos un array vacío
    }

    try {
        $stmt = $conexion->prepare("SELECT IDUsuario FROM usuariosreservas WHERE IDReserva = :id");
        $stmt->bindParam(':id', $idReserva, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}



function obtenerUsuarioid($idUsuario)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE UniqueID = :id");
        $stmt->bindParam(':id', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener usuarios: " . $e->getMessage();
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

function desactivarProtectora($idProtectora)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("UPDATE protectoras SET activa = 0 WHERE UniqueID = :id");
        $stmt->bindParam(':id', $idProtectora, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error al desactivar protectora: " . $e->getMessage();
    }
}

function activarProtectora($idProtectora)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("UPDATE protectoras SET activa = 1 WHERE UniqueID = :id");
        $stmt->bindParam(':id', $idProtectora, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error al activar protectora: " . $e->getMessage();
    }
}

function activarAdmin($idUsuario)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("UPDATE usuarios SET Admin = 1 WHERE UniqueID = :id");
        $stmt->bindParam(':id', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error al activar admin: " . $e->getMessage();
    }
}

function desactivarAdmin($idUsuario)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("UPDATE usuarios SET Admin = 0 WHERE UniqueID = :id");
        $stmt->bindParam(':id', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error al desactivar admin: " . $e->getMessage();
    }
}

function obtenerReserva($ID)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("SELECT * FROM reservas WHERE UniqueID = :id");
        $stmt->bindParam(':id', $ID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener reserva: " . $e->getMessage();
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
        $stmt = $conexion->query("SELECT * FROM Comentarios");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener usuarios: " . $e->getMessage();
        return [];
    }
}

function obtenrcomentariosID($idAnimal)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error"; // si no hay conexión, devolvemos un array vacío
    }

    try {
        $stmt = $conexion->prepare("SELECT * FROM Comentarios WHERE IDAnimal = :id");
        $stmt->bindParam(':id', $idAnimal, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener usuarios: " . $e->getMessage();
        return [];
    }
}

function obtenertodoscomentarios()
{
    $conexion = conection();

    if ($conexion === null) {
        return "error"; // si no hay conexión, devolvemos un array vacío
    }

    try {
        $stmt = $conexion->prepare("SELECT * FROM Comentarios order by IDAnimal desc");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener usuarios: " . $e->getMessage();
        return [];
    }
}

function eliminarcomentario($id)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("DELETE FROM Comentarios WHERE UniqueID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error al eliminar comentario: " . $e->getMessage();
    }
}
function obtenerReservaUsuariosReserva($idReserva)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("SELECT IDUsuario FROM usuariosreservas WHERE IDReserva = :id");
        $stmt->bindParam(':id', $idReserva, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener usuarios: " . $e->getMessage();
        return [];
    }
}

function aniadircomentario($comentario,$idAnimal,$idUsuario)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("INSERT INTO Comentarios (Comentario, IDAnimal, IDUsuario) VALUES (:comentario, :idAnimal, :idUsuario)");
        $stmt->bindParam(':comentario', $comentario, PDO::PARAM_STR);
        $stmt->bindParam(':idAnimal', $idAnimal, PDO::PARAM_INT);
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error al aniadir comentario: " . $e->getMessage();
    }
}

function obtenerTicketsU()
{
    $conexion = conection();

    if ($conexion === null) {
        return "error"; // si no hay conexión, devolvemos un array vacío
    }

    try {
        $stmt = $conexion->query("SELECT * FROM TiketsUsuarios");
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
        $stmt = $conexion->query("SELECT * FROM TiketsProtectoras");
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
function obtenerProtectoraID($ID)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error"; // si no hay conexión, devolvemos un array vacío
    }

    try {
        $stmt = $conexion->prepare("SELECT * FROM protectoras WHERE UniqueID = :id");
        $stmt->bindParam(':id', $ID, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener protectora: " . $e->getMessage();
        return [];
    }
}

function obtenerNumerosContactoProtectora($ID)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("SELECT * FROM TelefonosProtectoras WHERE IDProtectora = :id");
        $stmt->bindParam(':id', $ID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

function aniadirnumeroProtectora($ID,$numero)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("INSERT INTO TelefonosProtectoras (IDProtectora, Numero) VALUES (:id, :numero)");
        $stmt->bindParam(':id', $ID, PDO::PARAM_INT);
        $stmt->bindParam(':numero', $numero, PDO::PARAM_STR);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

function eliminarnumeroProtectora($ID)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("DELETE FROM TelefonosProtectoras WHERE UniqueID = :id");
        $stmt->bindParam(':id', $ID, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        return false;
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

function obtenrusuarioPorID($ID)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE UniqueID = :id");
        $stmt->bindParam(':id', $ID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener usuario: " . $e->getMessage();
        return [];
    }
}
function obtenerUsuarioCorreo($correo)
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



function selecionarimagenperfilanimal($IDAnimal)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("SELECT Enlace FROM multimedias WHERE IDAnimal = :id AND Enlace LIKE '%perfil/%'");
        $stmt->bindParam(':id', $IDAnimal, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

function eliminarimagenperfilanimal($IDAnimal)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("DELETE FROM multimedias WHERE IDAnimal = :id AND Enlace LIKE '%perfil/%'");
        $stmt->bindParam(':id', $IDAnimal, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        return false;
    }
}


function aniadirimagenanimal($IDAnimal,$enlace)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("INSERT INTO multimedias (Enlace, IDAnimal) VALUES (:enlace, :idAnimal)");
        $stmt->bindParam(':idAnimal', $IDAnimal, PDO::PARAM_INT);
        $stmt->bindParam(':enlace', $enlace, PDO::PARAM_STR);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

function obtenerAnimalesFavoritos($IDUsuario)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("SELECT * FROM animales WHERE UniqueID IN (SELECT IDAnimal FROM favoritos WHERE IDUsuario = :id)");
        $stmt->bindParam(':id', $IDUsuario, PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowCount() === 0){
            return [];
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
       return [];
    }
}

function obtenerAnimal($ID)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("SELECT * FROM animales WHERE UniqueID = :id");
        $stmt->bindParam(':id', $ID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

function actualizarAnimal($ID,$nombre,$especie,$peso,$discapacidad,$descripcion)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("UPDATE animales SET Nombre = :nombre, Especie = :especie, Peso = :peso, Discapacidad = :discapacidad, Descripcion = :descripcion WHERE UniqueID = :id");
        $stmt->bindParam(':id', $ID, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':especie', $especie, PDO::PARAM_STR);
        $stmt->bindParam(':peso', $peso, PDO::PARAM_STR);
        $stmt->bindParam(':discapacidad', $discapacidad, PDO::PARAM_INT);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        return false;
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

function filtroAnimales($nombre)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    if($nombre == "")
    {
        $stmt = $conexion->prepare("SELECT * FROM animales");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    try {
        $stmt = $conexion->prepare("SELECT * FROM animales WHERE Nombre LIKE '%$nombre%'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener animales: " . $e->getMessage();
        return [];
    }
}

function filtroProtectoras($nombre)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    if($nombre == "")
    {
        $stmt = $conexion->prepare("SELECT * FROM protectoras");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    try {
        $stmt = $conexion->prepare("SELECT * FROM protectoras WHERE Nombre LIKE '%$nombre%'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener protectoras: " . $e->getMessage();
        return [];
    }
}

function filtroProtectorasAdmin($correo)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    if($correo == "")
    {
        $stmt = $conexion->prepare("SELECT * FROM protectoras");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    try {
        $stmt = $conexion->prepare("SELECT * FROM protectoras WHERE Correo LIKE '%$correo%'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener protectoras: " . $e->getMessage();
        return [];
    }
}

function obtenrprotectoraPorID($idProtectora)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("SELECT * FROM protectoras WHERE UniqueID = ?");
        $stmt->execute([$idProtectora]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener protectora: " . $e->getMessage();
        return [];
    }
}

function filtroUsuariosAdmin($correo)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE Correo LIKE '%$correo%'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener usuarios: " . $e->getMessage();
        return [];
    }
}

function filtroAnimalesAdmin($nombre,$protectora,$especie)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("SELECT * FROM animales WHERE Nombre LIKE '%$nombre%' AND IDProtectora LIKE '%$protectora%' AND Especie LIKE '%$especie%'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener animales: " . $e->getMessage();
        return [];
    }
}

function filtroComentariosAdmin($comentario)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("SELECT * FROM comentarios WHERE Comentario LIKE '%$comentario%'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener animales: " . $e->getMessage();
        return [];
    }
}
function crearTicketUsuarios($tipo,$descripcion,$IDUsuario)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }
    $estado = 0;
    $fecha = date('Y-m-d H:i:s');
    try {
        $stmt = $conexion->prepare("INSERT INTO TiketsUsuarios (IDUsuario, Tipo, Descripcion,Estado,Fecha) VALUES (?, ?, ?,?,?)");
        $stmt->execute([$IDUsuario, $tipo, $descripcion,$estado,$fecha]);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}
function crearTicketProtectora($tipo,$descripcion,$IDProtectora)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }
    $estado = 0;
    $fecha = date('Y-m-d H:i:s');
    try {
        $stmt = $conexion->prepare("INSERT INTO TiketsProtectoras (IDProtectora, Tipo, Descripcion,Estado,Fecha) VALUES (?, ?, ?,?,?)");
        $stmt->execute([$IDProtectora, $tipo, $descripcion,$estado,$fecha]);
        return true;
    } catch (PDOException $e) {
        return false;
    }
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

function filtroTicketsU($nombre)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    if($nombre == "")
    {
        $stmt = $conexion->prepare("SELECT * FROM tiketsusuarios");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    try {
        $stmt = $conexion->prepare("SELECT * FROM tiketsusuarios WHERE Descripcion LIKE '%$nombre%'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener animales: " . $e->getMessage();
        return [];
    }
}

function filtroTicketsP($nombre)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    if($nombre == "")
    {
        $stmt = $conexion->prepare("SELECT * FROM tiketsprotectoras");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    try {
        $stmt = $conexion->prepare("SELECT * FROM tiketsprotectoras WHERE Descripcion LIKE '%$nombre%'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener animales: " . $e->getMessage();
        return [];
    }
}
function filtroespecie($especie)
{
    $conexion = conection();

    if ($conexion === null) {
        return "error";
    }

    try {
        $stmt = $conexion->prepare("SELECT * FROM animales WHERE Especie LIKE '%$especie%'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener animales: " . $e->getMessage();
        return [];
    }
}
function modificarEstadoTicketU($id,$estado)
{
    $conexion = conection();

    if ($conexion === null) {
        return false;
    }

    try {
        $stmt = $conexion->prepare("UPDATE tiketsusuarios SET Estado = ? WHERE UniqueID = ?");
        $stmt->execute([$estado, $id]);
        return true;
    } catch (PDOException $e) {
        echo "Error al modificar estado de ticket: " . $e->getMessage();
        return false;
    }
}

function modificarEstadoTicketP($id,$estado)
{
    $conexion = conection();

    if ($conexion === null) {
        return false;
    }

    try {
        $stmt = $conexion->prepare("UPDATE tiketsprotectoras SET Estado = ? WHERE UniqueID = ?");
        $stmt->execute([$estado, $id]);
        return true;
    } catch (PDOException $e) {
        echo "Error al modificar estado de ticket: " . $e->getMessage();
        return false;
    }
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

function eliminarreservas($idProtectora)
{
    $conexion = conection();

    if ($conexion === null) {
        return false;
    }

    try {
        $stmt = $conexion->prepare("DELETE FROM Reservas WHERE IDProtectora = ?");
        $stmt->execute([$idProtectora]);
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        echo "Error al eliminar reservas: " . $e->getMessage();
        return false;
    }
}

function eliminarAnimalesProtectora($idProtectora)
{
    $conexion = conection();

    if ($conexion === null) {
        return false;
    }

    try {
        $stmt = $conexion->prepare("DELETE FROM Animales WHERE IDProtectora = ?");
        $stmt->execute([$idProtectora]);
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        echo "Error al eliminar animales: " . $e->getMessage();
        return false;
    }
}

function eliminarProtectora($idProtectora)
{
    $conexion = conection();

    if ($conexion === null) {
        return false;
    }

    try {
        
        $stmt = $conexion->prepare("DELETE FROM Protectoras WHERE UniqueID = ?");
        $stmt->execute([$idProtectora]);
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        echo "Error al eliminar protectora: " . $e->getMessage();
        return false;
    }
}

function eliminarAnimalFavorito($idUsuario, $idAnimal)
{
    $conexion = conection();

    if ($conexion === null) {
        return false;
    }

    try {
        $stmt = $conexion->prepare("DELETE FROM Favoritos WHERE IDUsuario = ? AND IDAnimal = ?");
        $stmt->execute([$idUsuario, $idAnimal]);
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        echo "Error al eliminar animal favorito: " . $e->getMessage();
        return false;
    }
}

function aniadirAnimalFavorito($idUsuario, $idAnimal)
{
    $conexion = conection();

    if ($conexion === null) {
        return false;
    }

    try {
        $stmt = $conexion->prepare("INSERT INTO Favoritos (IDUsuario, IDAnimal) VALUES (?, ?)");
        $stmt->execute([$idUsuario, $idAnimal]);
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        echo "Error al aniadir animal favorito: " . $e->getMessage();
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


//función para eliminar directorio del animal con sus imágenes, y si falla devuelve un false
function eliminarDirectorio($ruta) {
    if (!file_exists($ruta)) {
        return true;
    }

    if (!is_dir($ruta)) {
        return unlink($ruta);
    }

    foreach (scandir($ruta) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!eliminarDirectorio($ruta . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }

    return rmdir($ruta);
}


?>
