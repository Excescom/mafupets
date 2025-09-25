<?php 
        require 'head.php';
        session_start();
?> 

<?php 
	require 'nav.php';
  require 'bd.php';
  require 'sesion.php';
    comprobar_admin();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buscador']) && $_POST['buscador'] == 1) {
      $buscador = 1;
      $comentario = $_POST['filtro-comentario'];
      header("Location: adminComentarios.php?buscador=1&comentario=$comentario");
      exit;
    }
  
?>
   <main class="items-center w-full gap-7 relative top-[] ">
    <div class="flex items-center content-center gap-5 p-4 pt-[50px]">
        
        <h1 class="text-4xl">Admin Comentarios</h1>
    </div>
   
   <hr class="w-full p-4">
   <?php 
	    require 'navAdmin.php';


   if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['borrar']))
   { 
        eliminarcomentario($_POST['id_usuario']); 
   }

  
    ?>
   <hr>
    
        <!-- Formulario de filtros -->
        <form id="filtroForm" class="grid sm:grid-cols-5 gap-4 " method="post">

       
        <input class="border px-3 py-2 rounded-md text-sm" type="text" name="filtro-comentario" placeholder="Comentario">
        <button name="buscador" value="1" type="submit" class="bg-[#54B5BE] hover:bg-[#54B5BE]/80 p-2 rounded-lg">Filtrar</button>
        </form>
  
    
  
      <?php 
              if (isset($_GET['buscador']) && $_GET['buscador'] == 1)
              {
                $comentario = $_GET['comentario'];
                $comentarios = filtroComentariosAdmin($comentario);
              }
              else
              {
                $comentarios = obtenerTodosComentarios();
              }
             
              echo "<div class='px-4 py-2 w-full grid grid-cols-1 lg:grid-cols-2  gap-2  text-[20px] rounded-lg'>";
              foreach ($comentarios as $comentario) 
              {
                $usuario = obtenerUsuarioID($comentario['IDUsuario']);
                $animal = obtenerAnimalporID($comentario['IDAnimal']);
                $protectora = obtenerProtectoraID($animal['IDProtectora']);
               echo "<div class=' px-4 py-2 border w-full grid grid-cols-1 lg:grid-cols-2 gap-2 bg-black/50 text-white text-[20px] rounded-lg'>";
                echo "<div class='col-span-1 flex items-center'>";
                echo "<p class='px-2 py-2 font-bold text-pink-200'>Usuario: </p>";
                 echo "<p class='px-2 py-2'>" . htmlspecialchars($usuario['Nombre']) . "</p>";
                echo "</div>";
                echo "<div class='col-span-1 flex items-center'>";
                echo "<p class='px-2 py-2 font-bold text-pink-200'>Animal: </p>";
                 echo "<p class='px-2 py-2'>" . htmlspecialchars($animal['Nombre']) . "</p>";
                echo "</div>";
                echo "<div class='col-span-1 flex items-center'>";
                echo "<p class='px-2 py-2 font-bold text-pink-200'>Protectora: </p>";
                echo "<p >" . htmlspecialchars($protectora['Nombre']) . "</p>";
                echo "</div>";
                echo "<div class='col-span-1  flex items-center cols-span-1 lg:col-span-2 xl:col-span-3'>";
                echo "<p>Comentario: " . htmlspecialchars($comentario['Comentario']) . "</p>";
                echo "</div>";
                echo "<div class='col-span-1 lg:col-span-2 xl:col-span-3 flex items-center'>";
                echo "<form action='' method='post' >";
                echo "<input type='hidden' name='id_usuario' value='" . $comentario['UniqueID'] . "'>";
                echo "<div class='flex gap-2 p-4 cols-span-1 lg:col-span-2 xl:col-span-3'>";
                echo "<input type='hidden' name='borrar' value='1'>";
                echo "<button type='submit' class='px-2 py-1 bg-red-500 hover:bg-red-600 rounded-lg'>borrar</button>";
                echo "</div>";
                echo "</form>";
                echo "</div>";
                echo "</div>";

               
              }
             
              echo "</div>";
              
          ?>
  </main>
</body>
</html>
