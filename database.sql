drop database if exists igklub_database;
create database igklub_database default character set utf8mb4 default collate utf8mb4_general_ci;
use igklub_database;

-- TABLA CENTRO
create table if not exists centro(
  id_centro int(5) auto_increment primary key,
  nombre varchar(255) not null
);

-- TABLA USUARIO
create table if not exists usuario (
  nickname varchar(255) primary key,
  nombre varchar(255) not null,
  apellidos varchar(255) not null,
  fecha_nacimiento date,
  email varchar(255) not null,
  telefono int(9),
  contrasena varchar(255) not null,
  rol enum('admin', 'irakasle', 'ikasle') not null,
  id_centro int(5),
  cod_grupo char(5),
  imagen varchar(255),
  estado enum('aceptado','denegado','espera') default 'espera' not null,
  foreign key (id_centro) references centro(id_centro) on delete cascade
);

-- TABLA GRUPO
create table if not exists grupo (
  codigo char(5) primary key,
  nombre varchar(20) not null,
  id_centro int(5),
  nivel varchar(10),
  curso varchar(10),
  profesor varchar(255),
  foreign key (profesor) references usuario(nickname) on delete cascade,
  foreign key (id_centro) references centro(id_centro) on delete cascade
);
Alter TABLE usuario add foreign key (cod_grupo) references grupo(codigo) on delete cascade;

-- TABLA LIBRO
create table if not exists libro (
  id_libro int(5) auto_increment primary key,
  titulo varchar(255) not null,
  escritor varchar(255) not null,
  sinopsis varchar(2300),
  formato enum('Nobela','Komikia','Nobela grafikoa','Manga') not null,
  etiqueta varchar(255),
  portada varchar(255),
  edad_media int(2) unsigned default 0,
  num_lectores int unsigned default 0,
  nota_media int(1) unsigned default 0
);

-- TABLA COMENTARIO
create table if not exists comentario (
  id_comentario int(5) auto_increment primary key,
  nickname varchar(255),
  id_libro int(5),
  mensaje varchar(2300) not null,
  fecha datetime,
  estado enum('aceptado','denegado','espera') default 'espera' not null,
  foreign key (nickname) references usuario(nickname) on delete cascade,
  foreign key (id_libro) references libro(id_libro) on delete cascade
);

-- TABLA IDIOMA
create table if not exists idioma (
  id_idioma int(5) auto_increment primary key,
  nombre varchar(255)
);

-- TABLA VALORACION
create table if not exists valoracion (
  id_valoracion int(5) auto_increment primary key,
  nickname varchar(255),
  nota int unsigned not null,
  edad int(2) unsigned not null,
  idioma int(5),
  id_comentario int(5),
  id_libro int(5),
  fecha datetime,
  estado enum('aceptado','denegado','espera') default 'espera' not null,
  foreign key (nickname) references usuario(nickname) on delete cascade,
  foreign key (id_comentario) references comentario(id_comentario) on delete cascade,
  foreign key (idioma) references idioma(id_idioma) on delete cascade
);

-- TABLA SOLICITUD LIBRO
create table if not exists solicitud_libro (
  nickname varchar(255),
  id_libro int(5),
  estado enum('aceptado','denegado','espera') default 'espera' not null,
  foreign key (id_libro) references libro(id_libro) on delete cascade,
  foreign key (nickname) references usuario(nickname) on delete cascade
);

-- TABLA SOLICITUD IDIOMA
create table if not exists solicitud_idioma (
  nickname varchar(255),
  idioma varchar(255),
  id_libro int(5),
  titulo varchar(255) not null,
  estado enum('aceptado','denegado','espera') default 'espera' not null,
  foreign key (nickname) references usuario(nickname) on delete cascade,
  foreign key (id_libro) references libro(id_libro) on delete cascade
);

-- TABLA IDIOMA LIBRO
create table if not exists idioma_libro (
  libro int(5),
  idioma int(5),
  titulo varchar(255) not null,
  foreign key (libro) references libro(id_libro) on delete cascade,
  foreign key (idioma) references idioma(id_idioma) on delete cascade
);

-- TABLA RESPUESTA
create table if not exists respuesta (
  id_comentario int(5),
  id_respuesta int(5) auto_increment primary key,
  nickname varchar(255),
  id_libro int(5),
  mensaje varchar(2300) not null,
  fecha datetime,
  estado enum('aceptado','denegado','espera') default 'espera' not null,
  foreign key (nickname) references usuario(nickname) on delete cascade,
  foreign key (id_libro) references libro(id_libro) on delete cascade,
  foreign key (id_comentario) references comentario(id_comentario) on delete cascade
);

-- CENTROS
INSERT INTO centro VALUES
  ('1', 'I.E.S. Miguel de Unamuno B.H.I.'),
  ('2', 'CIFP Txurdinaga LHII');

