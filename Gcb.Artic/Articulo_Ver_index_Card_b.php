<?php

	require_once 'Gcb.Connet/conection.php';
	require_once 'Gcb.Connet/conect.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ver_todo(){

	echo "<style>
			video {
				max-width: 98% !important;
				height: auto;
				max-height: 190px !important;
				overflow: hidden;
				border-radius: 8px;
				}
		</style>";

	// DEFINO EL NUMERO DE ARTICULOS POR PÁGINA
	global $nitem;
	$nitem = 4;

	require 'Gcb.Artic/Inc_Artic_Index_Pagina_Ini.php';

	if(!$qb){
			print("<font color='#FF0000'>Consulte L.496: </font></br>".mysqli_error($db)."</br>");
			
	} else {
		if(mysqli_num_rows($qb)== 0){

	require 'Gcb.Artic/Articulo_no_hay_datos_index.php';

	} else { 	

	print ("<!-- Titulo --> 
			<!-- <div class='projects-horizontal'> 
				<div class='intro'>
					<h2 class='section-heading text-uppercase'>Noticias</h2>
					<h3 class='section-subheading text-muted'>Lorem ipsum dolor sit amet consectetur.</h3>
				</div>
		  	</div> -->
            <div class='row projects'><!-- Inicio class row-->
				");

	while($rowb = mysqli_fetch_assoc($qb)){

        if(strlen(trim($rowb ['myvdo'])) > 0){
            global $visual;
            $visual = "<video controls>
                            <source src='Gcb.Vdo.Art/".$rowb['myvdo']."' />
                        </video>";
        } else { global $visual;
                 $visual = "<img class='img-fluid' src='Gcb.Img.Art/".$rowb['myimg']."' alt=''>";
                 //$visual = "";
                    }
    
				global $conte;
				$conte = substr($rowb['conte'],0,160);
				$conte = $conte." ...&nbsp;
				
	<form name='ver' method='POST' action='Gcb.Artic/Articulo_Ver_index_Popup_Ver.php' target='popup' onsubmit=\"window.open('', 'popup', 'width=500px, height=650px')\">
				<input name='id' type='hidden' value='".$rowb['id']."' />
				<input name='refuser' type='hidden' value='".$rowb['refuser']."' />
				<input name='refart' type='hidden' value='".$rowb['refart']."' />
				<input name='tit' type='hidden' value='".$rowb['tit']."' />
				<input name='titsub' type='hidden' value='".$rowb['titsub']."' />
				<input name='datein' type='hidden' value='".$rowb['datein']."' />
				<input name='timein' type='hidden' value='".$rowb['timein']."' />
				<input name='datemod' type='hidden' value='".$rowb['datemod']."' />
				<input name='timemod' type='hidden' value='".$rowb['timemod']."' />
				<input name='conte' type='hidden' value='".$rowb['conte']."' />
				<input name='myimg' type='hidden' value='".$rowb['myimg']."' />
				<input name='myvdo' type='hidden' value='".$rowb['myvdo']."' />
				<input type='submit' value='LEER MÁS...' class='botonleer' />
				<input type='hidden' name='oculto2' value=1 />
			</form>";	

	print ("<div class='col-sm-6 item' style='margin:auto;' >
				<div class='row' style='text-align:left !important;'>
                        <div class='col-md-12 col-lg-5'>
							".$visual."
                        </div>
                        <div class='col'>
                            <h3 class='name'>".$rowb['tit']."</h3>
							<h7>".$rowb['titsub']."<br>".$rowb['datein']."</h7>
                           	<p class='description'>".$conte."</p>
                        </div>
				</div>
		 </div>");

	} // Fin While

	print(" </div> <!-- Fin class row-->");
			
						} 

	require 'Gcb.Artic/Inc_Artic_Index_Pagina_Fin.php';

			} 
		
	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

				 ver_todo();

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


/* Creado por Juan Manuel Barros Pazos 2020/21 */
