<?php 
        require 'bd.php';
        require 'sesion.php';

        require 'head.php';
?> 

<?php 
    require 'nav.php'; 
    $sesion = comprobar_sesion();

    if($sesion  == true)
    {
        session_destroy();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        $correo = $_POST['email'] ?? '';
        $contrasenia = $_POST['password'] ?? '';
        //usuario tiene todos los campos del usuario
        $usuario =comprobarUsuario($correo,$contrasenia);
        if($usuario == false)
        {
            echo "<div class='text-center text-red-500'>Usuario no encontrado / correo o contraseña incorrectos</div>";
        }
        else
        {
            $_SESSION['Usuario'] = $usuario;
            if ($_SESSION['Usuario']['Admin']) 
            {
                $_SESSION['Admin'] = 1;
                header("Location: admin.php");
                exit;
            }
            else 
            {
                $_SESSION['Admin'] = 0;
                header("Location: index.php");
                exit;
            }
            return;
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
        <a href="registroUsuarios.php" class="block w-full bg-[#54B5BE] hover:bg-[#54B5BE]/80 text-white font-bold p-2 px-4 rounded text-center">
            Registrarse
        </a>
        <a href="loginProtectora.php" class="block w-full bg-[#DB3066] hover:bg-[#DB3066]/80 text-white font-bold p-2 px-4 rounded text-center">
            Protectora
        </a>
    </form>
  </main>



</body>
</html>
