<?php 
        require 'head.php';
        session_start();
?> 

<?php 
	require 'nav.php';
  require 'bd.php';
  require 'sesion.php';
    comprobar_admin();

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_protectora']) && isset($_POST['activa']))
    {
        $id_protectora = $_POST['id_protectora'];
        $protectora = obtenerProtectoraID($id_protectora);
        if($protectora['activa'] == 1)
        {
            desactivarProtectora($id_protectora);
            header("Location: adminProtectora.php");
            exit();
        }
        else
        {
            activarProtectora($id_protectora);
            header("Location: adminProtectora.php");
            exit();
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_protectora']) && isset($_POST['borrar']))
    {
        $id_protectora = $_POST['id_protectora'];
        $protectora = obtenerProtectoraID($id_protectora);
        $rutaCarpeta = "multimedia/protectoras/".$protectora['UniqueID']."/";
         eliminarDirectorio($rutaCarpeta); 
            eliminarAnimalesProtectora($id_protectora);
            eliminarreservas($id_protectora);
            eliminarProtectora($id_protectora);
            header("Location: adminProtectora.php");
            exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buscador']) && $_POST['buscador'] == 1) {
      $buscador = 1;
      $correo = $_POST['filtro-correo'];
      header("Location: adminProtectora.php?buscador=1&correo=$correo");
      exit;
    }
?>
  <main class="items-center w-full gap-7 relative top-[] ">
    <div class="flex items-center content-center gap-5 p-4 pt-[50px]">
        
        <h1 class="text-4xl">Admin Protectora</h1>
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
  
      <!-- Tabla de protectoras -->
    
          
          <?php 
              
              if (isset($_GET['buscador']) && $_GET['buscador'] == 1)
              {
                $correo = $_GET['correo'];
                $protectoras = filtroProtectorasAdmin($correo);
                
              }
              else
              {
                $protectoras = obtenerProtectoras();
              }
              echo "<div class='px-4 py-2 border w-full grid grid-cols-1 lg:grid-cols-2 gap-2'>";
              foreach ($protectoras as $protectora) 
              {
                $carpeta =  "multimedia/protectoras/".$protectora['UniqueID']."/perfil/";
                $imagenPerfil = glob($carpeta . '*');
               
                echo "<div class='grid grid-cols-1 lg:grid-cols-2 gap-2 bg-black/50 text-white text-[20px] rounded-lg'>";
                echo "<div class='col-span-1 lg:col-span-2 xl:col-span-3 flex items-center'>";
                echo "<img class='w-full h-[400px] object-cover object-center rounded-lg' src='".$imagenPerfil[0]."' alt='Imagen de la protectora'>";
                echo "</div>";
                echo "<div class='col-span-1  flex items-center'>";
                  echo "<p class='px-4 py-2 font-bold text-pink-200'>Nombre: </p>";
                  echo "<p>".htmlspecialchars($protectora['Nombre']) . "</p>";
                echo "</div>";
                echo "<div class='col-span-1 lg:col-span-2 flex items-center'>";
                echo "<p class='px-4 py-2 font-bold text-pink-200'>Correo: </p>";
                echo "<p>" . htmlspecialchars($protectora['Correo']) . "</p>";
                echo "</div>";
                echo "<div class='col-span-1 flex items-center'>";
                echo "<p class='px-4 py-2 font-bold text-pink-200'>Ubicacion: </p>";
                echo "<p>" . htmlspecialchars($protectora['Ubicacion']) . "</p>";
                echo "</div>";
                echo "<div class='col-span-1 flex items-center'>";
                echo "<p class='px-4 py-2 font-bold text-pink-200'>activa: </p>";
                echo "<p>" . ($protectora['activa'] == 1 ? "Si " : "No ") . 
                "<form action='' method='post' >";
                echo "<div class='flex gap-2 p-4'>";
                echo "<input type='hidden' name='id_protectora' value='" . $protectora['UniqueID'] . "'>";
                echo "<input type='hidden' name='activa' value='" . $protectora['activa'] . "'>";
                echo "<button type='submit' " . ($protectora['activa'] == 1 ? "class='text-black px-2 py-1 bg-[#DB3066] hover:bg-[#DB3066]/80 rounded-lg'" : "class='text-black px-2 py-1 bg-[#54B5BE] hover:bg-[#54B5BE]/80 rounded-lg'") . " >".($protectora['activa'] == 1 ? "desactivar" : "activar")."</button>";
                echo "</div>";
                echo "</form>";
                echo "</p>";
                echo "</div>";
                echo "<div class='lg:col-span-2 xl:col-span-3 flex flex-col '>";
                echo "<p class=' font-bold px-4  text-pink-200'>Descripcion: </p>";
                echo "<p class='col-span-3 pl-4'>" . htmlspecialchars($protectora['Informacion']) . "</p>";
                echo "</div>";
                echo "<div class='col-span-1 flex'>";
                echo "<form action='' method='post' >";
                echo "<input type='hidden' name='id_protectora' value='" . $protectora['UniqueID'] . "'>";
                echo "<input type='hidden' name='borrar' value='1'>";
                echo "<div class='flex gap-2 p-4'>";
                echo "<button type='submit' class='p-2 bg-[#DB3066] hover:bg-[#DB3066]/80 text-white rounded-lg'><span class='material-symbols-outlined scale-150'>
              delete
              </span></button>";
                echo "<a href='modificarProtectora.php?id=" . $protectora['UniqueID'] . "' class='p-2 bg-[#54B5BE] hover:bg-[#54B5BE]/80 text-white rounded-lg'><span class='material-symbols-outlined scale-150'>
              edit
              </span></a>";
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
