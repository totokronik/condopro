CREATE PROCEDURE `SP_RESERVA_ESPACIOS_COMUNES`(IN `pAccion` char(1),IN `pIdReserva` integer, IN `pIdResidente` integer , IN `pIdEspacioComun` integer ,IN `pObservacion`  blob ,IN `pFechaHoraInicio` timestamp ,IN `pFechaHoraTermino` timestamp ,IN `pUsuario`  varchar(30))
BEGIN
	#PROCEDIMIENTO DE GESTION DE RESERVAS DE ESPACIOS COMUNES

/*
###CODIGOS DE ACCION
I = GENERAR RESERVA DE ESPACIO COMUN (TODOS LOS ROLES)
U = MODIFICAR RESERVA
D = ELIMINAR RESERVA




###CODIGOS DE RETORNOS
-1000 = HORAS INCONGRUENTES
-4 = HORA LIMITE CUMPLIDA / NO PERMITE ACTUALIZAR O ELIMINAR RESERVA (1 HORA ANTES) PONER COMO MENSAJE
-3 = RESERVA NO EXISTE
-2 = ESPACIO O EQUIPO NO DISPONIBLE EN FECHA Y HORARIOS INDICADOS
-1 = RESERVA YA EXISTE
0 = NO HACE NADA
1 = RESERVA REALIZADA
2 = RESERVA ACTUALIZADA
3 = RESERVA ELIMINADA

PRUEBAS

INSERTAR RESERVA OK
'I',1,1,1,'CHE PECHECHEPERECHEPE','2017-05-31 20:00:05','2017-05-31 22:00:00','TOTO' / CODIGO RETORNO ESPERADO = 1 / RESULTADO OK
INSERTAR RESERVA OK
'I',1,2,1,'CHE PECHECHEPERECHEPE','2017-05-31 03:00:05','2017-05-31 05:00:00','TOTO' / CODIGO RETORNO ESPERADO = 1 / RESULTADO OK
RESEERVA EXISTE
'I',1,1,1,'CHE PECHECHEPERECHEPE','2017-05-31 20:00:05','2017-05-31 22:00:00','TOTO' / RESULTADO ESPERADO = -1 / OK
ESPACIO NO DISPONIBLE MISMAS HORAS
'I',1,2,1,'CHE PECHECHEPERECHEPE','2017-05-31 20:00:05','2017-05-31 22:00:00','TOTO' / RESULTADO ESPERADO = -2 / OK
ESPACIO NO DISPONIBLE / HORA DE INICIO ANTES, HORA DE TERMINO DURANTE OTRA RESERVA
'I',1,2,1,'CHE PECHECHEPERECHEPE','2017-05-31 19:00:05','2017-05-31 21:00:00','TOTO' / RESULTADO ESPERADO = -2 / OK
HORAS INCONGRUENTES
'I',1,2,1,'CHE PECHECHEPERECHEPE','2017-05-31 23:00:05','2017-05-31 21:00:00','TOTO'  / RESULTADO ESPERADO = -1000 / OK
ESPACIO NO DISPONIBLE / HORA DE INICIO DURANTE, HORA DE TERMINO DESPUES DE  OTRA RESERVA
'I',1,2,1,'CHE PECHECHEPERECHEPE','2017-05-31 19:00:05','2017-05-31 21:00:00','TOTO' / RESULTADO ESPERADO = -2 / OK
MODIFICAR RESERVA QUE NO EXISTE
'I',3,2,1,'CHE PECHECHEPERECHEPE','2017-05-31 21:00:05','2017-05-31 23:30:00','TOTO' / RESULTADO ESPERADO -3 / OK
modificar fuera de plazo
'U',2,2,1,'CHE PECHECHEPERECHEPE','2017-05-31 04:00:05','2017-05-31 05:00:00','TOTO' / RESULTADO ESPERADO -4 / OK
modificar dentro de plazo
'U',2,2,1,'CHE PECHECHEPERECHEPE','2017-05-31 04:00:05','2017-05-31 05:00:00','TOTO' / RESULTADO ESPERADO 2 / OK
eliminar fuera de plazo
'D',2,2,1,'CHE PECHECHEPERECHEPE','2017-05-31 05:00:05','2017-05-31 06:00:00','TOTO' /  RESULTADO ESPERADO -4 / OK
eliminar reserva que no existe
'D',3,2,1,'CHE PECHECHEPERECHEPE','2017-05-31 05:00:05','2017-05-31 06:00:00','TOTO' / resultado esperado -3 / ok
eliminar dentro de plazo
'D',2,2,1,'CHE PECHECHEPERECHEPE','2017-05-31 05:00:05','2017-05-31 06:00:00','TOTO' / Resultado esperado 3 / OK









*/



#### GENERAR RESERVA DE ESPACIO COMUN
set @ReturnValue  = 0;

#consulta compleja de validación de rango de hora disponible para eliminar o modificar reserva
#SELECT DATE_SUB(NOW(), INTERVAL 60 MINUTE), NOW(), (SEC_TO_TIME(TIMESTAMPDIFF(HOUR,DATE_SUB('2017-05-31 01:01:30', INTERVAL 60 MINUTE),NOW())) * 1)-1 AS DIFRENECA

