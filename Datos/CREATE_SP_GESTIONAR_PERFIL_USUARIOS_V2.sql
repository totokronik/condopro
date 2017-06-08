CREATE PROCEDURE `SP_GESTIONAR_PERFIL_USUARIOS_V2`(IN `pAccion` char(1),IN `pPerfil` char(1),IN `pIdUsuario` integer,IN `pIdCondominio` integer,IN `pIdEstructuraCondominio` integer, IN `pIdResidente` integer, IN `pIdRol` integer,IN `pActivo` integer ,IN `pUsuario` varchar(50))
BEGIN

###PROCEDIMIENTO DE ASOCIACION DE USUARIOS CON PERFIL
/* 

CODIGOS DE PERFIL

R = RESIDENTE
P = PERSONAL

CODIGOS DE ACCION
I = INSERTAR
U = MODIFICAR
D = DESACTIVAR 

CODIGOS DE RETORNO

0 = NO HACE NADA
-1 = USUARIO YA EXISTE COMO RESIDENTE PARA ESA UNIDAD (ESTRUCTURA CONDOMINIO)
-2 = NO EXISTE RESIDENTE EN CONDOMINIO
-11 = USUARIO YA EXISTE COMO PERSONAL EN EL CONDOMINIO
-22 = NO EXISTE COMO PERSONAL EN EL CONDOMINIO
1 = USUARIO ASOCIADO COMO RESIDENTE A ESTRUCTURA DEL CONDOMINIO
2 = RESIDENTE ACTUALIZADO, CAMBIO DE UNIDAD DENTRO DEL MISMO CONDOMINIO
3 = RESIDENTE DESACTIVADO/ACTIVADO
11 =  USUARIO ASOCIADO COMO PERSONAL DEL CONDOMINIO
22 = USUARIO EXISTE EN CONDOMINIO CAMBIO DE ROL OK
33 = PERSONAL ACTIVADO/DESACTIVADO


*/


set @pReturnValue = 0;


CASE pPerfil
###PARA RESIDENTES
WHEN 'R' THEN

		CASE pAccion

			WHEN 'I' THEN
### PARAMETROS UTILIZADOS `pIdUsuario` ,`pIdEstructuraCondominio` ,`pActivo` ,`pUsuario` ,`pUsuario`
					IF EXISTS ( SELECT 1 FROM RESIDENTE_CONDOMINIO WHERE id_usuario = pIdUsuario AND  id_estructura_condominio = `pIdEstructuraCondominio`) THEN

							set @pReturnValue = -1;

					ELSE

					INSERT INTO RESIDENTE_CONDOMINIO ( id_usuario, id_estructura_condominio, activo, usr_creacion, usr_ult_mod) VALUES
					(	pIdUsuario ,pIdEstructuraCondominio ,pActivo ,pUsuario ,pUsuario );

					set @pReturnValue = 1;

					END IF;

			WHEN 'U' THEN
			#### PARAMETROS UTILIZADOS pIdCondominio,pIdResidente,pUsuario, pIdEstructuraCondominio
				/* ESTO APLICA CUANDO EL RESIDENTE SE CAMBIA DE UNIDAD DENTRO DE UN MISMO CONDOMINIO, POR ESO VALIDA EL CONDOMINIO*/

#					IF NOT EXISTS ( SELECT 1 FROM RESIDENTE_CONDOMINIO R, ESTRUCTURA_CONDOMINIO E WHERE R.id_residente = `pIdResidente` AND R.id_estructura_condominio = E.id_estructura_condominio AND E.id_condominio = `pIdCondominio` ) THEN
					IF NOT EXISTS ( SELECT 1 
													FROM RESIDENTE_CONDOMINIO R 
													INNER JOIN ESTRUCTURA_CONDOMINIO E ON R.id_estructura_condominio = E.id_estructura_condominio 
													WHERE R.id_residente = `pIdResidente` AND E.id_condominio = `pIdCondominio` ) THEN

							set @pReturnValue = -2;

					ELSE
