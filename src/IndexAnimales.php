<?php 
        require 'head.php';
        session_start();
        require 'bd.php';
?> 

  <?php 
	require 'nav.php';
    
    // Verificar si se ha proporcionado un ID de animal
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id_animal = $_GET['id'];
        
        // Obtener información del animal
        $bd = conection();
        $stmt = $bd->prepare("SELECT a.*, p.Nombre as NombreProtectora, p.UniqueID as IDProtectora 
                             FROM Animales a 
                             JOIN Protectoras p ON a.IDProtectora = p.UniqueID 
                             WHERE a.UniqueID = ?");
        $stmt->execute([$id_animal]);
        $animal = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$animal) {
            echo '<div class="text-center p-8">
                    <h2 class="text-2xl text-red-500">Animal no encontrado</h2>
                    <p class="mt-4">El animal que estás buscando no existe o ha sido eliminado.</p>
                    <a href="index.php" class="mt-4 inline-block bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-4 rounded">
                        Volver al inicio
                    </a>
                  </div>';
            exit;
        }
        
        // Obtener la imagen principal del animal
        $stmt = $bd->prepare("SELECT Enlace FROM Multimedias WHERE IDAnimal = ? LIMIT 1");
        $stmt->execute([$id_animal]);
        $imagen = $stmt->fetch(PDO::FETCH_ASSOC);
        $ruta_imagen = $imagen && $imagen['Enlace'] ? $imagen['Enlace'] : "multimedia/imagenporDefecto/animal.webp";
        
        // Obtener todas las imágenes adicionales del animal
        $stmt = $bd->prepare("SELECT Enlace FROM Multimedias WHERE IDAnimal = ?");
        $stmt->execute([$id_animal]);
        $imagenes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Si no se proporciona un ID válido, redirigir a la página principal
        echo '<div class="text-center p-8">
                <h2 class="text-2xl text-red-500">Animal no especificado</h2>
                <p class="mt-4">No se ha especificado qué animal quieres ver.</p>
                <a href="index.php" class="mt-4 inline-block bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-4 rounded">
                    Volver al inicio
                </a>
              </div>';
        exit;
    }
  ?>
  <main class="flex flex-col items-center w-full gap-4 relative pt-[30px]">
    <div class="flex flex-col items-center content-center gap-5 p-4">
        <div class="rounded-full bg-amber-400 w-[200px] h-[200px] overflow-hidden flex items-center justify-center">
            <img class="w-full h-full object-cover" src="<?php echo $ruta_imagen; ?>" alt="<?php echo $animal['Nombre']; ?>">
        </div>
        <h1 class="text-4xl md:text-7xl text-center"><?php echo $animal['Nombre']; ?></h1>
    </div>
    <div class="p-4 max-w-2xl w-full bg-gray-800 rounded-lg shadow-md">
        <h2 class="text-2xl mb-4 text-amber-400">Información del animal</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="mb-2"><span class="font-bold">Especie:</span> <?php echo $animal['Especie']; ?></p>
                <p class="mb-2"><span class="font-bold">Peso:</span> <?php echo $animal['Peso']; ?> kg</p>
                <p class="mb-2"><span class="font-bold">Discapacidad:</span> <?php echo $animal['Discapacidad'] ? 'Sí' : 'No'; ?></p>
            </div>
            <div>
                <p class="mb-2"><span class="font-bold">Protectora:</span> <?php echo $animal['NombreProtectora']; ?></p>
                <p class="mb-2"><a href="protectoraInicio.php?id=<?php echo $animal['IDProtectora']; ?>" class="text-amber-400 hover:underline">Ver más animales de esta protectora</a></p>
            </div>
        </div>
        <div class="mt-4">
            <h3 class="text-xl mb-2 text-amber-400">Descripción</h3>
            <p><?php echo $animal['Descripcion']; ?></p>
        </div>
    </div>
   <hr class="w-full p-4">
   <h2 class="text-2xl p-4">Galería de imágenes</h2>
   <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
   
   <?php 
   if (count($imagenes) > 0) {
       foreach($imagenes as $img) {
           echo '<div class="text-center">
               <img class="rounded-lg object-cover w-full h-48" src="'.$img['Enlace'].'" alt="'.$animal['Nombre'].'">
           </div>';
       }
   } else {
       echo '<p class="col-span-full text-center text-gray-400">No hay imágenes adicionales disponibles</p>';
   }
   ?>
   </div>
  </main>
</body>
</html>
