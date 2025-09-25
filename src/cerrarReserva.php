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
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      cancelarReserva($idReserva);
      $usuariosreserva = obtenerusuariosreserva($idReserva);
      foreach($usuariosreserva as $usuarioreserva){
        if($usuarioreserva['Aceptado'] == 0)
        {
          $usuario = obtenerUsuarioid($usuarioreserva['IDUsuario']);
          correoReservaCancelada($usuario['Correo'],$protectora,$reserva);
        }
      }
      header("Location: gestionarVisitas.php?id=".$idReserva);
      exit;
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
  <div class="flex flex-col items-center content-center w-full gap-5 p-4">
        <h1 class="lg:text-7xl text-4xl text-center">Confirmación de cierre de reserva, no se podrá volver a abrir</h1>
    </div>
    <p>¿Está seguro/a de que desea cerrar la reserva?</p>
    <div class="flex justify-center items-center content-center w-full gap-5 p-4 text-center"> 
        <form action="" method="POST">
        <button type="submit" class="bg-[#54B5BE] hover:bg-[#54B5BE]/80 text-white font-bold p-2 px-4 rounded">Sí</button>
        </form>
        <a href="gestionarVisitas.php?id=<?php echo $idReserva; ?>" class="bg-[#DB3066] hover:bg-[#DB3066]/80 text-white font-bold p-2 px-4 rounded">No</a>
    </div>
  </main>
</body>
</html>
