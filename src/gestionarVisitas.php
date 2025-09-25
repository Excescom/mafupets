<?php 
        session_start();
        require 'head.php';
        require 'correo.php';
?> 

  <?php 
	  require 'nav.php';
    require 'bd.php';
    
    $protectora = obtenerProtectoraCorreo($_SESSION['Protectora']['Correo']);
    if(!isset($_SESSION['Protectora'])){
      header("Location: index.php?contador=0");
      exit;
    }
    $idReserva = $_GET['id'];
    $reserva = obtenerReserva($idReserva);
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['aceptar'])){
      if(isset($_POST['aceptar'])){
        $idUsuario = $_POST['id'];
        $usuario = obtenerUsuarioid($idUsuario);
        $usuarioreserva = obtenerusuarioreserva($idReserva,$idUsuario);
        $usuarioreserva['Aceptado'] = 1;
        actualizarusuarioreserva($usuarioreserva);
        correoReservaConfirmación($usuario['Correo'],$protectora,$reserva);
      }
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      if(isset($_POST['aceptado']) && $_POST['aceptado'] == 'aceptado'){
        $idUsuario = $_POST['id'];
        $usuario = obtenerUsuarioid($idUsuario);
        $usuarioreserva = obtenerusuarioreserva($idReserva,$idUsuario);
        $usuarioreserva['Aceptado'] = 1;
        actualizarusuarioreserva($usuarioreserva);
        correoReservaConfirmación($usuario['Correo'],$protectora,$reserva);
      }
    }

    
    //devuelve un array con los id de los usuarios que han reservado en esta reserva en concreto
    $IDusuarios = obtenerReservaUsuariosReserva($idReserva);

    //comprobar que la reserva es de esa protectora, si no lo es que te mande al index
    $protectora = obtenerProtectoraCorreo($_SESSION['Protectora']['Correo']);

    if($reserva['IDProtectora'] != $protectora['UniqueID']){
      header("Location: index.php?contador=0");
      exit;
    }
  ?>

  <main class="flex flex-col items-center w-full relative pt-[30px] ">
  <h1 class="text-4xl mb-6">Gestión de Publicación</h1>
  <?php if($reserva['estado'] == 1)
  { 
    ?>
    <a href="cerrarReserva.php?id=<?php echo $idReserva; ?>" class="w-[200px] bg-[#DB3066] hover:bg-[#DB3066]/80 text-white font-bold py-2 p-4 rounded">cerrar Reserva</a>
    <?php 
  }
  else  
  { ?>
  <p class="text-red-500 bg-red-100 p-2 rounded">La reserva ha sido cerrada</p>
   <?php } ?>
  <hr class="w-full border-gray-700">
    <?php foreach ($IDusuarios as $IDusuario) { 
      $usuario = obtenerUsuarioid($IDusuario['IDUsuario']);
      $usuarioreserva = obtenerusuarioreserva($reserva['UniqueID'],$usuario['UniqueID']);
    ?>
      <div class="flex flex-col items-center w-full relative pt-[30px] ">
        nombre: <?php echo $usuario['Nombre']; ?>
        apellidos: <?php echo $usuario['Apellidos']; ?>
        telefono: <?php echo $usuario['Telefono']; ?>
        correo: <?php echo $usuario['Correo']; ?>
       <?php if($usuarioreserva['Aceptado'] == 0) { ?>
        <form action="" method="POST">
         
          <button type="submit" name="aceptar" class="w-full bg-[#54B5BE] hover:bg-[#54B5BE]/80 text-white font-bold py-2 px-4 rounded">aceptar</button>

          <input type="hidden" name="id" value="<?php echo $usuario['UniqueID']; ?>">
        </form>
      <?php }
      else{ ?>
      <input type="hidden" name="aceptado" value="aceptado">
      <p class="text-green-500">aceptado</p>
      <?php } ?>
      </div>
    <?php } ?>

  </main>
</body>
</html>
