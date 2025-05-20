<?php 
        require 'head.php';
        session_start();
?> 
  <?php 
    require 'nav.php';
    if(!isset($_SESSION['Usuario']) && !isset($_SESSION['Protectora'])){
      header("Location: debesInicarSesion.php");
      exit;
    } 
  ?>
  <main class="items-center w-[100%] gap-7 relative top-[] p-7 flex flex-col justify-center ">
   <h1 class="text-4xl text-center  p-5">LISTA DE ANIMALES GUSTADOS</h1>
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
