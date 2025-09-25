<?php 
        require 'head.php';
        require 'sesion.php';
        require 'bd.php';
        comprobar_sesion_protectora();
        
?> 

  <?php 
	  require 'nav.php';

   $protectora = obtenerProtectoraCorreo($_SESSION['Protectora']['Correo']);
   $animales = obtenerAnimalesProtectora($protectora['UniqueID']);

   if (isset($_POST['eliminar_animal']) && isset($_POST['id_animal'])) {
    $idAnimal = $_POST['id_animal'];
  
  $rutaCarpeta = "multimedia/protectoras/".$protectora['UniqueID']."/".$idAnimal."/";
  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    if (eliminarDirectorio($rutaCarpeta)) {
        eliminarAnimal($idAnimal);
        header("Location: protectoraInicio.php");
        exit;
    }
  }
    
  }
  ?>

  <main class="items-center w-[90%] gap-7 relative pl-6 flex flex-col justify-center">
    <!-- Cabecera de la protectora -->
    <div class="flex flex-col items-center content-center w-full gap-5 p-4">
        <div class="rounded-full w-[200px] h-[200px] min-w-[200px] min-h-[200px] flex-shrink-0 overflow-hidden flex items-center justify-center">
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
          <li>
            <a href="crearTicketProtectora.php" class="inline-block hover:text-gray-300 hover:border-gray-300 p-4 rounded-t-lg ">Crear Tickets</a>
          </li>
        </ul>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 p-5 gap-4 ">
   
      <?php $animales = array_reverse($animales); ?> 
       
   <?php foreach($animales as $animal){
    $carpetaImagenAnimal = "multimedia/protectoras/".$protectora['UniqueID']."/".$animal['UniqueID']."/perfil/";
    $imagenanimal = selecionarimagenperfilanimal($animal['UniqueID']);
   echo '<div class=" w-full flex flex-col justify-end items-center flex-shrink-0">
           <a href="IndexAnimales.php?id='.$animal['UniqueID'].'"><img class="w-full h-[400px] object-cover rounded-lg" src="'.$imagenanimal['Enlace'].'"></a>
       <p class="mt-2 text-black dark:text-white">'.$animal['Nombre'].'</p>
       <form method="POST">
       <input type="hidden" name="id_animal" value="'.$animal['UniqueID'].'">
       <button type="submit" name="eliminar_animal" class="bg-[#DB3066] hover:bg-[#DB3066]/80 text-white py-1 px-3 rounded">
          Eliminar
       </button>
       </form>
       <a class="bg-[#EDB439] hover:bg-[#EDB439]/80 text-white py-1 px-3 rounded" href="modificarAnimal.php?id='.$animal['UniqueID'].'">Modificar</a>
   </div>';
   
   }?>
</div>
  </main>

</body>
</html>
