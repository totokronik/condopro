
CREATE PROCEDURE `SP_PERFILAMIENTO_USUARIOS_CONDOMINIOS`
(IN `pIdUsuario` integer,
IN `pIdCondominio` integer)
BEGIN
	
#
####Procedimiento de control de perfil de usuarios 
/*

### Valores de permiso
MASTER_USER = -1

 RESIDENTE = 1

PERSONAL
 
 CONSERJE = 10
 MAYORDOMO = 20
 ADMINISTRADOR = 30

LA SUMA DE LOS VALORES DE UN PERSONAL + RESIDENTE, ES LA ENTREGA DE LOS PRIVILEGIOS (Ver Case Final)

####CODIGOS DE RETORNO
0 = NO PROCESA NADA / ERROR
-1 = ID USUARIO CORRESPONDE A MASTER USER
1 = SOLO RESIDENTE
2 = SOLO CONSERJE
3 = SOLO MAYORDOMO
4 =  SOLO ADMIN. CONDOMINIOS
5 = CONSERJE Y RESIDENTYE
6 = MAYORDOMO Y RESIDENTE
7= ADMIN. CONDOMINIO Y RESIENTE

*/

set @CalculoPerfil = 0;
set @IdMasterUser = 0;  ##Valor fijo




set @pReturnValue = 0;

### Valida si usuario es master user
	IF EXISTS ( SELECT 1 FROM USUARIOS WHERE pIdUsuario = @IdMasterUser ) THEN

					set @CalculoPerfil = -1; 


					ELSE
#Busqueda como residente

			IF EXISTS ( SELECT 1 
									FROM RESIDENTE_CONDOMINIO as r INNER JOIN ESTRUCTURA_CONDOMINIO as e ON r.id_estructura_condominio = e.id_estructura_condominio
									WHERE r.id_usuario = pIdUsuario and e.id_condominio = pIdCondominio and r.activo = 1 ) THEN
					
				set @CalculoPerfil =  1;

			ELSE 

				set @CalculoPerfil = 0;

			END IF;

##### Busqueda como personal
			IF EXISTS ( SELECT 1 FROM PERSONAL_CONDOMINIO WHERE id_usuario = pIdUsuario AND id_condominio = pIdCondominio and activo = 1 ) THEN
					
				set @RolUsuario = (SELECT id_rol FROM PERSONAL_CONDOMINIO WHERE id_usuario = pIdUsuario AND id_condominio = pIdCondominio and activo = 1);
	

										CASE @RolUsuario

											WHEN 1 THEN

												set @CalculoPerfil = @CalculoPerfil + 30;

											WHEN 2 THEN

												set @CalculoPerfil = @CalculoPerfil + 20;

											WHEN 3 THEN

												set @CalculoPerfil = @CalculoPerfil + 10;

											ELSE

												set @CalculoPerfil = @CalculoPerfil;

										END CASE;

				ELSE 

				set @CalculoPerfil = @CalculoPerfil ;

			END IF;
END IF;

CASE @CalculoPerfil

											WHEN -1 THEN
											##master_user
												set @pReturnValue = -1;

											WHEN 1 THEN
											##solo residente
												set @pReturnValue = 1;

											WHEN 10 THEN
											##Conserje
												set @pReturnValue = 2;

											WHEN 20 THEN
											##Mayordomo
												set @pReturnValue = 3;

											WHEN 30 THEN
											##Administrador condominio
												set @pReturnValue = 4;

											WHEN 11 THEN
											##Conserje y residente
												set @pReturnValue = 5;

											WHEN 21 THEN
											##mayordomo y residente
												set @pReturnValue = 6;

											WHEN 31 THEN
											##Administrador condominio y residente
												set @pReturnValue = 7;

											ELSE
											## No cuenta con ningun acceso / error de validacion 
												set @pReturnValue = 0;

										END CASE;


#Select @pReturnValue as valor, @CalculoPerfil as calculo;
Select @pReturnValue as valor;

END;

