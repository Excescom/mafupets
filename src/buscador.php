<?php 
 
        require 'head.php';    
        session_start(); 
?> 

  <?php 
	  require 'nav.php';
      require 'bd.php';
      $nombre = "";
      $protectoras = obtenerProtectoras();
      $animales = obtenerTodosAnimales();
  ?>



  <main class="items-center w-[90%] gap-7 relative pl-6 flex flex-col justify-center">
  <form action="" method="post">
    <label for="tipo">Tipo</label>
    <select name="tipo" id="tipo">
      <option class="text-black" value="protectoras">protectoras</option>
      <option class="text-black" value="animales">animales</option>
    </select>
    <label for="nombre">Nombre</label>
  <input class="border border-gray-300 rounded p-2" type="text" name="nombre" id="nombre">
  <button type="submit" class="bg-blue-500 hover:bg-blue-600 p-2 rounded-lg mt-4">Buscar</button>
</form>
  <div class="overflow-x-auto bg-black/50 ">
        
          <?php 
              
               
              if($_SERVER['REQUEST_METHOD'] === 'POST')
              {
                  $nombre = $_POST['nombre'];
                  $tipo = $_POST['tipo'];
                  $nombre = $_POST['nombre'];
                  $cantidad = 0;
                  $animales = filtroAnimales($nombre);
                  $protectoras = filtroProtectoras($nombre);
                  if($tipo == "animales")
                  {
                    
                    foreach ($animales as $animal) 
                    {
                      $cantidad = count($animales);
                      echo "<div class=' p-4 border rounded '>";
                      echo "<p class='px-4 py-2 border'>" . htmlspecialchars($animal['Nombre']) . "</p>";
                      echo "<p class='px-4 py-2 border'>" . htmlspecialchars($animal['Especie']) . "</p>";
                      echo "<p class='px-4 py-2 border'>" . htmlspecialchars($animal['Descripcion']) . "</p>";
                      echo "<div class='p-4 flex text-center items-center justify-center w-full border'>";
                      echo "<a class='w-full p-4 bg-[#54B5BE] hover:bg-[#54B5BE]/80 hover:text-white hover:cursor-pointer rounded' href='indexAnimales.php?id=" . $animal['UniqueID'] . "'>Ver animal</a>";
                      echo "</div>";
                      echo "</div>";
                    }
                  }
                  else
                  {
                    foreach ($protectoras as $protectora) 
                    {
                      if ($protectora['activa'] == 1)
                      {
                        $cantidad = count($protectoras);
                        echo "<div class='p-4 border rounded'>";
                        echo "<p class='px-4 py-2 border'>" . htmlspecialchars($protectora['Nombre']) . "</p>";
                        echo "<p class='px-4 py-2 border'>" . htmlspecialchars($protectora['Informacion']) . "</p>";
                        echo "<div class='p-4 flex text-center items-center justify-center w-full border'>";
                        echo "<a class='w-full p-4 bg-[#54B5BE] hover:bg-[#54B5BE]/80 hover:text-white hover:cursor-pointer rounded' href='indexProtectora.php?id=" . $protectora['UniqueID'] . "'>Ver protectora</a>";
                        echo "</div>";
                        echo "</div>";
                      }
                    }
                    if($cantidad <= 0)
                    {
                     
                      echo "<p class='px-4 py-2 border'>No se han encontrado resultados</p>";
                    }
                  }
                  
                  
              }
             
              
          ?>
      
      </div>

  </main>
</body>
</html>
