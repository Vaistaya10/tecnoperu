CREATE DATABASE tecnoperu;
use tecnoperu;

-- Catalogo de producos, marcas y sus especificaciones
create table marcas(
id 			int 		auto_increment primary key,
marca 		varchar(40) not null,
creado 		datetime 	not null default now(),
modificado 	datetime 	null,
constraint uk_narca_mar unique (marca)
)engine = innodb;

create table productos(
id 		int 		auto_increment primary key,
idmarca 	int 	not null,
tipo 	varchar(40) not null,
descripcion 	varchar(70) 	not null,
precio 		decimal(7,2) 	not null,
garantia 	tinyint 		not null default 6,
esnuevo 	ENUM('S','N') 	not null default 'S' COMMENT 'Estado del producto',
creado	 	datetime 		not null default now(),
modificado datetime 		null,
constraint fk_idmarca_prd 	foreign key (idmarca) references marcas(id)
)engine = innodb;

create table especificaciones (
id 		int 		auto_increment primary key,
especificacion varchar(40) not null,
creado	 	datetime 		not null default now(),
modificado datetime 		null,
constraint uk_especificacion_esp unique (especificacion)
)engine = innodb;

create table bloques(
id 		int auto_increment primary key,
idproducto 	int 	not null,
bloque varchar(40) not null,
creado	 	datetime 		not null default now(),
modificado datetime 		null,
constraint fk_idproducto_blq foreign key (idproducto) references productos (id),
constraint uk_bloque_blq unique (idproducto, bloque)
)engine = innodb;

create table caracteristicas(
id 		int auto_increment primary key,
idbloque int not null,
idespecificacion int not null,
valor varchar(40) not null,
creado	 	datetime 		not null default now(),
modificado datetime 		null,
constraint fk_idbloque_car foreign key (idbloque) references bloques (id),
constraint fk_idespecificacion_car foreign key (idespecificacion) references especificaciones (id)
)engine = innodb;

-- Objetos DB
-- Tablas: Contenedores
-- Vistas: Consultas con nombre (tablas en memoria)
-- Procedimientos almacenados: programas(I/O), algoritmos
-- Desencadenadores (triggers): evento (accion automatica)
-- Funciones: tarea recurrente


insert into marcas (marca) values
('Samsung'),
('Lenovo'),
('Epson');

Insert into productos (idmarca, tipo, descripcion, precio) values
(1,'Smartphont','A51',1000),
(1,'Laptop','Gamer RGB',4000),
(1,'Impresora','L500',750);

-- Requerimiento:
-- Cuando se cambie cualquier dato de cualquier registro, se debera actualizar el campo "modificado"
DELIMITER //
create trigger productos_actualizar_fecha_modificacion
BEFORE UPDATE ON productos
FOR EACH ROW
BEGIN
-- update => (1) eliminar > (2) crear
 SET NEW.modificado = NOW(); -- 
END //


DELIMITER //
create trigger caracteristicas_actualizar_fecha_modificacion
BEFORE UPDATE ON caracteristicas
FOR EACH ROW
BEGIN
 SET NEW.modificado = NOW(); -- 
END //

create view vs_productos_todos
as
select 
	P.id,
    M.marca,
    P.tipo,
    P.descripcion,
    P.precio,
    P.garantia,
    P.esnuevo
 from productos P 
inner join marcas M on P.idmarca = M.id;
