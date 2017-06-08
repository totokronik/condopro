CREATE PROCEDURE `CRUD_Espacios_Comunes_V2`(IN pAccion CHAR(1),
   IN pIdEspacioComun INT, IN pIdCondominio INT,
  IN pIdTipoEspacio INT, IN pDescripcion VARCHAR(100),
  IN pActivo BIT,
  IN pUsuario VARCHAR(30))
BEGIN
/*
##Procedimiento de gestion de ESPACIOS_COMUNES por ROL Administrador VERSION 2
 I=Insertar
 U= UPDATE
 D= DESACTIVAR/ACTIVAR

##CAMBIOS REALIZADOS EN RELACION A VERSION 1 
- SE MODIFICA PARAMETRO pUsusario por pUsuario
- SE INCORPORA EN INSERT CAMPO usr_ult_mod
- SE MODIFICA LINEA " ELSEIF Accion = 'D' THEN " POR "ELSEIF pAccion = 'D' THEN" /ERROR YA QUE NO RECONOCIA EL PARAMETRO CUANDO ENTRABA A ESTE IF/
- SE QUITAN CAMPOS DE VALIDACION EN WHERE DE IF RELACIONADOS A "U Y D". SOLO SE MANTIENE EL ID_ESPACIO_COMUN
- EN EVENTOS UPDATE SE INCORPORA CAMPO usr_ult_mod
- EN EVENTO UPDATE RELACIONADO A "U", SE QUITAN CAMPOS QUE NO SON MODIFICABLES

nota: NO SE AGREGAN NI ELIMINAN PARAMETROS.


###Codigos de retorno
0 = Procedimiento terminado sin ejecutar querys
-1 = Insertar Espacio Común / ya existe
-2 = Update Espacio Común / no existe
-3 = Delete Espacio Común / no existe
1 =  Insertar Espacio Común / registro insertado
2 = Update Espacio Común / datos actualizados
3 = Delete Espacio Común / Espacio Común desactivado

datos de prueba
PRUEBAS REALIZADAS CON TABLA VACIA Y SECUENCIAL SEGUN SIGUIENTE LISTADO

'I',1,1,1,'PRIMERO',1,'TOTO' /Resultado Esperado: 1 / Resultado: Insertado OK
'U',1,1,1,'update primero',1,'TOTO' /Resultado Esperado: 2/ Resultado: update OK
'I',2,2,1,'SEGUNDO OTRO CONDOMINIO Y OTRO TIPO',1,'TOTO' /Resultado Esperado: 1 / Resultado: Insertado OK
'X',2,2,1,'SEGUNDO OTRO CONDOMINIO Y OTRO TIPO',1,'TOTO' /Resultado Esperado: 0 / Resultado: no ejecuta nada OK
'D',2,2,1,'SEGUNDO OTRO CONDOMINIO Y OTRO TIPO',0,'TOTO' /Resultado Esperado: 3/ Resultado: desactiva espacio OK
'D',3,2,1,'SEGUNDO OTRO CONDOMINIO Y OTRO TIPO',1,'TOTO' /Resultado Esperado: -3/ Resultado: no activa. no encuentra espacio OK
'U',3,2,1,'SEGUNDO OTRO CONDOMINIO Y OTRO TIPO',1,'TOTO' /Resultado Esperado: -2/ Resultado: no actualiza. no encuentra espacio OK
'I',1,1,1,'TERCERO DUPLICADO MISMO COND, MISMO TIPESP, DISTI DESC',1,'TOTO' /Resultado Esperado: 1/ Resultado: ESPACIO INSERTADO OK
'I',1,1,1,'TERCERO DUPLICADO MISMO COND, MISMO TIPESP, DISTI DESC',1,'TOTO' /Resultado Esperado: -1/ Resultado: NO INSERTA, ESPACIO EXISTE OK

*/	
	/*La validación de si la descripción del espacio_comun existe antes de enviar a modificarlo debe hacerse en el programa con un select por descripcion*/

	SET @pReturnValue = 0; /*valor default*/ 

	IF pAccion = 'I' THEN /*INSERT*/
    
		IF EXISTS ( SELECT 1 FROM espacios_comunes WHERE id_condominio = pIdCondominio 
					AND id_tipo_espacio = pIdTipoEspacio
                    AND descripcion = pDescripcion) THEN  /* Ya existe */
			SET @pReturnValue = -1;  /*Quieren crear espacio_comun pero ya existe*/
		ELSE 
    
			INSERT INTO espacios_comunes(
				id_condominio, id_tipo_espacio, descripcion, 
                activo, usr_creacion, usr_ult_mod)
			VALUES(
				pIdCondominio, pIdTipoEspacio, pDescripcion, 
                pActivo, pUsuario, pUsuario);
                
			SET @pReturnValue = 1;
			END IF;
    ELSEIF pAccion = 'U' THEN  /*UPDATE*/
    
		IF NOT EXISTS ( SELECT 1 FROM espacios_comunes WHERE id_espacio_comun = pIdEspacioComun) THEN  /* Ya existe */
			SET @pReturnValue = -2; /* Quieren actualizar espacio_comun pero no existe*/
		ELSE 
			UPDATE espacios_comunes
				SET		
				id_tipo_espacio = pIdTipoEspacio,
				descripcion	= pDescripcion, 
				usr_ult_mod	= pUsuario
							
				WHERE
         id_espacio_comun = pIdEspacioComun;
                    
			SET @pReturnValue = 2;
		END IF;

    ELSEIF pAccion = 'D' THEN  /*DELETE*/

		IF NOT EXISTS ( SELECT 1 FROM espacios_comunes WHERE id_espacio_comun = pIdEspacioComun ) THEN  /* Ya existe */
			SET @pReturnValue = -3; /*Quieren eliminar espacio_comun pero no existe*/
		ELSE 
			UPDATE	espacios_comunes
				SET		activo = 0,
							usr_ult_mod	= pUsuario
				WHERE
		id_espacio_comun = pIdEspacioComun;    
                    
			SET @pReturnValue = 3;
		END IF;
	END IF;
	
    SELECT @pReturnValue AS valor;
END