CREATE PROCEDURE `SP_Registro_poblacion_flotante`(IN pAccion CHAR(1),
IN pRol CHAR(1),
IN pIdCondominio INT, 
IN pIdEstructuraCondominio INT,
 IN pIdRegistroReserva INT,
  IN pIdUsuario INT,
  IN pIdTipoPoblacion INT,
  IN pFechaHoraRegistro TIMESTAMP,
 IN pChileno BIT,
  IN pNumeroDocumento VARCHAR(20),
 IN pNombre VARCHAR(255),
    IN pObservacion TEXT,
 IN pUsoEstacionamiento BIT,
 IN pFechaHoraIngreso TIMESTAMP,
 IN pUsuario VARCHAR(30))
BEGIN
/*
##Procedimiento de gestion de CONDOMINIOS por ROL Administrador
 I=Insertar
 U= UPDATE
 S= SALIDA
V = VALIDA INGRESO
D = ELIMINAR REGISTRO (SOLO RESIDENTE)

IN pAccion CHAR(1), 
IN pRol CHAR(1),
IN pIdCondominio INT, 
IN pIdEstructuraCondominio INT,
 IN pIdRegistroReserva INT,
  IN pIdUsuario INT,
  IN pIdTipoPoblacion INT,
  IN pFechaHoraRegistro TIMESTAMP,
 IN pChileno BIT,
  IN pNumeroDocumento VARCHAR(20),
 IN pNombre VARCHAR(255),
    IN pObservacion TEXT,
 IN pUsoEstacionamiento BIT,
 IN pFechaHoraIngreso TIMESTAMP,
 IN pUsuario VARCHAR(30)


###Codigos de retorno
0 = Procedimiento terminado sin ejecutar querys
-1 = Insertar Registro / Ya existe registro para la misma fecha hora
-2 = Insertar Registro / Ya existe registro para la misma fecha distinta hora pero no ha salido
-3 = registro no existe
-4 = NO ES CONSERJE
-5 = NO EXISTE COMO REGISTRO EN ESTADDO 1 ( VISITA ANUNCIADA) O NO EXISTE
-6 = no es residente
-7 = USUARIO SIN PRIVILEGIOS EN CONDOMINIO
1 =  Insertar Registro / registro insertado
2 = Update Registro / datos actualizados
3 = Delete registro / Registro desactivado
4 = SALIDA marcada
5 = registro validado el ingreso


*/	SET @pReturnValue = 0 ; /*valor default*/ 
		SET @VALIDADO = 0;
    
    IF pAccion = 'I' THEN  /*INSERT*/
SET @pReturnValue = 5 ;
		CASE pRol
		
		WHEN 'R' THEN #RESIDENTE
		
		IF EXISTS ( SELECT 1 
								FROM  residente_condominio r
								INNER JOIN estructura_condominio e on r.id_estructura_condominio = e.id_estructura_condominio
								WHERE r.id_usuario = pIdUsuario and e.id_condominio = pIdCondominio) THEN  /*Es un residente*/

								SET @VALIDADO = 1;
								SET @FechaHoraingreso = pFechaHoraRegistro;
								SET @EstadoRegistroingreso = 1;
		ELSE
								SET @VALIDADO = 0;
						
		END IF;
		WHEN 'P' THEN #PERSONAL

			IF EXISTS ( SELECT 1 FROM personal_condominio WHERE id_usuario = pIdUsuario and id_condominio = pIdCondominio ) THEN  /*es un conserje*/ 


							SET @VALIDADO = 2 ;	
							SET @FechaHoraingreso = NOW();
							SET @EstadoRegistroingreso = 2;
			ELSE
							SET @VALIDADO = 0;


			END IF;

			ELSE
								SET @pReturnValue = -7;

		END CASE;
			
	IF (@VALIDADO > 0) THEN
			###VALIDA SI EL REGISTRO EXISTE
						IF EXISTS (SELECT 1 FROM registro_poblacion_flotante WHERE id_estructura_condominio = pIdEstructuraCondominio
						AND (numero_documento = pNumeroDocumento OR	nombre = pNombre) AND fecha_hora_ingreso = pFechaHoraRegistro and id_estado_registro in(1, 2))  THEN

						SET @pReturnValue = -1;
						
		ELSE

		INSERT INTO registro_poblacion_flotante(
			id_estructura_condominio,
			id_usuario,
			id_tipo_poblacion_flotante,
			fecha_hora_registro,
			id_estado_registro,
			chileno,
			numero_documento,
			nombre,
			observacion,
			uso_estacionamiento,
			fecha_hora_ingreso,
			usr_creacion,
			usr_ult_mod
			)
		VALUES(
			pIdEstructuraCondominio,
			pIdUsuario,
			pIdTipoPoblacion,
			@FechaHoraingreso,
			@EstadoRegistroingreso,
			pChileno,
			pNumeroDocumento,
			pNombre,
			pObservacion,
			pUsoEstacionamiento,
			pFechaHoraIngreso,
			pUsuario,
			pUsuario);
		SET @pReturnValue = 1;
		END IF;
