
<?php 

    function publicacion($idAnimal)
    {

?>

<!-- Contenedor general del carrusel -->
<div class="flex justify-center w-full p-2">
  <div class="sm:w-[464.7px] relative h-full rounded-lg overflow-hidden">

    <!-- Contenedor de las imágenes -->
    <div id="slider" class="flex  transition-transform duration-500 ease-in-out h-full w-ful ">
      <div class=" w-full flex justify-center items-center flex-shrink-0">
        <img src="multimedia/imagenLado.jpg" class="w-full  object-cover rounded-lg" alt="Imagen 1">
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
<?php 
    }
?>


