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
    if(!isset($_SESSION['Usuario']) && !isset($_SESSION['Protectora'])){
      header("Location: login.php");
      exit;
    } 
?>
  <main class="flex flex-col items-center w-full gap-4 relative pt-[30px] ">
    <div class="flex flex-col items-center content-center w-full gap-5 p-4">
        <h1 class="lg:text-7xl text-4xl text-center">Confirmación de cierre de sesión</h1>
    </div>
    <p>¿Está seguro de que desea cerrar sesión?</p>
    <div class="flex justify-center items-center content-center w-full gap-5 p-4 text-center"> 
        <a href="login.php" class="bg-[#54B5BE] hover:bg-[#54B5BE]/80 text-white font-bold p-2 px-4 rounded">Sí</a>
        <a href="index.php" class="bg-[#DB3066] hover:bg-[#DB3066]/80 text-white font-bold p-2 px-4 rounded">No</a>
    </div>
  </main>
</body>
</html>
