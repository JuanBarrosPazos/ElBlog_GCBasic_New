<?php
session_start();

	require '../Gcb.Inclu/error_hidden.php';
	require '../Gcb.Inclu/Admin_Inclu_popup.php';

	require '../Gcb.Connet/conection.php';
	require '../Gcb.Connet/conect.php';
	require '../Gcb.Inclu/my_bbdd_clave.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if ($_SESSION['Nivel'] == 'admin'){
				
	global $nombre;
	global $apellido;
	$nombre = $_POST['Nombre'];
	$apellido = $_POST['Apellidos'];
							
		if($_POST['oculto2']){  process_form();
								info();
								} 
		} else { require '../Gcb.Inclu/table_permisos.php'; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $nombre;
	global $apellido;
	$nombre = $_POST['Nombre'];
	$apellido = $_POST['Apellidos'];


	print("<table align='center'>
				<tr>
					<th colspan=3  class='BorderInf'>
						ESTOS SON LOS DATOS DE SU CONSULTA
					</th>
				</tr>
			");

	global $rutaimg;
	$rutaimg = "src='../Gcb.Img.User/".$_POST['myimg']."'";
	require 'table_data_resum.php';
	require 'table_data_resum_feed.php';
				
	require 'Admin_Botonera.php';

	print(" <tr><td colspan=3 align='right' class='BorderSup'>".$closewindow."</td></tr></table>");	

	}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function info(){

	global $nombre;
	global $apellido;	
	
	$rf = $_POST['ref'];
	$nombre = $_POST['Nombre'];
	$apellido = $_POST['Apellidos'];
		
	$ActionTime = date('H:i:s');
	
	global $dir;
	$dir = "../Gcb.Log";

	global $text;
	$text = PHP_EOL."- ADMIN FEEDBACK DETALLES ".$ActionTime.PHP_EOL."\t Nombre: ".$nombre." ".$apellido;
	
	$logdocu = $_SESSION['ref'];
	$logdate = date('Y_m_d');
	$logtext = $text.PHP_EOL;
	$filename = $dir."/".$logdate."_".$logdocu.".log";
	$log = fopen($filename, 'ab+');
	fwrite($log, $logtext);
	fclose($log);

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require '../Gcb.Inclu/Admin_Inclu_footer.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

/* Creado por Juan Barros Pazos 2021 */
?>