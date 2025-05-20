<?php 
        require 'head.php';
        session_start();
?> 

  <?php 
    require 'plantillaPublicaciones.php';
	  require 'nav.php';
    require 'bd.php';
    
  ?>

  <?php 
    if(isset($_SESSION['Protectora'])){
      header("Location: protectoraInicio.php");
      exit;
    } 
  ?>
  <main class="flex flex-col items-center w-full gap-4 relative pt-[30px] ">
<!-- Contenedor general del carrusel -->
<div class="flex justify-center w-full p-2">
  <div class="sm:w-[464.7px] relative h-full rounded-lg overflow-hidden">

    <!-- Contenedor de las imágenes -->
    <div id="slider" class="flex  transition-transform duration-500 ease-in-out h-full w-ful ">
      <div class=" w-full flex justify-center items-center flex-shrink-0">
        <img src="multimedia/protectoras/1/perfil/perfil.webp" class="w-full  object-cover rounded-lg" alt="Imagen 1">
      </div>
      <div class=" w-full flex justify-center items-center flex-shrink-0">
      <video class="w-full  rounded-lg" src="multimedia/videoPrueba.mp4" controls></video>
      </div>
      <div class=" w-full flex justify-center items-center flex-shrink-0">
        <video class="w-full  rounded-lg" src="../clip_1.742.734.636.943.mp4" controls></video>
      </div>
    </div>

    <!-- Botones de navegación -->
    <button id="prev" class="z-20 absolute top-1/2 left-2 transform -translate-y-1/2 bg-black/50 text-white p-2 rounded-full shadow-lg">
      <span class="material-symbols-outlined">
        arrow_back_ios
      </span>
    </button>
    <button id="next" class="z-20 absolute top-1/2 right-2 transform -translate-y-1/2 bg-black/50 text-white p-2 rounded-full shadow-lg">
      <span class="material-symbols-outlined">
        arrow_forward_ios
      </span>
    </button>

    <!-- Texto descriptivo -->
    <p class="absolute bottom-0 w-full bg-black/50 text-white p-2 rounded-b-lg z-10"> 
      <?php 
        $des = obtenerDescAnimal(1);
        echo $des;
        
      ?>
    </p>

    <!-- Botonera lateral -->
    <div class="absolute right-0 translate-x-3 bottom-[10%] flex flex-col-reverse items-end gap-4 p-2 z-20">
      <button class="text-white px-4">
        <span class="material-symbols-outlined">error</span>
      </button>
      <button class="text-white px-4">
        <span class="material-symbols-outlined">mode_comment</span>
      </button>
      <button class="text-white px-4">
        <span class="material-symbols-outlined">add_circle</span>
      </button>
      <button class="text-white px-4">
        <span class="material-symbols-outlined">account_circle</span>
      </button>
    </div>

  </div>
</div>

 


 <!-- Contenedor general del video -->
 <div class="flex justify-center sm:h-[88vh] p-2  h-[60vh]">
  <div class="relative h-full rounded-lg">
    <div class="h-full w-full flex justify-center items-center">
      <img class="h-full rounded-lg z-10" src="wp3307160.webp" alt="">
    </div>
    
    <p class=" text-[15px] sm-text-[30px] absolute bottom-0 w-full bg-black/50 text-white p-2 rounded-b-lg z-20">
      Texto descriptivo de los animales sacado de la base de datos
    </p>

    <!-- Botonera pegada a la imagen, no al viewport -->
    <div class="absolute right-0 translate-x-3 bottom-[10%] flex flex-col-reverse items-end gap-4 p-2 z-20">
      <button class="dark:text-white px-4">
        <span class="material-symbols-outlined">error</span>
      </button>
      <button class="dark:text-white px-4">
        <span class="material-symbols-outlined">mode_comment</span>
      </button>
      <button class="dark:text-white px-4">
        <span class="material-symbols-outlined">add_circle</span>
      </button>
      <button class="dark:text-white px-4">
        <span class="material-symbols-outlined">account_circle</span>
      </button>
    </div>
  </div>
</div>

 <!-- Contenedor general del video -->
 <div class="flex justify-center sm:h-[88vh] p-2  h-[60vh]">
  <div class="relative h-full rounded-lg">
    <div class="h-full w-full flex justify-center items-center">
      <video class="w-[324.97px] sm:w-[408.7px] aspect-video" src="../clip_1.742.734.636.943.mp4" controls></video>
    </div>
    
    <p class=" text-[15px] sm-text-[30px] absolute bottom-0 w-full bg-black/50 text-white p-2 rounded-b-lg">
      Texto descriptivo de los animales sacado de la base de datos
    </p>

    <!-- Botonera pegada a la imagen, no al viewport -->
    <div class="absolute right-0  translate-x-3 bottom-[10%] flex flex-col-reverse items-end gap-4 p-2">
      <button class="dark:text-white px-4">
        <span class="material-symbols-outlined">error</span>
      </button>
      <button class="dark:text-white px-4">
        <span class="material-symbols-outlined">mode_comment</span>
      </button>
      <button class="dark:text-white px-4">
        <span class="material-symbols-outlined">add_circle</span>
      </button>
      <button class="dark:text-white px-4">
        <span class="material-symbols-outlined">account_circle</span>
      </button>
    </div>
  </div>
</div>
  </main>
</body>
<script src="sriptsJS/carrousel.js"></script>
</html>
