<?php 
        require 'head.php';
        require 'bd.php';
        session_start();
        $usuario = obtenerusuarioPorCorreo($_SESSION['Usuario']['Correo']);
        $animales = obtenerAnimalesFavoritos($usuario['UniqueID']);
        if($animales == "error"){
            $animales = [];
        }
        
?> 
  <?php 
    require 'nav.php';
    if(isset($_SESSION['Protectora'])){
      header("Location: protectoraInicio.php");
      exit;
    }
    if(!isset($_SESSION['Usuario']) && !isset($_SESSION['Protectora'])){
      header("Location: debesInicarSesion.php");
      exit;
    }
    
    if(isset($_POST['eliminar'])){
      eliminarAnimalFavorito($usuario['UniqueID'], $_POST['id']);
      header("Location: listaAnimales.php");
      exit;
    }
  ?>
  <main class="items-center w-[100%] gap-7 relative top-[] p-7 flex flex-col justify-center ">
   <h1 class="text-4xl text-center  p-5">LISTA DE ANIMALES GUSTADOS</h1>
   <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 p-5 gap-4 ">
   
   <?php foreach($animales as $animal){
    
   ?>
   <?php 
        $multimedia = obtenerImagenesAnimalporID($animal['UniqueID']); 
    ?>
        <div class="text-center flex flex-col  justify-center items-center border border-[#EDB439]">
            <a class="rounded-lg object-cover w-[80%]" href="IndexAnimales.php?id=<?php echo $animal['UniqueID']; ?>">
                <?php 
                if($multimedia){ ?>
            <img class="h-full w-full object-cover" src="<?php echo $multimedia[0]['Enlace']; ?>" alt="<?php echo $animal['Nombre']; ?>">
            <?php } ?></a>
            <p class="mt-2 text-white"><?php echo $animal['Nombre']; ?></p>

            <form action="" method="post">
            <button type="submit" name="eliminar" class="w-full bg-[#DB3066] hover:bg-[#DB3066]/80 text-white font-bold py-2 px-4 rounded">Eliminar</button>
            <input type="hidden" name="id" value="<?php echo $animal['UniqueID']; ?>">
            </form>
        </div>
    
    <?php } ?>

    
    </div>
    <?php if(count($animales) == 0){ ?>
      <div class="flex justify-center items-center text-center w-full ">
    <p class="text-4xl border border-[#DB3066] p-5 ">No tienes animales favoritos</p>
    </div>
    <?php } ?>
  </main>
</body>
</html>
