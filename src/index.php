<?php 
 session_start();
        require 'head.php';
       
?> 

  <?php 
	  require 'nav.php';
    require 'bd.php';

    $contador = 0;

    if(isset($_GET['contador']))
    {
      $contador = $_GET['contador'];
    }
    
  ?>

  <?php 

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['especie'])) {
      $animales = filtroespecie($_POST['especie']);
      header("Location: index.php?contador=0&especie=" . $_POST['especie']);
      exit;
    }

    if(isset($_SESSION['Protectora'])){
      header("Location: protectoraInicio.php");
      exit;
    } 


    if(isset($_GET['contador']))
    {
      if(isset($_GET['especie']))
      {
        $especie = $_GET['especie'];
        $animales = obtenerAnimalesConfiltro( $_GET['contador'] , $especie);
      }
      else
      {
        $animales = obtenerAnimalesConfiltro($_GET['contador'] , "Todos");
      }
    }
    else
    {
    $animales = obtenerAnimalesConfiltro(0 , "Todos");
    }
    if(isset($_SESSION['Usuario'])){
    $animalesGustados = obtenerAnimalesFavoritos($_SESSION['Usuario']['UniqueID']);
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $animal = obtenerAnimalporID($_POST['id']);
      aniadirAnimalFavorito($_SESSION['Usuario']['UniqueID'], $animal['UniqueID']);
      header("Location: listaAnimales.php");
      exit;
    }
  ?>
 <div class="fixed w-full top-0 left-0 z-50">
  <div class="w-full flex justify-center pt-2">
    <form class="flex items-center gap-2 bg-black/70 p-2 rounded-lg" action="index.php" method="post">
      <label class="text-white" for="especie">Especie:</label>
      <input class="border border-gray-600 rounded p-1 bg-white/90" type="text" name="especie" id="especie">
      <button type="submit" class="bg-[#54B5BE] hover:bg-[#54B5BE]/80 text-white px-3 py-1 rounded">Filtrar</button>
    </form>
  </div>
</div>
  <main class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4 w-full relative pt-[30px] top-[30%] ">
    <!--contadores para paginar los animales-->
  <?php 
  $contadorexterno = $contador;
  $contadorinterno = 0; 
  ?>

  <?php if(!$animales){ 
    ?>
    <div class="w-full flex justify-center items-center col-span-3 text-center z-[100]">
    <p class="text-center text-[15px] sm-text-[30px] bg-black/50 p-2 rounded text-white">No se encontraron más animales</p>
    </div>
    <?php }?>
<?php foreach($animales as $animal){ 
  $contadorinterno++;
  $contadorexterno++;
  if($contadorinterno >= 10){
    break;
  }
  ?>
 <!-- Contenedor general de la multimedia -->
<div>
 <div class="flex flex-col justify-center  sm:h-[80vh] h-auto">
 <h2 class="text-2xl text-white text-center lg:text-4xl p-2 rounded-t-lg font-bold"><?php echo $animal['Nombre']; ?></h2>
  <div class="relative h-full rounded-lg">
    
    <div class="h-full w-full flex justify-center items-center p-2">
      <?php $multimedia = obtenerImagenesAnimalporID($animal['UniqueID']); ?>
      <?php $multi = $multimedia[random_int(0, count($multimedia) - 1)]; ?>
      <?php 
      // Obtener la extensión del archivo
        $extension = strtolower(pathinfo($multi['Enlace'], PATHINFO_EXTENSION));
        
        // Array con extensiones de imagen
        $imagenes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        // Array con extensiones de video
        $videos = ['mp4', 'webm', 'ogg','mov','mkv'];
      ?>
      <?php if(in_array($extension, $videos)){ ?>
      <video class=" w-full h-[80vh] rounded-lg z-10" src="<?php echo $multi['Enlace']; ?>" alt="" controls></video>
      <?php }else{ ?>
      <img class="h-[80vh] rounded-lg z-10" src="<?php echo $multi['Enlace']; ?>" alt="">
      <?php } ?>
    </div>
   
  </div >
</div>

<div class="w-full flex flex-col items-center justify-center pt-7 top-0">
    <p class="text-center text-[15px] sm-text-[30px] bottom-0 w-full  bg-black/50 text-white rounded-t-lg z-[20]">
          <?php echo $animal['Descripcion']; ?>
    </p>
</div>
<!--botonera-->
<div class="flex justify-center bg-black/50 rounded-b-lg">
<a href="crearTicketUsuarios.php?id=<?php echo $animal['UniqueID']; ?>" class="dark:text-white px-4">
        <span class="material-symbols-outlined text-white">error</span>
      </a>
      <a target="_blank" href="paginaComentarios.php?id=<?php echo $animal['UniqueID']; ?>" class="dark:text-white px-4 boton-comentario" data-animal-id="<?php echo $animal['UniqueID']; ?>">
        <span class="material-symbols-outlined text-white">mode_comment</span>
      </a>
      <?php
      $gustado = false;
      
      if(isset($_SESSION['Usuario'])){
      foreach($animalesGustados as $animalGustado){
        if($animalGustado['UniqueID'] == $animal['UniqueID']){
          echo '<a href="listaAnimales.php?id='.$animal['UniqueID'].'" class="text-white px-4">
          <span class="material-symbols-outlined text-white">task_alt</span>
        </a>';
        $gustado = true;
        }
      } 
      }
      ?>
      <?php if(!$gustado){ ?>
      <form action="" method="post">
      <button type="submit" name="gustar" class="text-white px-4 cursor-pointer">
        <span class="material-symbols-outlined text-white">add_circle</span>
      </button>
      <input type="hidden" name="id" value="<?php echo $animal['UniqueID']; ?>">
      </form>
      <?php } ?>
      <a href="IndexAnimales.php?id=<?php echo $animal['UniqueID']; ?>" class="text-white px-4">
        <span class="material-symbols-outlined text-white">account_circle</span>
      </a>
</div>
</div>

<?php } ?>

  </main>
  <div class="flex justify-center">
  <?php if($animales){ ?>
    <?php if(isset($_GET['especie'])): ?>
<a href="index.php?contador=<?php echo $contadorexterno-1; ?>&especie=<?php echo $especie; ?>" class="bg-[#EDB439] hover:bg-[#EDB439]/80 text-white font-bold p-2 px-4 rounded">Ver más</a>
<?php else: ?>
  <?php if($contadorinterno < 10){ ?>
    <a href="index.php?contador=0" class="bg-[#EDB439] hover:bg-[#EDB439]/80 text-white font-bold p-2 px-4 rounded">Volver al inicio</a>
<?php }
else{ ?>
<a href="index.php?contador=<?php echo $contadorexterno-1; ?>" class="bg-[#EDB439] hover:bg-[#EDB439]/80 text-white font-bold p-2 px-4 rounded">Ver más</a>

<?php } ?>
<?php endif; ?>
<?php }else{ ?>
<?php if(isset($_GET['especie'])): ?>
<a href="index.php?contador=0&especie=<?php echo $especie; ?>" class="bg-[#EDB439] hover:bg-[#EDB439]/80 text-white font-bold p-2 px-4 rounded">Volver al inicio</a>
<?php else: ?>
<a href="index.php?contador=0" class="bg-[#EDB439] hover:bg-[#EDB439]/80 text-white font-bold p-2 px-4 rounded">Volver al inicio</a>
<?php endif; ?>
<?php } ?>
</div>
</body>
</html>
