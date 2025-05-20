<?php 
        require 'head.php';
        require 'sesion.php';
        require 'bd.php';
        comprobar_sesion_protectora();
?> 

<?php 
    require 'nav.php';

    $bd = conection();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        $nombre = $_POST['nombre'] ?? '';
        $especie = $_POST['especie'] ?? '';
        $peso = $_POST['peso'] ?? '';
        $discapacidad = isset($_POST['discapacidad']) ? 1 : 0;
        $descripcion = $_POST['descripcion'] ?? '';
        $imagen = $_FILES['imagen']['name'] ?? '';
        $protectora = obtenerProtectoraCorreo($_SESSION['Protectora']['Correo']);
        
        $stmt = $bd->prepare("INSERT INTO animales (Nombre, Especie, Peso, Discapacidad, Descripcion, IDProtectora) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $especie, $peso, $discapacidad, $descripcion, $protectora['UniqueID']]);
        $animal = $bd->lastInsertId();

        // Procesar la imagen
        $ruta_imagen = '';
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            // Definir la carpeta donde se guardarán las imágenes
            $carpeta_destino = "multimedia/protectoras/" . $protectora['UniqueID'] . "/" . $animal . "/perfil";
            
            // Crear la carpeta si no existe
            if (!file_exists($carpeta_destino)) {
                mkdir($carpeta_destino, 0777, true);
            }
            
            // Generar un nombre único para el archivo
            $nombre_archivo = time() . '_' . basename($imagen);
            $ruta_completa = $carpeta_destino . '/' . $nombre_archivo;
            
            // Mover el archivo cargado a la carpeta de destino
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_completa)) {
                $ruta_imagen = "multimedia/protectoras/" . $protectora['UniqueID'] . "/" . $animal . "/perfil/" . $nombre_archivo;
            } 
        }
        $stmtMultimedia = $bd->prepare("INSERT INTO multimedias (IDAnimal, Enlace) VALUES (?, ?)");
        $stmtMultimedia->execute([$animal, $ruta_imagen]);

        header("Location: protectoraInicio.php");
        exit;
    }

    
?>

  <main class="items-center w-[90%] gap-7 relative pl-6 left-[80px] flex flex-col justify-center">
    <!-- Cabecera de la protectora -->
    <div class="flex flex-col items-center content-center w-full gap-5 p-4">
        <div class="rounded-full bg-amber-400 w-[200px] h-[200px] min-w-[200px] min-h-[200px] flex-shrink-0 overflow-hidden flex items-center justify-center">
        <?php 
        $protectora = obtenerProtectoraCorreo($_SESSION['Protectora']['Correo']);
        $carpeta =  "multimedia/protectoras/".$protectora['UniqueID']."/perfil/";
        $imagenPerfil = glob($carpeta . '*');
        ?>
            <img class="w-full h-full object-cover object-center" src="<?php echo $imagenPerfil[0]; ?>" alt="Imagen">
      </div>
        <h1 class="text-4xl lg:text-7xl"><?php echo $_SESSION['Protectora']['Nombre']; ?></h1>
    </div>
      
      <!-- Tabs de navegación -->
      <div class="w-full p-4">
      <h2 class="text-4xl mb-6">Gestión de Publicaciones</h2>
      
      <!-- Tabs de navegación -->
      <div class="border-b border-gray-700 mb-6 text-center flex justify-center">
        <ul class="flex flex-wrap justify-center text-sm font-medium text-center">
          <li>
            <a href="protectoraInicio.php" class="inline-block hover:text-gray-300 hover:border-gray-300 p-4 rounded-t-lg ">Mis animales </a>  
          </li>
          <li>
            <a href="protectoraReservas.php" class="inline-block hover:text-gray-300 hover:border-gray-300 p-4 rounded-t-lg ">Mis reservas </a>  
          </li>
          <li>
            <a href="protectoraCrearReservas.php" class="inline-block hover:text-gray-300 hover:border-gray-300 p-4 rounded-t-lg ">Crear reservas</a>
          </li>
          <li>
            <a href="protectoraPublicaciones.php" class="inline-block hover:text-gray-300 hover:border-gray-300 p-4 rounded-t-lg ">Crear animales</a>
          </li>
        </ul>
      </div>

      <form action="" class="max-w-sm mx-auto bg-gray-800 p-6 rounded-lg shadow-md w-full gap-3 flex flex-col" method="POST" enctype="multipart/form-data">
        <label class="block text-gray-300 text-sm font-semibold mb-2" for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" required
            class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        
        <label class="block text-gray-300 text-sm font-semibold mb-2" for="especie">Especie</label>
        <input type="text" id="especie" name="especie" required
            class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        
            <label class="block text-gray-300 text-sm font-semibold mb-2" for="peso">Peso en KG</label>
        <input type="number" id="peso" name="peso" required
            class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        
        <div class="flex items-center gap-2 mb-4">
            <label class="block text-gray-300 text-sm font-semibold" for="discapacidad">Discapacidad</label>
            <input type="checkbox" id="discapacidad" name="discapacidad">
        </div>
        
            <label class="block text-gray-300 text-sm font-semibold mb-2" for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" required
            class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
        
            <label class="block text-gray-300 text-sm font-semibold mb-2" for="imagen">Imagen Perfil</label>
        <input type="file" name="imagen" id="imagen" required
            class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">

        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            Crear animal
        </button>
    </form>
  </main>
</body>
</html>