IF pFechaHoraTermino <= pFechaHoraInicio THEN

set @ReturnValue  = -1000;

ELSE

CASE pAccion

WHEN 'I' THEN

/*parametros a utilizar ( IN `pIdResidente` integer , IN `pIdEspacioComun` integer ,IN `pObservacion`  blob ,
													IN `pFechaHoraInicio` timestamp ,IN `pFechaHoraTermino` timestamp ,IN `pUsuario`  varchar(30))
*/
#Valida si ya no existe una reserva
		IF EXISTS ( SELECT 1 FROM registro_reserva_espacio_comun R 	
								INNER JOIN residente_condominio RC ON R.id_residente = RC.id_residente 
								INNER JOIN estructura_condominio E ON RC.id_estructura_condominio = E.id_estructura_condominio
								WHERE R.id_residente = pIdResidente AND R.id_espacio_comun = pIdEspacioComun AND R.fecha_hora_inicio = pFechaHoraInicio) THEN

								set @ReturnValue  = -1;
		
						ELSEIF EXISTS ( SELECT 1 FROM registro_reserva_espacio_comun 
												WHERE id_espacio_comun = pIdEspacioComun AND 
												((pFechaHoraInicio BETWEEN fecha_hora_inicio AND fecha_hora_termino) OR (pFechaHoraTermino BETWEEN fecha_hora_inicio AND fecha_hora_termino))) THEN

												set @ReturnValue  = -2;
								
						ELSE

										INSERT INTO registro_reserva_espacio_comun (id_residente, id_espacio_comun, fecha_hora_registro, observacion, fecha_hora_inicio, fecha_hora_termino, usr_creacion, usr_ult_mod) VALUES
										(pIdResidente, pIdEspacioComun, NOW(), pObservación, pFechaHoraInicio, pFechaHoraTermino, pUsuario, pUsuario);

										set @ReturnValue  = 1;
					
		END IF;


WHEN 'U' THEN 

#PARAMETROS UTILIZADOS: pIdReserva, pObservacion, pFechaHoraInicio, pFechaHoraTermino,PuSUARIO

#Valida si existe la reserva
			IF NOT EXISTS (SELECT 1 FROM REGISTRO_RESERVA_ESPACIO_COMUN WHERE id_registro_reserva = pIdReserva) THEN
							
			set @ReturnValue  = -3;

	
#Valida si modificación esta antes de plazo disponible para modificar
					ELSEIF EXISTS ( SELECT 1 FROM REGISTRO_RESERVA_ESPACIO_COMUN WHERE id_registro_reserva = pIdReserva AND ((SEC_TO_TIME(TIMESTAMPDIFF(HOUR,DATE_SUB(NOW(), INTERVAL 60 MINUTE),fecha_hora_inicio)) * 1)-1) = 0) THEN

					set @ReturnValue  = -4;

					ELSE 
							
								set @idEspacioComun = (SELECT id_espacio_comun FROM REGISTRO_RESERVA_ESPACIO_COMUN where id_registro_reserva =pIdReserva);

#Valida si nuevas fechas/horas de entrada en modificación no se topan con alguna otra reserva
							IF EXISTS ( SELECT 1 FROM registro_reserva_espacio_comun 
												WHERE id_espacio_comun = @idEspacioComun AND 
												((pFechaHoraInicio BETWEEN fecha_hora_inicio AND fecha_hora_termino) OR (pFechaHoraTermino BETWEEN fecha_hora_inicio AND fecha_hora_termino)) and id_registro_reserva != pIdReserva) THEN

												set @ReturnValue  = -2;	

							ELSE

											UPDATE REGISTRO_RESERVA_ESPACIO_COMUN SET
											observacion = pObservacion,
											fecha_hora_inicio  = pFechaHoraInicio,
											fecha_hora_termino = pFechaHoraTermino,
											usr_ult_mod = pUsuario
											WHERE
											id_registro_reserva = pIdReserva;

						set @ReturnValue  = 2;

			END IF;
		END IF;
					
WHEN 'D' THEN 

#PARAMETROS UTILIZADOS: pIdReserva

#Valida si existe la reserva
	IF NOT EXISTS (SELECT 1 FROM REGISTRO_RESERVA_ESPACIO_COMUN WHERE id_registro_reserva = pIdReserva) THEN
							
			set @ReturnValue  = -3;

	
#Valida si modificación esta antes de plazo disponible para modificar
					ELSEIF EXISTS ( SELECT 1 FROM REGISTRO_RESERVA_ESPACIO_COMUN WHERE id_registro_reserva = pIdReserva AND ((SEC_TO_TIME(TIMESTAMPDIFF(HOUR,DATE_SUB(NOW(), INTERVAL 60 MINUTE),fecha_hora_inicio)) * 1)-1) = 0 ) THEN

					set @ReturnValue  = -4;

					ELSE 

					DELETE R.* FROM REGISTRO_RESERVA_ESPACIO_COMUN R WHERE id_registro_reserva = pIdReserva;

						set @ReturnValue  = 3;
	END IF;					

ELSE

set @ReturnValue  = 0;


END CASE;

END IF;
SELECT @ReturnValue AS valor;



END