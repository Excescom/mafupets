<?php 
        require 'head.php';
        require 'bd.php';
        session_start();
        $bd = conection();
?> 

  <?php 
	  require 'nav.php';
    if(isset($_SESSION['Usuario']))
    {
    $usuario = obtenerUsuarioPorCorreo($_SESSION['Usuario']['Correo']);
    }
    else if(isset($_SESSION['Protectora']))
    {
    $protectora = obtenerProtectoraCorreo($_SESSION['Protectora']['Correo']);
    }
    else
    {
      header("Location: debesInicarSesion.php");
      exit;
    }
    if(isset($_SESSION['Usuario']) && $_SERVER['REQUEST_METHOD'] === 'POST')
    {
      
      $Correo =$_REQUEST["Correo"];
      $Telefono =$_REQUEST["Telefono"];
      $Nombre =$_REQUEST["Nombre"];
      $Apellidos =$_REQUEST["Apellidos"];
      $ContrasenaHash = password_hash($_REQUEST["password"], PASSWORD_DEFAULT);
      $stmt = $bd->prepare("UPDATE usuarios SET Correo = ?, Telefono = ?, Nombre = ?, Apellidos = ?, Contrasena = ? WHERE UniqueID = ?");
      try{
        $stmt->execute([$Correo, $Telefono, $Nombre, $Apellidos, $ContrasenaHash, $usuario['UniqueID']]);
        $_SESSION['Usuario']['Nombre'] = $Nombre;
        $_SESSION['Usuario']['Correo'] = $Correo;
        echo "<div class='text-center text-green-500'>Usuario actualizado correctamente</div>";
        //tiempo de espera para recargar la página después de decir que se ha actualizado correctamente
        echo "<meta http-equiv='refresh' content='2;url=config.php'>";
        exit;
      }
      catch(PDOException $e){
        echo "<div class='text-center text-red-500'>Error al actualizar al usuario, correo o número ya existentes</div>";
      }
    }
    else if(isset($_SESSION['Protectora']) && $_SERVER['REQUEST_METHOD'] === 'POST')
    {
      $Correo =$_REQUEST["Correo"];
      $Nombre =$_REQUEST["Nombre"];
      $Informacion = $_REQUEST["Informacion"];
      $contrasena = password_hash($_REQUEST["Contrasena"], PASSWORD_DEFAULT);
      $stmt = $bd->prepare("UPDATE Protectoras SET Correo = ?, Nombre = ?, Contrasena = ?, Informacion = ? WHERE UniqueID = ?");
      try{
        $stmt->execute([$Correo, $Nombre, $contrasena, $Informacion, $protectora['UniqueID']]);
        $_SESSION['Protectora']['Nombre'] = $Nombre;
        $_SESSION['Protectora']['Correo'] = $Correo;

        $imagenPerfil = $_FILES['imagen'];
        // Procesar la imagen
        $ruta_imagen = '';
        if (isset($imagenPerfil) && $imagenPerfil['error'] == 0) {
            // Definir la carpeta donde se guardarán las imágenes
            $carpeta_destino = "multimedia/protectoras/" . $protectora['UniqueID'] . "/perfil";
            
            // Crear la carpeta si no existe
            if (!file_exists($carpeta_destino)) {
                mkdir($carpeta_destino, 0777, true);
            }
            
            // Generar un nombre único para el archivo
            $nombre_archivo = time() . '_' . basename($imagenPerfil['name']);
            $ruta_completa = $carpeta_destino . '/' . $nombre_archivo;
            // eliminar archivo existente en caso de existir
            $carpeta =  "multimedia/protectoras/".$protectora['UniqueID']."/perfil/";
            $imagenPerfilVieja = glob($carpeta . '*');
            if ($imagenPerfilVieja) {
                unlink($imagenPerfilVieja[0]);
            }
            // Mover el archivo cargado a la carpeta de destino
            if (move_uploaded_file($imagenPerfil['tmp_name'], $ruta_completa)) {
                $ruta_imagen = "multimedia/protectoras/" . $protectora['UniqueID'] . "/perfil/" . $nombre_archivo;
            } 
        }
        echo "<div class='text-center text-green-500'>Protectora actualizada correctamente</div>";
        //tiempo de espera para recargar la página después de decir que se ha actualizado correctamente
        echo "<meta http-equiv='refresh' content='2;url=config.php'>";
        header("Location: config.php");
        exit;
      }
      catch(PDOException $e){
        echo "<div class='text-center text-red-500'>Error al actualizar al usuario, correo o número ya existentes</div>";
      }
    }
    else if(isset($_SESSION['Protectora']) )
    {
      $protectora = obtenerProtectoraCorreo($_SESSION['Protectora']['Correo']);
    }
  ?>
  <main class="flex flex-col items-center w-full gap-4 relative top-[-20px]">
