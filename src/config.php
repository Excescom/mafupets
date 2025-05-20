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
      $Admin = 0;
      $stmt = $bd->prepare("UPDATE usuarios SET Correo = ?, Telefono = ?, Nombre = ?, Apellidos = ?, Contrasena = ?, Admin = ? WHERE UniqueID = ?");
      try{
        $stmt->execute([$Correo, $Telefono, $Nombre, $Apellidos, $ContrasenaHash, $Admin, $usuario['UniqueID']]);
        $_SESSION['Usuario']['Nombre'] = $Nombre;
        $_SESSION['Usuario']['Correo'] = $Correo;
        header("Location: config.php");
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
      $ContrasenaHash = password_hash($_REQUEST["password"], PASSWORD_DEFAULT);
      $stmt = $bd->prepare("UPDATE Protectoras SET Correo = ?, Nombre = ?, Contrasena = ? WHERE UniqueID = ?");
      try{
        $stmt->execute([$Correo, $Nombre, $ContrasenaHash, $protectora['UniqueID']]);
        $_SESSION['Protectora']['Nombre'] = $Nombre;
        $_SESSION['Protectora']['Correo'] = $Correo;
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
  
  
      <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold p-2 px-4 rounded">
              Actualizar
        </button>
      </form>
      <?php
      }
      else if(isset($_SESSION['Protectora']))
      {
        ?>
        <form action="" method="POST" enctype="multipart/form-data" class="max-w-sm mx-auto bg-gray-800 p-6 rounded-lg shadow-md w-full gap-3 flex flex-col ">
      <label class="block text-gray-300 text-sm font-semibold mb-2" for="Nombre">Nombre Protectora</label>
      <input type="text" id="Nombre" name="Nombre" value="<?php echo $protectora['Nombre']; ?>" required
      class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
      
    <label class="block text-gray-300 text-sm font-semibold mb-2" for="Correo">Correo</label>
    <input type="email" id="Correo" name="Correo" value="<?php echo $protectora['Correo']; ?>" required
    class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">

    <label class="block text-gray-300 text-sm font-semibold mb-2" for="Contrasena">Contraseña</label>
    <input type="password" id="Contrasena" name="Contrasena" value="<?php echo $protectora['Contrasena']; ?>" required
    class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">

    <label class="block text-gray-300 text-sm font-semibold mb-2" for="Ubicacion">Ubicación (se mantendrá privada)</label>
    <input type="text" id="Ubicacion" name="Ubicacion" placeholder="calle, número, puerta, etc." value="<?php echo $protectora['Ubicacion']; ?>" required
    class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">

    <label class="block text-gray-300 text-sm font-semibold mb-2" for="imagen">Imagen Perfil</label>
        <input type="file" name="imagen" id="imagen" required
            class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
    <button 
    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold p-2 px-4 rounded">
    Actualizar Protectora
    </button>
    </form>

    <form action="" method="POST" enctype="multipart/form-data" class="max-w-sm mx-auto bg-gray-800 p-6 rounded-lg shadow-md w-full gap-3 flex flex-col ">
    <label class="block text-gray-300 text-sm font-semibold mb-2" for="Telefono">añadir nuevo número de teléfono</label>
    <input type="number" id="Telefono" name="Telefono" required
    class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
    <button 
    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold p-2 px-4 rounded">
    Añadir número de teléfono
    </button>
    </form>
      <?php
      }
      
 ?>   
  </main>
</body>
</html>
