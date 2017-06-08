CREATE PROCEDURE `UPDATE_PASSWORD`(IN pUserID integer,IN `pUserMod` varchar(50),IN `pPasswordOld` varchar(32),IN `pPasswordNew` varchar(32))
BEGIN

##Procedimiento de validación de usuarios. Login

## Proceimiento utiliza metodo MD5() para encryptar password

/* Descripción Parametros
pUserId = Id de usuario a quien se le quiere actualizar PASSWORD
pUserMod = nombre de usuario, de usuario quien realiza el cambio de passowrd
pPasswordOld = Password existente para el usuario, antes de UPDATE
pPasswordNew = nueva password de usuarios.



/*Codigos de retorno
0 = Procedimiento terminado sin ejecutar querys
-1 = error al actualizar password (password no corresponde a usuario)
1 =  password Actualizada

*/

##String de Prueba
/*
Dato 1 password old ok, nueva passowrd ok, password actualizada : exitoso
1,'prueba','condopro','condopro1',@pReturnValue


*/

set @pReturnValue = 0;

set @oldpass = MD5(pPasswordOld);
set @newpass = MD5(pPasswordNew);
	
			IF EXISTS ( SELECT 1 FROM USUARIOS WHERE id_usuario = pUserId  and `password` = @oldpass) THEN

					UPDATE usuarios SET
					`password` = @newpass,
					usr_ult_mod = pUserMod
					WHERE id_usuario = pUserID;
					
					set @pReturnValue = 1;

				ELSE
			
					set @pReturnValue = -1;

				END IF;
				
		SELECT @pReturnValue as Valor;
	
END