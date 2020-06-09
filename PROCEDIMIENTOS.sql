
--EL SIGUIENTE PROCEDIMIENTO NOS VA A PERMITIR ACTUALIZAR EL REGISTRO DE LAS PERSONAS ASIGNANDOLE LOS SIGUIENTES CAMPOS
DELIMITER $$
CREATE  PROCEDURE up_actualizar_personas (
  IN IN_id_persona INT,
  IN IN_documento VARCHAR(12),
  IN IN_nombre VARCHAR(45), 
  IN IN_apellido_paterno VARCHAR(45),
  IN IN_apellido_materno VARCHAR(45),
  IN IN_fecha_nacimiento DATE,
  IN IN_sexo CHAR(1),
  IN IN_correo VARCHAR(150),
  IN IN_numero VARCHAR(12)
)  BEGIN

    IF IN_id_persona IS NOT NULL AND IN_id_persona != '' THEN 
       IF (SELECT 1 FROM personas WHERE id_persona = IN_id_persona LIMIT 1)  THEN
            UPDATE personas SET
               documento= IN_documento,
               nombre= IN_nombre,
               apellido_paterno= IN_apellido_paterno,
               apellido_materno= IN_apellido_materno,
               fecha_nacimiento= IN_fecha_nacimiento,
               sexo=IN_sexo WHERE 
               id_persona = IN_id_persona;

               IF IN_correo != '' THEN
                  call up_update_correos_persona(IN_correo,IN_id_persona);  
              END IF;

              IF IN_numero != '' THEN
                  call up_update_numero_persona(IN_numero,IN_id_persona);  
              END IF;

        ELSE
            signal sqlstate '45000' set message_text = 'La persona que desea actualizar no existe en el sistema!!!';
        END IF;

    ELSE
          signal sqlstate '45000' set message_text = 'Ingrese los datos de manera correcta!!!';
    END IF;
END $$


--EL SIGUIENTE PROCEDIMIENTO NOS VA A PERMITIR ACTUALIZAR EL REGISTRO DE LOS CORREO DE LAS PERSONAS
DELIMITER $$
CREATE  PROCEDURE up_update_correos_persona (
  IN IN_correo VARCHAR(150),
  IN IN_id_persona INT
)  
BEGIN
  UPDATE correos SET correo = IN_correo WHERE id_persona = IN_id_persona;
END $$


--EL SIGUIENTE PROCEDIMIENTO NOS VA A PERMITIR ACTUALIZAR EL NUMERO DE TELEFONO DE LAS PERSONAS
DELIMITER $$
CREATE  PROCEDURE up_update_numero_persona (
  IN IN_numero VARCHAR(150),
  IN IN_id_persona INT
)  
BEGIN
  UPDATE telefonos SET numero=IN_numero WHERE id_persona = IN_id_persona;
END $$


--EL SIGUIENTE PROCEDIMIENTO NOS VA A LISTAR LOS CORREOS QUE SE ENCUENTRES RELACIONADO A UNA PERSONA
DELIMITER $$
CREATE  PROCEDURE up_listar_correos_id_persona (
  IN IN_id_persona INT
)  
BEGIN

 SELECT * FROM correos WHERE id_persona =  IN_id_persona;

END $$


--EL SIGUIENTE PROCEDIMIENTO NOS VA A PERMITIR LISTAR EL TELEFONO QUE SE ENCUENTREN RELACIONADOS A UNA PERSONA
DELIMITER $$
CREATE  PROCEDURE up_listar_telefono_id_persona (
  IN IN_id_persona INT
)  
BEGIN

 SELECT * FROM telefonos WHERE id_persona =  IN_id_persona;

END $$


--EL SIGUIENTE PROCEDIMIENTO NOS VA A PERMITIR ACTUALIZAR LOS REGISTROS DE LA TABLA "resoluciones"
DELIMITER $$
CREATE  PROCEDURE up_actualizar_resoluciones (
     IN IN_id_resolucion INT,
     IN IN_id_tipo_resolucion INT,
     IN IN_id_concepto INT,
     IN IN_id_estado INT,
     IN IN_proyecto VARCHAR(45), 
     IN IN_id_usuario_ambiente INT,
     IN IN_numero VARCHAR(45),
     IN IN_anio VARCHAR(45),
     IN IN_fecha_emision date
 )  
BEGIN

  IF IN_id_resolucion IS NOT NULL AND IN_id_resolucion != '' THEN 
      IF (SELECT 1 FROM resoluciones WHERE id_resolucion = IN_id_resolucion LIMIT 1)  THEN
      UPDATE resoluciones SET
      id_tipo_resolucion= IN_id_tipo_resolucion,
      id_concepto= IN_id_concepto,
      id_estado= IN_id_estado,
      proyecto= IN_proyecto,
      id_usuario_ambiente = IN_id_usuario_ambiente,
      numero= IN_numero,
      anio= IN_anio,
      fecha_emision = IN_fecha_emision
      WHERE 
      id_resolucion = IN_id_resolucion;
      ELSE

      signal sqlstate '45000' set message_text = 'La resolución que desea actualizar no existe en el sistema!!!';

      END IF;

  ELSE
      signal sqlstate '45000' set message_text = 'Ingrese los datos de manera correcta!!!';
  END IF;

END $$


--EL SIGUIENTE PROCEDIMIENTO NOS VA A PERMITIR ACTUALIZAR EL REGISTRO DE LA TABLA "instituciones"
DELIMITER $$
CREATE PROCEDURE up_actualizar_instituciones(
    IN IN_id_institucion    INT,
    IN IN_cod_modular       VARCHAR(45),
    IN IN_nombre           VARCHAR(45),
    IN IN_nivel            INT
)
BEGIN 

  UPDATE instituciones SET
  id_nivel = IN_nivel,
  cod_modular = IN_cod_modular,
  nombre = IN_nombre
  WHERE id_institucion = IN_id_institucion;

END $$ 


