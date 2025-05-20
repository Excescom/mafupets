<?php 
        require 'head.php';
        session_start();
?> 

  <?php 
	  require 'nav.php';
  ?>
  <main class="flex flex-col items-center w-full gap-4 relative top-[-20px]">

 <?php 

        echo "<div class='text-center text-red-500 flex flex-col items-center gap-2'>Debes iniciar sesión para acceder a esta página";
        echo "<a href='login.php' class='w-full bg-[#54B5BE] hover:bg-[#54B5BE]/80 text-white font-bold p-2 px-4 rounded'>Iniciar Sesión / Registrarse</a></div>";
 ?>   
  </main>
</body>
</html>
