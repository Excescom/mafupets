<?php 
        require 'head.php';
        session_start();
?> 

  <?php 
	  require 'nav.php';
    require 'bd.php';
    
  ?>

<?php 
    if(!isset($_SESSION['Protectora'])){
      header("Location: login.php");
      exit;
    } 
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['telefono']))
    {
        $telefono = $_POST['telefono'];
        $protectora = obtenerProtectoraCorreo($_SESSION['Protectora']['Correo']);
        $protectora['Telefono'] = $telefono;
        aniadirnumeroProtectora($protectora['UniqueID'],$telefono);
        header("Location: configTelefono.php");
        exit;
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar']))
    {
        $numero = $_POST['eliminar'];
        eliminarnumeroProtectora($numero);
        header("Location: configTelefono.php");
        exit;
    }
    $numeros = obtenerNumerosContactoProtectora($_SESSION['Protectora']['UniqueID']);
?>
  <main class="flex flex-col items-center w-full gap-4 relative pt-[30px] ">
   <form action="" method="post">
    <label for="telefono">Telefono</label>
    <input min="100000000" max="999999999" class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" type="number" id="telefono" name="telefono">
    <button class="bg-[#54B5BE] hover:bg-[#54B5BE]/80 text-white font-bold p-2 px-4 rounded" type="submit">añadir</button>
   </form>
   <div>
    <?php foreach ($numeros as $numero) { ?>
        <div class="flex items-center gap-2 bg-gray-700 p-2 rounded">
            <p><?php echo $numero['Numero']; ?></p>
            <form action="" method="post">
                <button class="bg-[#DB3066] hover:bg-[#DB3066]/80 text-white font-bold p-2 px-4 rounded" type="submit" name="eliminar" value="<?php echo $numero['UniqueID']; ?>">Eliminar</button>
            </form>
        </div>
    <?php } ?>
   </div>
  </main>
</body>
</html>