--EL SIGUIENTE PROCEDIMIENTO NOS VA A PERMITIR BUSCAR A LAS PERSONAS MEDIANTE SU ID DE IDENTIFICACION
DELIMITER $$
CREATE  PROCEDURE `up_buscar_persona_id` (IN `IN_id_persona` INT)  BEGIN

    SELECT * FROM personas WHERE  id_persona = IN_id_persona;

     IF IN_id_persona IS NOT NULL AND IN_id_persona != '' THEN 
       IF (SELECT 1 FROM personas WHERE IN_id_persona = IN_id_persona LIMIT 1)  THEN
            SELECT * FROM personas WHERE  idPersona = IN_id_persona;
        ELSE
             signal sqlstate '45000' set message_text = 'Lo siento la persona que busca no existe en el sistema';
        END IF;
    
    ELSE
          signal sqlstate '45000' set message_text = 'Ingrese los datos de manera correcta!!!';
    END IF;

END $$


--EL SIGUIENTE PROCEDIMIENTO NOS VA A PERMITIR BUSCAR A LAS INSTITUCIONES MEDIANTE SU ID DE IDENTIFICACION
DELIMITER $$
CREATE PROCEDURE up_buscar_instituciones_id (
  IN IN_id_institucion INT
) 
BEGIN

   SELECT * FROM instituciones ins 
   INNER JOIN niveles ni on ins.id_nivel = ni.id_nivel 
   WHERE  ins.id_institucion = IN_id_institucion;

END $$


--EL SIGUIENTE PROCEDIMIENTO NOS VA A PERMITIR BUSCAR A LAS PERSONAS MEDIANTE SU NOMBRE Y SU APELLIDO PATERNO Y MATERNO
DELIMITER $$
CREATE  PROCEDURE `up_buscar_persona_nombre_apellidos` ( IN `IN_documento` VARCHAR(12), IN `IN_nombre` VARCHAR(45), 
  IN `IN_apellido_paterno` VARCHAR(45), IN `IN_apellido_materno` VARCHAR(45))  BEGIN

    SELECT * FROM personas 
    WHERE documento = IN_documento or nombre = IN_nombre or apellido_materno = IN_apellido_materno 
          or apellido_paterno = IN_apellido_paterno;

END $$


--EL SIGUIENTE PROCEDIMIENTO NOS VA A PERMITIR DESIGNAR USUARIOS A SUS RESPECTIVOS AMBIENTES
DELIMITER $$
CREATE  PROCEDURE `up_designar_ambientes` (IN `IN_id_usuario` INT, IN `IN_id_ambiente` INT)  BEGIN

    IF IN_id_usuario IS NOT NULL AND IN_id_ambiente != '' THEN 

        INSERT INTO `usuario_ambientes`(`id_usuario`, `id_ambiente`)VALUES (IN_id_usuario,IN_id_ambiente);
    
    ELSE
          signal sqlstate '45000' set message_text = 'Ingrese los datos de manera correcta!!!';
    END IF;

END $$


--EL SIGUIENTE PROCEDIMIENTO NOS VA A PERMITIR REGISTRAR A LAS INSTITUCIONES
DELIMITER $$
CREATE  PROCEDURE `up_registrar_institucion` (
  IN `IN_cod_modular` VARCHAR(45),
  IN `IN_nombre` VARCHAR(45),
  IN `IN_nivel` VARCHAR(45)
)  
BEGIN

	INSERT INTO instituciones (cod_modular, nombre, id_nivel) 
    VALUES (IN_cod_modular, IN_nombre, IN_nivel);

END $$


--EL SIGUIENTE PROCEDIMIENTO NOS VA A PERMITIR REGISTRAR A LAS PERSONAS
DELIMITER $$
CREATE  PROCEDURE up_insert_personas (
  IN IN_documento VARCHAR(12),
  IN IN_nombre VARCHAR(150),
  IN IN_apellido_paterno VARCHAR(70),
  IN IN_apellido_materno VARCHAR(70),
  IN IN_fecha_nacimiento DATE,
  IN IN_sexo CHAR(1),
  IN IN_correo VARCHAR(150),
  IN IN_numero VARCHAR(12)
)  
BEGIN
    DECLARE id_persona int;

    IF IN_documento IS NOT NULL AND IN_documento != '' THEN 
       IF (SELECT 1 FROM personas WHERE documento = IN_documento LIMIT 1)  THEN

               signal sqlstate '45000' set message_text = 'La persona que decea ingresar ya esta registrado en el sistema!!!';

        ELSE
          
        INSERT INTO personas (documento, nombre, apellido_paterno, apellido_materno, fecha_nacimiento, sexo) 
              VALUES (IN_documento, IN_nombre, IN_apellido_paterno, IN_apellido_materno, IN_fecha_nacimiento, IN_sexo);
        
        SET id_persona = LAST_INSERT_ID();

              IF IN_correo != '' THEN
                  call up_insert_correos_persona(IN_correo,id_persona);  
              END IF;

              IF IN_numero != '' THEN
                  call up_insert_numero_persona(IN_numero,id_persona);  
              END IF;  

        END IF;
    
    ELSE
          signal sqlstate '45000' set message_text = 'Ingrese los datos de manera correcta!!!';
    END IF;
END $$


--EL SIGUIENTE PROCEDIMIENTO NOS VA A PERMITIR REGISTRAR CORREOS A LAS PERSONAS
DELIMITER $$
CREATE  PROCEDURE up_insert_correos_persona (
  IN IN_correo VARCHAR(150),
  IN IN_id_persona INT
)  
BEGIN
  INSERT INTO correos(id_persona, correo) VALUES (IN_id_persona,IN_correo); 
END $$


--EL SIGUIENTE PROCEDIMIENTO NOS VA A PERMITIR REGISTRAR UN NUMERO DE TELEFONO A UNA PERSONA
DELIMITER $$
CREATE  PROCEDURE up_insert_numero_persona (
  IN IN_numero VARCHAR(150),
  IN IN_id_persona INT
)  
BEGIN
INSERT INTO telefonos(id_persona, numero) VALUES (IN_id_persona,IN_numero); 
END $$


