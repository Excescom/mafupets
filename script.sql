
CREATE DATABASE IF NOT EXISTS mafupets;
USE mafupets;

-- Tabla: Usuarios
CREATE TABLE Usuarios (
    UniqueID INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(255),
    Apellidos VARCHAR(255),
    Telefono VARCHAR(9) UNIQUE,
    Correo VARCHAR(255) UNIQUE,
    Contrasena VARCHAR(255),
    Admin BOOLEAN
);

-- Tabla: Protectoras
CREATE TABLE Protectoras (
    UniqueID INT AUTO_INCREMENT PRIMARY KEY,
    Correo VARCHAR(255)UNIQUE,
    Contrasena VARCHAR(255),
    Nombre VARCHAR(255),
    Ubicacion VARCHAR(255),
    activa BOOLEAN,
    Informacion VARCHAR(255)
);

-- Tabla: TelefonosProtectoras
CREATE TABLE TelefonosProtectoras (
    UniqueID INT AUTO_INCREMENT PRIMARY KEY,
    IDProtectora INT,
    Numero VARCHAR(20),
    FOREIGN KEY (IDProtectora) REFERENCES Protectoras(UniqueID) ON DELETE CASCADE
);

-- Tabla: Animales
CREATE TABLE Animales (
    UniqueID INT AUTO_INCREMENT PRIMARY KEY,
    IDProtectora INT,
    Nombre VARCHAR(255),
    Especie VARCHAR(255),
    Peso FLOAT,
    Discapacidad BOOLEAN,
    Descripcion VARCHAR(255),
    FOREIGN KEY (IDProtectora) REFERENCES Protectoras(UniqueID) ON DELETE CASCADE
);

-- Tabla: Multimedias
CREATE TABLE Multimedias (
    UniqueID INT AUTO_INCREMENT PRIMARY KEY,
    IDAnimal INT,
    Enlace VARCHAR(255),
    FOREIGN KEY (IDAnimal) REFERENCES Animales(UniqueID) ON DELETE CASCADE
);

-- Tabla: Publicidades
CREATE TABLE Publicidades (
    UniqueID INT AUTO_INCREMENT PRIMARY KEY,
    Enlace VARCHAR(255)
);

-- Tabla: MultimediasPublicidades
CREATE TABLE MultimediasPublicidades (
    UniqueID INT AUTO_INCREMENT PRIMARY KEY,
    IDPublicidad INT,
    Enlace VARCHAR(255),
    FOREIGN KEY (IDPublicidad) REFERENCES Publicidades(UniqueID)
);

-- Tabla: Reservas
CREATE TABLE Reservas (
    UniqueID INT AUTO_INCREMENT PRIMARY KEY,
    IDProtectora INT,
    FechaHora DATETIME,
    Tipo ENUM('visita', 'puertas abiertas', 'voluntariado'),
    FOREIGN KEY (IDProtectora) REFERENCES Protectoras(UniqueID)
);

-- Tabla: UsuariosReservas (relación N:M)
CREATE TABLE UsuariosReservas (
    IDUsuario INT,
    IDReserva INT,
    UsuariosReservas BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (IDUsuario, IDReserva),
    FOREIGN KEY (IDUsuario) REFERENCES Usuarios(UniqueID) ON DELETE CASCADE,
    FOREIGN KEY (IDReserva) REFERENCES Reservas(UniqueID) ON DELETE CASCADE
);



-- Tabla: favoritos (relación N:M)
CREATE TABLE Favoritos (
    IDAnimal INT,
    IDUsuario INT,
    PRIMARY KEY (IDAnimal, IDUsuario),
    FOREIGN KEY (IDAnimal) REFERENCES Animales(UniqueID) ON DELETE CASCADE,
    FOREIGN KEY (IDUsuario) REFERENCES Usuarios(UniqueID) ON DELETE CASCADE
);


-- Tabla: TiketsUsuarios
CREATE TABLE TiketsUsuarios (
    UniqueID INT AUTO_INCREMENT PRIMARY KEY,
    IDUsuario INT,
    Tipo VARCHAR(255),
    Fecha DATETIME,
    Estado BOOLEAN,
    Descripcion VARCHAR(255),
    FOREIGN KEY (IDUsuario) REFERENCES Usuarios(UniqueID) ON DELETE CASCADE
);

-- Tabla: TiketsProtectoras
CREATE TABLE TiketsProtectoras (
    UniqueID INT AUTO_INCREMENT PRIMARY KEY,
    IDProtectora INT,
    Tipo VARCHAR(255),
    Fecha DATETIME,
    Estado BOOLEAN,
    Descripcion VARCHAR(255),
    FOREIGN KEY (IDProtectora) REFERENCES Protectoras(UniqueID) ON DELETE CASCADE
);

-- Tabla: Comentarios (relación N:M)
CREATE TABLE Comentarios (
    IDUsuario INT,
    IDAnimal INT,
    Comentario VARCHAR(255),
    PRIMARY KEY (IDUsuario, IDAnimal),
    FOREIGN KEY (IDUsuario) REFERENCES Usuarios(UniqueID) ON DELETE CASCADE,
    FOREIGN KEY (IDAnimal) REFERENCES Animales(UniqueID) ON DELETE CASCADE
);
