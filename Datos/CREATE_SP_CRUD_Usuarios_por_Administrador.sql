CREATE PROCEDURE `CRUD_Usuarios_por_Administrador`(IN `pAccion` char(1),IN `pUsername` varchar(30),IN `pPassword` varchar(32),IN `pChileno` bit(1),IN `pNroDoc` varchar(20),IN `pNombres` varchar(50),IN `pApellidos` varchar(50),IN `pNroCelular` integer,IN `pEmail` varchar(100),IN `pActivo` bit(1),IN `pUsrCreacion` varchar(30),IN `pUsrUltMod` varchar(30))
BEGIN
/*
##Procedimiento de gestion de USUARIOS por ROL Administrador
 I=Insertar
 U= UPDATE
 D= DESACTIVAR/ACTIVAR


###Codigos de retorno
0 = Procedimiento terminado sin ejecutar querys
-1 = Insertar Usuario / numero de documento existe
-2 = Insertar Usuario / username existe
-3 = Update usuario / username no existe
1 =  Insertar Usuario / registro insertado
2 = Update usuario / datos usuarios actualizados
3 = Update usuario / usuarios activado/desactivado

*/

##String de Prueba
# 'I','toto','toto',1,111,'orlando','velasco',4444,'sjsjjs',1,'sss','sss'

set @pReturnValue = 0;
	CASE pAccion
		WHEN 'I' Then

			IF EXISTS ( SELECT 1 FROM USUARIOS WHERE numero_documento = pNroDoc) THEN
					set @pReturnValue = -1;

			ELSEIF EXISTS  ( SELECT 1 FROM USUARIOS WHERE username = pUsername) THEN
					set @pReturnValue = -2;
			ELSE
				INSERT INTO USUARIOS (username,`password`,chileno,numero_documento,nombres,apellidos,telefono_celular,email,activo,usr_creacion,usr_ult_mod)
				VALUES (pUsername,MD5(pPassword),pChileno,pNroDoc,pNombres,pApellidos,pNroCelular,pEmail,pActivo,pUsrCreacion,pUsrUltMod);
					set @pReturnValue = 1;
			END IF;


		WHEN 'U' Then
			
			IF NOT EXISTS  ( SELECT 1 FROM USUARIOS WHERE username = pUsername) THEN
					set @pReturnValue = -3;
			ELSE
					UPDATE USUARIOS SET
						`password` =	MD5(pPassword),
						chileno =	pChileno,
						numero_documento =	pNroDoc,
						nombres = pNombres,
						apellidos =	pApellidos,
						telefono_celular = pNroCelular,
						email = pEmail,
						usr_ult_mod =	pUsrUltMod
					WHERE username = pUsername;

		set @pReturnValue = 2;
	END IF;
	
	
		WHEN 'D' Then
			
			IF NOT EXISTS  ( SELECT 1 FROM USUARIOS WHERE username = pUsername) THEN
					set @pReturnValue = -3;
			ELSE
					UPDATE USUARIOS SET
			    		activo = pActivo,
						usr_ult_mod =	pUsrUltMod
					WHERE username = pUsername;

		set @pReturnValue = 3;
	END IF;

			ELSE

				set @pReturnValue = 0;

END CASE;

Select @pReturnValue as valor;

END