--EL SIGUIENTE PROCEDIMIENTO NOS VA A PERMITIR REGISTRAR DIFERENTES TIPOS DE ROLES
DELIMITER $$
CREATE  PROCEDURE `up_insert_tipo_rol` (IN `IN_tipo_rol` VARCHAR(150))  BEGIN

    IF (SELECT 1 FROM tipo_roles WHERE 
        tipo_rol = IN_tipo_rol LIMIT 1) THEN
    
     signal sqlstate '45000' set message_text = 'El tipo de rol que desea ingresar ya existe!!!';

    ELSE
          
        INSERT INTO tipo_roles (tipo_rol) 
              VALUES (IN_tipo_rol);  
        END IF;
END $$


--EL SIGUIENTE PROCEDIMIENTO NOS VA A PERMITIR REGISTRAR LAS RESOLUCIONES
DELIMITER $$
CREATE  PROCEDURE `up_registrar_resolucion` (
  IN `IN_id_tipo_resolucion` INT, 
  IN `IN_id_estado` INT,
  IN `IN_id_usuario_ambiente` INT, 
  IN `IN_id_concepto` INT, 
  IN `IN_proyecto` VARCHAR(45), 
  IN `IN_numero` VARCHAR(45), 
  IN `IN_anio` VARCHAR(45), 
  IN `IN_fecha_emision` date, 
  IN `IN_archivo` LONGBLOB
)  
BEGIN

    IF (SELECT 1 FROM resoluciones WHERE 
        id_tipo_resolucion= IN_id_tipo_resolucion AND  numero = IN_numero AND
           anio = IN_anio LIMIT 1) THEN
     signal sqlstate '45000' set message_text = 'La resolucion que desea ingresar ya existe!!!';
    ELSE
      INSERT INTO resoluciones (id_tipo_resolucion, id_estado, id_usuario_ambiente,proyecto,id_concepto, numero, anio,fecha_emision, archivo) 
  VALUES (
      IN_id_tipo_resolucion,
      IN_id_estado,
      IN_id_usuario_ambiente,
      IN_proyecto, 
      IN_id_concepto,
      IN_numero, 
      IN_anio,
      IN_fecha_emision, 
      IN_archivo
);

    END IF;
    
END $$


--EL SIGUIENTE PROCEDIMIENTO NOS VA A PERMITIR REGISTRAR UN NUMERO DE TELEFONO A UNA PERSONA
DELIMITER $$
CREATE  PROCEDURE `up_insert_telefonos` (IN `IN_id_persona` INT, IN `IN_numero` VARCHAR(20))  BEGIN
  INSERT INTO telefonos (id_persona, numero) 
    VALUES (IN_id_persona, IN_numero);
    
END $$


--EL SIGUIENTE PROCEDIMIENTO NOS VA A PERMITIR LISTAR LOS REGISTROS EXISTENTES DEL BUZON DE ENTRADA										
DELIMITER $$
CREATE  PROCEDURE `up_listar_buzon_entradas` ()  BEGIN

SELECT b.id_buzon, b.id_ambiente, r.id_resolucion, r.proyecto,r.id_estado FROM buzon_entradas b 
INNER JOIN resoluciones r on b.id_resolucion = r.id_resolucion 
INNER JOIN conceptos c on r.id_concepto = c.id_concepto WHERE r.id_estado = 3;

END $$


--EL SIGUIENTE PROCEDIMIENTO NOS VA A PERMITIR LISTAR LOS REGISTROS EXISTENTES DEL CONCEPTO 
DELIMITER $$									
CREATE  PROCEDURE `up_listar_conceptos` ()  BEGIN 

SELECT * FROM conceptos;

END $$

			
--EL SIGUIENTE PROCEDIMIENTO NOS VA A PERMITIR LISTAR LOS REGISTROS EXISTENTES DE LOS AMBIENTES   	
DELIMITER $$							
CREATE  PROCEDURE `up_listar_ambientes` ()  BEGIN 
	SELECT id_ambiente,
		   nombre_ambiente
	FROM ambientes;
END $$


--EL SIGUIENTE PROCEDIMIENTO NOS VA A PERMITIR LISTAR LOS REGISTROS EXISTENTES DE LA INSTITUCION 		
DELIMITER $$								
CREATE  PROCEDURE `up_listar_instituciones` (
)  
BEGIN 
	SELECT * FROM instituciones ins INNER JOIN niveles ni on ins.id_nivel = ni.id_nivel;
END $$


--EL SIGUIENTE PROCEDIMIENTO NOS VA A PERMITIR LISTAR LOS REGISTROS EXISTENTES DE LAS PERSONAS
DELIMITER $$							
CREATE  PROCEDURE `up_listar_personas` ()  BEGIN 
	SELECT per.id_persona,
		   per.documento,
           per.nombre,
           per.apellido_paterno,
           per.apellido_materno, 
		   per.fecha_nacimiento, 
           per.sexo
	FROM personas per;
END $$


--EL SIGUIENTE PROCEDIMIENTO NOS VA A PERMITIR BUSCAR A LAS RESOLUCIONES MEDIANTE SU AÑO Y SU NUMERO DE RESOLUCION
DELIMITER $$
CREATE  PROCEDURE `up_buscar_resolucion_anio_tipo_numero` (
  IN `IN_id_tipo_resolucion` INT,
  IN `IN_numero` VARCHAR(250),
  IN `IN_anio` VARCHAR(5)
) 
BEGIN 

SELECT RES.id_resolucion,
       TIR.tipo_resolucion,
           EST.tipo_estado,
           USU.usuario,
       RES.proyecto,     
       CO.concepto,
           RES.numero,
           RES.anio,
           RES.fecha_emision
  FROM resoluciones RES
