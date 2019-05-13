CREATE TABLE `tipousuario` (
  `idtipousuario` int(11) NOT NULL,
  `tipo` varchar(25) DEFAULT NULL,
  `descripcion` text,
  PRIMARY KEY (`idtipousuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT  INTO `tipousuario`(`idtipousuario`,`tipo`,`descripcion`) VALUES
(1,'ADMINISTRADOR','DESCRIPCIÓN ADMINISTRADOR'),
(2,'ENCUESTADOR','DESCRIPCIÓN ENCUESTADOR');

/*Table structure for table `usuario` */
DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `paterno` varchar(50) DEFAULT NULL,
  `materno` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `ntelefono` varchar(20) DEFAULT NULL,
  `idtipousuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`idusuario`),
  CONSTRAINT `tipousuario_ibfk_1` FOREIGN KEY (`idtipousuario`) REFERENCES `tipousuario` (`idtipousuario`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Data for the table `usuario` */
INSERT  INTO `usuario`(`idusuario`,`nombre`,`paterno`,`materno`,`email`,`ntelefono`,`idtipousuario`) VALUES
(1,'Juan','Administrador','',NULL,NULL,1),
(2,'Juan','Autoridad','Educativa',NULL,NULL,2);


/*Table structure for table `seguridad` */
DROP TABLE IF EXISTS `seguridad`;

CREATE TABLE `seguridad` (
  `username` varchar(50) DEFAULT NULL,
  `clave` varchar(100) DEFAULT NULL,
  `estatus` tinyint(1) DEFAULT NULL,
  `idusuario` int(1) DEFAULT NULL,
  KEY `idusuario` (`idusuario`),
  CONSTRAINT `seguridad_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `seguridad` */
INSERT  INTO `seguridad`(`username`,`clave`,`estatus`,`idusuario`) VALUES
('admin','43e6dce366e0a0729d38266840d0e004',1,1),
('autoridad1','43e6dce366e0a0729d38266840d0e004',1,2);



/*Table structure for table `encuesta` */
DROP TABLE IF EXISTS `encuesta`;

CREATE TABLE `encuesta` (
  `idencuesta` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) DEFAULT NULL,
  `idtipoaplicar` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idencuesta`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Data for the table `encuesta` */

insert  into `encuesta`(`idencuesta`,`descripcion`,`idtipoaplicar`) values
(1,'Encuesta 1',1);


/*Table structure for table `pregunta` */
DROP TABLE IF EXISTS `pregunta`;

CREATE TABLE `pregunta` (
  `idpregunta` INT(11) NOT NULL AUTO_INCREMENT,
  `pregunta` VARCHAR(255) DEFAULT NULL,
  `idtipopregunta` TINYINT(1) DEFAULT NULL,
  `idencuesta` INT(11) DEFAULT NULL,
  `npregunta` TINYINT(6) DEFAULT NULL,
  PRIMARY KEY (`idpregunta`),
  KEY `idencuesta` (`idencuesta`),
  CONSTRAINT `pregunta_ibfk_1` FOREIGN KEY (`idencuesta`) REFERENCES `encuesta` (`idencuesta`) ON UPDATE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


/*Data for the table `pregunta` */

INSERT  INTO `pregunta`(`idpregunta`,`pregunta`,`idtipopregunta`,`idencuesta`,`npregunta`) VALUES
(1,'Años de servicio',2,1,1),
(2,'Formación',2,1,2),
(3,'¿Conoce los resultados de su escuela en PLANEA 2016?¿Cuáles son?',3,1,3),
(4,'¿A qué factores atribuye esos resultados?',2,1,4),
(5,'¿Recibió apoyo por parte de la SEPP para mejorar el desempeño académico de sus alumnos? (información, talleres, visitas, etc.)',1,1,5),
(6,'¿Asistió al taller de fortalecimiento académico?',1,1,6),
(7,'¿Le avisaron con anticipación que deberia asistir al Taller?',1,1,7),
(8,'¿En el Taller conoció con claridad la Estrategia Estatal?',1,1,8),
(9,'¿El facilitador dominó los contenidos que se trataron?',1,1,9),
(10,'¿Se resolvieron sus dudas o inquietudes respecto a la Estrategia Estatal?',1,1,10),
(11,'¿En el Taller aprendió a analizar los resultados de la prueba PLANEA?',1,1,11),
(12,'¿En el Taller aprendió cómo diseñar una estrategia para apoyar',1,1,12),
(13,'¿Conoció a su escuela monitor?',1,1,13),
(14,'¿Sabe cuál es la función de su escuela monitor?',1,1,14),
(15,'En general, ¿asistir al Taller le fue útil?',1,1,15);


CREATE TABLE pregunta_complemento (
 idpregunta INT(11) NOT NULL AUTO_INCREMENT,
 complemento VARCHAR(100) NOT  NULL,
 orden TINYINT(6) DEFAULT NULL,
 FOREIGN KEY (idpregunta) REFERENCES pregunta(idpregunta) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=INNODB;


INSERT INTO pregunta_complemento(idpregunta, complemento, orden) VALUES (3, 'SI', 1), (3, 'NO', 2);





/* Table structure for table `aplicar` */
DROP TABLE IF EXISTS `aplicar`;

CREATE TABLE `aplicar` (
  `idaplicar` INT(11) NOT NULL AUTO_INCREMENT,
  `idusuario` INT(11) DEFAULT NULL,
  `fcreacion` DATETIME DEFAULT NULL,
  PRIMARY KEY (`idaplicar`),
  KEY `idusuario` (`idusuario`),
  CONSTRAINT `aplicar_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON UPDATE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

insert into aplicar(idaplicar,idusuario,fcreacion) values(1,2,now());


/*Table structure for table `respuesta` */

DROP TABLE IF EXISTS `respuesta`;

CREATE TABLE `respuesta` (
  `idrespuesta` int(11) NOT NULL AUTO_INCREMENT,
  `idpregunta` int(11) DEFAULT NULL,
  `respuesta` char(2) DEFAULT NULL,
  `complemento` varchar(255) DEFAULT NULL,
  `idaplicar` int(11) DEFAULT NULL,
  PRIMARY KEY (`idrespuesta`),
  KEY `idpregunta` (`idpregunta`),
  KEY `idaplicar` (`idaplicar`),
  CONSTRAINT `respuesta_ibfk_1` FOREIGN KEY (`idpregunta`) REFERENCES `pregunta` (`idpregunta`) ON UPDATE CASCADE,
  CONSTRAINT `respuesta_ibfk_2` FOREIGN KEY (`idaplicar`) REFERENCES `aplicar` (`idaplicar`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Data for the table `respuesta` */

insert  into `respuesta`(`idrespuesta`,`idpregunta`,`respuesta`,`complemento`,`idaplicar`) values
(1,1,NULL,'1',1),
(2,2,'si',NULL,1),
(3,3,'si','sdfghjk',1),
(4,4,NULL,'a mi',1),
(5,5,'si',NULL,1),
(6,6,'si','sdfghjkl',1),
(7,7,'si','sdfghjk',1),
(8,8,'no',NULL,1),
(9,9,NULL,'no',1),
(10,10,'si','zsdfgm,',1),
(11,11,'si','zxfghjkk',1),
(12,12,NULL,'no se',1),
(13,13,NULL,'quien sabe',1),
(14,14,NULL,'2',1),
(15,15,NULL,'lic',1);
