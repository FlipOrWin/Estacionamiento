CREATE DATABASE IF NOT EXISTS estacionamiento;
USE estacionamiento;

CREATE TABLE registros (
    id INT AUTO_INCREMENT NOT NULL,
    placa VARCHAR(255),
    entrada VARCHAR(255),
    salida VARCHAR(255) NULL,
    tipo VARCHAR(255),
    pago INT,
    duracion VARCHAR(255),
    PRIMARY KEY (id)
) ENGINE=InnoDB;