INNER JOIN tipo_resoluciones TIR ON TIR.id_tipo_resolucion = RES.id_tipo_resolucion
INNER JOIN estados EST ON EST.id_estado = RES.id_estado
INNER JOIN usuario_ambientes USA ON USA.id_usuario_ambiente = RES.id_usuario_ambiente
INNER JOIN ambientes AMB ON AMB.id_ambiente = USA.id_ambiente
INNER JOIN usuarios USU ON USU.id_usuario = USA.id_usuario
INNER JOIN conceptos CO on RES.id_concepto = CO.id_concepto WHERE 
RES.id_tipo_resolucion = IN_id_tipo_resolucion
AND RES.numero = IN_numero
AND RES.anio = IN_anio;

END $$


--EL SIGUIENTE PROCEDIMIENTO VA A PERMITIR INICIAR SESION A LOS USUARIOS
DELIMITER $$
CREATE  PROCEDURE `up_login_usuario` (IN `IN_usuario` VARCHAR(150), IN `IN_contrasenia` VARCHAR(150))  BEGIN 

IF IN_usuario != '' AND IN_contrasenia != '' THEN 

SELECT 
ua.id_usuario_ambiente,
ua.id_ambiente,
p.id_persona, 
p.nombre, 
p.apellido_paterno, 
p.apellido_materno, 
u.id_usuario, 
u.usuario, 
u.contrasenia, 
a.id_ambiente,
p.documento,
GROUP_CONCAT(DISTINCT a.id_ambiente,'-',a.nombre_ambiente ,'-' ,a.id_tipo_rol SEPARATOR ',' ) ambientes
FROM usuarios u INNER JOIN personas p on u.id_persona = p.id_persona 
INNER JOIN usuario_ambientes ua on u.id_usuario = ua.id_usuario
INNER JOIN ambientes a on ua.id_ambiente = a.id_ambiente
where u.usuario = IN_usuario and u.contrasenia = IN_contrasenia GROUP BY u.usuario desc;

ELSE
signal sqlstate '45000' set message_text = 'Ingrese un usuario !';
END IF;

END $$


-- Procedimiento para listar los ambientes con los usuarios
--EL SIGUIENTE PROCEDIMIENTO NOS VA A PERMITIR LISTAR LOS REGISTROS EXISTENTES DE LA TABLA "ambiente_usuarios"
DELIMITER $$
CREATE  PROCEDURE `up_listar_ambiente_usuarios` (
  IN `IN_id_usuario` INT
)  

BEGIN 

IF IN_id_usuario != '' THEN 

SELECT ua.id_usuario_ambiente,ua.id_ambiente,u.id_usuario, u.usuario, u.usuario, u.contrasenia, a.nombre_ambiente FROM usuarios u 
INNER JOIN usuario_ambientes ua on ua.id_usuario = u.id_usuario 
INNER join ambientes a on ua.id_ambiente = a.id_ambiente WHERE u.id_usuario = IN_id_usuario;

ELSE

signal sqlstate '45000' set message_text = 'Ingrese un usuario !';

END IF;

END $$

-- Procedimiento para registrar los ambientes
DELIMITER $$
CREATE  PROCEDURE `up_registrar_ambientes` (IN `IN_id_ambiente` INT, IN `IN_nombre_ambiente` VARCHAR(250))  BEGIN

INSERT INTO ambientes(id_ambiente, nombre_ambiente)
 VALUES (
IN_id_ambiente,
IN_nombre_ambiente
);

END $$

-- Procedimiento para registrar a los usuarios 	
DELIMITER $$											     
CREATE  PROCEDURE `up_registrar_usuarios` (
  IN `IN_id_persona` INT,
  IN `IN_usuario` VARCHAR(250),
  IN `IN_contrasenia` VARCHAR(250)
)  

BEGIN

    IF IN_usuario IS NOT NULL AND IN_usuario != '' AND IN_contrasenia IS NOT NULL AND IN_contrasenia != ''  THEN 

        IF (SELECT 1 FROM personas WHERE id_persona = IN_id_persona  LIMIT 1) THEN

            INSERT INTO `usuarios`(`id_persona`, `usuario`, `contrasenia`) 
            VALUES (IN_id_persona,IN_usuario,IN_contrasenia);

        ELSE
            signal sqlstate '45000' set message_text = 'La persona que desea ingresar no existe!!!';

        END IF;

    ELSE
        signal sqlstate '45000' set message_text = 'Ingrese datos correctos!';
    END IF;

END $$

-- Procedimiento para validar resoluciones  
DELIMITER $$
CREATE  PROCEDURE `up_validar_resoluciones` (IN `IN_id_tipo_resolucion` INT, IN `IN_numero` VARCHAR(45), IN `IN_anio` VARCHAR(45))  BEGIN 
  SELECT * FROM resoluciones
    WHERE id_tipo_resolucion= IN_id_tipo_resolucion AND 
          numero = IN_numero AND
          anio = IN_anio;
END $$

-- Procedimiento para buscar archivos de la tabla resoluciones 	
DELIMITER $$														      
CREATE  PROCEDURE `up_buscar_archivo_resolucion` (IN `_id` INT)  BEGIN

SELECT archivo FROM resoluciones WHERE id_resolucion = _id;

END $$

-- Procedimiento para listar los datos de las resoluciones	
DELIMITER $$														      
CREATE  PROCEDURE `up_listar_resoluciones` ()  BEGIN

SELECT * FROM resoluciones ORDER BY id_resolucion DESC
 LIMIT 10;

END $$

-- Procedimiento para listar los datos de la tabla telefono	
DELIMITER $$													      
CREATE  PROCEDURE `up_listar_telefonos` ()  BEGIN

SELECT * FROM telefonos;

END $$

-- Procedimiento para listar los datos de la tabla tipo resoluciones	
DELIMITER $$														      
CREATE  PROCEDURE `up_listar_tipo_resoluciones` ()  BEGIN

SELECT * FROM tipo_resoluciones;

END $$

-- Procedimiento para listar los datos de la tabla usuarios y ambientes		
DELIMITER $$													      
CREATE  PROCEDURE `up_listar_usuario_ambientes` ()  BEGIN

SELECT a.nombre_ambiente,a.id_ambiente, u.usuario,u.id_usuario,ua.id_usuario_ambiente FROM 
usuario_ambientes ua 
INNER JOIN ambientes a on ua.id_ambiente = a.id_ambiente
INNER JOIN usuarios u on ua.id_usuario = u.id_usuario;