<h1 class="text-4xl p-4">MODIFICAR INFORMACIÓN PERSONAL</h1>
 <?php 
      if(isset($_SESSION['Usuario']))
      {
        ?>
        <form action="" class="max-w-sm mx-auto bg-gray-800 p-6 rounded-lg shadow-md w-full gap-3 flex flex-col" method="POST">
        <label class="block text-gray-300 text-sm font-semibold mb-2" for="Nombre">Nombre</label>
        <input type="text" id="Nombre" name="Nombre" value="<?php echo $usuario['Nombre']; ?>" required
        class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
  
        <label class="block text-gray-300 text-sm font-semibold mb-2" for="Apellidos">Apellidos</label>
        <input type="text" id="Apellidos" name="Apellidos" value="<?php echo $usuario['Apellidos']; ?>" required
        class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
  
        <label class="block text-gray-300 text-sm font-semibold mb-2" for="Correo">Correo</label>
        <input type="email" id="Correo" name="Correo" value="<?php echo $usuario['Correo']; ?>" required
        class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
  
        <label class="block text-gray-300 text-sm font-semibold mb-2" for="password">Contraseña</label>
        <input type="password" id="password" name="password" required
        class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
  
        <label class="block text-gray-300 text-sm font-semibold mb-2" for="Telefono">nº teléfono</label>
        <input type="number" id="Telefono" name="Telefono" value="<?php echo $usuario['Telefono']; ?>" required
        class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
  
  
      <button type="submit" class="w-full bg-[#EDB439] hover:bg-[#EDB439]/80 text-white font-bold p-2 px-4 rounded">
              Actualizar
        </button>
      </form>
      <?php
      }
      else if(isset($_SESSION['Protectora']))
      {
        ?>

        <div class="flex flex-col items-center">
          <p id="alerta" class="text-red-500"> </p>
        </div>

        <form action="" method="POST" enctype="multipart/form-data" class="max-w-sm mx-auto bg-gray-800 p-6 rounded-lg shadow-md w-full gap-3 flex flex-col " onsubmit="return validartamanio()">
      <label class="block text-gray-300 text-sm font-semibold mb-2" for="Nombre">Nombre Protectora</label>
      <input type="text" id="Nombre" name="Nombre" value="<?php echo $protectora['Nombre']; ?>" required
      class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
      
    <label class="block text-gray-300 text-sm font-semibold mb-2" for="Correo">Correo</label>
    <input type="email" id="Correo" name="Correo" value="<?php echo $protectora['Correo']; ?>" required
    class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">

    <label class="block text-gray-300 text-sm font-semibold mb-2" for="Contrasena">Contraseña</label>
    <input type="password" id="Contrasena" name="Contrasena" required
    class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">

    <label class="block text-gray-300 text-sm font-semibold mb-2" for="Ubicacion">Ubicación (se mantendrá privada)</label>
    <input type="text" id="Ubicacion" name="Ubicacion" placeholder="calle, número, puerta, etc." value="<?php echo $protectora['Ubicacion']; ?>" required
    class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">

    <label class="block text-gray-300 text-sm font-semibold mb-2" for="Informacion">Información</label>
    <textarea name="Informacion" id="Informacion" cols="30" rows="10" class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo $protectora['Informacion']; ?></textarea>

    <label class="block text-gray-300 text-sm font-semibold mb-2" for="imagen">Imagen Perfil</label>
        <input type="file" name="imagen" id="imagen" required
            class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
    <button 
    class="w-full bg-[#54B5BE] hover:bg-[#54B5BE]/80 text-white font-bold p-2 px-4 rounded">
    Actualizar Protectora
    </button>
    <div class="w-full bg-[#54B5BE] hover:bg-[#54B5BE]/80 text-white font-bold p-2 px-4 rounded text-center">
    <a href="configTelefono.php" >
    modificar números de teléfono
    </a>
    </div>
    </form>

    
      <?php
      }
      
 ?>   

  </main>
  <script src="sriptsJS/validarImagenes.js"></script>
</body>
</html>
