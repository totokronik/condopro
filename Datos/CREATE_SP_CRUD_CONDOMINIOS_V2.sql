CREATE PROCEDURE `CRUD_Condominio_V2`(IN pAccion			CHAR(1),
	IN pIdCondominio	INT,
    IN pRUT			INT,
    IN pDV				CHAR(1),
    IN pNombreCondo	VARCHAR(255),
    IN pDireccion		VARCHAR(255),
    IN pIdComuna		INT,
    IN pCantSectores	INT,
    IN pPrimerPisoHab	INT,
    IN pCantPisosHab	INT,
    IN pUnidadesPiso	INT,
    IN pActivo			BIT,
    IN pUsuario		VARCHAR(30))
BEGIN
/*
##Procedimiento de gestion de CONDOMINIOS por ROL Administrador
 I=Insertar
 U= UPDATE
 D= DESACTIVAR/ACTIVAR


###Codigos de retorno
0 = Procedimiento terminado sin ejecutar querys
-1 = Insertar Condominio / RUT existe
-2 = Update Condominio / RUT no existe
-3 = Delete Condominio/ RUT no existe
1 =  Insertar Condominio / registro insertado
2 = Update Condominio / datos actualizados
3 = Delete Condominio / Condominio desactivado

*/	
    SET @pReturnValue = 0; /*valor default*/ 

	IF pAccion = 'I' THEN /*INSERT*/
    
		IF EXISTS ( SELECT 1 FROM CONDOMINIOS WHERE rut = pRUT and dv = pDV) THEN  /* Ya existe */
			SET @pReturnValue = -1;  /*Quieren crear condominio pero ya existe*/
		ELSE 
    
			INSERT INTO CONDOMINIOS(
				rut, dv, nombre_condominio, direccion, id_comuna,
				cantidad_sectores, primer_piso_habitable, cantidad_piso_habitables,
				unidades_por_piso, activo, usr_creacion, usr_ult_mod)
			VALUES(
				pRUT, pDV, pNombreCondo, pDireccion, pIdComuna,
				pCantSectores, pPrimerPisoHab, pCantPisosHab, 
				pUnidadesPiso, pActivo, pUsuario, pUsuario);
				
			set @id_condominio = (select id_condominio from CONDOMINIOS where rut = pRUT and dv = pDV);


		INSERT INTO ESTRUCTURA_CONDOMINIO(
				id_condominio, unidad, activo, usr_creacion, usr_ult_mod)
			VALUES( @id_condominio, '00000',1,pUsuario,pUsuario);
				
			SET @pReturnValue = 1;
			END IF;
    ELSEIF pAccion = 'U' THEN  /*UPDATE*/
    
		IF NOT EXISTS ( SELECT 1 FROM CONDOMINIOS WHERE id_condominio = pIdCondominio) THEN  /* Ya existe */
			SET @pReturnValue = -2; /* Quieren actualizar condominio pero no existe*/
		ELSE 
			UPDATE CONDOMINIOS
				SET		nombre_condominio		= pNombreCondo, 
						direccion				= pDireccion, 
						id_comuna				= pIdComuna,
						cantidad_sectores		= pCantSectores, 
						primer_piso_habitable	= pPrimerPisoHab, 
						cantidad_piso_habitables= pCantPisosHab,
						unidades_por_piso		= pUnidadesPiso,
						activo					= pActivo,
						usr_ult_mod				= pUsuario
							WHERE
							id_condominio = pIdCondominio;
                    
			SET @pReturnValue = 2;
		END IF;

    ELSEIF pAccion = 'D' THEN  /*DELETE*/

		IF NOT EXISTS ( SELECT 1 FROM CONDOMINIOS WHERE id_condominio = pIdCondominio) THEN  /* Ya existe */
			SET @pReturnValue = -3; /*Quieren eliminar condominio pero no existe*/
		ELSE 
			UPDATE CONDOMINIOS
				SET 	activo			= pActivo,
					usr_ult_mod				= pUsuario
				WHERE
				id_condominio = pIdCondominio;
                    
			SET @pReturnValue = 3;
		END IF;
	END IF;
    
    SELECT @pReturnValue AS valor;
	
END