<?php 
        require 'head.php';
        session_start();
?> 

<?php 
	require 'nav.php';
  require 'bd.php';
  require 'sesion.php';
    comprobar_admin();
    
  // Procesar la eliminación si se recibió un ID
  if (isset($_POST['eliminar_animal']) && isset($_POST['id_animal'])) {
    $idAnimal = $_POST['id_animal'];
    if (eliminarAnimal($idAnimal)) {
      header("Location: adminAnimales.php");
      exit;
    }
  }
?>
  <main class="items-center w-[80%] gap-7 relative top-[] pl-6 left-[80px] ">
    <div class="flex items-center content-center gap-5 p-4">
        
        <h1 class="text-7xl">Admin Animales</h1>
    </div>
   
   <hr class="w-full p-4">
   <?php 
	    require 'navAdmin.php';
    ?>
   <hr>
   <div class="p-6">
    <div class="p-6 space-y-6">
      <!-- Formulario de navegación por características -->
      <div class="p-6 space-y-6">
        <!-- Formulario de filtros -->
        <form id="filtroForm" class="grid sm:grid-cols-4 gap-4">
          <input type="text" placeholder="Nombre" id="filtro-nombre" class="border px-3 py-2 rounded-md text-sm" />
          <input type="text" placeholder="Protectora" id="filtro-protectora" class="border px-3 py-2 rounded-md text-sm" />
          <input type="text" placeholder="Especie" id="filtro-especie" class="border px-3 py-2 rounded-md text-sm" />
          <input type="text" placeholder="Características" id="filtro-caracteristicas" class="border px-3 py-2 rounded-md text-sm" />
        </form>
        <button class="bg-blue-500 hover:bg-blue-600 p-2 rounded-lg">Filtrar</button>
      
    <table class="min-w-full border bg-white border-gray-300 text-sm text-left text-gray-700">
      <thead class=" text-xs uppercase">
        <tr class=" text-center">
          <th class="px-4 py-2 border">Nombre</th>
          <th class="px-4 py-2 border">Protectora</th>
          <th class="px-4 py-2 border">Especie</th>
          <th class="px-4 py-2 border">Peso</th>
          <th class="px-4 py-2 border">Especie</th>
          <th class="px-4 py-2 border">Discapacidad</th>
          <th class="px-4 py-2 border">Descripción</th>
          <th class="px-4 py-2 border">Acciones</th>
        </tr>
      </thead>
      <tbody class="text-center text-black " >
          <?php 
              // Mostrar mensaje de resultado si existe
              if (isset($mensaje)) {
                echo "<tr><td colspan='8' class='px-4 py-2 text-center font-bold " . 
                     (strpos($mensaje, 'Error') !== false ? "text-red-500" : "text-green-500") . 
                     "'>" . $mensaje . "</td></tr>";
              }
              
              $animales = obtenerAnimales();

              foreach ($animales as $animal) 
              {
                echo "<tr class='hover:bg-gray-50'>";
                $nombreProtectora = obtenerNombreProtectora($animal['IDProtectora']);
                echo "<td class='px-4 py-2 border'>" . htmlspecialchars($animal['Nombre']) . "</td>";
                echo "<td class='px-4 py-2 border'>" . htmlspecialchars($nombreProtectora) . "</td>";
                echo "<td class='px-4 py-2 border'>" . htmlspecialchars($animal['Especie']) . "</td>";
                echo "<td class='px-4 py-2 border'>" . htmlspecialchars($animal['Peso']) . "KG </td>";
                echo "<td class='px-4 py-2 border'>" . htmlspecialchars($animal['Especie']) . "</td>";
                echo "<td class='px-4 py-2 border'>" . ($animal['Discapacidad'] ? 'Sí' : 'No') . "</td>";
                echo "<td class='px-4 py-2 border'>" . htmlspecialchars($animal['Descripcion']) . "</td>";
                echo "<td class='px-4 py-2 border'>
                        <form method='POST' >
                          <input type='hidden' name='id_animal' value='" . $animal['UniqueID'] . "'>
                          <button type='submit' name='eliminar_animal' class='bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded'>
                            Eliminar
                          </button>
                        </form>
                      </td>";
                echo "</tr>";
              }
          ?>
      </tbody>
    </table>
  </div>
  </main>
</body>
</html>
