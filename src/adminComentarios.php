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
        
        <h1 class="text-7xl">Admin Comentarios</h1>
    </div>
   
   <hr class="w-full p-4">
   <?php 
	    require 'navAdmin.php';
    ?>
   <hr>
   <div class="p-6">
    <div class="p-6 space-y-6">
      <!-- Formulario de filtros para comentarios -->
      <form id="filtroForm" class="grid sm:grid-cols-3 gap-4">
       
        <input type="text" placeholder="Publicación" id="filtro-publicacion" class="border px-3 py-2 rounded-md text-sm" />
        <input type="text" placeholder="Comentario" id="filtro-comentario" class="border px-3 py-2 rounded-md text-sm" />
        <input type="text" placeholder="Usuario" id="filtro-usuario" class="border px-3 py-2 rounded-md text-sm" />
      </form>
      <button class="bg-blue-500 hover:bg-blue-600 p-2 rounded-lg mt-4">Filtrar</button>
  
      <!-- Tabla de comentarios -->
      <div class="overflow-x-auto mt-6">
        <table class="min-w-full border bg-white border-gray-300 text-sm text-left text-gray-700">
          <thead class="bg-gray-100 text-xs uppercase">
            <tr>
                <th class="px-4 py-2 border">Usuario</th>
                <th class="px-4 py-2 border">Animal</th>
                <th class="px-4 py-2 border">Comentario</th>
                <th class="px-4 py-2 border">acciones</th>
            </tr>
          </thead>
          <tbody class="text-center text-black " >
          <?php 
              
              $comentarios = obtenerComentarios();

              foreach ($comentarios as $comentario) 
              {
                echo "<tr class='hover:bg-gray-50'>";
                $nombreUsuario = obtenerNombreUsuario($comentario['IDUsuario']);
                $nombreAnimal = obtenerNombreAnimal($comentario['IDAnimal']);
                echo "<td class='px-4 py-2 border'>" . htmlspecialchars( $nombreUsuario) . "</td>";
                echo "<td class='px-4 py-2 border'>" . htmlspecialchars( $nombreAnimal) . "</td>";
                echo "<td class='px-4 py-2 border'>" . htmlspecialchars($comentario['Comentario']) . "</td>";
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
