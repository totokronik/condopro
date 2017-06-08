CREATE PROCEDURE `LOGIN_USUARIO_SP`(IN `pUsernameOrNumdoc` varchar(50),IN `pPassword` varchar(32))
BEGIN

##Procedimiento de validación de usuarios. Login

## Proceimiento utiliza metodo MD5() para encryptar password


/*Codigos de retorno
0 = Procedimiento terminado sin ejecutar querys
-2 = Password incorrecta
-1 = usuario y/o rut no existe
1 =  Usuario validado

*/

##String de Prueba
/*
Dato 1 (login ok OK, usando solo username y password OK) Existoso
'master_user','condopro',@pReturnValue

Dato 2 ( login Ok, usando solo numero de documento y password ok) Exitoso
'000123','condopro',@pReturnValue

Dato 3 ( login invalido, usando numero de documento ok y password incorrecta) Exitoso
'000123','condopr',@pReturnValue

Dato 4 ( login invalido, usando usernmae o nro doc incorrecto y password correcta) Exitoso
'','condopr',@pReturnValue


*/

set @pReturnValue = 0;

set @pass = MD5(pPassword);
	
			IF EXISTS ( SELECT 1 FROM USUARIOS WHERE numero_documento = pUsernameOrNumdoc or username = pUsernameOrNumdoc) THEN

				IF EXISTS ( SELECT 1 FROM USUARIOS WHERE (numero_documento = pUsernameOrNumdoc or username = pUsernameOrNumdoc) and `password` = @pass) THEN
									
						set @pReturnValue = 1;

				ELSE
			
						set @pReturnValue = -2;

				END IF;

			ELSE

					set @pReturnValue = -1;

			END IF;
			
			Select @pReturnValue as valor;
	
END