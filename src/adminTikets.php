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
        
        <h1 class="text-7xl">Admin Tickets</h1>
    </div>
   
   <hr class="w-full p-4">
   <?php 
	    require 'navAdmin.php';
    ?>
   <hr>
   <div class="p-6">
    <div class="p-6 space-y-6">
      <!-- Formulario de filtros para incidencias -->
      <form id="filtroForm" class="grid sm:grid-cols-2 gap-4">
        
        <input type="text" placeholder="Descripción" id="filtro-descripcion" class="border px-3 py-2 rounded-md text-sm" />
        <input type="text" placeholder="Enlace a la incidencia" id="filtro-enlace" class="border px-3 py-2 rounded-md text-sm" />
      </form>
      <button class="bg-blue-500 hover:bg-blue-600 p-2 rounded-lg mt-4">Filtrar</button>
  
      <!-- Tabla de incidencias -->
      <div class="overflow-x-auto mt-6">
        <table class="min-w-full border bg-white border-gray-300 text-sm text-left text-gray-700">
          <thead class="bg-gray-100 text-xs uppercase">
            <tr>
              <th class="px-4 py-2 border">Usuario</th>
              <th class="px-4 py-2 border">Problema</th>
              <th class="px-4 py-2 border">Fecha/hora</th>
              <th class="px-4 py-2 border">Descripción</th>
              <th class="px-4 py-2 border">Estado</th>
            </tr>
          </thead>
          <tbody class="text-center text-black " >
          <?php 
              
              $ticketsU = obtenerTicketsU();

              foreach ($ticketsU as $TicketU) 
              {
                echo "<tr class='hover:bg-gray-50'>";
                $nombreUsuario = obtenerNombreUsuario($TicketU['IDUsuario']);
                echo "<td class='px-4 py-2 border'>" . htmlspecialchars( $nombreUsuario) . "</td>";
                echo "<td class='px-4 py-2 border'>" . htmlspecialchars($TicketU['Tipo']) . "</td>";
                echo "<td class='px-4 py-2 border'>" . htmlspecialchars($TicketU['Fecha']) . "</td>";
                echo "<td class='px-4 py-2 border'>" . htmlspecialchars($TicketU['Descripcion']) . "</td>";
                echo "<td class='px-4 py-2 border'>" . ($TicketU['Estado'] ? 'Completado' : 'Incompleto') . "</td>";
                echo "<td class='px-4 py-2 border'> <button>borrar</button> </td>";
                echo "</tr>";
              }
          ?>

          
      </tbody>
        </table>
      </div>
    </div>
  </div>
<hr>
  <div class="p-6">
    <div class="p-6 space-y-6">
      <!-- Formulario de filtros para incidencias -->
      <form id="filtroForm" class="grid sm:grid-cols-2 gap-4">
        
        <input type="text" placeholder="Descripción" id="filtro-descripcion" class="border px-3 py-2 rounded-md text-sm" />
        <input type="text" placeholder="Enlace a la incidencia" id="filtro-enlace" class="border px-3 py-2 rounded-md text-sm" />
      </form>
      <button class="bg-blue-500 hover:bg-blue-600 p-2 rounded-lg mt-4">Filtrar</button>
  
      <!-- Tabla de incidencias -->
      <div class="overflow-x-auto mt-6">
        <table class="min-w-full border bg-white border-gray-300 text-sm text-left text-gray-700">
          <thead class="bg-gray-100 text-xs uppercase">
            <tr>
              <th class="px-4 py-2 border">Usuario</th>
              <th class="px-4 py-2 border">Problema</th>
              <th class="px-4 py-2 border">Fecha/hora</th>
              <th class="px-4 py-2 border">Descripción</th>
              <th class="px-4 py-2 border">Estado</th>
            </tr>
          </thead>
          <tbody class="text-center text-black " >
          
          <?php 
              
              $ticketsP = obtenerTicketsP();

              foreach ($ticketsP as $TicketP) 
              {
                echo "<tr class='hover:bg-gray-50'>";
                $nombreProtectora = obtenerNombreProtectora($TicketP['IDProtectora']);
                echo "<td class='px-4 py-2 border'>" . htmlspecialchars( $nombreProtectora) . "</td>";
                echo "<td class='px-4 py-2 border'>" . htmlspecialchars($TicketP['Tipo']) . "</td>";
                echo "<td class='px-4 py-2 border'>" . htmlspecialchars($TicketP['Fecha']) . "</td>";
                echo "<td class='px-4 py-2 border'>" . htmlspecialchars($TicketP['Descripcion']) . "</td>";
                echo "<td class='px-4 py-2 border'>" . ($TicketP['Estado'] ? 'Completado' : 'Incompleto') . "</td>";
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












