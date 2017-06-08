CREATE DEFINER=`root`@`localhost` PROCEDURE `CRUD_Favoritos`(
	IN pAccion			CHAR(1),
    IN pIdFavorito		INT,
    IN pIdResidente		INT,
    IN pChileno			BIT,
    IN pNumeroDocumento	VARCHAR(20),
    IN pNombre			VARCHAR(255),
    IN pUsuario			VARCHAR(30))
BEGIN
/*
##Procedimiento de gestion de FAVORITOS del Residente
 I=Insertar
 U= UPDATE
 D= DELETE
 S= SELECT

###Codigos de retorno
0 = Procedimiento terminado sin ejecutar querys
-1 = Insertar favorito / Ya existe
-2 = Update favorito / No existe
-3 = Delete favorito/ No existe
1 =  Insertar favoritp / registro insertado
2 = Update favorito / datos actualizados
3 = Delete favorito / Favorito eliminado

*/	
    SET @pReturnValue = 0; /*valor default*/ 

	IF pAccion = 'I' THEN /*INSERT*/
		IF EXISTS ( SELECT 1 FROM favoritos_residente WHERE id_residente = pIdresidente AND nombre = pNombre) THEN
			SET @pReturnValue = -1;
		ELSE
			INSERT INTO favoritos_residente(
				id_residente, chileno, numero_documento, nombre,
                usr_creacion, usr_ult_mod)
			VALUES(
				pIdResidente, pChileno, pNumeroDocumento, pNombre,
                pusuario, pUsuario);
			SET @pReturnValue = 1;
		END IF;
    ELSEIF pAccion = 'U' THEN  /*UPDATE*/
		IF NOT EXISTS ( SELECT 1 FROM favoritos_residente WHERE id_favorito = pIdFavorito) THEN
			SET @pReturnValue = -2;
		ELSE
			UPDATE	favoritos_residente
				SET 	chileno 			= pChileno,
						numero_documento	= pNumeroDocumento,
                        nombre				= pNombre,
                        usr_ult_mod			= pusuario
				WHERE	id_favorito		= pIdFavorito;
			SET @preturnValue = 2;
		END IF;
    ELSEIF pAccion = 'D' THEN  /*DELETE*/
		IF NOT EXISTS ( SELECT 1 FROM favoritos_residente WHERE id_favorito = pIdFavorito) THEN
			SET @pReturnValue = -3;
		ELSE
			DELETE FROM favoritos_residente
				WHERE	id_favorito 	= pIdFavorito;
			SET @pReturnValue = 3;
		END IF;
    ELSE IF pAccion = 'S' THEN
		SELECT * FROM favoritos_residente
			WHERE	id_favorito = pIdFavorito;
		END IF;
	
    END IF;
    
    SELECT @pReturnValue AS valor;
END