<?php 
    session_start();
    require 'head.php';
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

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_usuario']) && isset($_POST['admin']))
    {
        $id_usuario = $_POST['id_usuario'];
        $usuario = obtenerUsuarioID($id_usuario);
        if($usuario['Admin'] == 1)
        {
            desactivarAdmin($id_usuario);
            header("Location: adminUsuarios.php");
            exit();
        }
        else
        {
            activarAdmin($id_usuario);
            header("Location: adminUsuarios.php");
            exit();
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buscador']) && $_POST['buscador'] == 1) {
      $buscador = 1;
      $correo = $_POST['filtro-correo'];
      header("Location: adminUsuarios.php?buscador=1&correo=$correo");
      exit;
    }
?> 

<?php 
	require 'nav.php';
?>
   <main class="items-center w-full gap-7 relative top-[] ">
    <div class="flex items-center content-center gap-5 p-4">
        
        <h1 class="text-4xl">Admin Usuarios</h1>
    </div>
   
   <hr class="w-full p-4">
   <?php 
	    require 'navAdmin.php';
    ?>
   <hr>
    
        <!-- Formulario de filtros -->
  <form id="filtroForm" class="grid sm:grid-cols-5 gap-4 " method="post">

    <input name="filtro-correo" type="text" placeholder="Correo" id="filtro-correo" class="border px-3 py-2 rounded-md text-sm" />
    <button name="buscador" value="1" type="submit" class="bg-[#54B5BE] hover:bg-[#54B5BE]/80 p-2 rounded-lg">Filtrar</button>
  </form>

  
      <?php 
              if (isset($_GET['buscador']) && $_GET['buscador'] == 1)
              {
                $correo = $_GET['correo'];
                $usuarios = filtroUsuariosAdmin($correo);
              }
              else
              {
                $usuarios = obtenerUsuarios();
              }
              echo "<div class='px-4 py-2 border w-full grid grid-cols-1 lg:grid-cols-2  gap-2'>";
              foreach ($usuarios as $usuario) 
              {
                echo "<div class='grid grid-cols-1 lg:grid-cols-2  gap-2 bg-black/50 text-white text-[20px] rounded-lg'>";
                echo "<div class='col-span-1 lg:col-span-2 xl:col-span-1 flex items-center'>";
                echo "<p class=' py-2 font-bold text-pink-200'>Nombre: </p>";
                echo "<p>".htmlspecialchars($usuario['Nombre']) . "</p>";
                echo "</div>";
                echo "<div class='col-span-1 lg:col-span-2 xl:col-span-1 flex items-center'>";
                echo "<p class=' py-2 font-bold text-pink-200'>Apellidos: </p>";
                echo "<p>" . htmlspecialchars($usuario['Apellidos']) . "</p>";
                echo "</div>";
                echo "<div class='col-span-1 lg:col-span-2 xl:col-span-1 flex items-center'>";
                echo "<p class=' py-2 font-bold text-pink-200'>Telefono: </p>";
                echo "<p>" . htmlspecialchars($usuario['Telefono']) . "</p>";
                echo "</div>";
                echo "<div class='col-span-1 lg:col-span-2 xl:col-span-1 flex items-center'>";
                echo "<p class=' py-2 font-bold text-pink-200'>Correo: </p>";
                echo "<p>" . htmlspecialchars($usuario['Correo']) . "</p>";
                echo "</div>";
                echo "<div class='col-span-1 lg:col-span-2 xl:col-span-1 flex items-center'>";
                echo "<p class=' py-2 font-bold text-pink-200'>admin: </p>";
                echo "<p>" . ($usuario['Admin'] == 1 ? "Si " : "No ") . "</p>";
                echo "</div>";
                echo "<div class=' flex items-center'>";
                echo "<form action='' method='post' >";
                echo "<input type='hidden' name='id_usuario' value='" . $usuario['UniqueID'] . "'>";
                echo "<input type='hidden' name='admin' value='" . $usuario['Admin'] . "'>";
                echo "<button type='submit' " . ($usuario['Admin'] == 1 ? "class='text-black px-2 py-1 bg-[#DB3066] hover:bg-[#DB3066]/80 rounded-lg'" : "class='text-black px-2 py-1 bg-[#54B5BE] hover:bg-[#54B5BE]/80 rounded-lg'") . " >".($usuario['Admin'] == 1 ? "desactivar" : "activar")."</button>";
                echo "</form>";
                echo "</div>";
                echo "<div class=' flex items-center'>";
                echo "<form action='' method='post' >";
                echo "<input type='hidden' name='id_usuario' value='" . $usuario['UniqueID'] . "'>";
                echo "<input type='hidden' name='borrar' value='1'>";
                echo "<button type='submit' class='px-2 py-1 bg-red-500 hover:bg-red-600 rounded-lg'>borrar</button>";
                echo "</form>";
                echo "</div>";              
                echo "</div>";
              }
              echo "</div>";
          ?>
  </main>
</body>
</html>


