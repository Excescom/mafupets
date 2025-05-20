<body class="dark:bg-black dark:text-white ">
<header class="sticky top-0 p-4 z-20 ">
    <img class="h-[80px]" src="../favicon.ico" alt="">
    <p class="text-right w-[90%] top-0 absolute pt-4"> 
    <?php 
    // Verificar si la sesión está iniciada y mostrar el nombre del usuario od e la protectora
    if (isset($_SESSION['Usuario']) && isset($_SESSION['Usuario']['Nombre'])) {
        echo $_SESSION['Usuario']['Nombre']; 
    } else if (isset($_SESSION['Protectora']) && isset($_SESSION['Protectora']['Nombre'])) {
        echo $_SESSION['Protectora']['Nombre'];
    } else {
        echo "Sesión no iniciada";
    }
    ?> 
    </p>
    <nav class="w-20 fixed left-0 z-20 dark:bg-black/50 bg-white/50 rounded-2xl">
      <ul class="space-y-4 flex flex-col items-center ">
        <li>
            <button id="menu-button">
              <span id="icono"  class="pt-3 material-symbols-outlined scale-150 transition-transform duration-300 ease-in-out " title="abrir/cerrar menú">
                menu
              </span>
            </button>
        </li>
        <li>
          <ul id="menu" class="hidden gap-3" >
            <li>
              <a title="perfil" href="config.php">
                <span class="material-symbols-outlined scale-150">
                account_circle
                </span>
              </a>
            </li>
            <?php 
            if(!isset($_SESSION['Protectora'])){
            ?>
            <li><a href="index.php">
              <span class="material-symbols-outlined scale-150" title="inicio">
                home
              </span>
              </a>
            </li>
            <?php 
            }
            ?>
           <?php 
            if(!isset($_SESSION['Protectora'])){
            ?>
            <li>
              <a href="listaAnimales.php">
                <span class="material-symbols-outlined scale-150" title="lista animales">
                  checklist
                </span>
              </a>
            </li>
            <?php 
            }
            ?>
            
            <?php 
            if(!isset($_SESSION['Protectora'])){
            ?>
            <li>
              <a title="buscador de protectoras" href="buscador.php">
                <span class="material-symbols-outlined scale-150">
                  pets
                </span>
              </a>
            </li>
            <?php 
            }
            ?>

            <li>
              <a title="cerrar sesión / iniciar sesión" href="confirmacionCerrarSesion.php">
              <span class="material-symbols-outlined scale-150">
                logout
              </span>
              </a>
            </li>
          </ul> 
        </li>
      </ul>
    </nav>  
  </header>



  <?php 
       echo '<script src="sriptsJS/oscuro.js"></script>';
       echo '<script src="sriptsJS/menu.js"></script>';
    ?> 
  