ELSE 

SET @pReturnValue = -7;

END IF;

	 ELSEIF pAccion = 'U' THEN  /*UPDATE*/

		IF EXISTS ( SELECT 1 
								FROM  residente_condominio r
								INNER JOIN estructura_condominio e on r.id_estructura_condominio = e.id_estructura_condominio
								INNER JOIN registro_poblacion_flotante pf on r.id_usuario = pf.id_usuario
								WHERE r.id_usuario = pIdUsuario and e.id_condominio = pIdCondominio and pf.id_registro = pIdRegistroReserva ) THEN  /*Es un residente*/

			UPDATE	registro_poblacion_flotante
				SET	fecha_hora_registro 	= pFechaHoraRegistro,
						numero_documento   	= pNumeroDocumento, /*Se actualiza porque el residente puede no haber ingresado el RUT de la visita*/
            nombre			   			= pNombre,
						observacion        	= pObservacion,
            uso_estacionamiento = pUsoEstacionamiento,
						usr_ult_mod        	= pUsuario
				WHERE	id_registro = pIdRegistroReserva;
        
        ELSEIF EXISTS ( SELECT 1 FROM personal_condominio, registro_poblacion_flotante pf WHERE id_usuario = pIdUsuario and id_condominio = pIdCondominio and pf.id_registro = pIdRegistroReserva) THEN  /*es un conserje*/ 

			UPDATE	registro_poblacion_flotante
				SET		numero_documento   	= pNumeroDocumento, /*Se actualiza porque el residente puede no haber ingresado el RUT de la visita*/
						nombre			   	= pNombre,
						observacion        	= pObservacion,
						uso_estacionamiento = pUsoEstacionamiento,
						usr_ult_mod        	= pUsuario
				where	id_registro = pIdRegistroReserva;
		SET @pReturnValue = 2;
		END IF;
	ELSEIF pAccion = 'S' THEN  /*Salida*/

		IF NOT EXISTS ( SELECT 1 FROM registro_poblacion_flotante WHERE id_registro = pIdRegistroReserva AND id_estado_registro = 2) THEN

				SET @pReturnValue = -3;

			ELSE 

			UPDATE	registro_poblacion_flotante
				SET		id_estado_registro  = 3,
							fecha_hora_salida = NOW(),
						usr_ult_mod        	= pUsuario
				where	id_registro = pIdRegistroReserva;		

		SET @pReturnValue = 4;
		END IF;

		ELSEIF pAccion = 'V' THEN

				IF NOT EXISTS ( SELECT 1 FROM personal_condominio WHERE id_usuario = pIdUsuario and id_condominio = pIdCondominio) THEN
					SET @pReturnValue = -4;
				ELSE

				IF NOT EXISTS ( SELECT 1 FROM registro_poblacion_flotante WHERE id_registro = pIdRegistroReserva AND id_estado_registro = 1) THEN

					SET @pReturnValue = -5;

					ELSE
					UPDATE	registro_poblacion_flotante
					SET		id_estado_registro  = 2,
								fecha_hora_ingreso = NOW(),
						usr_ult_mod        	= pUsuario
					where	id_registro = pIdRegistroReserva;		

							SET @pReturnValue = 5;

				END IF;	
	END IF;				
					
	ELSEIF pAccion = 'D' THEN

				IF NOT EXISTS ( SELECT 1 
								FROM  residente_condominio r
								INNER JOIN estructura_condominio e on r.id_estructura_condominio = e.id_estructura_condominio
								WHERE r.id_usuario = pIdUsuario and e.id_condominio = pIdCondominio AND e.id_estructura_condominio = pIdEstructuraCondominio ) THEN  /*Es un residente*/

								SET @pReturnValue = -6;
				ELSEIF NOT EXISTS ( SELECT 1 FROM registro_poblacion_flotante WHERE id_registro = pIdRegistroReserva AND id_estado_registro = 1 and id_usuario = pIdUsuario ) THEN

							SET @pReturnValue = -3; #SIN ESTADO ANUNCIADO O NO ES QUIEN REALIZO RESERVA

				ELSE 

				DELETE R.* FROM registro_poblacion_flotante R WHERE R.id_registro = pIdRegistroReserva AND R.id_estado_registro = 1 and id_usuario = pIdUsuario;
				
				SET @pReturnValue = 3;

				END IF;
					
	END IF;

    SELECT @pReturnValue AS valor;
END