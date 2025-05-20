<?php 
        require 'head.php';
        require 'sesion.php';
        require 'bd.php';
        comprobar_sesion_protectora();
        
?> 

  <?php 
	  require 'nav.php';

   $protectora = obtenerProtectoraCorreo($_SESSION['Protectora']['Correo']);
   $reservas = obtenerReservasProtectora($protectora['UniqueID']);

   if ($_SERVER['REQUEST_METHOD'] === 'POST') 
   {
    eliminarReserva($_POST['id']);
    header("Location: protectoraReservas.php");
   }
  ?>

  <main class="items-center w-[90%] gap-7 relative pl-6 flex flex-col justify-center">
    <!-- Cabecera de la protectora -->
    <div class="flex flex-col items-center content-center w-full gap-5 p-4">
        <div class="rounded-full bg-amber-400 w-[200px] h-[200px] min-w-[200px] min-h-[200px] flex-shrink-0 overflow-hidden flex items-center justify-center">
        <?php 
        $carpeta =  "multimedia/protectoras/".$protectora['UniqueID']."/perfil/";
        $imagenPerfil = glob($carpeta . '*');
        ?>
            <img class="w-full h-full object-cover object-center" src="<?php echo $imagenPerfil[0]; ?>" alt="Imagen">
        </div>
        <h1 class="text-4xl lg:text-7xl"><?php echo $protectora['Nombre']; ?></h1>
    </div>

    <!-- Sección de gestión de publicaciones -->
    <div class="w-full p-4">
      <h2 class="text-4xl mb-6">Gestión de Publicaciones</h2>
      
      <!-- Tabs de navegación -->
      <div class="border-b border-gray-700 mb-6 text-center flex justify-center">
        <ul class="flex flex-wrap justify-center text-sm font-medium text-center">
          <li>
            <a href="protectoraInicio.php" class="inline-block hover:text-gray-300 hover:border-gray-300 p-4 rounded-t-lg ">Mis animales </a>  
          </li>
          <li>
            <a href="protectoraReservas.php" class="inline-block hover:text-gray-300 hover:border-gray-300 p-4 rounded-t-lg ">Mis reservas </a>  
          </li>
          <li>
            <a href="protectoraCrearReservas.php" class="inline-block hover:text-gray-300 hover:border-gray-300 p-4 rounded-t-lg ">Crear reservas</a>
          </li>
          <li>
            <a href="protectoraPublicaciones.php" class="inline-block hover:text-gray-300 hover:border-gray-300 p-4 rounded-t-lg ">Crear animales</a>
          </li>
        </ul>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 p-5 gap-4 ">
   
       
   <?php 
    foreach ($reservas as $reserva) 
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
          echo '<form action="" method="POST" class="flex flex-col text-center gap-3">';
          echo '<a class="w-full bg-[#54B5BE] hover:bg-[#54B5BE]/80 text-white font-bold py-2 px-4 rounded" href="protectoraGestionarReservas.php?id='.$reserva['UniqueID'].'">Gestionar reserva</a>';
          echo '<button class="w-full bg-[#DB3066] hover:bg-[#DB3066]/80 text-white font-bold py-2 px-4 rounded" type="submit">';
              echo 'Eliminar';
              echo '<input type="hidden" name="id" value="'.$reserva['UniqueID'].'">';
          echo '</button>';
          echo '</form>';
      echo '</div>';    
      echo '</div>';
    }
   ?>
</div>
  </main>
</body>
</html>
