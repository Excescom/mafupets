<?php 
        require 'head.php';
        session_start();
?> 

<?php 
	require 'nav.php';
  require 'bd.php';
  require 'sesion.php';
    comprobar_admin();
    
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['borrar']))
    {
      $idAnimal = $_POST['id_animal'];
      $animal = obtenerAnimalporID($idAnimal);
      $rutaCarpeta = "multimedia/protectoras/".$animal['IDProtectora']."/".$animal['UniqueID']."/";
      if (eliminarDirectorio($rutaCarpeta)) {
          eliminarAnimal($idAnimal);
          header("Location: adminAnimales.php");
          exit;
      }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buscador']) && $_POST['buscador'] == 1) {
      $buscador = 1;
      $nombre = $_POST['filtro-nombre'];
      $protectora = $_POST['filtro-protectora'];
      $especie = $_POST['filtro-especie'];
      header("Location: adminAnimales.php?buscador=1&nombre=$nombre&protectora=$protectora&especie=$especie");
      exit;
    }
?>
   <main class="items-center w-full gap-7 relative ">
    <div class="flex items-center content-center gap-5 p-4  pt-[50px]">
        
        <h1 class="text-4xl">Admin Animales</h1>
    </div>
   
   <hr class="w-full p-4">
   <?php 
	    require 'navAdmin.php';
    ?>
   <hr>
    
    <!-- Formulario de filtros -->
    <form id="filtroForm" class="grid sm:grid-cols-3 gap-4 " method="post">
  
  <input name="filtro-nombre" type="text" placeholder="Nombre" id="filtro-nombre" class="border px-3 py-2 rounded-md text-sm" />
 
  <input name="filtro-protectora" type="text" placeholder="Protectora" id="filtro-protectora" class="border px-3 py-2 rounded-md text-sm" />
 
  <input name="filtro-especie" type="text" placeholder="Especie" id="filtro-especie" class="border px-3 py-2 rounded-md text-sm" />
  <button name="buscador" value="1" type="submit" class="bg-[#54B5BE] hover:bg-[#54B5BE]/80 p-2 rounded-lg">Filtrar</button>
  </form>

  
    
  
      <?php 
      if(isset($_GET['contador']))
      {
        $contadorexterno = $_GET['contador'];
      }
      else
      {
        $contadorexterno = 0;
      }
              if (isset($_GET['buscador']) && $_GET['buscador'] == 1)
              {
                $nombre = $_GET['nombre'];
                $protectora = $_GET['protectora'];
                $especie = $_GET['especie'];
                
                $animales = filtroAnimalesAdmin($nombre, $protectora, $especie,$contadorexterno);
              }
              else
              {
                $animales = obtenerAnimalespaginados($contadorexterno);
              }
              if(isset($_GET['contador']))
              {
                $contadorexterno = $_GET['contador'];
              }
              else
              {
                $contadorexterno = 0;
              }
              $contadorinterno = 0; 
              echo "<div class='px-4 py-2 border w-full grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3  gap-2'>";
              foreach ($animales as $animal) 
              {
                $contadorinterno++;
                $contadorexterno++;
                if($contadorinterno >= 10)
                {
                  break;
                }
                  echo "<div class='grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-2 bg-black/50 text-white text-[20px] rounded-lg'>";
                  $imagenPerfil = selecionarimagenperfilanimal($animal['UniqueID']);
                 echo "<div class='col-span-1 lg:col-span-2 xl:col-span-3 flex justify-center items-center pt-2 rounded-lg'>";
                 echo "<img class='w-[50%] h-[300px] object-cover object-center rounded-lg pt-2' src='" . htmlspecialchars($imagenPerfil['Enlace']) . "' alt='Imagen del animal'>";
                 echo "</div>";
                 echo "<div class='col-span-1 lg:col-span-2 xl:col-span-1 flex items-center'>";
                  echo "<p class='px-4 py-2 font-bold text-pink-200'>Nombre: </p>";
                  echo "<p>".htmlspecialchars($animal['Nombre']) . "</p>";
                  echo "</div>";
                  $protectora = obtenerProtectoraID($animal['IDProtectora']);
                  echo "<div class='col-span-1 lg:col-span-2 xl:col-span-1 flex items-center'>";
                  echo "<p class='px-4 py-2 font-bold text-pink-200'>Protectora: </p>";
                  echo "<p>". htmlspecialchars($protectora['Nombre']) . "</p>";
                  echo "</div>";
                  echo "<div class='col-span-1 lg:col-span-2 xl:col-span-1 flex items-center'>";
                  echo "<p class='px-4 py-2 font-bold text-pink-200'>Especie: </p>";
                  echo "<p>" . htmlspecialchars($animal['Especie']) . "</p>";
                  echo "</div>";
                  echo "<div class='col-span-1 lg:col-span-2 xl:col-span-1 flex items-center'>";
                  echo "<p class='px-4 py-2 font-bold text-pink-200'>Peso: </p>";
                  echo "<p>" . htmlspecialchars($animal['Peso']) . "</p>";
                  echo "</div>";
                  echo "<div class='col-span-1 lg:col-span-2 xl:col-span-1 flex items-center'>";
                  echo "<p class='px-4 py-2 font-bold text-pink-200'>Discapacidad: </p>";
                  echo "<p>" . htmlspecialchars($animal['Discapacidad'] == 1 ? "Sí" : "No") . "</p>";
                  echo "</div>";
                  echo "<div class='col-span-1 lg:col-span-2 xl:col-span-3 flex flex-col '>";
                  echo "<p class=' font-bold px-4 col-span-3 text-pink-200'>Descripcion: </p>";
                  echo "<p class='col-span-3 pl-4'>" . htmlspecialchars($animal['Descripcion']) . "</p>";
                  echo "</div>";
                  echo "<div class='col-span-1 lg:col-span-2 xl:col-span-3'>";
                  echo "<form action='' method='post' >";
                  echo "<input type='hidden' name='id_animal' value='" . $animal['UniqueID'] . "'>";
                  echo "<input type='hidden' name='borrar' value='1'>";
                  echo "<div class='flex gap-2 p-4'>";
                  echo "<button type='submit' class='p-2 bg-[#DB3066] hover:bg-[#DB3066]/80 text-white rounded-lg'><span class='material-symbols-outlined scale-150'>
                delete
                </span></button>";
                  echo "<a href='modificarAnimal.php?id=" . $animal['UniqueID'] . "' class='p-2 bg-[#54B5BE] hover:bg-[#54B5BE]/80 text-white rounded-lg'><span class='material-symbols-outlined scale-150'>
                edit
                </span></a>";
                  echo "</div>";
                  echo "</form>";
                  echo "</div>";
                
                  echo "</div>";
                
              }

              if($contadorinterno==0)
              {
                echo "<div class='flex justify-center w-full col-span-3'>";
                echo "No hay más animales";
                echo "<a class='bg-[#EDB439] hover:bg-[#EDB439]/80 text-white font-bold p-2 px-4 rounded' href='adminAnimales.php?contador=0'>volver</a>";
                echo "</div>";
              }
              else
              {
                echo "</div>";
                echo "<div class='flex justify-center w-full'>";
                if($contadorinterno==10)
                {
                echo "<a class='bg-[#EDB439] hover:bg-[#EDB439]/80 text-white font-bold p-2 px-4 rounded' href='adminAnimales.php?contador=" . ($contadorexterno - 1) . "'>Ver más</a>";
                }
                else
                {
                  echo "<a class='bg-[#EDB439] hover:bg-[#EDB439]/80 text-white font-bold p-2 px-4 rounded' href='adminAnimales.php?contador=" . ($contadorexterno - $contadorexterno) . "'>Volver</a>";
                }
                echo "</div>";
              }
              
          ?>
  </main>
</body>
</html>
