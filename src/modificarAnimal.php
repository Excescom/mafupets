<?php 
    session_start();
    require 'head.php';
    require 'bd.php';
    
    $bd = conection();
?> 

  <?php 
    require 'nav.php';
    $idAnimal = $_GET['id'];
    $animal = obtenerAnimal($idAnimal);
    $imagenPerfil = selecionarimagenperfilanimal($idAnimal);
    
    if(!isset($contador))
    {
        $contador = 0;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nuevaImagenPerfil = $_FILES['imagen'];
        $nombre = $_POST['nombre'];
        $especie = $_POST['especie'];
        $peso = $_POST['peso'];
        $discapacidad = isset($_POST['discapacidad']) ? 1 : 0;
        $descripcion = $_POST['descripcion'];
        actualizarAnimal($animal['UniqueID'],$nombre,$especie,$peso,$discapacidad,$descripcion);
        if($nuevaImagenPerfil['name'] != '')
        {
        // Procesar la imagen
        $ruta_imagen = '';
        
            // Definir la carpeta donde se guardarán las imágenes
            $carpeta_destino = "multimedia/protectoras/" . $animal['IDProtectora'] . "/" . $animal['UniqueID'] . "/perfil";
            
            // Crear la carpeta si no existe
            if (!file_exists($carpeta_destino)) {
                mkdir($carpeta_destino, 0777, true);
            }
            
            // Generar un nombre único para el archivo
            $nombre_archivo = time() . '_' . basename($nuevaImagenPerfil['name']);
            $ruta_completa = $carpeta_destino . '/' . $nombre_archivo;
            // eliminar archivo existente en caso de existir
            if(file_exists($imagenPerfil['Enlace'])){
                unlink($imagenPerfil['Enlace']);
            }

            eliminarimagenperfilanimal($animal['UniqueID']);
            aniadirimagenanimal($animal['UniqueID'],$ruta_completa);
        
            // Mover el archivo cargado a la carpeta de destino
            if (move_uploaded_file($nuevaImagenPerfil['tmp_name'], $ruta_completa)) {
                $ruta_imagen = "multimedia/protectoras/" . $animal['IDProtectora'] . "/" . $animal['UniqueID'] . "/perfil/" . $nombre_archivo;
            } 
        }
        header("Location: IndexAnimales.php?id=".$animal['UniqueID']);
        exit;
    }
  ?>
  <main class="flex flex-col items-center w-full gap-4 relative top-[-20px]">
<h1 class="text-4xl p-4">MODIFICAR INFORMACIÓN ANIMAL</h1>


        <div class="flex flex-col items-center">
          <p id="alerta" class="text-red-500"> </p>
        </div>

        <form action="" class="max-w-sm mx-auto bg-gray-800 p-6 rounded-lg shadow-md w-full gap-3 flex flex-col" method="POST" enctype="multipart/form-data" onsubmit="return validartamanio()">
        <label class="block text-gray-300 text-sm font-semibold mb-2" for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $animal['Nombre']; ?>" required
            class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        
        <label class="block text-gray-300 text-sm font-semibold mb-2" for="especie">Especie</label>
        <input type="text" id="especie" name="especie" value="<?php echo $animal['Especie']; ?>" required
            class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        
            <label class="block text-gray-300 text-sm font-semibold mb-2" for="peso">Peso en KG</label>
        <input type="number" id="peso" name="peso" value="<?php echo $animal['Peso']; ?>" required
            class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        
        <div class="flex items-center gap-2 mb-4">
            <label class="block text-gray-300 text-sm font-semibold" for="discapacidad">Discapacidad</label>
            <input type="checkbox" id="discapacidad" name="discapacidad" value="1" <?php if ($animal['Discapacidad'] == 1) echo 'checked'; ?>>
        </div>
        <label class="block text-gray-300 text-sm font-semibold mb-2" for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" cols="30" rows="10" class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo $animal['Descripcion']; ?></textarea>
        
            <label class="block text-gray-300 text-sm font-semibold mb-2" for="imagen">Imagen Perfil</label>
        <input type="file" name="imagen" id="imagen"  value="<?php echo $imagenPerfil['Enlace']; ?>"
            class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button type="submit" class="w-full bg-[#54B5BE] hover:bg-[#54B5BE]/80 text-white font-bold py-2 px-4 rounded">
           modificar animal
        </button>
    </form>
  </main>
  <script src="sriptsJS/validarImagenes.js"></script>
</body>
</html>
