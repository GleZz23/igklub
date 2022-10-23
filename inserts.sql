INSERT INTO centro VALUES
  ('1', 'I.E.S. Miguel de Unamuno B.H.I.'),
  ('2', 'CIFP Txurdinaga LHII');

INSERT INTO libro (titulo, escritor, portada, edad_media, nota_media) VALUES 
  ('Malaherba', 'Jabois, Manuel', '1.jpg', 17, 3),
  ('Las Lágrimas de Shiva', 'Mallorquí del Corral, César', '2.jpg', 12, 5),
  ('Harry Potter', 'Rowling, J.K.', '3.jpg', 12, 4),
  ('Los Futbolisimos', 'Santiago, Roberto', '4.jpg', 10, 3),
  ('Cruzada en Jeans', 'Beckman, Thea', '5.jpg', 13, 3),
  ('My Hero Academia', 'Horikoshi, Kohei', '6.jpg', 13, 5),
  ('Charlie y La Fábrica De Chocolate', 'Dahl, Roald', '7.jpg', 11, 4),
  ('Diario de Anne Frank', 'Frank, Anne', '8.jpg', 12, 5),
  ('El Hobbit', 'Tolkien, J.R.R.', '9.jpg', 14, 4);

INSERT INTO solicitud_libro (id_libro, estado) VALUES
  (1, 'aceptado'),
  (2, 'aceptado'),
  (3, 'aceptado'),
  (4, 'aceptado'),
  (5, 'aceptado'),
  (6, 'aceptado'),
  (7, 'aceptado'),
  (8, 'aceptado'),
  (9, 'aceptado');

