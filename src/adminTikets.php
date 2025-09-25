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
    <main class="items-center w-[90%] gap-7 relative pl-6 flex flex-col justify-center">
    <main class="items-center w-full gap-7 relative top-[] ">
    <div class="flex items-center content-center gap-5 p-4">
        
        <h1 class="text-4xl">Admin Usuarios</h1>
    </div>
   
   <hr class="w-full p-4">
   <?php 
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Ticketusuario']))
    {
        $id = $_POST['Ticketusuario'];
        $estado = $_POST['modificar'];
        if($estado == 0)
        {
            modificarEstadoTicketU($id,1);
        }
        else
        {
            modificarEstadoTicketU($id,0);
        }
        header("Location: adminTikets.php");
        exit();
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Ticketprotectora']))
    {
        $id = $_POST['Ticketprotectora'];
        $estado = $_POST['modificar'];
        if($estado == 0)
        {
            modificarEstadoTicketP($id,1);
        }
        else
        {
            modificarEstadoTicketP($id,0);
        }
        header("Location: adminTikets.php");
        exit();
    }
	    require 'navAdmin.php';

    ?>
   <hr>
  <form action="" method="post">
    <label for="tipo">Tipo</label>
    <select name="tipo" id="tipo">
      <option class="text-black" value="usuarios">usuarios</option>
      <option class="text-black" value="protectoras">protectoras</option>
    </select>
    <label for="nombre">Descripción</label>
  <input class="border border-gray-300 rounded p-2" type="text" name="nombre" id="nombre">
  <button type="submit" class="bg-[#54B5BE] hover:bg-[#54B5BE]/80 p-2 rounded-lg mt-4">Buscar</button>
</form>
  <div class="overflow-x-auto">
        
          <?php 
              
               
              if($_SERVER['REQUEST_METHOD'] === 'POST')
              {
                  $nombre = $_POST['nombre'];
                  $tipo = $_POST['tipo'];
                  $cantidad = 0;
                  $usuarios = filtroTicketsU($nombre);
                  $protectoras = filtroTicketsP($nombre);
                  if($tipo == "usuarios")
                  {
                    echo "<div class='px-4 py-2 w-full grid grid-cols-1 lg:grid-cols-2  gap-4  text-white text-[20px] rounded-lg'>";
                    foreach ($usuarios as $usuario) 
                    {
                      $cantidad = count($usuarios);
                      if ($usuario['Estado'] == 1) {
                       $estado = "TERMINADO";
                      }else{
                        $estado = "EN PROCESO";
                      }
                      $us = obtenerUsuarioid($usuario['IDUsuario']);
                      echo "<div class='px-4 py-2 flex flex-col border lg:grid lg:grid-cols-2 gap-2 bg-black/50 text-white text-[20px] rounded-lg'>";
                      
                      echo "<div class='col-span-1 flex flex-col lg:flex-row items-center'>";
                      echo "<p class='px-4 py-2 font-bold text-pink-200'>Nombre: </p>";
                      echo "<p class='px-4 py-2 '>" . htmlspecialchars($us['Nombre']) . "</p>";
                      echo "</div>";
                      echo "<div class='col-span-1 flex flex-col lg:flex-row items-center'>";
                      echo "<p class='px-4 py-2 font-bold text-pink-200'>Tipo: </p>";
                      echo "<p class='px-4 py-2 '>" . htmlspecialchars($usuario['Tipo']) . "</p>";
                      echo "</div>";
                      echo "<div class='col-span-1 flex flex-col lg:flex-row items-center'>";
                      echo "<p class='px-4 py-2 font-bold text-pink-200'>Estado: </p>";
                      echo "<p class='px-4 py-2 '>" . htmlspecialchars($estado) . "</p>";
                      echo "</div>";
                      echo "<form action='' method='post'>
                      <input type='hidden' name='Ticketusuario' value='".$usuario['UniqueID']."'>
                      <button type='submit' name='modificar' value='".$usuario['Estado']."' " . ($usuario['Estado'] == 0 ? "class='text-black px-2 py-1 bg-[#54B5BE] hover:bg-[#54B5BE]/80 rounded-lg'" : "class='text-black px-2 py-1 bg-[#DB3066] hover:bg-[#DB3066]/80 rounded-lg'") . " >".($usuario['Estado'] == 0 ? "cerrar" : "abrir")."</button>
                      </form>";
                      echo "<div class='col-span-1 flex flex-col lg:flex-row items-center cols-span-1 lg:col-span-2 xl:col-span-3'>";
                      echo "<p class='px-4 py-2 font-bold text-pink-200 '>Descripcion: </p>";
                      echo "<p class='px-4 py-2 '>" . htmlspecialchars($usuario['Descripcion']) . "</p>";
                      echo "</div>";
                      echo "<div class='col-span-1 flex flex-col lg:flex-row items-center cols-span-1 lg:col-span-2 xl:col-span-3'>";
                      echo "<p class='px-4 py-2 font-bold text-pink-200'>Fecha: </p>";
                      echo "<p class='px-4 py-2 '>" . htmlspecialchars($usuario['Fecha']) . "</p>";
                      echo "</div>";
                     
                      
                      echo "</div>";
                    }
                  }
                  else
                  {
                    echo "<div class='px-4 py-2 w-full grid grid-cols-1 lg:grid-cols-2  gap-4  text-white text-[20px] rounded-lg'>";
                    foreach ($protectoras as $protectora) 
                    {
                        $cantidad = count($protectoras);
                        if ($protectora['Estado'] == 1) {
                          $estado = "TERMINADO";
                          }else{
                            $estado = "EN PROCESO";
                          }
                       
                        $pro = obtenrprotectoraPorID($protectora['IDProtectora']);
                        echo "<div class='px-4 py-2 flex flex-col border lg:grid lg:grid-cols-2 gap-2 bg-black/50 text-white text-[20px] rounded-lg'>";
                      
                      echo "<div class='col-span-1 flex flex-col lg:flex-row items-center'>";
                      echo "<p class='px-4 py-2 font-bold text-pink-200'>Nombre: </p>";
                      echo "<p class='px-4 py-2 '>" . htmlspecialchars($pro['Nombre']) . "</p>";
                      echo "</div>";
                      echo "<div class='col-span-1 flex flex-col lg:flex-row items-center'>";
                      echo "<p class='px-4 py-2 font-bold text-pink-200'>Tipo: </p>";
                      echo "<p class='px-4 py-2 '>" . htmlspecialchars($protectora['Tipo']) . "</p>";
                      echo "</div>";
                      echo "<div class='col-span-1 flex flex-col lg:flex-row items-center'>";
                      echo "<p class='px-4 py-2 font-bold text-pink-200'>Estado: </p>";
                      echo "<p class='px-4 py-2 '>" . htmlspecialchars($estado) . "</p>";
                      echo "</div>";
                      echo "<form action='' method='post'>
                      <input type='hidden' name='Ticketprotectora' value='".$protectora['UniqueID']."'>
                      <button type='submit' name='modificar' value='".$protectora['Estado']."' " . ($protectora['Estado'] == 0 ? "class='text-black px-2 py-1 bg-[#54B5BE] hover:bg-[#54B5BE]/80 rounded-lg'" : "class='text-black px-2 py-1 bg-[#DB3066] hover:bg-[#DB3066]/80 rounded-lg'") . " >".($protectora['Estado'] == 0 ? "cerrar" : "abrir")."</button>
                      </form>";
                      echo "<div class='col-span-1 flex flex-col lg:flex-row items-center cols-span-1 lg:col-span-2 xl:col-span-3'>";
                      echo "<p class='px-4 py-2 font-bold text-pink-200 '>Descripcion: </p>";
                      echo "<p class='px-4 py-2 '>" . htmlspecialchars($protectora['Descripcion']) . "</p>";
                      echo "</div>";
                      echo "<div class='col-span-1 flex flex-col lg:flex-row items-center cols-span-1 lg:col-span-2 xl:col-span-3'>";
                      echo "<p class='px-4 py-2 font-bold text-pink-200'>Fecha: </p>";
                      echo "<p class='px-4 py-2 '>" . htmlspecialchars($protectora['Fecha']) . "</p>";
                      echo "</div>";
                     
                      
                      echo "</div>";
   
                      }
                    }
                    if($cantidad <= 0)
                    {
                     
                      echo "<p class='px-4 py-2 border'>No se han encontrado resultados</p>";
                    }
                  }
                  echo "</div>";
                  
                  
              
             
              
          ?>
      
      </div>

  </main>
</body>
</html>