END $$

-- Procedimiento para cambiar el estado a la resolucion   
DELIMITER $$                               
CREATE  PROCEDURE `up_cambiar_estado_resolucion` (
    IN `IN_numero` INT,
    IN `IN_id_tipo_resolucion` INT,
    IN `IN_anio` INT,
    IN `IN_id_estado` INT
)  
BEGIN

    IF (SELECT 1 FROM resoluciones WHERE 
        id_tipo_resolucion= IN_id_tipo_resolucion AND  numero = IN_numero AND
           anio = IN_anio LIMIT 1) THEN
    
    UPDATE resoluciones 
    SET id_estado = IN_id_estado 
    WHERE id_tipo_resolucion= IN_id_tipo_resolucion AND  numero = IN_numero AND anio = IN_anio;


    ELSE
      
      signal sqlstate '45000' set message_text = 'La resolucion que desea ingresar no existe!!!';

    END IF;


END $$

-- Procedimiento para registrar la tabla buzon 			
DELIMITER $$												      
CREATE  PROCEDURE `up_registrar_buzon_usuarios` (IN `IN_id_ambiente` INT, IN `IN_id_estado` INT, IN `IN_id_resolucion` INT)  BEGIN

INSERT INTO buzon_entradas(`id_ambiente`, `id_estado`, `id_resolucion`)
VALUES (IN_id_ambiente,IN_id_estado,IN_id_resolucion);
END $$

-- Procedimiento para registrar la tabla buzon entrada
DELIMITER $$
CREATE  PROCEDURE `up_registrar_buzon_entrada_v1` (
  IN `_id_ambiente` INT, 
  IN `_id_estado` INT, 
  IN `_numero_res` INT,
  IN `_id_tipo_res` INT,
  IN `_anio_res` INT
)  
BEGIN
    DECLARE id_resoluciones INT;

    SELECT id_resolucion INTO id_resoluciones FROM resoluciones 
    WHERE numero = _numero_res AND id_tipo_resolucion = _id_tipo_res AND anio = _anio_res;

    IF id_resoluciones IS NOT NULL AND id_resoluciones > 0 THEN
        INSERT INTO buzon_entradas(`id_ambiente`, `id_estado`, `id_resolucion`)
            VALUES (_id_ambiente,_id_estado,id_resoluciones);
    ELSE
    
    signal sqlstate '45000' set message_text = 'You cannot vote for yourself, dude!';

    END IF;
END $$


-- Procedimiento para buscar datos de la tabla usuarios y personas
DELIMITER $$
CREATE  PROCEDURE `up_buscar_usuario_persona_ajax` (
      IN IN_documento INT
)  

BEGIN

    IF IN_documento IS NOT NULL AND IN_documento != '' THEN 
       IF (SELECT 1 FROM personas WHERE documento = IN_documento LIMIT 1)  THEN

          IF(SELECT 1 FROM personas pe INNER JOIN usuarios us on pe.id_persona = us.id_persona where pe.documento = IN_documento) THEN

          SELECT pe.id_persona, pe.nombre, pe.apellido_paterno, pe.apellido_materno, pe.documento, us.usuario, us.id_usuario 
          FROM personas pe 
          INNER JOIN usuarios us on pe.id_persona = us.id_persona where pe.documento = IN_documento;

          ELSE

              signal sqlstate '45000' set message_text = 'La persona no cuenta con un usurio en el sistema!!!'; 

          END IF;

        ELSE
          
        signal sqlstate '45000' set message_text = 'La persona que ingreso no existe en el sistema!!!'; 

        END IF;
    
    ELSE
          signal sqlstate '45000' set message_text = 'Ingrese los datos de manera correcta!!!';
    END IF;

END $$


-- AGREGADO EL 03-05-2019 ------
															      
-- LISTAR A LAS PERSONAS, LO MUESTRA EN UN SOLO CAMPO SUS DATOS
DELIMITER $$
CREATE PROCEDURE up_listar_persona_datos(
)
BEGIN
	SELECT CONCAT(documento,' - ', nombre,', ', apellido_paterno,' ',apellido_materno) AS DATOS_PERSONA FROM personas;
END $$

-- LISTAR A RESOLUCIONES, LO MUESTRA EN UN SOLO CAMPO SUS DATOS

-- Procedimiento para listar los datos de la tabla resolucion en un solo cmpo			
DELIMITER $$												      
CREATE PROCEDURE up_listar_resolucion_datos(
)
BEGIN
	
    SELECT CONCAT(RES.numero,' - ', TIR.tipo_resolucion,' - ', RES.anio,' - ', EST.tipo_estado) AS DATOS_RESOLUCION FROM resoluciones RES
    INNER JOIN tipo_resoluciones TIR ON RES.id_tipo_resolucion = TIR.id_tipo_resolucion
    INNER JOIN estados EST ON RES.id_estado = EST.id_estado;    
END $$
																		     
	
-- procedimiento para buscar a las personas mediante su DNI y AJAX
DELIMITER $$
CREATE PROCEDURE up_buscar_persona_dni_ajax(
  IN IN_documento INT
)
BEGIN

    IF IN_documento IS NOT NULL AND IN_documento != '' THEN 
       
       SELECT * FROM personas WHERE documento = IN_documento;
    
    ELSE
          signal sqlstate '45000' set message_text = 'Ingrese los datos de manera correcta!!!';
    END IF;

END $$																		     

