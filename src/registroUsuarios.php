<?php 
        require 'head.php';
?> 

  <?php 
    require 'nav.php';
    require 'bd.php';
    require 'correo.php';
    $bd = conection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
      $Correo =$_REQUEST["Correo"];
      $Telefono =$_REQUEST["Telefono"];
      $Nombre =$_REQUEST["Nombre"];
      $Apellidos =$_REQUEST["Apellidos"];
      $ContrasenaHash = password_hash($_REQUEST["password"], PASSWORD_DEFAULT);
      $Admin = 0;
      $stmt = $bd->prepare("INSERT INTO usuarios (Correo, Telefono, Nombre, Apellidos, Contrasena, Admin) VALUES (?, ?, ?, ?, ?, ?)");
      try{
        $stmt->execute([$Correo, $Telefono, $Nombre, $Apellidos, $ContrasenaHash, $Admin]);
        correoRegistro($Correo);
        header("Location: login.php");
        exit;
      }
      catch(PDOException $e){
        echo "<div class='text-center text-red-500'>Error al dar de alta al nuevo usuario, correo o número ya existentes</div>";
      }
    }
  ?>
  <main class="flex flex-col justify-center items-center w-full gap-4 relative pt-[50px] p-2">
    <form action="" class="max-w-sm mx-auto bg-gray-800 p-6 rounded-lg shadow-md w-full gap-3 flex flex-col" method="POST">
      <label class="block text-gray-300 text-sm font-semibold mb-2" for="Nombre">Nombre</label>
      <input type="text" id="Nombre" name="Nombre" required class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">

      <label class="block text-gray-300 text-sm font-semibold mb-2" for="Apellidos">Apellidos</label>
      <input type="text" id="Apellidos" name="Apellidos" required class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">

      <label class="block text-gray-300 text-sm font-semibold mb-2" for="Correo">Correo</label>
      <input type="email" id="Correo" name="Correo" required class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">

      <label class="block text-gray-300 text-sm font-semibold mb-2" for="password">Contraseña</label>
      <input type="password" id="password" name="password" required class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">

      <label class="block text-gray-300 text-sm font-semibold mb-2" for="Telefono">nº teléfono</label>
      <input type="number" id="Telefono" name="Telefono" min="100000000" max="999999999" required class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">


    <button type="submit" class="w-full bg-[#EDB439] hover:bg-[#EDB439]/80 text-white font-bold p-2 px-4 rounded">Registrarse</button>
    </form>
  </main>



</body>
</html>
