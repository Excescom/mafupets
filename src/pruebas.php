<?php 
        require 'head.php';
        session_start();
?> 

  <?php 
	  require 'nav.php';
      require 'bd.php';
  ?>
  <main class="items-center w-[80%] gap-7 relative top-[] pl-6 left-[80px]">
  <div class="overflow-x-auto w-full max-w-5xl">
        <table class="w-full bg-white border border-gray-300 rounded-lg shadow">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2 border">Usuario</th>
                    <th class="px-4 py-2 border">Animal</th>
                    <th class="px-4 py-2 border">Comentario</th>
                </tr>
            </thead>
            <tbody class="text-center text-black " >
                <?php 
                    $comentarios = obtenerComentarios();

                    foreach ($comentarios as $comentario) {
                        echo "<tr class='hover:bg-gray-50'>";
                        echo "<td class='px-4 py-2 border'>" . htmlspecialchars($comentario['IDUsuario']) . "</td>";
                        echo "<td class='px-4 py-2 border'>" . htmlspecialchars($comentario['IDAnimal']) . "</td>";
                        echo "<td class='px-4 py-2 border'>" . htmlspecialchars($comentario['Comentario']) . "</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>

    <?php
        // Ruta de la carpeta que quieres escanear
        $carpeta = 'multimedia/protectoras/1/1/'; // Asegúrate de que termine en "/"

        // Tipos de imágenes que quieres contar
        $imagenes = glob($carpeta . "*.{jpg,jpeg,png,gif,webp}", GLOB_BRACE);

        // Contar cuántas hay
        $cantidad = count($imagenes);

        echo "Hay $cantidad imágenes en la carpeta.";
    ?>
  </main>
</body>
</html>
