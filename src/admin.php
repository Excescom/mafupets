<?php 
        require 'head.php';
        session_start();
?> 

 
  <?php 
	  require 'nav.php';
    require 'sesion.php';
    comprobar_admin()
    
  ?>
  <main class="items-center w-[80%] gap-7 relative top-[] pl-6 left-[80px] ">
    <div class="flex items-center content-center gap-5 p-4">
        
        <h1 class="text-7xl">Admin</h1>
    </div>
   
    <hr class="w-full p-4">
    <?php 
	    require 'navAdmin.php';
    ?>
  </main>
</body>
</html>
