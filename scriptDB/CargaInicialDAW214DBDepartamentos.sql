/* Base de datos a usar */
USE DAW214DBDepartamentos;

/* Introduccion de datos dentro de la tabla creada */
INSERT INTO Departamento(CodDepartamento,DescDepartamento,FechaBaja,VolumenNegocio) VALUES
('INF', 'Departamento de informatica',null,1),
('VEN', 'Departamento de ventas',"2017-06-15",2),
('CON', 'Departamento de contabilidad',"2019-03-03",3),
('COC', 'Departamento de cocina',"2019-10-10",4),
('MEC', 'Departamento de mecanica',null,5),
('MAT', 'Departamento de matematicas',null,6);