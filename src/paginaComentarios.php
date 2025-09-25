<?php 
        require 'head.php';
        session_start();
        if(!isset($_SESSION['Usuario'])){
            header("Location: debesInicarSesion.php");
            exit;
        }
?> 

  <?php 
    require 'nav.php';
    require 'bd.php';
    $idanimal = $_GET['id'];
    $animal = obtenerAnimalporID($idanimal);
    $comentarios = obtenrcomentariosID($idanimal);
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comentario']))
    {
        $comentario = $_POST['comentario'];
        if(trim($comentario) === '')
        {
            header("Location: paginaComentarios.php?id=" . $idanimal);
            exit;
        }
        $usuario = obtenerUsuarioPorCorreo($_SESSION['Usuario']['Correo']);
        aniadircomentario($comentario,$idanimal,$usuario['UniqueID']);
        header("Location: paginaComentarios.php?id=" . $idanimal);
        exit;
    }
  ?>
  <main class="flex flex-col items-center w-full relative pt-[30px] ">
    <h1 class="text-4xl p-4">Comentarios de <?php echo $animal['Nombre']; ?></h1>
  <div class="flex flex-col w-full gap-2 border p-4 w-[80%] text-left h-[60vh] overflow-y-scroll">
 <?php foreach($comentarios as $comentario){ ?>
    <?php $nombreUsuario = obtenerNombreUsuario($comentario['IDUsuario']); ?>
    <p><?php echo $nombreUsuario; ?>: <?php echo $comentario['Comentario']; ?></p>
 <?php } ?>
</div>


<form action="" method="post" class="flex flex-col items-center w-full gap-2 p-2">
    <input type="text" name="comentario" id="comentario" class="border border-gray-300 rounded p-2">
    <button type="submit" class="bg-[#54B5BE] hover:bg-[#54B5BE]/80 p-2 rounded-lg mt-4">Enviar</button>
</form>
  </main>
</body>
</html>
























