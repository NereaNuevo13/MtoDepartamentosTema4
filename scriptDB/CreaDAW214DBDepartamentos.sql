/* Creación de la Base de Datos */
    CREATE DATABASE if NOT EXISTS DAW214DBDepartamentos;
    
/* Creación del usuario */
    CREATE USER IF NOT EXISTS 'usuarioDAW214DBDepartamentos'@'%' identified BY 'paso'; 
    
/* Usar la base de datos creada */
    USE DAW214DBDepartamentos;

/* Creación de la table departamento */
CREATE TABLE IF NOT EXISTS Departamento (
    CodDepartamento CHAR(3) PRIMARY KEY,
    DescDepartamento VARCHAR(255) NOT NULL,
    FechaBaja DATE NULL,
    VolumenNegocio float NULL
)  ENGINE=INNODB;

/* Dar permisos al usuario creado */
    GRANT ALL PRIVILEGES ON DAW214DBDepartamentos.* TO 'usuarioDAW214DBDepartamentos'@'%'; 