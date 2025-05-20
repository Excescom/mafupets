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
   
       
   <?php foreach($animales as $animal){
    $carpetaImagenAnimal = "multimedia/protectoras/".$protectora['UniqueID']."/".$animal['UniqueID']."/perfil/";
    $imagenanimal = glob($carpetaImagenAnimal."*");
    echo '<div class="text-center flex flex-col justify-center items-center">
       <a class="rounded-lg object-cover w-[80%]" href="IndexAnimales.php?id='.$animal['UniqueID'].'"><img class="" src="'.$imagenanimal[0].'" alt="animal"></a>
       <p class="mt-2 text-white">'.$animal['Nombre'].'</p>
   </div>';
   }?>
</div>
  </main>
</body>
</html>
