<?php
	//@session_start();

	require '../Gcb.Connet/conection.php';
	require '../Gcb.Connet/conect.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	if(isset($_POST['oculto'])){
				if($form_errors = validate_form()){
						show_form($form_errors);
				} else {show_form();
						process_form();
						//info();
							}
			}	

	elseif ((isset($_GET['page'])) || (isset($_POST['page']))) { 
												show_form();
												process_form(); 
											}

	else { 	unset($_SESSION['titulo']);
			unset($_SESSION['autor']);
			unset($_SESSION['dy']);
			unset($_SESSION['dm']);	
			show_form();
			ver_todo();}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_form(){
	
	$errors = array();
	
	if (strlen(trim($_POST['titulo'])) > 0) {
		
		if (!preg_match('/^[^@#$&%<>:"·\(\)=¿?!¡\[\]\{\};,:\.\*]+$/',$_POST['titulo'])){
			$errors [] = "<font color='#FF0000'>CARACTERES NO VALIDOS</font>";
			}
		}
	
	return $errors;

		} 
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $db;
	global $db_name;
	
	//echo @$_SESSION['autor']."<br>";

	global $autor;
	global $g;
	global $titulo;

	if (strlen(trim(@$_SESSION['titulo'])) == 0){
		$titulo = '';
		$g = 'AND';
	}else{
		$titulo = trim($_SESSION['titulo']);
		$titulo = "AND `tit` LIKE '%".$titulo."%' ";
		$g = 'OR';
	}

	if (strlen(trim(@$_SESSION['autor'])) == 0){
		$autor = '';
	}else{
		$autor = trim($_SESSION['autor']);
		$autor = "$g `refuser` LIKE '%".$autor."%' ";
	}

	global $orden;
	$orden = "`id` DESC";

	//global $dd1;
	
	if ((isset($_POST["page"]))||(isset($_GET["page"]))){
		global $dyt1;
		global $dy1;
		$dy1 = "20".$_SESSION['dy'];
		$dyt1 = "20".$_SESSION['dy'];
	}
	elseif ((!isset($_POST['dy']))||($_POST['dy'] == '')){	
								global $dyt1;
								global $dy1;
								$dy1 = date('Y');
								$dyt1 = date('Y');
								$_SESSION['dy'] = date('y');
											} 
							 				else {	global $dyt1;
													global $dy1;
													$dy1 = "20".$_SESSION['dy'];
													$dyt1 = "20".$_SESSION['dy'];
													}
	
	if ((isset($_POST["page"]))||(isset($_GET["page"]))){
		global $dm1;
		$dm1 = "-".$_SESSION['dm'];
	}
	elseif (!isset($_POST['dm'])){ 	global $dm1;
									$dm1 = '';} 
											 else {	global $dm1;
													$dm1 = "-".$_SESSION['dm'];
													}
	global $fil;
	$fil = $dy1.$dm1."%";
	//$fil = $dy1."-%".$dm1."%";
	global $vname;
	$vname = "gcb_".$dyt1."_articulos";
	//$vname = "`".$vname."`";

	$result =  "SELECT * FROM `$db_name`.$vname WHERE `datein` LIKE '$fil' AND `visible` = 'y' $titulo $autor ";
	$q = mysqli_query($db, $result);
	global $row;
	@$row = mysqli_fetch_assoc($q);
	global $num_total_rows;
	@$num_total_rows = mysqli_num_rows($q);

	if(!$q || ($num_total_rows < 1)){
		echo "<div class='juancentra' style=\"margin-bottom:0.4em !important;\"><h5>** NO HAY DATOS EN ".$_SESSION['dyt1']." **</h5></div>";
		/*
			global $fil;
			$fil = ($dy1-1).$dm1."%";
			echo "<div class='col-lg-12 text-center'><h5>** NO HAY DATOS EN ".$dy1." **</h5></div>";
			global $vname;
			$vname = "gcb_".($dyt1-1)."_articulos";
			$vname = "`".$vname."`";
			$result =  "SELECT * FROM `$db_name`.$vname WHERE `datein` LIKE '$fil' $titulo $autor ";
			$q = mysqli_query($db, $result);
			@$row = mysqli_fetch_assoc($q);
			global $num_total_rows;
			@$num_total_rows = mysqli_num_rows($q);
		*/
	} else { }

	// DEFINO EL NUMERO DE ARTICULOS POR PÁGINA
	global $nitem;
	$nitem = 3;
	
	global $page;

	if (isset($_POST["page"])) {
		global $page;
        $page = $_POST["page"];
    }

    //examino la pagina a mostrar y el inicio del registro a mostrar
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    }

    if (!$page) {
        $start = 0;
        $page = 1;
    } else {
        $start = ($page - 1) * $nitem;
    }
    
    //calculo el total de paginas
	$total_pages = ceil($num_total_rows / $nitem);
	
    //pongo el n�mero de registros total, el tama�o de p�gina y la p�gina que se muestra
    echo '<h7>* Noticias: '.$num_total_rows.' * P&aacute;gina '.$page.' de ' .$total_pages.'.</h7>';

	global $limit;
	$limit = " LIMIT ".$start.", ".$nitem;

	$sqlb =  "SELECT * FROM `$db_name`.$vname WHERE `datein` LIKE '$fil' $titulo $autor  ORDER BY $orden $limit";
	$qb = mysqli_query($db, $sqlb);

	if(!$qb){
			print("<font color='#FF0000'>Consulte L.175 </font></br>".mysqli_error($db)."</br>");
			
		} else {
			if(mysqli_num_rows($qb)== 0){
							print ("<table align='center'>
										<tr>
											<td aling='center'>
												<font color='#FF0000'>
													NO HAY DATOS 20".$_SESSION['dy']."
												</font>
											</td>
										</tr>
									</table>");
									
				} else {
			print ("<div class='row'> <!-- Titulo -->
					<div class='col-lg-12 text-center'>
					  <h2 class='section-heading text-uppercase'>Noticias</h2>
					  <!--
					  <h3 class='section-subheading text-muted'>Lorem ipsum dolor sit amet consectetur.</h3>
					  -->
					</div>
				  	</div>
					
					<div class='row'> <!-- Inicio class row-->
					<div class='col-lg-12'>  <!-- Inicio class col-lg-12 -->
					<ul class='timeline'> <!-- Inicio Ul class timeline -->
									");
			
				global $estilo;
				$estilo = array('timeline','timeline-inverted');
				global $estiloin;
				$estiloin = 0;
	
		while($rowb = mysqli_fetch_assoc($qb)){

	// DEFINO LA RECTIFICACIÓN DE LA RUTA IMG
    global $rut;
    //$rut = "";
    $rut = "../";

	require '../Gcb.Artic/Inc_Artic_News_Form.php';

	print ("<li  class='".$estilo[$estiloin]."'> <!-- Inicio Li contenedor -->
			<div class='timeline-image'>
	<img class='<!--rounded-circle--> img-fluid' src='../Gcb.Img.Art/".$rowb['myimg']."' alt=''>
			</div>
			<div class='timeline-panel'>
			<div class='timeline-heading'>
				<h6>".$rowb['datein']."</h6>
				<h5>".$rowb['tit']."</h5>
			</div>
			<div class='timeline-body'>
				<p class='text-muted'>".$conte."</p>
			</div>
		<div id=\"".$refart."\"></div>
			</div>
		</li> <!-- Final Li contenedor -->
		");
		$estiloin = 1 - $estiloin;	

		} // Fin While

	print(" </ul> <!-- Fin Ul class timeline -->
			</div> <!-- Fin class col-lg-12 -->
  			</div> <!-- Fin class row-->
			");
				} 
    echo '<nav>';
    echo '<ul class="pagination">';

    if ($total_pages > 1) {
        if ($page != 1) {
            echo '<li class="page-item"><a class="page-link" href="news.php?page='.($page-1).'"><span aria-hidden="true">&laquo;</span></a></li>';
        }

        for ($i=1;$i<=$total_pages;$i++) {
            if ($page == $i) {
                echo '<li class="page-item active"><a class="page-link" href="#">'.$page.'</a></li>';
            } else {
                echo '<li class="page-item"><a class="page-link" href="news.php?page='.$i.'">'.$i.'</a></li>';
            }
        }

        if ($page != $total_pages) {
            echo '<li class="page-item"><a class="page-link" href="news.php?page='.($page+1).'"><span aria-hidden="true">&raquo;</span></a></li>';
        }
    }
    echo '</ul>';
    echo '</nav>';

			} 
		}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){

	// FORMULARIO FILTRO ARTICULOS AUTOR
	require '../Gcb.Artic/Articulo_Ver_news_showform.php';
	
	}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ver_todo(){
		
	global $db;
	global $db_name;

	global $dyt1;
	$dyt1 = date('Y')/*-1*/;
	if(!isset($_SESSION['dy'])){$_SESSION['dy'] = date('y')/*-1*/;
								$_SESSION['dm'] = '';
	} else { }

	global $fil;
	$fil = $dyt1."-%";
	//$fil = $dy1.$dm1.$dd1."%";
	global $vname;
	$vname = "gcb_".$dyt1."_articulos";
	$vname = "`".$vname."`";

	$result =  "SELECT * FROM $vname WHERE `visible` = 'y' AND `datein` LIKE '$fil' ";
	$q = mysqli_query($db, $result);
	global $row;
	@$row = mysqli_fetch_assoc($q);
	global $num_total_rows;
	@$num_total_rows = mysqli_num_rows($q);

	if(!$q || ($num_total_rows < 1)){
		echo "<div class='juancentra' style=\"margin-bottom:0.4em !important;\"><h5>** NO HAY DATOS EN ".$_SESSION['dyt1']." **</h5></div>";
	} else { }

	// DEFINO EL NUMERO DE ARTICULOS POR PÁGINA
	global $nitem;
	$nitem = 3;
	
	global $page;

     if (isset($_POST["page"])) {
		global $page;
        $page = $_POST["page"];
	}
	
   //examino la pagina a mostrar y el inicio del registro a mostrar
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    }

    if (!$page) {
        $start = 0;
        $page = 1;
    } else {
        $start = ($page - 1) * $nitem;
    }
    
    //calculo el total de paginas
	$total_pages = ceil($num_total_rows / $nitem);
	
    //pongo el n�mero de registros total, el tama�o de p�gina y la p�gina que se muestra
    echo '<h7>* Noticias: '.$num_total_rows.' * P&aacute;gina '.$page.' de ' .$total_pages.'.</h7>';

	global $limit;
	$limit = " LIMIT ".$start.", ".$nitem;

	$sqlb =  "SELECT * FROM `$db_name`.$vname WHERE `visible` = 'y' AND `datein` LIKE '$fil' ORDER BY `id` DESC $limit";

	/*
	$sqlb =  "SELECT * FROM `gcb_admin` WHERE `gcb_admin`.`dni` <> '$_SESSION[mydni]' ORDER BY $orden ";
	*/
	$qb = mysqli_query($db, $sqlb);
	if(!$qb){
			print("<font color='#FF0000'>Consulte L.496: </font></br>".mysqli_error($db)."</br>");
			
		} else {
			if(mysqli_num_rows($qb)== 0){
							print ("<table align='center'>
										<tr>
											<td aling='center'>
												<font color='#FF0000'>
													NO HAY DATOS 20".$_SESSION['dy']."
												</font>
											</td>
										</tr>
									</table>");
			} else {
			print ("<div class='row'> <!-- Titulo -->
					<div class='col-lg-12 text-center'>
					  <h2 class='section-heading text-uppercase'>Noticias</h2>
					  <!--
					  <h3 class='section-subheading text-muted'>Lorem ipsum dolor sit amet consectetur.</h3>
					  -->
					</div>
				  	</div>
					
					<div class='row'> <!-- Inicio class row-->
					<div class='col-lg-12'>  <!-- Inicio class col-lg-12 -->
					<ul class='timeline'> <!-- Inicio Ul class timeline -->
									");
			
				global $estilo;
				$estilo = array('timeline','timeline-inverted');
				global $estiloin;
				$estiloin = 0;

		while($rowb = mysqli_fetch_assoc($qb)){

	// DEFINO LA RECTIFICACIÓN DE LA RUTA IMG
    global $rut;
    //$rut = "";
    $rut = "../";

	require '../Gcb.Artic/Inc_Artic_News_Form.php';

	print ("<li  class='".$estilo[$estiloin]."'> <!-- Inicio Li contenedor -->
			<div class='timeline-image'>
	<img class='<!--rounded-circle--> img-fluid' src='../Gcb.Img.Art/".$rowb['myimg']."' alt=''>
			</div>
			<div class='timeline-panel'>
			<div class='timeline-heading'>
				<h6>".$rowb['datein']."</h6>
				<h5>".$rowb['tit']."</h5>
			</div>
			<div class='timeline-body'>
				<p class='text-muted'>".$conte."</p>
			</div>
		<div id=\"".$refart."\"></div>
			</div>
		</li> <!-- Final Li contenedor -->
		");
		$estiloin = 1 - $estiloin;	

		} // Fin While

	print(" </ul> <!-- Fin Ul class timeline -->
			</div> <!-- Fin class col-lg-12 -->
  			</div> <!-- Fin class row-->
			");
						} 

    echo '<nav>';
    echo '<ul class="pagination">';

    if ($total_pages > 1) {
        if ($page != 1) {
            echo '<li class="page-item"><a class="page-link" href="news.php?page='.($page-1).'"><span aria-hidden="true">&laquo;</span></a></li>';
        }

        for ($i=1;$i<=$total_pages;$i++) {
            if ($page == $i) {
                echo '<li class="page-item active"><a class="page-link" href="#">'.$page.'</a></li>';
            } else {
                echo '<li class="page-item"><a class="page-link" href="news.php?page='.$i.'">'.$i.'</a></li>';
            }
        }

        if ($page != $total_pages) {
            echo '<li class="page-item"><a class="page-link" href="news.php?page='.($page+1).'"><span aria-hidden="true">&raquo;</span></a></li>';
        }
    }
    echo '</ul>';
    echo '</nav>';

			} 
	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function info(){

	global $db;
	global $rowout;
	global $nombre;
	global $apellido;
	global $orden;
	
	$orden = isset($_POST['Orden']);
	
	if (isset($_POST['todo'])){$nombre = "TODOS LOS USUARIOS ".$orden;};	

	$rf = isset($_POST['ref']);
	if (($_SESSION['Nivel'] == 'user') || ($_SESSION['Nivel'] == 'plus')){	
										$nombre = $_SESSION['Nombre'];
										$apellido = $_SESSION['Apellidos'];}
	
	$ActionTime = date('H:i:s');

	global $dir;
	$dir = "../Gcb.Log";
	
	global $text;
	$text = PHP_EOL."- ADMIN VER ".$ActionTime.PHP_EOL."\t Filtro => ".$nombre." ".$apellido;

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

	//require '../Gcb.Inclu/Admin_Inclu_footer.php';
		
/* Creado por Juan Manuel Barros Pazos 2020/21 */
