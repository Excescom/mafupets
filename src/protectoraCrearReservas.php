<?php 
        require 'head.php';
        require 'sesion.php';
        require 'bd.php';
        comprobar_sesion_protectora();
?> 

  <?php 
	  require 'nav.php';
      $bd = conection();
      $protectora = obtenerProtectoraCorreo($_SESSION['Protectora']['Correo']);
      if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
          $fechaHora = $_POST['fechaHora'] ?? '';
          $tipo = $_POST['tipo'] ?? '';
          
          
          $stmt = $bd->prepare("INSERT INTO reservas (FechaHora, Tipo, IDProtectora) VALUES (?, ?, ?)");
          $stmt->execute([$fechaHora, $tipo, $protectora['UniqueID']]);
          
          header("Location: protectoraReservas.php");
          exit;
      }

  ?>

  <main class="items-center w-[90%] gap-7 relative pl-6  flex flex-col justify-center">
    <!-- Cabecera de la protectora -->
    <div class="flex flex-col items-center content-center w-full gap-5 p-4">
        <div class="rounded-full bg-amber-400 w-[200px] h-[200px] min-w-[200px] min-h-[200px] flex-shrink-0 overflow-hidden flex items-center justify-center">
        <?php 
        $carpeta =  "multimedia/protectoras/".$protectora['UniqueID']."/perfil/";
        $imagenPerfil = glob($carpeta . '*');
        ?>
            <img class="w-full h-full object-cover object-center" src="<?php echo $imagenPerfil[0]; ?>" alt="Imagen">
        </div>
        <h1 class="text-4xl lg:text-7xl"><?php echo $_SESSION['Protectora']['Nombre']; ?></h1>
    </div>

    <!-- Sección de gestión de publicaciones -->
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
          <li>
            <a href="crearTicketProtectora.php" class="inline-block hover:text-gray-300 hover:border-gray-300 p-4 rounded-t-lg ">Crear tickets</a>
          </li>
        </ul>
      </div>

      <form action="" class="max-w-sm mx-auto bg-gray-800 p-6 rounded-lg shadow-md w-full gap-3 flex flex-col" method="POST" enctype="multipart/form-data">
       <label for="fechaHora">Fecha hora</label>
       <input type="datetime-local" name="fechaHora" id="fechaHora" required>
       <label for="tipo">Tipo</label>
       <select name="tipo" id="tipo">
        <option value="visita" class="bg-gray-700">Visita</option>
        <option value="puertas abiertas" class="bg-gray-700">Puertas abiertas</option>
        <option value="voluntariado" class="bg-gray-700">Voluntariado</option>
       </select>
       <button type="submit" class="w-full bg-[#54B5BE] hover:bg-[#54B5BE]/80 text-white font-bold py-2 px-4 rounded">Crear reserva</button>
    </form>
  </main>
</body>
</html>