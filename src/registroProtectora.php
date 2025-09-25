<?php 
        require 'head.php';
        require 'bd.php';
        require 'correo.php';
        $bd = conection();
?> 

<!-- crear protectora -->
  <?php 
    require 'nav.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
      $Correo =$_REQUEST["Correo"];
      $Nombre =$_REQUEST["Nombre"];
      $Ubicacion =$_REQUEST["Ubicacion"];
      $numero = $_REQUEST["Telefono"];
      $ContrasenaHash = password_hash($_REQUEST["Contrasena"], PASSWORD_DEFAULT);
      $Activa = 0;
      $Informacion = $_REQUEST["Informacion"];
      $stmt = $bd->prepare("INSERT INTO Protectoras (Correo, Nombre, Ubicacion, Contrasena, Activa, Informacion) VALUES (?, ?, ?, ?, ?, ?)");
      try{$stmt->execute([$Correo, $Nombre, $Ubicacion, $ContrasenaHash, $Activa, $Informacion]);
      
        $protectora = obtenerProtectoraCorreo($Correo);
        aniadirnumeroProtectora($protectora['UniqueID'], $numero);
      
      $imagen = $_FILES['imagen']['name'] ?? '';
      

       // Procesar la imagen
        $ruta_imagen = '';
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            // Definir la carpeta donde se guardarán las imágenes
            $carpeta_destino = "multimedia/protectoras/" . $protectora['UniqueID'] . "/perfil";
            
            // Crear la carpeta si no existe
            if (!file_exists($carpeta_destino)) {
                mkdir($carpeta_destino, 0777, true);
            }
            
            // Generar un nombre único para el archivo
            $nombre_archivo = time() . '_' . basename($imagen);
            $ruta_completa = $carpeta_destino . '/' . $nombre_archivo;
            
            // Mover el archivo cargado a la carpeta de destino
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_completa)) {
                $ruta_imagen = "multimedia/protectoras/" . $protectora['UniqueID'] . "/perfil/" . $nombre_archivo;
            } 
        }
        correoRegistro($Correo);
        header("Location: loginProtectora.php");
        exit;
      }
      catch(PDOException $e){
        echo "<div class='text-center text-red-500'>Error al dar de alta al nuevo usuario, correo o número ya existentes</div>";
      }      
    }
  ?>
  <main class="flex flex-col justify-center items-center w-full gap-4 relative pt-[50px] p-2">
    <form action="" method="POST" enctype="multipart/form-data" class="max-w-sm mx-auto bg-gray-800 p-6 rounded-lg shadow-md w-full gap-3 flex flex-col " onsubmit="return validartamanio()">
      <label class="block text-gray-300 text-sm font-semibold mb-2" for="Nombre">Nombre Protectora</label>
      <input type="text" id="Nombre" name="Nombre" required class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
      
    <label class="block text-gray-300 text-sm font-semibold mb-2" for="Correo">Correo</label>
    <input type="email" id="Correo" name="Correo" required class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">

    <label class="block text-gray-300 text-sm font-semibold mb-2" for="Contrasena">Contraseña</label>
    <input type="password" id="Contrasena" name="Contrasena" required class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">

    <label class="block text-gray-300 text-sm font-semibold mb-2" for="Ubicacion">Ubicación (se mantendrá privada)</label>
    <input type="text" id="Ubicacion" name="Ubicacion" placeholder="calle, número, puerta, etc." required class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">


    <label class="block text-gray-300 text-sm font-semibold mb-2" for="Telefono">nº teléfono (en un futuro se podrán añadir más en configuración)</label>
    <input min="100000000" max="999999999" type="number" id="Telefono" name="Telefono" required class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
   
    <label class="block text-gray-300 text-sm font-semibold mb-2" for="Informacion">Información</label>
    <textarea name="Informacion" id="Informacion" cols="30" rows="10" class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
    
    <label class="block text-gray-300 text-sm font-semibold mb-2" for="imagen">Imagen Perfil</label>
    <input type="file" name="imagen" id="imagen" required class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
    <button class="w-full bg-[#DB3066] hover:bg-[#EDB439]/80 text-white font-bold p-2 px-4 rounded">Registrarse</button>
    </form>
  </main>


  <script src="sriptsJS/validarImagenes.js"></script>

</body>
</html>
