<?php 
        require 'head.php';
        session_start();
?> 

<?php 
	require 'nav.php';
  require 'bd.php';
  require 'sesion.php';
    comprobar_admin()
?>
  <main class="items-center w-[80%] gap-7 relative top-[] pl-6 left-[80px] ">
    <div class="flex items-center content-center gap-5 p-4">
        
        <h1 class="text-7xl">Admin Protectora</h1>
    </div>
   
   <hr class="w-full p-4">
   <?php 
	    require 'navAdmin.php';
    ?>
   <hr>
   <div class="p-6">
    <div class="p-6 space-y-6">
      <!-- Formulario de filtros -->
      <form id="filtroForm" class="grid sm:grid-cols-5 gap-4">
        <input type="text" placeholder="Nombre" id="filtro-nombre" class="border px-3 py-2 rounded-md text-sm" />
        <input type="text" placeholder="Correo" id="filtro-correo" class="border px-3 py-2 rounded-md text-sm" />
        <input type="text" placeholder="Dirección" id="filtro-direccion" class="border px-3 py-2 rounded-md text-sm" />
        <input type="text" placeholder="Localidad" id="filtro-localidad" class="border px-3 py-2 rounded-md text-sm" />
        <input type="text" placeholder="Información adicional" id="filtro-info" class="border px-3 py-2 rounded-md text-sm" />
      </form>
      <button class="bg-blue-500 hover:bg-blue-600 p-2 rounded-lg mt-4">Filtrar</button>
  
      <!-- Tabla de protectoras -->
      <div class="overflow-x-auto">
        <table class="min-w-full border bg-white border-gray-300 text-sm text-left text-gray-700">
          <thead class="bg-gray-100 text-xs uppercase">
            <tr>
              <th class="px-4 py-2 border">Nombre</th>
              <th class="px-4 py-2 border">Correo</th>
              <th class="px-4 py-2 border">Ubicacion</th>
              <th class="px-4 py-2 border">Informacion</th>
              <th class="px-4 py-2 border">acciones</th>
            </tr>
          </thead>
          <tbody class="text-center text-black " >
          <?php 
              
              $protectoras = obtenerProtectoras();

              foreach ($protectoras as $protectora) 
              {
                echo "<tr class='hover:bg-gray-50'>";
                echo "<td class='px-4 py-2 border'>" . htmlspecialchars($protectora['Nombre']) . "</td>";
                echo "<td class='px-4 py-2 border'>" . htmlspecialchars($protectora['Correo']) . "</td>";
                echo "<td class='px-4 py-2 border'>" . htmlspecialchars($protectora['Ubicacion']) . "</td>";
                echo "<td class='px-4 py-2 border'>" . htmlspecialchars($protectora['Informacion']) . "</td>";
                echo "<td class='px-4 py-2 border'> <button>borrar</button> </td>";
                echo "</tr>";
              }
          ?>
      </tbody>
        </table>
      </div>
    </div>
  </div>
  
  </main>
</body>
</html>
