<?php
session_start();

	global $docs;
	$docs = 1;
	
	require '../Gcb.Inclu/error_hidden.php';
	require '../Gcb.Inclu/Admin_Inclu_popup.php';
	require '../Gcb.Connet/conection.php';
	require '../Gcb.Connet/conect.php';

/* OJO SOLO PARA VALIDATE.PHP
$sqld =  "SELECT * FROM `gcb_admin` WHERE `ref` = '$_SESSION[ref]' AND `Usuario` = '$_SESSION[Usuario]'";
$qd = mysqli_query($db, $sqld);
$rowd = mysqli_fetch_assoc($qd);
*/

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if (($_SESSION['Nivel'] == 'admin') || ($_SESSION['Nivel'] == 'user') || ($_SESSION['Nivel'] == 'plus')){

	//master_index();

	if (isset($_POST['oculto2'])){
		show_form();
		info_01();
		}
	elseif($_POST['modifica']){
			if($form_errors = validate_form()){
				show_form($form_errors);
					} else {
						process_form();
						info_02();
						unset($_SESSION['refcl']);
						}
		} else { show_form(); }
	} else { require '../Gcb.Inclu/table_permisos.php'; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_form(){
	
		/* global $sqld; global $qd; global $rowd; */
	
	require '../Gcb.Inclu/validate.php';	
		
		return $errors;

	} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $db;
	global $db_name;

	global $nombre;
	global $apellido;
	$nombre = $_POST['Nombre'];
	$apellido = $_POST['Apellidos'];
	
	global $password;
	$password = $_POST['Password'] ;
	global $passwordhash;
	$passwordhash = password_hash($password, PASSWORD_DEFAULT, array ( "cost"=>10));

	if ($_SESSION['Nivel'] == 'admin') {
		
	$sqlc = "UPDATE `$db_name`.`gcb_admin` SET `Nivel` = '$_POST[Nivel]', `Nombre` = '$_POST[Nombre]', `Apellidos` = '$_POST[Apellidos]', `doc` = '$_POST[doc]', `dni` = '$_POST[dni]', `ldni` = '$_POST[ldni]', `Email` = '$_POST[Email]', `Usuario` = '$_POST[Usuario]', `Password` = '$passwordhash', `Pass` = '$password', `Direccion` = '$_POST[Direccion]', `Tlf1` = '$_POST[Tlf1]', `Tlf2` = '$_POST[Tlf2]' WHERE `gcb_admin`.`id` = '$_POST[id]' LIMIT 1 ";

	if(mysqli_query($db, $sqlc)){ 	
		
	if (($_SESSION['dni'] == $_SESSION['mydni']) && ($_SESSION['id'] == $_POST['id']) && ($_POST['dni'] != $_SESSION['mydni'])) { 	$_SESSION['dni'] = $_POST['dni'];
							// CREA EL ARCHIVO MYDNI.TXT $_SESSION['mydni'].
							$filename = "../Gcb.Inclu/mydni.php";
							$fw2 = fopen($filename, 'w+');
							$mydni = '<?php $_SESSION[\'mydni\'] = '.$_POST['dni'].'; ?>';
							fwrite($fw2, $mydni);
							fclose($fw2);
										}
	elseif (($_SESSION['dni'] != $_SESSION['mydni']) && ($_SESSION['id'] == $_POST['id']) && ($_POST['dni'] != $_SESSION['dni'])) { 
							$_SESSION['dni'] = $_POST['dni'];
					}else{ }
								 
					require '../Gcb.Inclu/mydni.php';

		print("<table align='center' style=\"margin-top:20px\">
				<tr>
					<th colspan=3  class='BorderInf'>
						NUEVOS DATOS DEL USUARIO.
					</th>
				</tr>");

				global $rutaimg;
				$rutaimg = "src='../Gcb.Img.User/".$_SESSION['myimgcl']."'";
				require 'table_data_resum.php';

		require 'Admin_Botonera.php';

		print("<tr><td colspan=3 style='text-align:right;' class='BorderSup BorderInf'>
					".$closewindow."</td></tr></table>");

				} else {
				print("<font color='#FF0000'>
						* MODIFIQUE LA ENTRADA 220: </font>
						</br>
						&nbsp;&nbsp;&nbsp;".mysqli_error($db))."
						</br>";
						show_form ();
						global $texerror;
						$texerror = "\n\t ".mysqli_error($db);
							}
		
					} // FIN CONDICIONAL ADMIN
	
	elseif (($_SESSION['Nivel'] == 'user') || ($_SESSION['Nivel'] == 'plus')){
		
			$sqlc = "UPDATE `$db_name`.`gcb_admin` SET `Nivel` = '$_POST[Nivel]', `Nombre` = '$_POST[Nombre]', `Apellidos` = '$_POST[Apellidos]', `Email` = '$_POST[Email]', `Direccion` = '$_POST[Direccion]', `Tlf1` = '$_POST[Tlf1]', `Tlf2` = '$_POST[Tlf2]' WHERE `gcb_admin`.`id` = '$_POST[id]' LIMIT 1 ";

	if(mysqli_query($db, $sqlc)){ 
		print("<table align='center' style=\"margin-top:20px\">
				<tr>
					<th colspan=3  class='BorderInf'>
						NUEVOS DATOS DEL USUARIO.
					</th>
				</tr>");

				global $rutaimg;
				$rutaimg = "src='../Gcb.Img.User/".$_SESSION['myimgcl']."'";
				require 'table_data_resum.php';

	require 'Admin_Botonera.php';

	print("<tr><td colspan=3 style='text-align:right;' class='BorderSup BorderInf'>
					".$closewindow."</td></tr></table>");

		} else {print("<font color='#FF0000'>
						* MODIFIQUE LA ENTRADA 241: </font>
						</br>
						&nbsp;&nbsp;&nbsp;".mysqli_error($db))."
						</br>";
						show_form ();
						global $texerror;
						$texerror = "\n\t ".mysqli_error($db);
							}
					} // FIN CONDICIONAL USER / PLUS
	
 	} // FIN FUNCTION PROCESS_FORM

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
			
function show_form($errors=[]){
	
			require '../Gcb.Inclu/mydni.php';

	if(isset($_POST['oculto2'])){

				$_SESSION['refcl'] = $_POST['ref'];
				$_SESSION['myimgcl'] = $_POST['myimg'];
				
				global $dt;
				$dt = $_POST['doc'];

				global $defaults;
				$defaults = array ( 'id' => $_POST['id'],
									'ref' => $_POST['ref'],
									'Nombre' => $_POST['Nombre'],
									'Apellidos' => $_POST['Apellidos'],
									'myimg' => $_SESSION['myimgcl'],
									'Nivel' => $_POST['Nivel'],			
									'doc' => $dt,
									'dni' => $_POST['dni'],
									'ldni' => $_POST['ldni'],
									'Email' => $_POST['Email'],
									'Usuario' => $_POST['Usuario'],
									'Usuario2' => $_POST['Usuario'],
									'Password' => $_POST['Pass'],
									'Password2' => $_POST['Pass'],
									'Direccion' => $_POST['Direccion'],
									'Tlf1' => $_POST['Tlf1'],
									'Tlf2' => $_POST['Tlf2']);
												}
								   
		elseif(isset($_POST['modifica'])){
			
			global $dt;
			$dt = $_POST['doc'];
			
			global $defaults;
			$defaults = array ( 'id' => $_POST['id'],
								'ref' => $_SESSION['refcl'],
								'Nombre' => $_POST['Nombre'],
								'Apellidos' => $_POST['Apellidos'],
								'myimg' => $_SESSION['myimgcl'],
								'Nivel' => $_POST['Nivel'],						
								'doc' => $dt,
								'dni' => $_POST['dni'],
								'ldni' => $_POST['ldni'],
								'Email' => $_POST['Email'],
								'Usuario' => $_POST['Usuario'],
								'Usuario2' => $_POST['Usuario2'],
								'Password' => $_POST['Password'],
								'Password2' => $_POST['Password2'],
								'Direccion' => $_POST['Direccion'],
								'Tlf1' => $_POST['Tlf1'],
								'Tlf2' => $_POST['Tlf2']);
												}
		else {  global $defaults;
				$defaults = array ( 'id' => $defaults['id'],
									'ref' => $defaults['ref'],
									'Nombre' => $defaults['Nombre'],
									'Apellidos' => $defaults['Apellidos'],
									'myimg' => $defaults['myimgcl'],
									'Nivel' => $defaults['Nivel'],			
									'doc' => $defaults['doc'],
									'dni' => $defaults['dni'],
									'ldni' => $defaults['ldni'],
									'Email' => $defaults['Email'],
									'Usuario' => $defaults['Usuario'],
									'Usuario2' => $defaults['Usuario'],
									'Password' => $defaults['Pass'],
									'Password2' => $defaults['Pass'],
									'Direccion' => $defaults['Direccion'],
									'Tlf1' => $defaults['Tlf1'],
									'Tlf2' => $defaults['Tlf2']);
					}
	
	if ($errors){
		print("<table align='center'>
					<tr>
						<th style='text-align:center'>
							<font color='#FF0000'>* SOLUCIONE ESTOS ERRORES:</font><br/>
						</th>
					</tr>
					<tr>
					<td style='text-align:left'>");
			
		for($a=0; $c=count($errors), $a<$c; $a++){
			print("<font color='#FF0000'>**</font>  ".$errors [$a]."<br/>");
			}
		print("</td>
				</tr>
				</table>");
					}
		
	$Nivel = array (	'' => 'NIVEL USUARIO',
						'admin' => 'ADMINISTRADOR',
						'plus' => 'USER PLUS',
						'user'  => 'USER',
						'close'  => 'CLOSE', );														

	$doctype = array (	'DNI' => 'DNI/NIF Espa&ntilde;oles',
						'NIE' => 'NIE/NIF Extranjeros',
						'NIFespecial' => 'NIF Persona F&iacute;sica Especial',
						/*
						'NIFsa' => 'NIF Sociedad An&oacute;nima',
						'NIFsrl' => 'NIF Sociedad Responsabilidad Limitada',
						'NIFscol' => 'NIF Sociedad Colectiva',
						'NIFscom' => 'NIF Sociedad Comanditaria',
						'NIFcbhy' => 'NIF Comunidad Bienes y Herencias Yacentes',
						'NIFscoop' => 'NIF Sociedades Cooperativas',
						'NIFasoc' => 'NIF Asociaciones',
						'NIFcpph' => 'NIF Comunidad Propietarios Propiedad Horizontal',
						'NIFsccspj' => 'NIF Sociedad Civil, con o sin Personalidad Juridica',
						'NIFee' => 'NIF Entidad Extranjera',
						'NIFcl' => 'NIF Corporaciones Locales',
						'NIFop' => 'NIF Organismo Publico',
						'NIFcir' => 'NIF Congragaciones Instituciones Religiosas',
						'NIFoaeca' => 'NIF Organos Admin Estado y Comunidades Autonomas',
						'NIFute' => 'NIF Uniones Temporales de Empresas',
						'NIFotnd' => 'NIF Otros Tipos no Definidos',
						'NIFepenr' => 'NIF Establecimientos Permanentes Entidades no Residentes',
						*/		);
	
	if ($_SESSION['Nivel'] == 'admin'){
	
		global $modifadmin;
		$modifadmin = 1;
		require 'table_crea_admin.php';
		
	} // FIN IF ADMIN
	
		
	elseif(($_SESSION['Nivel'] == 'user') || ($_SESSION['Nivel'] == 'plus')){
	
		global $modifadmin;
		$modifadmin = 1;
		require 'table_crea_admin.php';

			} // FIN ELSE IF USER / PLUS
	
	} // FIN FUNCTION SHOW_FOMR

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){
		
		require '../Gcb.Inclu.Menu/rutaadmin.php';
		require '../Gcb.Inclu.Menu/Master_Index.php';
		
		} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function info_02(){

	global $ruta;
	
	$ActionTime = date('H:i:s');
	
	if($_SESSION['refcl'] == $_SESSION['ref']){	global $ruta;
												$ruta = $_SESSION['refcl'];}
	elseif($_SESSION['refcl'] != $_SESSION['ref']){	global $ruta;
													$ruta = $_SESSION['ref'];}
	
	global $dir;
	$dir = "../Gcb.Log";
	
	global $text;
	$text = PHP_EOL."- USER MODIFICADO ".$ActionTime.PHP_EOL."\t ID:".$_POST['id'].PHP_EOL."\t Nombre: ".$_POST['Nombre']." ".$_POST['Apellidos'].PHP_EOL."\t Ref: ".$_SESSION['ref'].PHP_EOL."\t Nivel: ".$_POST['Nivel'].PHP_EOL."\t User: ".$_POST['Usuario'].".\n\t Pass: ".$_POST['Password'].".\n\t ".$_POST['doc'].": ".$_POST['dni'].$_POST['ldni'].".\n\t Email: ".$_POST['Email'].PHP_EOL."\t Direccion: ".$_POST['Direccion'].PHP_EOL."\t Telefono 1: ".$_POST['Tlf1'].PHP_EOL."\t Telefono 2: ".$_POST['Tlf2'].PHP_EOL."\t Imagen: ".$_POST['myimg'];

	$logdocu = $ruta;
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

function info_01(){

	global $texerror;

	global $orden;
	$orden = isset($_POST['Orden']);	

	$ActionTime = date('H:i:s');

	global $dir;
	$dir = "../Gcb.Log";
	
	global $text;
	$text = PHP_EOL."- USER MODIFICAR SELECCIONADO ".$ActionTime.PHP_EOL."\t ID:".$_POST['id'].PHP_EOL."\t Nombre: ".$_POST['Nombre']." ".$_POST['Apellidos'].PHP_EOL."\t Ref: ".$_POST['ref'].PHP_EOL."\t Nivel: ".$_POST['Nivel'].PHP_EOL."\t User: ".$_POST['Usuario'].".\n\t Pass: ".$_POST['Password'].".\n\t ".$_POST['doc'].": ".$_POST['dni'].$_POST['ldni'].".\n\t Email: ".$_POST['Email'].PHP_EOL."\t Direccion: ".$_POST['Direccion'].PHP_EOL."\t Telefono 1: ".$_POST['Tlf1'].PHP_EOL."\t Telefono 2: ".$_POST['Tlf2'].PHP_EOL."\t Imagen: ".$_POST['myimg'];

	$logdocu = $_SESSION['ref'];
	$logdate = date('Y_m_d');
	$logtext = $text.$texerror.PHP_EOL;
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

/* Creado por Juan Manuel Barros Pazos 2020/21 */

?>