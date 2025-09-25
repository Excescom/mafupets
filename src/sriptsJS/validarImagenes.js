function validartamanio() {
    const input = document.getElementById('imagen');
    const alerta = document.getElementById('alerta');
    const formatosPermitidos = ["jpg", "jpeg", "png", "webp"];
    const archivo = input.files[0];
    const tipoarchivo = archivo.name.split('.').pop().toLowerCase();
    const tamanoMaximoMB = 40; // 40MB
    const tamanoMaximoBytes = tamanoMaximoMB * 1024 * 1024; // Convertir a bytes
    
    if (archivo && archivo.size > tamanoMaximoBytes) {
        alerta.innerHTML = `El archivo es demasiado grande. Tamaño máximo permitido: ${tamanoMaximoMB}MB`;
        input.value = ''; // Limpia el campo de archivo
        return false; // Detiene el envío del formulario
    }
    if (!formatosPermitidos.includes(tipoarchivo)) {
        alerta.innerHTML = `Formato de archivo no permitido. Formatos permitidos: ${formatosPermitidos.join(', ')} y el archivo no puede permitir un punto en el nombre`;
        input.value = ''; // Limpia el campo de archivo
        return false; // Detiene el envío del formulario
    }
    return true; // Permite el envío del formulario
}

function validartamaniomultimedia() {
    const input = document.getElementById('multimedia');
    const alerta = document.getElementById('alerta');
    const formatosPermitidos = ["mp4", "webm", "ogg","mov","mkv","jpg", "jpeg", "png", "webp"];
    const archivo = input.files[0];
    const tipoarchivo = archivo.name.split('.').pop().toLowerCase();
    const tamanoMaximoMB = 40; // 40MB
    const tamanoMaximoBytes = tamanoMaximoMB * 1024 * 1024; // Convertir a bytes
    
    if (archivo && archivo.size > tamanoMaximoBytes) {
        alerta.innerHTML = `El archivo es demasiado grande. Tamaño máximo permitido: ${tamanoMaximoMB}MB`;
        input.value = ''; // Limpia el campo de archivo
        return false; // Detiene el envío del formulario
    }
    if (!formatosPermitidos.includes(tipoarchivo)) {
        alerta.innerHTML = `Formato de archivo no permitido. Formatos permitidos: ${formatosPermitidos.join(', ')}, y el archivo no puede permitir un punto en el nombre`;
        input.value = ''; // Limpia el campo de archivo
        return false; // Detiene el envío del formulario
    }
    return true; // Permite el envío del formulario
}