UPDATE `libro` SET `sinopsis` = '«La primera vez que papá murió todos pensamos que estaba fingiendo.» <br> Así empieza Malaherba de Manuel Jabois. Un día Mr. Tamburino, Tambu, un niño de diez años, se encuentra a su padre tirado en la habitación y conoce a Elvis, un nuevo compañero de su clase. Descubrirá por primera vez el amor y la muerte, pero no de la forma que él cree. Y los dos, Tambu y Elvis, vivirán juntos los últimos días de la niñez, esos en los que aún pasan cosas que no se pueden explicar y sentimientos a los que todavía no se sabe poner nombre. <br> Esta es una historia de dos niños que viven una extraña y solitaria historia de amor. Un libro sobre las cosas terribles que se hacen con cariño, escrito con humor y una prosa rápida que avanza llevando a Tambu y su hermana Rebe, a Claudia y su hermano Elvis, a la frontera de un mundo nuevo. <br> «Bien sabe Dios que es más peligrosa la pena que el odio, porque el odio puede destruir lo que odias, pero la pena lo destruye todo.»' WHERE `libro`.`id_libro` = 1;
UPDATE `libro` SET `sinopsis` = 'En cierta ocasión, hace ya mucho tiempo, vi un fantasma. Sí, un espectro, una aparición, un espíritu; lo puedes llamar como quieras, el caso es que lo vi. Ocurrió el mismo año en que el hombre llegó a la Luna y, aunque hubo momentos en los que pasé mucho miedo, esta historia no es lo que suele llamarse una novela de terror. --Todo comenzó con un enigma: el misterio de un objeto muy valioso que estuvo perdido durante siete décadas. Las Lágrimas de Shiva, así se llamaba ese objeto extraviado. A su alrededor tuvieron lugar venganzas cruzadas, y amores prohibidos, y extrañas desapariciones.--Hubo un fantasma, sí, y un viejo secreto oculto en las sombras, pero también hubo mucho más.' WHERE `libro`.`id_libro` = 2;
UPDATE `libro` SET `sinopsis` = '«Con las manos temblorosas, Harry le dio la vuelta al sobre y vio un sello de lacre púrpura con un escudo de armas: un león, un águila, un tejón y una serpiente, que rodeaban una gran letra H.» <br> Harry Potter nunca ha oído hablar de Hogwarts hasta que empiezan a caer cartas en el felpudo del número 4 de Privet Drive. Llevan la dirección escrita con tinta verde en un sobre de pergamino amarillento con un sello de lacre púrpura, y sus horripilantes tíos se apresuran a confiscarlas. Más tarde, el día que Harry cumple once años, Rubeus Hagrid, un hombre gigantesco cuyos ojos brillan como escarabajos negros, irrumpe con una noticia extraordinaria: Harry Potter es un mago, y le han concedido una plaza en el Colegio Hogwarts de Magia y Hechicería. ¡Está a punto de comenzar una aventura increíble!' WHERE `libro`.`id_libro` = 3;
UPDATE `libro` SET `sinopsis` = 'El equipo de fútbol 7 Soto Alto no es solo el equipo de fútbol del colegio. Es mucho más. Nosotros hemos hecho un pacto: nada ni nadie nos separará nunca. Siempre jugaremos juntos. Pase lo que pase. Así que cuando pasó lo que pasó no tuvimos más remedio que actuar. Preparamos nuestro material de investigadores... y nos lanzamos a la aventura. Por algo somos los Futbolísimos.' WHERE `libro`.`id_libro` = 4;
UPDATE `libro` SET `sinopsis` = 'Una emocionante novela de aventuras ambientada en la Edad Media. Imagina que la máquina del tiempo en la que viajas te transporta a un lugar que no deseas.Y que cuando estás a punto de conseguir volver a casa, una cruzada de niños se interpone en tu camino. Es exactamente lo que le sucede a Rudolf Hefting. Perdido en una época que no es la suya, no le queda más remedio que unirse a la expedición. En vaqueros, por supuesto. ' WHERE `libro`.`id_libro` = 5;
UPDATE `libro` SET `sinopsis` = 'Estamos en un mundo donde abundan los superhéroes (y los supervillanos). Los mejores humanos son entrenados en la Academia de Héroes para optimizar sus poderes. <br> Entre la minoría normal, sin poder alguno, aparece Izuku Midoriya, dispuesto a ser una excepción y formarse en la Academia.' WHERE `libro`.`id_libro` = 6;
UPDATE `libro` SET `sinopsis` = 'Charlie y la fábrica de chocolate es una historia de Roald Dahl, el gran autor de literatura infantil. El señor Wonka, dueño de la magnífica fábrica de chocolate, ha escondido cinco billetes de oro en sus chocolatinas. Quienes los encuentren serán los elegidos para visitar la fábrica. Charlie tiene la fortuna de encontrar uno de esos billetes y, a partir de ese momento, su vida cambiará para siempre.' WHERE `libro`.`id_libro` = 7;
UPDATE `libro` SET `sinopsis` = 'Tras la invasión de Holanda, los Frank, comerciantes judíos alemanes emigrados a Amsterdam en 1933, se ocultaron de la Gestapo en una buhardilla anexa al edificio donde el padre de Anne tenía sus oficinas. Ocho personas permanecieron recluidas desde junio de 1942 hasta agosto de 1944, fecha en que fueron detenidas y enviadas a campos de concentración. Desde su escondite y en las más precarias condiciones, Anne, una niña de trece años, escribió su estremecedor Diario: un testimonio único en su género sobre el horror y la barbarie nazi, y sobre los sentimientos y experiencias de la propia Anne y sus acompañantes. Anne murió en el campo de Bergen-Belsen en marzo de 1945. Su Diario nunca morirá.' WHERE `libro`.`id_libro` = 8;
UPDATE `libro` SET `sinopsis` = 'Smaug parecía profundamente dormido cuando Bilbo espió una vez más desde la entrada. ¡Pero fingía! ¡Estaba vigilando la entrada del túnel!... Sacado de su cómodo agujero-hobbit por Gandalf y una banda de enanos, Bilbo se encuentra de pronto en medio de una conspiración que pretende apoderarse del tesoro de Smaug el Magnífico, un enorme y muy peligroso dragón...' WHERE `libro`.`id_libro` = 9;