-- USUARIO
INSERT INTO usuario (`nickname`, `nombre`, `apellidos`, `fecha_nacimiento`, `email`, `telefono`, `contrasena`, `rol`, `id_centro`, `cod_grupo`, `estado`, `imagen`) VALUES
  ('Admin', 'Administrador', 'de Prueba', '2000-01-01', 'admin@mail.com', NULL, '$2y$10$SZU5HY0RmiNkvpl7rOoPkeERGKXk0bTNZJoBDTAdzR.VYYEHuZx8q', 'admin', NULL, NULL, 'aceptado', 'Admin.png'),
  ('Admin2', 'Administrador', 'de Prueba Segundo', '2000-01-01', 'admin2@mail.com', NULL, '$2y$10$SZU5HY0RmiNkvpl7rOoPkeERGKXk0bTNZJoBDTAdzR.VYYEHuZx8q', 'admin', NULL, NULL, 'aceptado', 'Admin.png'),
  ('Profesor', 'Profesor', 'de Prueba', '2000-01-01', 'profesor@mail.com', 911111111, '$2y$10$SZU5HY0RmiNkvpl7rOoPkeERGKXk0bTNZJoBDTAdzR.VYYEHuZx8q', 'irakasle', 2, NULL, 'espera', 'Profesor.png'),
  ('Alumno', 'Alumno', 'de Prueba', '2000-01-01', 'alumno@mail.com', NULL, '$2y$10$SZU5HY0RmiNkvpl7rOoPkeERGKXk0bTNZJoBDTAdzR.VYYEHuZx8q', 'ikasle', 2, NULL, 'espera', NULL);

-- LIBROS
INSERT INTO libro (titulo, escritor, portada) VALUES 
  ('Malaherba', 'Manuel Jabois', '1.jpg'),
  ('Las Lágrimas de Shiva', 'César Mallorquí del Corral', '2.jpg'),
  ('Harry Potter', 'J.K. Rowling', '3.jpg'),
  ('Los Futbolisimos', 'Roberto Santiago', '4.jpg'),
  ('Cruzada en Jeans', 'Thea Beckman', '5.jpg'),
  ('My Hero Academia', 'Kohei Horikoshi', '6.jpg'),
  ('Charlie y La Fábrica De Chocolate', 'Roald Dahl', '7.jpg'),
  ('Diario de Anne Frank', 'Anne Frank', '8.jpg'),
  ('El Hobbit', 'J.R.R. Tolkien', '9.jpg');