-- Procedimiento para listar las resoluciones pendientes de cada ambiente
DELIMITER $$
CREATE PROCEDURE up_listar_resolucion_pendientes(
  IN IN_id_ambiente INT
)
BEGIN

    IF IN_id_ambiente IS NOT NULL AND IN_id_ambiente != '' THEN 
       
     SELECT bz.id_buzon,re.id_resolucion,re.id_resolucion, re.numero, tp.tipo_resolucion, co.concepto, re.anio, es.tipo_estado FROM buzon_entradas bz 
     INNER JOIN resoluciones re on bz.id_resolucion = re.id_resolucione
     INNER JOIN ambientes am on bz.id_ambiente = am.id_ambiente
     INNER JOIN tipo_resoluciones tp on re.id_tipo_resolucion = tp.id_tipo_resolucion 
     INNER JOIN conceptos co on re.id_concepto = co.id_concepto 
     INNER JOIN estados es on bz.id_estado = es.id_estado WHERE am.id_ambiente = IN_id_ambiente and bz.id_estado = 3;
    
    ELSE
          signal sqlstate '45000' set message_text = 'Ingrese los datos de manera correcta!!!';
    END IF;

END $$   

-- Procedimiento para listar las resoluciones recibidas de cada ambiente 		
DELIMITER $$													      
CREATE PROCEDURE up_listar_resolucion_recibidas(
  IN IN_id_ambiente INT
)
BEGIN

    IF IN_id_ambiente IS NOT NULL AND IN_id_ambiente != '' THEN 
       
     SELECT bz.id_buzon,re.id_resolucion,re.id_resolucion, re.numero, tp.tipo_resolucion, co.concepto, re.anio, es.tipo_estado FROM buzon_entradas bz 
     INNER JOIN resoluciones re on bz.id_resolucion = re.id_resolucion 
     INNER JOIN ambientes am on bz.id_ambiente = am.id_ambiente
     INNER JOIN tipo_resoluciones tp on re.id_tipo_resolucion = tp.id_tipo_resolucion 
     INNER JOIN conceptos co on re.id_concepto = co.id_concepto 
     INNER JOIN estados es on bz.id_estado = es.id_estado WHERE am.id_ambiente = IN_id_ambiente and bz.id_estado = 4;
    
    ELSE
          signal sqlstate '45000' set message_text = 'Ingrese los datos de manera correcta!!!';
    END IF;

END $$         

-- Procedimiento para recibir las resoluciones pendientes a traves del buzon		
DELIMITER $$													      
CREATE PROCEDURE up_recibir_resolucion_pendientes(
  IN IN_id_buzon INT
)
BEGIN

    IF IN_id_buzon IS NOT NULL AND IN_id_buzon != '' THEN 
          UPDATE buzon_entradas SET id_estado=4 WHERE id_buzon = IN_id_buzon;
    ELSE
          signal sqlstate '45000' set message_text = 'Ingrese los datos de manera correcta!!!';
    END IF;

END $$                                 

-- Procedimiento para buscar a la institucion mediante el nombre y el nivel
DELIMITER $$

CREATE PROCEDURE up_buscar_institucion_codigo_nombre_nivel (
  IN IN_cod_modular VARCHAR(45),
  IN IN_nombre VARCHAR(45),
  IN IN_nivel VARCHAR(45)
) 
BEGIN

    SELECT * FROM instituciones ins INNER JOIN niveles ni on ins.id_nivel = ni.id_nivel 
    WHERE ins.cod_modular = IN_cod_modular or ins.nombre = IN_nombre or ni.id_nivel = IN_nivel;

END $$


DELIMITER $$
CREATE PROCEDURE up_registrar_persona_resolucion_rp (
  IN IN_id_persona int,
  IN IN_id_resolucion int
) 
BEGIN

    INSERT INTO detalle_resolucion_personas(id_persona, id_resolucion) 
    VALUES (IN_id_persona,IN_id_resolucion);

END $$

DELIMITER $$
CREATE PROCEDURE up_registrar_institucion_resolucion_rp (
  IN IN_id_institucion int,
  IN IN_id_resolucion int
) 
BEGIN

    INSERT INTO detalle_resolucion_instituciones(id_institucion, id_resolucion) 
    VALUES (IN_id_institucion,IN_id_resolucion);

END $$

-- procedimiento para buscar a las insituciones mediante su codigo Modular  y AJAX
DELIMITER $$
CREATE PROCEDURE up_buscar_institucion_cModular_ajax(
  IN IN_cod_modular INT
)
BEGIN

    IF IN_cod_modular IS NOT NULL AND IN_cod_modular != '' THEN 
       
      SELECT * FROM instituciones ins 
      INNER JOIN niveles ni 
      on ins.id_nivel = ni.id_nivel WHERE ins.cod_modular = IN_cod_modular;
    
    ELSE
          signal sqlstate '45000' set message_text = 'Ingrese los datos de manera correcta!!!';
    END IF;

END $$  




-- PROCEDIMIENTO PARA AGREGAR AMBIENTE Y EN QUE ROL PERTENECE
DELIMITER $$
CREATE PROCEDURE up_registrar_rolambientes (
  IN IN_id_tipo_rol       INT,
  IN IN_id_area       INT,
  IN IN_nombre_ambiente   VARCHAR(250)
) 
BEGIN
  INSERT INTO ambientes (id_tipo_rol,id_area, nombre_ambiente) VALUES (IN_id_tipo_rol,IN_id_area,IN_nombre_ambiente);
END $$


-- PROCEDIMIENTO PARA MOSTRAR ROL
DELIMITER $$
CREATE  PROCEDURE up_listar_rol () BEGIN

  SELECT * FROM tipo_roles;
    
END $$


DELIMITER $$
CREATE  PROCEDURE `up_buscar_resolucion_id` (
  IN IN_id_resolucion       INT
)  

BEGIN
SELECT * FROM resoluciones WHERE id_resolucion = IN_id_resolucion;

END $$


DELIMITER $$
CREATE  PROCEDURE `up_buscar_ambientes` (
  IN IN_nombre_ambiente   VARCHAR(250),
  IN IN_id_tipo_rol       INT
)  

BEGIN

SELECT a.id_ambiente, a.nombre_ambiente, tr.tipo_rol, tr.id_tipo_rol 
FROM ambientes a INNER JOIN tipo_roles tr 
on a.id_tipo_rol = tr.id_tipo_rol where a.id_tipo_rol = IN_id_tipo_rol  
AND a.nombre_ambiente LIKE CONCAT('%', IN_nombre_ambiente , '%');

