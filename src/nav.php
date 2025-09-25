<html class="h-full">
<body class="min-h-screen bg-black text-white bg-fixed bg-gradient-to-br from-[#3b8087] to-[gray]/50 text-white">
<header class="sticky top-0 p-4 z-20  bg-black">
    <a href="index.php?contador=0" class="inline-block bg-black"><img class="h-[80px]" src="../favicon.ico" alt=""></a>
    <p class="text-right w-[90%] top-0 absolute pt-4"> 
    <?php 
    // Verificar si la sesión está iniciada y mostrar el nombre del usuario o de la protectora
    if (isset($_SESSION['Usuario']) && isset($_SESSION['Usuario']['Nombre'])) {
      echo '<a class="z-[200] bg-black/50 p-2 rounded" href="confirmacionCerrarSesion.php">'.$_SESSION['Usuario']['Nombre']. '<span class="pl-2 center material-symbols-outlined scale-100">logout</span>'.'</a>'; 
  } else if (isset($_SESSION['Protectora']) && isset($_SESSION['Protectora']['Nombre'])) {
      echo '<a class="z-[200] bg-black/50 p-2 rounded" href="confirmacionCerrarSesion.php">'.$_SESSION['Protectora']['Nombre']. '<span class="pl-2 center material-symbols-outlined scale-100">logout</span>'.'</a>';
  } else {
      echo '<a class="z-[200]" href="confirmacionCerrarSesion.php">Sesión no iniciada</a>';
  }
    ?> 
    </p>
    <nav class="w-28 fixed left-0 z-20 bg-black/5 rounded-2xl z-[100] text-white z-[200] bg-black/50">
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
              <a class="flex flex-col items-center gap-2" title="perfil" href="config.php">
                <span class="material-symbols-outlined scale-150">
                settings
                </span>
                configuración
              </a>
            </li>
            
            <li><a class="flex flex-col items-center gap-2 " title="inicio" href="index.php?contador=0">
              <span class="material-symbols-outlined scale-150" title="inicio">
                home
              </span>
              inicio
              </a>
            </li>
            
           <?php 
            if(!isset($_SESSION['Protectora'])){
            ?>
            <li>
              <a class="flex flex-col items-center gap-2" title="lista animales" href="listaAnimales.php">
                <span class="material-symbols-outlined scale-150" title="lista animales">
                  checklist
                </span>
                lista animales
              </a>
            </li>
            <?php 
            }
            ?>
            
            <?php 
            if(!isset($_SESSION['Protectora'])){
            ?>
            <li>
              <a class="flex flex-col items-center gap-2" title="buscador de protectoras" href="buscador.php">
                <span class="material-symbols-outlined scale-150">
                  pets
                </span>
                buscador
              </a>
            </li>
            <?php 
            }
            ?>
             <?php 
            if(isset($_SESSION['Usuario']['Admin']) && $_SESSION['Usuario']['Admin']==1)
            {
            ?>
            <li>
              <a class="flex flex-col items-center gap-2" title="administración" href="admin.php">
              <span class="material-symbols-outlined scale-150">
              admin_panel_settings
              </span>
              <p class="text-center">administración</p>
              </a>
            </li>
            <?php 
            }
            ?>

            <li>
              <a class="flex flex-col items-center gap-2" title="cerrar sesión / iniciar sesión" href="confirmacionCerrarSesion.php">
              <span class="material-symbols-outlined scale-150">
                logout
              </span>
              <p class="text-center">cerrar / iniciar sesión</p>
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
  
