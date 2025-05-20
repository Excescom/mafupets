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
  if (isset($_POST['eliminar_usuario']) && isset($_POST['id_usuario'])) {
    $idUsuario = $_POST['id_usuario'];
    if (eliminarUsuario($idUsuario)) {
      header("Location: adminUsuarios.php");
      exit;
    }
  }
?>
  <main class="items-center w-[80%] gap-7 relative top-[] pl-6 left-[80px] ">
    <div class="flex items-center content-center gap-5 p-4">
        
        <h1 class="text-7xl">Admin Usuarios</h1>
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
    <input type="text" placeholder="Apellidos" id="filtro-apellidos" class="border px-3 py-2 rounded-md text-sm" />
    <input type="text" placeholder="Teléfono" id="filtro-telefono" class="border px-3 py-2 rounded-md text-sm" />
    <input type="text" placeholder="Correo" id="filtro-correo" class="border px-3 py-2 rounded-md text-sm" />
    <input type="text" placeholder="Rol (admin/usuario)" id="filtro-rol" class="border px-3 py-2 rounded-md text-sm" />
  </form>
  <button class="bg-blue-500 hover:bg-blue-600 p-2 rounded-lg">Filtrar</button>
  <!-- Tabla de personas -->
  <div class="overflow-x-auto">
  <table class="min-w-full border bg-white border-gray-300 text-sm text-left text-gray-700">
      <thead class=" text-xs uppercase">
        <tr class=" text-center">
          <th class="px-4 py-2 border">Nombre</th>
          <th class="px-4 py-2 border">Apellidos</th>
          <th class="px-4 py-2 border">Teléfono</th>
          <th class="px-4 py-2 border">Correo</th>
          <th class="px-4 py-2 border">admin</th>
          <th class="px-4 py-2 border">acciones</th>
        </tr>
      </thead>
      <tbody class="text-center text-black " >
          <?php 
              // Mostrar mensaje de resultado si existe
              if (isset($mensaje)) {
                echo "<tr><td colspan='6' class='px-4 py-2 text-center font-bold " . 
                     (strpos($mensaje, 'Error') !== false ? "text-red-500" : "text-green-500") . 
                     "'>" . $mensaje . "</td></tr>";
              }
              
              $usuarios = obtenerUsuarios();

              foreach ($usuarios as $usuario) 
              {
                echo "<tr class='hover:bg-gray-50'>";
                echo "<td class='px-4 py-2 border'>" . htmlspecialchars($usuario['Nombre']) . "</td>";
                echo "<td class='px-4 py-2 border'>" . htmlspecialchars($usuario['Apellidos']) . "</td>";
                echo "<td class='px-4 py-2 border'>" . htmlspecialchars($usuario['Telefono']) . "</td>";
                echo "<td class='px-4 py-2 border'>" . htmlspecialchars($usuario['Correo']) . "</td>";
                echo "<td class='px-4 py-2 border'>" . ($usuario['Admin'] ? 'Sí' : 'No') . "</td>";
                echo "<td class='px-4 py-2 border'>
                        <form method='POST' onsubmit='return confirm(\"¿Estás seguro de que deseas eliminar este usuario?\")' style='display:inline'>
                          <input type='hidden' name='id_usuario' value='" . $usuario['UniqueID'] . "'>
                          <button type='submit' name='eliminar_usuario' class='bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded'>
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