END $$

-- Procedimiento para listar los datos de la tabla usuarios y persona  
DELIMITER $$                                 
CREATE  PROCEDURE `up_buscar_usuarios` (
  IN `IN_documento` INT,
  IN `IN_nombre` VARCHAR(45)
) 
BEGIN 

SELECT PER.id_persona,
       USU.id_usuario,
       PER.documento,
       PER.nombre,
       PER.apellido_paterno,     
       PER.apellido_materno,
       USU.usuario,
       USU.contrasenia
  FROM personas PER
INNER JOIN usuarios USU ON USU.id_persona = PER.id_persona 
                        WHERE PER.documento = IN_documento 
                        OR PER.nombre = IN_nombre;
END $$


-- Procedimiento para listar los datos de la tabla usuarios y persona 
DELIMITER $$                                  
CREATE  PROCEDURE up_registrar_usuario_ambiente_estado (
  IN IN_id_persona INT,
  IN IN_usuario VARCHAR(200),
  IN IN_contrasenia VARCHAR(200),
  IN IN_estado INT,
  IN IN_id_ambiente INT
) 
BEGIN 

INSERT INTO usuarios(id_persona, usuario, contrasenia, estado)VALUES(
  IN_id_persona,
  IN_usuario,
  IN_contrasenia,
  IN_estado
);


INSERT INTO usuario_ambientes(id_usuario, id_ambiente) 
VALUES (
LAST_INSERT_ID(),
IN_id_ambiente
);

END $$


-- Procedimiento para listar los datos de la tabla usuarios y persona    
DELIMITER $$                               
CREATE  PROCEDURE up_listar_estados_res  (

) 
BEGIN 

SELECT * FROM estados;

END $$


-- Procedimiento para actualizar los datos del ambiente
DELIMITER $$
CREATE PROCEDURE up_modificar_ambientes (
     IN IN_id_ambiente INT,
     IN IN_id_tipo_rol INT,
     IN IN_id_area INT,
     IN IN_nombre_ambiente VARCHAR(250)
 )  
BEGIN

  IF IN_id_ambiente IS NOT NULL AND IN_id_ambiente != '' THEN 
      IF (SELECT 1 FROM ambientes WHERE id_ambiente = IN_id_ambiente LIMIT 1)  THEN
      
      UPDATE ambientes SET
      id_tipo_rol= IN_id_tipo_rol,
      id_area = IN_id_area,
      nombre_ambiente= IN_nombre_ambiente
      WHERE id_ambiente = IN_id_ambiente;
      ELSE

      signal sqlstate '45000' set message_text = 'La resolución que desea actualizar no existe en el sistema!!!';

      END IF;

  ELSE
      signal sqlstate '45000' set message_text = 'Ingrese los datos de manera correcta!!!';
  END IF;

END $$


DELIMITER $$
CREATE PROCEDURE up_buscar_amb_id (
  IN IN_id_ambiente     INT
) BEGIN 
    
  SELECT  AMB.id_ambiente, TIR.id_tipo_rol, TIR.tipo_rol, AMB.nombre_ambiente,a.id_area FROM ambientes AMB
  INNER JOIN tipo_roles TIR ON TIR.id_tipo_rol = AMB.id_tipo_rol INNER JOIN areas a on AMB.id_area = a.id_area
    WHERE  id_ambiente = IN_id_ambiente;

END $$


DELIMITER $$
CREATE PROCEDURE up_filtrar_ambientes (
  IN IN_nombre_ambiente VARCHAR(250),
  IN IN_id_tipo_rol     INT
) BEGIN  

     SELECT amb.id_ambiente, tir.id_tipo_rol, amb.nombre_ambiente, tir.tipo_rol FROM ambientes amb
       INNER JOIN tipo_roles tir ON tir.id_tipo_rol = amb.id_tipo_rol
        WHERE amb.nombre_ambiente = IN_nombre_ambiente OR tir.id_tipo_rol = IN_id_tipo_rol;
END $$


-- Procedimiento para buscar a los usuarios mediante su ID
DELIMITER $$
CREATE  PROCEDURE `up_buscar_usuario_id` (IN `IN_id_usuario` INT)  BEGIN

    SELECT * FROM usuarios WHERE  id_persona = IN_id_usuario;

     IF IN_id_usuario IS NOT NULL AND IN_id_usuario != '' THEN 
       IF (SELECT 1 FROM usuarios WHERE IN_id_usuario = IN_id_usuario LIMIT 1)  THEN
            SELECT * FROM usuarios WHERE  idUsuario = IN_id_usuario;
        ELSE
             signal sqlstate '45000' set message_text = 'Lo siento la persona que busca no existe en el sistema';
        END IF;
    
    ELSE
          signal sqlstate '45000' set message_text = 'Ingrese los datos de manera correcta!!!';
    END IF;

END $$


-- Procedimiento para actualizar los datos del usuario
DELIMITER $$
CREATE  PROCEDURE `up_actualizar_usuarios` (
  IN `IN_id_usuario` INT, 
  IN `IN_usuario` VARCHAR(90), 
  IN `IN_contrasenia` VARCHAR(180)
  )  
BEGIN

    IF IN_id_usuario IS NOT NULL AND IN_id_usuario != '' THEN 
       IF (SELECT 1 FROM usuarios WHERE id_usuario = IN_id_usuario LIMIT 1)  THEN
            UPDATE `usuarios` SET
               `usuario`= IN_usuario,
               `contrasenia`= IN_contrasenia WHERE 
               id_usuario = IN_id_usuario;
        ELSE
            signal sqlstate '45000' set message_text = 'La persona que desea actualizar no existe en el sistema!!!';

        END IF;
    
    ELSE
          signal sqlstate '45000' set message_text = 'Ingrese los datos de manera correcta!!!';
    END IF;

END $$


DELIMITER $$
CREATE  PROCEDURE `up_listar_resoluciones_pendientes` (
  
  )  
