<?php
	function MostrarNavegadorPrincipal($perfil){
		$msg = "";
		switch ($perfil) {
			case -1:
			$msg .= "<li>
				<a href='index.php'><i class='fa fa-dashboard fa-fw'></i> Tablero</a>
			</li>
			<li>
				<a href='#'><i class='fa fa-wrench fa-fw'></i> Administración<span class='fa arrow'></span></a>
				<ul class='nav nav-second-level'>
					<li>
						<a href='Modulo_usuario/usuario.index.php'>Usuarios</a>
					</li>
					<li>
						<a href='Modulo_personal/personal.index.php'>Personal</a>
					</li>
				</ul>
				<!-- /.nav-second-level -->
			</li>
			<li>
				<a href='Modulo_condominio/condominio.index.php'><i class='fa fa-table fa-fw'></i> Condominios</a>
			</li>
			<li>
				<a href='Modulo_estructura_condominio/estructura.index.php'><i class='fa fa-building fa-fw'></i> Estructura Condominio</a>
			</li>";
			break;
			case 1:
			$msg .= "<li>
				<a href='index.php'><i class='fa fa-dashboard fa-fw'></i> Tablero</a>
			</li>
			<li>
				<a href='#'><i class='fa fa-users fa-fw'></i> Población Flotante<span class='fa arrow'></span></a>
				<ul class='nav nav-second-level'>
					<li>
						<a href='Modulo_registrar_entrada/entrada.index.php'>Registrar Entrada</a>
					</li>
				</ul>
			</li>
			<li>
				<a href='Modulo_reserva_espacio_comun/reserva.index.php'><i class='fa fa-table fa-fw'></i> Reserva espacio común</a>
			</li>";
			break;
			case 2:
			$msg .= "<li>
				<a href='index.php'><i class='fa fa-dashboard fa-fw'></i> Tablero</a>
			</li>
			<li>
				<a href='#'><i class='fa fa-users fa-fw'></i> Población Flotante<span class='fa arrow'></span></a>
				<ul class='nav nav-second-level'>
					<li>
						<a href='Modulo_registrar_entrada/entrada.index.php'>Registrar Entrada</a>
					</li>
				</ul>
			</li>
			<li>
				<a href='#'><i class='fa fa-wrench fa-fw'></i> Administración<span class='fa arrow'></span></a>
				<ul class='nav nav-second-level'>
					<li>
						<a href='Modulo_residente/residente.index.php'>Residentes</a>
					</li>
				</ul>
			</li>
			<li>
				<a href='Modulo_reserva_espacio_comun/reserva.index.php'><i class='fa fa-table fa-fw'></i> Reserva espacio común</a>
			</li>";
			break;
			case 3:
			$msg .= "<li>
				<a href='index.php'><i class='fa fa-dashboard fa-fw'></i> Tablero</a>
			</li>
			<li>
				<a href='#'><i class='fa fa-users fa-fw'></i> Población Flotante<span class='fa arrow'></span></a>
				<ul class='nav nav-second-level'>
					<li>
						<a href='Modulo_registrar_entrada/entrada.index.php'>Registrar Entrada</a>
					</li>
				</ul>
			</li>
			<li>
				<a href='#'><i class='fa fa-wrench fa-fw'></i> Administración<span class='fa arrow'></span></a>
				<ul class='nav nav-second-level'>
					<li>
						<a href='Modulo_personal/personal.index.php'>Personal</a>
					</li>
					<li>
						<a href='Modulo_residente/residente.index.php'>Residentes</a>
					</li>
				</ul>
			</li>
			<li>
				<a href='Modulo_espacio_comun/espacio.index.php'><i class='fa fa-bicycle fa-fw'></i> Espacio Común</a>
			</li>
			<li>
				<a href='Modulo_reserva_espacio_comun/reserva.index.php'><i class='fa fa-table fa-fw'></i> Reserva espacio común</a>
			</li>
			<li>
				<a href='Modulo_estructura_condominio/estructura.index.php'><i class='fa fa-building fa-fw'></i> Estructura Condominio</a>
			</li>";
			break;
			case 4:
			$msg .=  "<li>
				<a href='index.php'><i class='fa fa-dashboard fa-fw'></i> Tablero</a>
			</li>
			<li>
				<a href='#'><i class='fa fa-users fa-fw'></i> Población Flotante<span class='fa arrow'></span></a>
				<ul class='nav nav-second-level'>
					<li>
						<a href='Modulo_registrar_entrada/entrada.index.php'>Registrar Entrada</a>
					</li>
				</ul>
			</li>
			<li>
				<a href='#'><i class='fa fa-wrench fa-fw'></i> Administración<span class='fa arrow'></span></a>
				<ul class='nav nav-second-level'>
					<li>
						<a href='Modulo_usuario/usuario.index.php'>Usuarios</a>
					</li>
					<li>
						<a href='Modulo_personal/personal.index.php'>Personal</a>
					</li>
					<li>
						<a href='Modulo_residente/residente.index.php'>Residentes</a>
					</li>
				</ul>
			</li>
			<li>
				<a href='Modulo_espacio_comun/espacio.index.php'><i class='fa fa-bicycle fa-fw'></i> Espacio Común</a>
			</li>
			<li>
				<a href='Modulo_reserva_espacio_comun/reserva.index.php'><i class='fa fa-table fa-fw'></i> Reserva espacio común</a>
			</li>
			<li>
				<a href='Modulo_estructura_condominio/estructura.index.php'><i class='fa fa-building fa-fw'></i> Estructura Condominio</a>
			</li>";
			break;
			case 5:
			$msg .=   "<li>
				<a href='index.php'><i class='fa fa-dashboard fa-fw'></i> Tablero</a>
			</li>
			<li>
				<a href='#'><i class='fa fa-users fa-fw'></i> Población Flotante<span class='fa arrow'></span></a>
				<ul class='nav nav-second-level'>
					<li>
						<a href='Modulo_registrar_entrada/entrada.index.php'>Registrar Entrada</a>
					</li>
				</ul>
			</li>
			<li>
				<a href='#'><i class='fa fa-wrench fa-fw'></i> Administración<span class='fa arrow'></span></a>
				<ul class='nav nav-second-level'>
					<li>
						<a href='Modulo_residente/residente.index.php'>Residentes</a>
					</li>
				</ul>
			</li>
			<li>
				<a href='Modulo_reserva_espacio_comun/reserva.index.php'><i class='fa fa-table fa-fw'></i> Reserva espacio común</a>
			</li>";
			break;
			case 6:
			$msg .=  "<li>
				<a href='index.php'><i class='fa fa-dashboard fa-fw'></i> Tablero</a>
			</li>
			<li>
				<a href='#'><i class='fa fa-users fa-fw'></i> Población Flotante<span class='fa arrow'></span></a>
				<ul class='nav nav-second-level'>
					<li>
						<a href='Modulo_registrar_entrada/entrada.index.php'>Registrar Entrada</a>
					</li>
				</ul>
			</li>
			<li>
				<a href='#'><i class='fa fa-wrench fa-fw'></i> Administración<span class='fa arrow'></span></a>
				<ul class='nav nav-second-level'>
					<li>
						<a href='Modulo_personal/personal.index.php'>Personal</a>
					</li>
					<li>
						<a href='Modulo_residente/residente.index.php'>Residentes</a>
					</li>
				</ul>
			</li>
			<li>
				<a href='Modulo_espacio_comun/espacio.index.php'><i class='fa fa-bicycle fa-fw'></i> Espacio Común</a>
			</li>
			<li>
				<a href='Modulo_reserva_espacio_comun/reserva.index.php'><i class='fa fa-table fa-fw'></i> Reserva espacio común</a>
			</li>
			<li>
				<a href='Modulo_estructura_condominio/estructura.index.php'><i class='fa fa-building fa-fw'></i> Estructura Condominio</a>
			</li>";
			break;
			case 7:
			$msg .=  "<li>
				<a href='index.php'><i class='fa fa-dashboard fa-fw'></i> Tablero</a>
			</li>
			<li>
				<a href='#'><i class='fa fa-users fa-fw'></i> Población Flotante<span class='fa arrow'></span></a>
				<ul class='nav nav-second-level'>
					<li>
						<a href='Modulo_registrar_entrada/entrada.index.php'>Registrar Entrada</a>
					</li>
				</ul>
			</li>
			<li>
				<a href='#'><i class='fa fa-wrench fa-fw'></i> Administración<span class='fa arrow'></span></a>
				<ul class='nav nav-second-level'>
					<li>
						<a href='Modulo_usuario/usuario.index.php'>Usuarios</a>
					</li>
					<li>
						<a href='Modulo_personal/personal.index.php'>Personal</a>
					</li>
					<li>
						<a href='Modulo_residente/residente.index.php'>Residentes</a>
					</li>
				</ul>
			</li>
			<li>
				<a href='Modulo_espacio_comun/espacio.index.php'><i class='fa fa-bicycle fa-fw'></i> Espacio Común</a>
			</li>
			<li>
				<a href='Modulo_reserva_espacio_comun/reserva.index.php'><i class='fa fa-table fa-fw'></i> Reserva espacio común</a>
			</li>
			<li>
				<a href='Modulo_estructura_condominio/estructura.index.php'><i class='fa fa-building fa-fw'></i> Estructura Condominio</a>
			</li>";
			break;
		}
		return $msg;
	}

	function MostrarNavegadorSecundario($perfil){
		$msg = "";
		switch ($perfil) {
			case -1:
			$msg .= "<li>
				<a href='../index.php'><i class='fa fa-dashboard fa-fw'></i> Tablero</a>
			</li>
			<li>
				<a href='#'><i class='fa fa-wrench fa-fw'></i> Administración<span class='fa arrow'></span></a>
				<ul class='nav nav-second-level'>
					<li>
						<a href='../Modulo_usuario/usuario.index.php'>Usuarios</a>
					</li>
					<li>
						<a href='../Modulo_personal/personal.index.php'>Personal</a>
					</li>
				</ul>
				<!-- /.nav-second-level -->
			</li>
			<li>
				<a href='../Modulo_condominio/condominio.index.php'><i class='fa fa-table fa-fw'></i> Condominios</a>
			</li>
			<li>
				<a href='../Modulo_estructura_condominio/estructura.index.php'><i class='fa fa-building fa-fw'></i> Estructura Condominio</a>
			</li>";
			break;
			case 1:
			$msg .= "<li>
				<a href='../index.php'><i class='fa fa-dashboard fa-fw'></i> Tablero</a>
			</li>
			<li>
				<a href='#'><i class='fa fa-users fa-fw'></i> Población Flotante<span class='fa arrow'></span></a>
				<ul class='nav nav-second-level'>
					<li>
						<a href='../Modulo_registrar_entrada/entrada.index.php'>Registrar Entrada</a>
					</li>
				</ul>
			</li>
			<li>
				<a href='../Modulo_reserva_espacio_comun/reserva.index.php'><i class='fa fa-table fa-fw'></i> Reserva espacio común</a>
			</li>";
			break;
			case 2:
			$msg .= "<li>
				<a href='../index.php'><i class='fa fa-dashboard fa-fw'></i> Tablero</a>
			</li>
			<li>
				<a href='#'><i class='fa fa-users fa-fw'></i> Población Flotante<span class='fa arrow'></span></a>
				<ul class='nav nav-second-level'>
					<li>
						<a href='../Modulo_registrar_entrada/entrada.index.php'>Registrar Entrada</a>
					</li>
				</ul>
			</li>
			<li>
				<a href='#'><i class='fa fa-wrench fa-fw'></i> Administración<span class='fa arrow'></span></a>
				<ul class='nav nav-second-level'>
					<li>
						<a href='../Modulo_residente/residente.index.php'>Residentes</a>
					</li>
				</ul>
			</li>
			<li>
				<a href='../Modulo_reserva_espacio_comun/reserva.index.php'><i class='fa fa-table fa-fw'></i> Reserva espacio común</a>
			</li>";
			break;
			case 3:
			$msg .= "<li>
				<a href='../index.php'><i class='fa fa-dashboard fa-fw'></i> Tablero</a>
			</li>
			<li>
				<a href='#'><i class='fa fa-users fa-fw'></i> Población Flotante<span class='fa arrow'></span></a>
				<ul class='nav nav-second-level'>
					<li>
						<a href='../Modulo_registrar_entrada/entrada.index.php'>Registrar Entrada</a>
					</li>
				</ul>
			</li>
			<li>
				<a href='#'><i class='fa fa-wrench fa-fw'></i> Administración<span class='fa arrow'></span></a>
				<ul class='nav nav-second-level'>
					<li>
						<a href='../Modulo_personal/personal.index.php'>Personal</a>
					</li>
					<li>
						<a href='../Modulo_residente/residente.index.php'>Residentes</a>
					</li>
				</ul>
			</li>
			<li>
				<a href='../Modulo_espacio_comun/espacio.index.php'><i class='fa fa-bicycle fa-fw'></i> Espacio Común</a>
			</li>
			<li>
				<a href='../Modulo_reserva_espacio_comun/reserva.index.php'><i class='fa fa-table fa-fw'></i> Reserva espacio común</a>
			</li>
			<li>
				<a href='../Modulo_estructura_condominio/estructura.index.php'><i class='fa fa-building fa-fw'></i> Estructura Condominio</a>
			</li>";
			break;
			case 4:
			$msg .=  "<li>
				<a href='../index.php'><i class='fa fa-dashboard fa-fw'></i> Tablero</a>
			</li>
			<li>
				<a href='#'><i class='fa fa-users fa-fw'></i> Población Flotante<span class='fa arrow'></span></a>
				<ul class='nav nav-second-level'>
					<li>
						<a href='../Modulo_registrar_entrada/entrada.index.php'>Registrar Entrada</a>
					</li>
				</ul>
			</li>
			<li>
				<a href='#'><i class='fa fa-wrench fa-fw'></i> Administración<span class='fa arrow'></span></a>
				<ul class='nav nav-second-level'>
					<li>
						<a href='../Modulo_usuario/usuario.index.php'>Usuarios</a>
					</li>
					<li>
						<a href='../Modulo_personal/personal.index.php'>Personal</a>
					</li>
					<li>
						<a href='../Modulo_residente/residente.index.php'>Residentes</a>
					</li>
				</ul>
			</li>
			<li>
				<a href='../Modulo_espacio_comun/espacio.index.php'><i class='fa fa-bicycle fa-fw'></i> Espacio Común</a>
			</li>
			<li>
				<a href='../Modulo_reserva_espacio_comun/reserva.index.php'><i class='fa fa-table fa-fw'></i> Reserva espacio común</a>
			</li>
			<li>
				<a href='../Modulo_estructura_condominio/estructura.index.php'><i class='fa fa-building fa-fw'></i> Estructura Condominio</a>
			</li>";
			break;
			case 5:
			$msg .=   "<li>
				<a href='../index.php'><i class='fa fa-dashboard fa-fw'></i> Tablero</a>
			</li>
			<li>
				<a href='#'><i class='fa fa-users fa-fw'></i> Población Flotante<span class='fa arrow'></span></a>
				<ul class='nav nav-second-level'>
					<li>
						<a href='../Modulo_registrar_entrada/entrada.index.php'>Registrar Entrada</a>
					</li>
				</ul>
			</li>
			<li>
				<a href='#'><i class='fa fa-wrench fa-fw'></i> Administración<span class='fa arrow'></span></a>
				<ul class='nav nav-second-level'>
					<li>
						<a href='../Modulo_residente/residente.index.php'>Residentes</a>
					</li>
				</ul>
			</li>
			<li>
				<a href='../Modulo_reserva_espacio_comun/reserva.index.php'><i class='fa fa-table fa-fw'></i> Reserva espacio común</a>
			</li>";
			break;
			case 6:
			$msg .=  "<li>
				<a href='../index.php'><i class='fa fa-dashboard fa-fw'></i> Tablero</a>
			</li>
			<li>
				<a href='#'><i class='fa fa-users fa-fw'></i> Población Flotante<span class='fa arrow'></span></a>
				<ul class='nav nav-second-level'>
					<li>
						<a href='../Modulo_registrar_entrada/entrada.index.php'>Registrar Entrada</a>
					</li>
				</ul>
			</li>
			<li>
				<a href='#'><i class='fa fa-wrench fa-fw'></i> Administración<span class='fa arrow'></span></a>
				<ul class='nav nav-second-level'>
					<li>
						<a href='../Modulo_personal/personal.index.php'>Personal</a>
					</li>
					<li>
						<a href='../Modulo_residente/residente.index.php'>Residentes</a>
					</li>
				</ul>
			</li>
			<li>
				<a href='../Modulo_espacio_comun/espacio.index.php'><i class='fa fa-bicycle fa-fw'></i> Espacio Común</a>
			</li>
			<li>
				<a href='../Modulo_reserva_espacio_comun/reserva.index.php'><i class='fa fa-table fa-fw'></i> Reserva espacio común</a>
			</li>
			<li>
				<a href='../Modulo_estructura_condominio/estructura.index.php'><i class='fa fa-building fa-fw'></i> Estructura Condominio</a>
			</li>";
			break;
			case 7:
			$msg .=  "<li>
				<a href='../index.php'><i class='fa fa-dashboard fa-fw'></i> Tablero</a>
			</li>
			<li>
				<a href='#'><i class='fa fa-users fa-fw'></i> Población Flotante<span class='fa arrow'></span></a>
				<ul class='nav nav-second-level'>
					<li>
						<a href='../Modulo_registrar_entrada/entrada.index.php'>Registrar Entrada</a>
					</li>
				</ul>
			</li>
			<li>
				<a href='#'><i class='fa fa-wrench fa-fw'></i> Administración<span class='fa arrow'></span></a>
				<ul class='nav nav-second-level'>
					<li>
						<a href='../Modulo_usuario/usuario.index.php'>Usuarios</a>
					</li>
					<li>
						<a href='../Modulo_personal/personal.index.php'>Personal</a>
					</li>
					<li>
						<a href='../Modulo_residente/residente.index.php'>Residentes</a>
					</li>
				</ul>
			</li>
			<li>
				<a href='../Modulo_espacio_comun/espacio.index.php'><i class='fa fa-bicycle fa-fw'></i> Espacio Común</a>
			</li>
			<li>
				<a href='../Modulo_reserva_espacio_comun/reserva.index.php'><i class='fa fa-table fa-fw'></i> Reserva espacio común</a>
			</li>
			<li>
				<a href='../Modulo_estructura_condominio/estructura.index.php'><i class='fa fa-building fa-fw'></i> Estructura Condominio</a>
			</li>";
			break;
		}
		return $msg;
	}
?>