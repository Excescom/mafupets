<?php 
        require 'head.php';
        require 'bd.php';
        session_start();
        $bd = conection();
?> 

  <?php 
	  require 'nav.php';
    
    $usuario = obtenerUsuarioPorCorreo($_SESSION['Usuario']['Correo']);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $tipo = $_POST['tipo'];
      $descripcion = $_POST['descripcion'];
     crearTicketUsuarios($tipo,$descripcion,$usuario['UniqueID']);
     header("Location: crearTicketUsuarios.php");
     exit;
    }
    
  ?>
  <main class="flex flex-col items-center w-full gap-4 relative top-[-20px]">
<h1 class="text-4xl p-4">Crear Ticket</h1>
 <?php 
      if(isset($_SESSION['Usuario']))
      {
        ?>
        <form action="" class="max-w-sm mx-auto bg-gray-800 p-6 rounded-lg shadow-md w-full gap-3 flex flex-col" method="POST">
       tipo
       <select name="tipo" id="tipo">
        <option class="text-black" value="Solicitud">Solicitud</option>
        <option class="text-black" value="Queja">Queja</option>
        <option class="text-black" value="Reclamo">Reclamo</option>
        <option class="text-black" value="Otro">Otro</option>
       </select>
       Descripcion
       <textarea placeholder="Si la solicitud es sobre un animal, describe el animal, nombre y protectora si es posible" name="descripcion" id="descripcion" cols="30" rows="10" class="border px-3 py-2 rounded-md text-sm"></textarea>
  
      <button type="submit" class="w-full bg-[#EDB439] hover:bg-[#EDB439]/80 text-white font-bold p-2 px-4 rounded">
              Crear Ticket
        </button>
      </form>
      <?php
      }
      else if(isset($_SESSION['Protectora']))
      {
        

       header("Location: index.php");
       exit;
      }
      else
      {
        header("Location: debesInicarSesion.php");
        exit;
      }
      
 ?>   

  </main>
  <script src="sriptsJS/validarImagenes.js"></script>
</body>
</html>