BEGIN

  SELECT re.fecha_emision,re.id_resolucion,re.id_tipo_resolucion,re.id_estado,re.id_usuario_ambiente,re.proyecto,re.id_concepto,re.id_concepto,re.numero,re.anio,am.*,es.*,co.*,tp.*,usa.*
  FROM resoluciones re
  INNER JOIN usuario_ambientes usa on re.id_usuario_ambiente = usa.id_usuario_ambiente
  INNER JOIN ambientes am on usa.id_ambiente = am.id_ambiente 
  INNER JOIN estados es on re.id_estado = es.id_estado 
  INNER JOIN conceptos co on re.id_concepto = co.id_concepto 
  INNER JOIN tipo_resoluciones tp ON re.id_tipo_resolucion = tp.id_tipo_resolucion
  WHERE re.id_estado = 1;

END $$


DELIMITER $$
CREATE  PROCEDURE up_listar_resoluciones_pendientes_oficina(
    IN IN_id_ambiente INT
)  
BEGIN

    SELECT re.id_resolucion,re.id_tipo_resolucion,re.id_estado,re.id_usuario_ambiente,re.proyecto,re.id_concepto,re.id_concepto,re.numero,re.anio,bz.*,am.*,es.*,co.*,tp.* FROM buzon_entradas bz INNER JOIN resoluciones re on bz.id_resolucion = re.id_resolucion INNER JOIN ambientes am on bz.id_ambiente = am.id_ambiente INNER JOIN estados es on re.id_estado = es.id_estado INNER JOIN conceptos co on re.id_concepto = co.id_concepto INNER JOIN tipo_resoluciones tp ON re.id_tipo_resolucion = tp.id_tipo_resolucion
    WHERE bz.id_estado = 2 and bz.id_ambiente =  IN_id_ambiente;

END $$


DELIMITER $$
CREATE  PROCEDURE up_listar_resoluciones_aceptados(
    IN IN_id_ambiente INT,
    IN IN_numero  INT,
    IN IN_anio INT
)  
BEGIN

    SELECT re.id_resolucion,re.id_tipo_resolucion,re.id_estado,re.id_usuario_ambiente,re.proyecto,re.id_concepto,re.id_concepto,re.numero,re.anio,bz.*,am.*,es.*,co.*,tp.* 
    FROM buzon_entradas bz 
    INNER JOIN resoluciones re on bz.id_resolucion = re.id_resolucion 
    INNER JOIN ambientes am on bz.id_ambiente = am.id_ambiente 
    INNER JOIN estados es on bz.id_estado = es.id_estado 
    INNER JOIN conceptos co on re.id_concepto = co.id_concepto 
    INNER JOIN tipo_resoluciones tp ON re.id_tipo_resolucion = tp.id_tipo_resolucion
    WHERE bz.id_estado = 4 and bz.id_ambiente =  IN_id_ambiente and re.numero = IN_numero and re.anio = IN_anio;

END $$


DELIMITER $$
CREATE  PROCEDURE up_listar_resoluciones_aceptados_todo(
    IN IN_id_ambiente INT
)  
BEGIN

    SELECT re.id_resolucion,re.id_tipo_resolucion,re.id_estado,re.id_usuario_ambiente,re.proyecto,re.id_concepto,re.id_concepto,re.numero,re.anio,bz.*,am.*,es.*,co.*,tp.* 
    FROM buzon_entradas bz 
    INNER JOIN resoluciones re on bz.id_resolucion = re.id_resolucion 
    INNER JOIN ambientes am on bz.id_ambiente = am.id_ambiente 
    INNER JOIN estados es on bz.id_estado = es.id_estado 
    INNER JOIN conceptos co on re.id_concepto = co.id_concepto 
    INNER JOIN tipo_resoluciones tp ON re.id_tipo_resolucion = tp.id_tipo_resolucion
    WHERE bz.id_estado = 4 and bz.id_ambiente =  IN_id_ambiente ORDER BY re.id_resolucion DESC
 LIMIT 15;

END $$


DELIMITER $$
CREATE PROCEDURE up_recibir_resoluciones_pendientes(
  IN IN_idBuzon INT
)
BEGIN

    IF IN_idBuzon IS NOT NULL AND IN_idBuzon != '' THEN 
          UPDATE buzon_entradas SET id_estado= 4 , fecha_recepcion=now() WHERE id_buzon = IN_idBuzon;
    ELSE
          signal sqlstate '45000' set message_text = 'Ingrese los datos de manera correcta!!!';
    END IF;

END $$  




-- Procedimiento para listar los datos de la tabla usuarios y persona   
DELIMITER $$                                
CREATE  PROCEDURE up_listar_areas(

) 
BEGIN 

SELECT * FROM areas;

END $$


-- Procedimiento para listar los datos de la tabla usuarios y persona      
DELIMITER $$                             
CREATE  PROCEDURE up_listar_niveles(

) 
BEGIN 

SELECT * FROM niveles;

END $$


DELIMITER $$
CREATE  PROCEDURE up_listar_reportes_Dfecha_Hfecha(
  IN IN_fecha_derivada timestamp,
  IN IN_fecha_recepcion timestamp

) 
BEGIN 

select re.numero,tp.tipo_resolucion,re.anio,es.tipo_estado,am.nombre_ambiente,bz.fecha_derivada,bz.fecha_recepcion,u.usuario 
from buzon_entradas bz 
INNER JOIN resoluciones re on re.id_resolucion = bz.id_resolucion 
INNER JOIN tipo_resoluciones tp on re.id_tipo_resolucion = tp.id_tipo_resolucion 
INNER JOIN estados es on bz.id_estado = es.id_estado 
INNER JOIN ambientes am on am.id_ambiente = bz.id_ambiente 
INNER JOIN usuario_ambientes ua ON ua.id_ambiente = bz.id_ambiente 
INNER JOIN usuarios u on ua.id_usuario = u.id_usuario where fecha_derivada 

between CONCAT(IN_fecha_derivada, ' 00:00:00') and CONCAT(IN_fecha_recepcion, ' 00:00:00') ORDER BY fecha_derivada ASC;

END $$

