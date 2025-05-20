<?php 
        require 'bd.php';
        require 'sesion.php';

        require 'head.php';
?> 

<?php 
    require 'nav.php';
    $sesion = comprobar_sesion();

    if($sesion == true)
    {
        session_destroy();
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = $_POST['email'] ?? '';
            $contrasenia = $_POST['password'] ?? '';
            //usuario tiene todos los campos del usuario
            $protectora = comprobarProtectora($correo,$contrasenia);
            if($protectora == false)
            {
                echo "<div class='text-center text-red-500'>Protectora no encontrada / correo o contraseña incorrectos</div>";
            }
            else
            {
                if (!isset($_SESSION)) {
                    session_start();
                }
                
                if ($protectora['activa'] == 1) 
                {
                    $_SESSION['Protectora'] = $protectora;
                    header("Location: protectoraInicio.php");
                    exit;
                }
                else 
                {
                    echo "<div class='text-center text-red-500'>Esta protectora no está activa. Contacte con el administrador.</div>";
                }
            }
        }
?>

  <main class="flex flex-col justify-center items-center w-full gap-4 relative pt-[50px] p-2">
    <form action="" class="max-w-sm mx-auto bg-gray-800 p-6 rounded-lg shadow-md w-full gap-3 flex flex-col" method="POST">
        <label class="block text-gray-300 text-sm font-semibold mb-2" for="email">Correo</label>
        <input type="email" id="email" name="email" required
            class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        
        <label class="block text-gray-300 text-sm font-semibold mb-2" for="password">Contraseña</label>
        <input type="password" id="password" name="password" required
            class="w-full p-2 mb-4 border border-gray-600 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
    
        <button type="submit" class="w-full bg-[#54B5BE] hover:bg-[#54B5BE]/80 text-white font-bold py-2 px-4 rounded">
            Inicar sesión
        </button>
        <a href="registroProtectora.php" class="block w-full bg-[#54B5BE] hover:bg-[#54B5BE]/80 text-white font-bold p-2 px-4 rounded text-center">
            Registrarse
        </a>
    </form>
  </main>



</body>
</html>
