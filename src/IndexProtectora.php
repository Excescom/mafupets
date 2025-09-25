<?php 
        session_start();
        require 'head.php';
        require 'bd.php';
        require 'nav.php';
        require 'correo.php';
        $ID = $_GET['id'];
        $protectora = obtenerProtectoraID($ID);
        
       
?> 

  <?php 
    if (isset($_SESSION['Protectora'])){
      header("Location: index.php?contador=0");
      exit;
    }
    

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $reserva = obtenerReserva($_POST['reserva']);
     aniadirReserva($reserva['UniqueID'], $_SESSION['Usuario']['UniqueID']);
     
     correoReserva($_SESSION['Usuario']['Correo'],$protectora,$reserva);
     correoReservaProtectora($protectora['Correo'],$_SESSION['Usuario']['Correo'],$reserva);
     header("Location: IndexProtectora.php?id=".$ID);
      exit;
    }
  ?>
  <main class="items-center w-[100%] gap-7 relative top-[] pl-6 flex flex-col justify-center ">
    <?php if($protectora['activa'] == 1){ ?>
    <div class="flex flex-col items-center content-center w-full gap-5 p-4">
        <div class="rounded-full bg-amber-400 w-[200px] h-[200px] min-w-[200px] min-h-[200px] flex-shrink-0 overflow-hidden flex items-center justify-center">
        <?php 
        $carpeta =  "multimedia/protectoras/".$ID."/perfil/";
        $imagenPerfil = glob($carpeta . '*');    
        ?>
        <img class="w-full h-full object-cover object-center" src="<?php echo $imagenPerfil[0]; ?>" alt="Imagen">
        </div>
        <h1 class="text-4xl lg:text-7xl"><?php echo $protectora['Nombre']; ?></h1>
    </div>
    <div class="p-4 text-left w-full">
        <h1 class="text-2xl font-bold">Información Protectora:</h1>
        <div>
            <p>Nombre: <?php echo $protectora['Nombre']; ?></p>
            <p>Correo: <?php echo $protectora['Correo']; ?></p>
            
            <?php 
            $telefonos = obtenerNumerosContactoProtectora($ID);
           foreach($telefonos as $telefono){
            echo '<p>numero de contacto: '.$telefono['Numero'].'</p>';
           }
            ?>
            <p>Información: <?php echo $protectora['Informacion']; ?></p>
        </div>
    </div>
    
    <div class="w-full flex flex-col items-center justify-center">
    <h2 class="text-2xl font-bold px-4 md:px-8 pt-6">Próximos Eventos</h2>
    <hr class="w-[80%]">
    <?php if(isset($_SESSION['Usuario'])) { ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 w-full px-4 md:px-8 py-6">
        <?php 
            
            $reservas = obtenerReservasProtectora($ID);
            $usuarioactual = obtenerUsuarioCorreo($_SESSION['Usuario']['Correo']);
            $reservado = false;
            foreach($reservas as $reserva){
              $usuarioreserva = obtenerUsuarioReserva($reserva['UniqueID'],$usuarioactual['UniqueID']);
              if($usuarioreserva){
                $reservado = true;
              }
            }
            if ($reservas ) 
            {
              foreach ($reservas as $reserva) 
              {
                if ($reserva['estado'] == 1) 
                {
                  echo '<div class="bg-gray-800 rounded-xl shadow-md border border-gray-700 overflow-hidden">';
                  echo '<div class="bg-[#EDB439] py-2 px-4 text-white font-bold">';
                  echo 'RESERVA';
                  echo '</div>';
                  echo '<div class="p-4">';
                  echo '<h3 class="font-bold text-lg mb-2">'.$reserva['Tipo'].'</h3>';
                  echo '<div class="flex justify-between mb-2">';
                  echo '<span class="text-gray-300">fecha y hora: '.$reserva['FechaHora'].'</span>';
                  echo '</div>';
                  if($reservado){
                    echo '<p class="w-full bg-[#DB3066] text-white font-bold py-2 px-4 rounded">Ya tienes una reserva</p>';
                  }
                  else
                  {
                    echo '<form action="" method="post">';
                    echo '<button class="w-full bg-[#54B5BE] hover:bg-[#54B5BE]/80 text-white font-bold py-2 px-4 rounded" name="reserva" value="'.$reserva['UniqueID'].'">';
                    echo 'Reservar';
                    echo '</button>';
                    echo '</form>';
                  }
                  echo '</div>';
                  echo '</div>';
                }
                else
                {
                  echo '<div class="bg-gray-800 rounded-xl shadow-md border border-gray-700 overflow-hidden">';
                  echo '<div class="bg-[#DB3066] py-2 px-4 text-white font-bold">';
                  echo 'RESERVA CERRADA';
                  echo '</div>';
                  echo '<div class="p-4">';
                  echo '<h3 class="font-bold text-lg mb-2">'.$reserva['Tipo'].'</h3>';
                  echo '<div class="flex justify-between mb-2">';
                  echo '<span class="text-gray-300">fecha y hora: '.$reserva['FechaHora'].'</span>';
                  echo '</div>';
                  echo '</div>';
                  echo '</div>';
                }
              }
            } 
            else 
            {
              echo '<div class="w-full flex justify-center items-center h-full">';
             echo '<p class="text-center">No se encontraron eventos próximos</p>';
             echo '</div>';
            }
          ?>
    </div>
    <?php }
    else{
      echo ' <p class="text-center text-red-500">deves iniciar sesión para ver las reservas</p>';
      echo '<a href="login.php" class="mt-4 inline-block bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-4 rounded">
      Iniciar sesión
  </a>';
    }
    ?>
    <div class="w-full p-4">
      <h2 class="text-4xl mb-6">Animales</h2>
      <hr class="w-full">
      
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 p-5 gap-4 ">
   
       
   <?php 
   $animales = obtenerAnimalesProtectora($ID);
   foreach($animales as $animal){
    $carpetaImagenAnimal = "multimedia/protectoras/".$ID."/".$animal['UniqueID']."/perfil/";
    $imagenanimal = glob($carpetaImagenAnimal."*");
   echo '<div class=" w-full flex flex-col justify-end items-center flex-shrink-0">
           <a href="IndexAnimales.php?id='.$animal['UniqueID'].'"><img class="w-full h-[400px] object-cover rounded-lg" src="'.$imagenanimal[0].'"></a>
       <p class="mt-2 text-black dark:text-white">'.$animal['Nombre'].'</p>
   </div>';
   
   }?>
   <?php }
   else{
    echo '<p class="text-center ">Essta protectora ha sido desactivada por administración, por favor vuelve al inicio lamentamos las molestias</p>';
    echo '<a href="index.php?contador=0" class="mt-4 inline-block bg-[#DB3066] hover:bg-[#DB3066]/80 text-white font-bold py-2 px-4 rounded">
    inicio
</a>';
   }
   
   ?>
  </main>
</body>
</html>
