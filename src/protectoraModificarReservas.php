<?php 
        require 'head.php';
        require 'sesion.php';
        require 'bd.php';
        comprobar_sesion_protectora();
        
?> 

  <?php 
	  require 'nav.php';
      $idReserva = $_GET['id'];

   if ($_SERVER['REQUEST_METHOD'] === 'POST') 
   {
    $bd = conection();
    $fechaHora = $_POST['fechaHora'] ?? '';
    $tipo = $_POST['tipo'] ?? '';
    
    $stmt = $bd->prepare("UPDATE reservas SET FechaHora = ?, Tipo = ? WHERE UniqueID = ?");
    $stmt->execute([$fechaHora, $tipo, $idReserva]);
    
    header("Location: protectoraReservas.php");
   }

  
   $reserva = obtenerReserva($idReserva);

  ?>

  <main class="items-center w-[90%] gap-7 relative pl-6 flex flex-col justify-center">
  
   
  <form action="" class="max-w-sm mx-auto bg-gray-800 p-6 rounded-lg shadow-md w-full gap-3 flex flex-col" method="POST" enctype="multipart/form-data">
       <label for="fechaHora">Fecha hora</label>
       <input type="datetime-local" name="fechaHora" id="fechaHora" value="<?php echo $reserva['FechaHora']; ?>" required>
       <label for="tipo">Tipo</label>
       <select name="tipo" id="tipo" value="<?php echo $reserva['Tipo']; ?>" required>
        <option value="visita" class="bg-gray-700">Visita</option>
        <option value="puertas abiertas" class="bg-gray-700">Puertas abiertas</option>
        <option value="voluntariado" class="bg-gray-700">Voluntariado</option>
       </select>
       <button type="submit" class="w-full bg-[#54B5BE] hover:bg-[#54B5BE]/80 text-white font-bold py-2 px-4 rounded">Actualizar reserva</button>
    </form>

 

  </main>
</body>
</html>