/*
						UPDATE RESIDENTE_CONDOMINIO R, ESTRUCTURA_CONDOMINIO E SET 
						R.id_estructura_condominio = pIdEstructuraCondominio,
						R.usr_ult_mod = pUsuario
						WHERE R.id_residente = pIdResidente AND E.id_condominio = pIdCondominio;
*/

						UPDATE RESIDENTE_CONDOMINIO R 
						INNER JOIN ESTRUCTURA_CONDOMINIO E ON R.id_estructura_condominio = E.id_estructura_condominio  
						SET 
						R.id_estructura_condominio = pIdEstructuraCondominio,
						R.usr_ult_mod = pUsuario
						WHERE R.id_residente = pIdResidente AND E.id_condominio = pIdCondominio;

							set @pReturnValue = 2;
					
					END IF;

				WHEN 'D' THEN
					
					IF NOT EXISTS ( SELECT 1 
													FROM RESIDENTE_CONDOMINIO R 
													INNER JOIN ESTRUCTURA_CONDOMINIO E ON R.id_estructura_condominio = E.id_estructura_condominio 
													WHERE R.id_residente = `pIdResidente` AND E.id_condominio = `pIdCondominio`) THEN

							set @pReturnValue = -2;

					ELSE	

						UPDATE RESIDENTE_CONDOMINIO R 
						INNER JOIN ESTRUCTURA_CONDOMINIO E ON R.id_estructura_condominio = E.id_estructura_condominio  
						SET 
						R.activo = pActivo,
						R.usr_ult_mod = pUsuario
						WHERE R.id_residente = pIdResidente AND E.id_condominio = pIdCondominio;

							set @pReturnValue = 3;
					
					END IF;

			ELSE
					
					set @pReturnValue = 0;

			END CASE;
#############
#############
#############
#############
#### PARA PERSONAL
WHEN 'P' THEN


			CASE pAccion

			WHEN 'I' THEN
### PARAMETROS UTILIZADOS `pIdUsuario` ,`pIdEstructuraCondominio` ,`pActivo` ,`pUsuario` ,`pUsuario`
					IF EXISTS ( SELECT 1 FROM PERSONAL_CONDOMINIO WHERE id_usuario = pIdUsuario AND  id_condominio = pIdCondominio) THEN

							set @pReturnValue = -11;

					ELSE

					INSERT INTO PERSONAL_CONDOMINIO ( id_usuario, id_condominio, id_rol, activo ,usr_creacion, usr_ult_mod) VALUES
					(	pIdUsuario ,pIdCondominio ,pIdRol ,pActivo ,pUsuario ,pUsuario );

					set @pReturnValue = 11;

					END IF;

			WHEN 'U' THEN
			#### PARAMETROS UTILIZADOS pIdCondominio,pIdRol,pUsuario,pIdUsuario

					IF NOT EXISTS ( SELECT 1 
													FROM PERSONAL_CONDOMINIO
													WHERE id_usuario = pIdUsuario AND id_condominio = pIdCondominio ) THEN

							set @pReturnValue = -22;

					ELSE

						UPDATE PERSONAL_CONDOMINIO 
						SET 
						id_rol = pIdRol ,
						usr_ult_mod = pUsuario
						WHERE id_usuario = pIdUsuario AND id_condominio = pIdCondominio ;

							set @pReturnValue = 22;
					
					END IF;

				WHEN 'D' THEN
					
					IF NOT EXISTS ( SELECT 1 
													FROM PERSONAL_CONDOMINIO
													WHERE id_usuario = pIdUsuario AND id_condominio = pIdCondominio ) THEN

							set @pReturnValue = -2;

					ELSE	

						UPDATE PERSONAL_CONDOMINIO
						SET 
						activo = pActivo,
						usr_ult_mod = pUsuario
						WHERE id_usuario = pIdUsuario AND id_condominio = pIdCondominio;

							set @pReturnValue = 33;
					
					END IF;

			ELSE

		set @pReturnValue = 0;

		END CASE;
ELSE
	set @pReturnValue = 0;

	END CASE;

SELECT @pReturnValue AS valor;

END