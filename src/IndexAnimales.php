<?php 
    session_start();
    require 'head.php';
    require 'bd.php';
?> 

  <?php 
	require 'nav.php';
    
    // Verificar si se ha proporcionado un ID de animal
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id_animal = $_GET['id'];
        $animal = obtenerAnimalporID($id_animal);
        // Obtener información del animal
        
        
        //si se pone una id de un animal que no existe sale esto 
        if (!$animal) {
            echo '<div class="text-center p-8">
                    <h2 class="text-2xl text-red-500">Animal no encontrado</h2>
                    <p class="mt-4">El animal que estás buscando no existe o ha sido eliminado.</p>
                    <a href="index.php?contador=0" class="mt-4 inline-block bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-4 rounded">
                        Volver al inicio
                    </a>
                  </div>';
            exit;
        }
        
        // Obtener la imagen principal del animal
        $multimedia = obtenerImagenesAnimalporID($id_animal);
        $multimedia =  array_reverse($multimedia);
        if($multimedia)
        {
            $imagenPerfil = selecionarimagenperfilanimal($id_animal);
        }
        
        // Obtener todas las imágenes adicionales del animal
    } else {
        // Si no se proporciona un ID válido, redirigir a la página principal
        echo '<div class="text-center p-8">
                <h2 class="text-2xl text-red-500">Animal no especificado</h2>
                <p class="mt-4">No se ha especificado qué animal quieres ver.</p>
                <a href="index.php?contador=0" class="mt-4 inline-block bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-4 rounded">
                    Volver al inicio
                </a>
              </div>';
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['añadirImagen']))
    {
         // Procesar la multimedia
         $rutamultimedia = '';
         if (isset($_FILES['multimedia']) && $_FILES['multimedia']['error'] == 0) {
             // Definir la carpeta donde se guardarán las imágenes
             $carpeta_destino = "multimedia/protectoras/" . $animal['IDProtectora'] . "/" . $animal['UniqueID'] . "/";
             
             // Crear la carpeta si no existe
             if (!file_exists($carpeta_destino)) {
                 mkdir($carpeta_destino, 0777, true);
             }
             
             // Generar un nombre único para el archivo
             $nombre_archivo = time() . '_' . basename($_FILES['multimedia']['name']);
             $ruta_completa = $carpeta_destino . '/' . $nombre_archivo;
             
             // Mover el archivo cargado a la carpeta de destino
             if (move_uploaded_file($_FILES['multimedia']['tmp_name'], $ruta_completa)) {
                 $rutamultimedia = "multimedia/protectoras/" . $animal['IDProtectora'] . "/" . $animal['UniqueID'] . "/" . $nombre_archivo;
             } 
         }
         aniadirmultimedia($rutamultimedia,$animal['UniqueID']);
 
         header("Location: IndexAnimales.php?id=".$animal['UniqueID']);
         exit;
        
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminarMultimedia']))
    {
        // eliminar archivo

        unlink($_POST['enlace']);

        eliminarMultimedia($_POST['enlace']);

        header("Location: IndexAnimales.php?id=".$animal['UniqueID']);
        exit;
        
    }

  ?>
  <main class="flex flex-col items-center w-full gap-4 relative pt-[30px]">
  <!-- Cabecera de la protectora -->
  <div class="flex flex-col items-center content-center w-full gap-5 p-4">
        <div class="rounded-full bg-amber-400 w-[200px] h-[200px] min-w-[200px] min-h-[200px] flex-shrink-0 overflow-hidden flex items-center justify-center">
            <img class="w-full h-full object-cover object-center" src="<?php echo $imagenPerfil['Enlace']; ?>" alt="Imagen">
        </div>
        <h1 class="text-4xl text-center lg:text-7xl"><?php echo $animal['Nombre']; ?></h1>
    </div>
    <div class="p-4 sm:w-[50%] w-[90%] flex flex-col gap-2 border border-gray-600">
       <p>especie: <?php echo $animal['Especie']; ?></p>
       <p>peso: <?php echo $animal['Peso']; ?>KG</p>
       <p>discapacidad: <?php if ($animal['Discapacidad'] == 1) { ?>Sí<?php }else{ ?>No<?php } ?></p>
       <p>descripcion: <?php echo $animal['Descripcion']; ?></p>
       <p><a class="bg-[#EDB439] hover:bg-[#EDB439]/80 text-white font-bold py-2 px-4 rounded" href="indexprotectora.php?id=<?php echo $animal['IDProtectora']; ?>">PROTECTORA</a></p>
    </div>

    <?php if(isset($_SESSION['Protectora'])): ?>
        <div>
            <p class="text-red-500" id="alerta"></p>
        </div>
    <div class="p-4 flex justify-center">
        <form action="" method="post" enctype="multipart/form-data" class="flex flex-col gap-2 w-[50%] text-center" onsubmit="return validartamaniomultimedia()">
           <label for="multimedia">Subir multimedia</label>
            <input type="file" name="multimedia" id="multimedia" required class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" name="añadirImagen" class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-4 rounded">Añadir multimedia</button>
        </form>
        
    </div>
    <?php endif; ?>
<hr class="w-full">
    <!-- Sección de gestión de publicaciones -->
    <div class="w-full p-4">
      <h2 class="text-4xl mb-6">Multimedia</h2>
      
      <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 p-5 gap-4 ">
   
       
   <?php 
   $multimedia = obtenerImagenesAnimalporID($animal['UniqueID']);
   $multimedia =  array_reverse($multimedia);
   if ($multimedia)
   {
        foreach($multimedia as $multi)
        {
            echo '<div class="text-center flex flex-col justify-center items-center pb-4">';
            
            // Obtener la extensión del archivo
            $extension = strtolower(pathinfo($multi['Enlace'], PATHINFO_EXTENSION));
            
            // Array con extensiones de imagen
            $imagenes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            // Array con extensiones de video
            $videos = ['mp4', 'webm', 'ogg','mov','mkv'];
            
            if (in_array($extension, $imagenes)) {
                echo '<div class=" flex justify-center items-center flex-shrink-0 border border-gray-600 rounded h-full  ">
                <img class=" w-full object-cover rounded-lg" src="'.$multi['Enlace'].'">
        </div>';
            } elseif (in_array($extension, $videos)) {
                echo '<div class=" flex justify-center items-center flex-shrink-0 border border-gray-600 rounded h-full">
                <video class=" object-cover rounded-lg w-full" src="'.$multi['Enlace'].'" controls></video>
                </div>';
            } 
            if(isset($_SESSION['Protectora']))
            {
                if( $multi['Enlace'] != $imagenPerfil['Enlace'])
                {
                    echo '<form action="" method="POST">
                    <input type="hidden" name="enlace" value="'.$multi['Enlace'].'">
                    <button type="submit" name="eliminarMultimedia" class="bg-[#DB3066] hover:bg-[#DB3066]/80 text-white py-1 px-3 rounded">
                    Eliminar
                    </button>
                    </form>';
                }
                else
                {
                    echo '<p class="text-red-500">No puedes eliminar la imagen perfil</p>';
                }
            }
            echo '</div>';
        }
    }
    else
    {
    echo '<div class="text-center flex flex-col justify-center items-center">
    <p>No hay imágenes</p>
   </div>';
   }?>
</div>
  </main>

   </div>
</div>
  </main>
  <script src="sriptsJS/validarImagenes.js"></script>
</body>
</html>