UPDATE `libro` SET `sinopsis` = '«La primera vez que papá murió todos pensamos que estaba fingiendo.» <br> Así empieza Malaherba de Manuel Jabois. Un día Mr. Tamburino, Tambu, un niño de diez años, se encuentra a su padre tirado en la habitación y conoce a Elvis, un nuevo compañero de su clase. Descubrirá por primera vez el amor y la muerte, pero no de la forma que él cree. Y los dos, Tambu y Elvis, vivirán juntos los últimos días de la niñez, esos en los que aún pasan cosas que no se pueden explicar y sentimientos a los que todavía no se sabe poner nombre. <br> Esta es una historia de dos niños que viven una extraña y solitaria historia de amor. Un libro sobre las cosas terribles que se hacen con cariño, escrito con humor y una prosa rápida que avanza llevando a Tambu y su hermana Rebe, a Claudia y su hermano Elvis, a la frontera de un mundo nuevo. <br> «Bien sabe Dios que es más peligrosa la pena que el odio, porque el odio puede destruir lo que odias, pero la pena lo destruye todo.»' WHERE `libro`.`id_libro` = 1;
UPDATE `libro` SET `sinopsis` = 'En cierta ocasión, hace ya mucho tiempo, vi un fantasma. Sí, un espectro, una aparición, un espíritu; lo puedes llamar como quieras, el caso es que lo vi. Ocurrió el mismo año en que el hombre llegó a la Luna y, aunque hubo momentos en los que pasé mucho miedo, esta historia no es lo que suele llamarse una novela de terror. --Todo comenzó con un enigma: el misterio de un objeto muy valioso que estuvo perdido durante siete décadas. Las Lágrimas de Shiva, así se llamaba ese objeto extraviado. A su alrededor tuvieron lugar venganzas cruzadas, y amores prohibidos, y extrañas desapariciones.--Hubo un fantasma, sí, y un viejo secreto oculto en las sombras, pero también hubo mucho más.' WHERE `libro`.`id_libro` = 2;
UPDATE `libro` SET `sinopsis` = '«Con las manos temblorosas, Harry le dio la vuelta al sobre y vio un sello de lacre púrpura con un escudo de armas: un león, un águila, un tejón y una serpiente, que rodeaban una gran letra H.» <br> Harry Potter nunca ha oído hablar de Hogwarts hasta que empiezan a caer cartas en el felpudo del número 4 de Privet Drive. Llevan la dirección escrita con tinta verde en un sobre de pergamino amarillento con un sello de lacre púrpura, y sus horripilantes tíos se apresuran a confiscarlas. Más tarde, el día que Harry cumple once años, Rubeus Hagrid, un hombre gigantesco cuyos ojos brillan como escarabajos negros, irrumpe con una noticia extraordinaria: Harry Potter es un mago, y le han concedido una plaza en el Colegio Hogwarts de Magia y Hechicería. ¡Está a punto de comenzar una aventura increíble!' WHERE `libro`.`id_libro` = 3;
UPDATE `libro` SET `sinopsis` = 'El equipo de fútbol 7 Soto Alto no es solo el equipo de fútbol del colegio. Es mucho más. Nosotros hemos hecho un pacto: nada ni nadie nos separará nunca. Siempre jugaremos juntos. Pase lo que pase. Así que cuando pasó lo que pasó no tuvimos más remedio que actuar. Preparamos nuestro material de investigadores... y nos lanzamos a la aventura. Por algo somos los Futbolísimos.' WHERE `libro`.`id_libro` = 4;
UPDATE `libro` SET `sinopsis` = 'Una emocionante novela de aventuras ambientada en la Edad Media. Imagina que la máquina del tiempo en la que viajas te transporta a un lugar que no deseas.Y que cuando estás a punto de conseguir volver a casa, una cruzada de niños se interpone en tu camino. Es exactamente lo que le sucede a Rudolf Hefting. Perdido en una época que no es la suya, no le queda más remedio que unirse a la expedición. En vaqueros, por supuesto. ' WHERE `libro`.`id_libro` = 5;
UPDATE `libro` SET `sinopsis` = 'Estamos en un mundo donde abundan los superhéroes (y los supervillanos). Los mejores humanos son entrenados en la Academia de Héroes para optimizar sus poderes. <br> Entre la minoría normal, sin poder alguno, aparece Izuku Midoriya, dispuesto a ser una excepción y formarse en la Academia.' WHERE `libro`.`id_libro` = 6;
UPDATE `libro` SET `sinopsis` = 'Charlie y la fábrica de chocolate es una historia de Roald Dahl, el gran autor de literatura infantil. El señor Wonka, dueño de la magnífica fábrica de chocolate, ha escondido cinco billetes de oro en sus chocolatinas. Quienes los encuentren serán los elegidos para visitar la fábrica. Charlie tiene la fortuna de encontrar uno de esos billetes y, a partir de ese momento, su vida cambiará para siempre.' WHERE `libro`.`id_libro` = 7;
UPDATE `libro` SET `sinopsis` = 'Tras la invasión de Holanda, los Frank, comerciantes judíos alemanes emigrados a Amsterdam en 1933, se ocultaron de la Gestapo en una buhardilla anexa al edificio donde el padre de Anne tenía sus oficinas. Ocho personas permanecieron recluidas desde junio de 1942 hasta agosto de 1944, fecha en que fueron detenidas y enviadas a campos de concentración. Desde su escondite y en las más precarias condiciones, Anne, una niña de trece años, escribió su estremecedor Diario: un testimonio único en su género sobre el horror y la barbarie nazi, y sobre los sentimientos y experiencias de la propia Anne y sus acompañantes. Anne murió en el campo de Bergen-Belsen en marzo de 1945. Su Diario nunca morirá.' WHERE `libro`.`id_libro` = 8;
UPDATE `libro` SET `sinopsis` = 'Smaug parecía profundamente dormido cuando Bilbo espió una vez más desde la entrada. ¡Pero fingía! ¡Estaba vigilando la entrada del túnel!... Sacado de su cómodo agujero-hobbit por Gandalf y una banda de enanos, Bilbo se encuentra de pronto en medio de una conspiración que pretende apoderarse del tesoro de Smaug el Magnífico, un enorme y muy peligroso dragón...' WHERE `libro`.`id_libro` = 9;

INSERT INTO solicitud_libro (nickname, id_libro, estado) VALUES
  (NULL, 1, 'aceptado'),
  (NULL, 2, 'aceptado'),
  (NULL, 3, 'aceptado'),
  (NULL, 4, 'aceptado'),
  (NULL, 5, 'aceptado'),
  (NULL, 6, 'espera'),
  (NULL, 7, 'espera'),
  (NULL, 8, 'espera'),
  ('Alumno', 9, 'espera');

-- IDIOMAS
INSERT INTO `idioma`(`nombre`) VALUES
  ('Gaztelania'),
  ('Euskera'),
  ('Ingelesa'),
  ('Frantsesa'),
  ('Aleman'),
  ('Ukrainera'),
  ('Errumaniera'),
  ('Txinera');

-- BORRAR DATOS DE ALUMNOS
DROP EVENT IF EXISTS `delete_user`;
CREATE DEFINER=`root`@`localhost` EVENT `desactivate_user`
ON SCHEDULE EVERY 1 YEAR STARTS '2023-06-25 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO
UPDATE usuario SET id_centro = NULL, cod_grupo = NULL WHERE rol = 'ikasle';

-- USUARIO PARA LA BBDD
create user 'igklub'@'%' identified by '655Yj6Rc$F@x';
grant all on igklub_database.* to 'igklub'@'%';