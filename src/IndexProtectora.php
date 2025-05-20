<?php 
        require 'head.php';
        require 'bd.php';
        session_start();
       
?> 

  <?php 
	  require 'nav.php';
  ?>
  <main class="items-center w-[100%] gap-7 relative top-[] pl-6 flex flex-col justify-center ">
    <div class="flex flex-col items-center content-center w-full gap-5 p-4">
        <div class="rounded-full bg-amber-400 w-[200px] h-[200px] min-w-[200px] min-h-[200px] flex-shrink-0 overflow-hidden flex items-center justify-center">
            <img class="w-full h-full object-cover object-center" src="multimedia/imagenporDefecto/perfil.webp" alt="Imagen">
        </div>
        <h1 class="text-4xl lg:text-7xl">NOMBRE DE LA PROTECTORA</h1>
    </div>
    <div class="p-4 text-left w-full">
        <h1 class="text-2xl font-bold">Información Protectora:</h1>
        <div>
            <p>Nombre: </p>
            <p>Correo: </p>
            <p>Informacion: </p>
        </div>
    </div>
    
    <div class="w-full flex flex-col items-center justify-center">
        <!-- Título para la sección de eventos -->
    <h2 class="text-2xl font-bold px-4 md:px-8 pt-6">Próximos Eventos</h2>
    <hr class="w-[80%]">
    <!-- Contenedor de tarjetas de eventos -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 w-full px-4 md:px-8 py-6">
        <!-- Tarjeta de evento 1 -->
        <?php 
              $reservas = obtenerReservas();

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
                    echo '<button class="w-full bg-[#54B5BE] hover:bg-[#54B5BE]/80 text-white font-bold py-2 px-4 rounded">';
                        echo 'Reservar';
                    echo '</button>';
                echo '</div>';
          echo '</div>';
              }
          ?>
    </div>
    
    
  </div>
   <hr class="w-full ">
   <h1 class="text-4xl w-full p-4 ">ANIMALES:</h1>
   <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 p-5 gap-4 ">
   
        <div class="text-center flex flex-col justify-center items-center">
            <a class="rounded-lg object-cover w-[80%]" href="IndexAnimales.php"><img class="" src="wp3307160.webp" alt="Perrete"></a>
            <p class="mt-2 text-white">nombre animal</p>
        </div>
    
        <div class="text-center flex flex-col justify-center items-center">
            <a class="rounded-lg object-cover w-[80%]" href="IndexAnimales.php"><img class="" src="wp3307160.webp" alt="Perrete"></a>
            <p class="mt-2 text-white">nombre animal</p>
        </div>

        <div class="text-center flex flex-col justify-center items-center">
            <a class="rounded-lg object-cover w-[80%]" href="IndexAnimales.php"><img class="" src="wp3307160.webp" alt="Perrete"></a>
            <p class="mt-2 text-white">nombre animal</p>
        </div>

        <div class="text-center flex flex-col justify-center items-center">
            <a class="rounded-lg object-cover w-[80%]" href="IndexAnimales.php"><img class="" src="wp3307160.webp" alt="Perrete"></a>
            <p class="mt-2 text-white">nombre animal</p>
        </div>

        <div class="text-center flex flex-col justify-center items-center">
            <a class="rounded-lg object-cover w-[80%]" href="IndexAnimales.php"><img class="" src="wp3307160.webp" alt="Perrete"></a>
            <p class="mt-2 text-white">nombre animal</p>
        </div>
        <div class="text-center flex flex-col justify-center items-center">
            <a class="rounded-lg object-cover w-[80%]" href="IndexAnimales.php"><img class="" src="wp3307160.webp" alt="Perrete"></a>
            <p class="mt-2 text-white">nombre animal</p>
        </div>
        <div class="text-center flex flex-col justify-center items-center">
            <a class="rounded-lg object-cover w-[80%]" href="IndexAnimales.php"><img class="" src="wp3307160.webp" alt="Perrete"></a>
            <p class="mt-2 text-white">nombre animal</p>
        </div>
        <div class="text-center flex flex-col justify-center items-center">
            <a class="rounded-lg object-cover w-[80%]" href="IndexAnimales.php"><img class="" src="wp3307160.webp" alt="Perrete"></a>
            <p class="mt-2 text-white">nombre animal</p>
        </div>
    </div>
  </main>
</body>
</html>
