<?php

	if ($page > 1){
		global $pg;
		$pg = "<input type='hidden' name='page' value=".$page." />";
	}else{	global $pg;
			$pg = "<input type='hidden' name='page' value=1 />";
			}

	global $db;
	$sqlra =  "SELECT * FROM `gcb_admin` WHERE `ref`='$rowb[refuser]' LIMIT 1 ";
	$qra = mysqli_query($db, $sqlra);
	
	if(!$qra){ print("* ".mysqli_error($db)."</br>");
	} else { 
			while($rowautor = mysqli_fetch_assoc($qra)){
				global $autor;
				$autor = "<h6>".$rowautor['Nombre']." ".$rowautor['Apellidos']."</h6>";
				}
			}

	if ($rowb['myvdo'] != ''){
		global $vdonw;
		$vdonw = "<video style=\" width:98%; max-width:600px !important; height:auto\" controls>
			<source style=\" width:98%; height:auto\" src='../Gcb.Vdo.Art/".@$_POST['myvdo']."' />
				  </video>";
		}else{	global $vdonw;
				$vdonw = '';
				}
	
	global $contem;
	$contem = substr($rowb['conte'],0,100);
	$contem = $contem." ...&nbsp;
			<form name='ver' name='ver' action=\"news.php#".$rowb['refart']."\" method='post' >
				<input name='id' type='hidden' value='".$rowb['id']."' />
				<input name='refart' type='hidden' value='".$rowb['refart']."' />
				<input name='refuser' type='hidden' value='".$rowb['refuser']."' />
				<input name='myimg' type='hidden' value='".$rowb['myimg']."' />
				<input type='hidden' name='myvdo' value='".$rowb['myvdo']."' />
				<input type='submit' value='LEER MÁS...' class='botonleer' />
				<input type='hidden' name='leermas' id=\"".$rowb['refart']."\" value=1 />
				".$pg."
			</form>";

    global $contep;
	$contep = $rowb['conte'];
	$contep = $autor.$vdonw.$contep."
	<img class='imgarticulo' src='".$rut."Gcb.Img.Art/".@$_POST['myimg']."' />
	<form name='ver' name='ver' action=\"news.php#".$rowb['refart']."\" method='post' >
				<input type='hidden' name='id' value='".$rowb['id']."' />
				<input type='hidden' name='refart' value='".$rowb['refart']."' />
				<input name='refuser' type='hidden' value='".$rowb['refuser']."' />
				<input type='hidden' name='myimg' value='".$rowb['myimg']."' />
				<input type='hidden' name='myvdo' value='".$rowb['myvdo']."' />
				<input type='hidden' name='leermenos' id=\"".$rowb['refart']."\" value=1 />
				<input type='submit' value='LEER MENOS' class='botonleer' />
				".$pg."
			</form>";

	global $refart;
	$refart = @$_POST['refart'];

	if((isset($_POST['leermas'])) && ($refart == $rowb['refart'])){
		global $contep;
		global $conte;
		$conte = $contep/*."<div id=\"".$refart."\"></div>"*/;
		}
	elseif((isset($_POST['leermenos'])) && ($refart == $rowb['refart'])){
		global $contem;
		global $conte;
		$conte = $contem/*."<div id=\"".$refart."\"></div>"*/;
		}
	else{
		global $contem;
		global $conte;
		$conte = $contem/*."<div id=\"".$refart."\"></div>"*/;
	}

	/* Creado por Juan Manuel Barros Pazos 2020/21 */

?>