<?php

	require_once 'Gcb.Connet/conection.php';
	require_once 'Gcb.Connet/conect.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ver_todo(){

	echo "<style> 
			.jcard { margin-bottom: 6px !important; }
			video { background-color: #343434; }
			.img-fluid { max-height: 190px !important;}
		  </style>";

	// DEFINO EL NUMERO DE ARTICULOS POR PÁGINA
	global $nitem;
	$nitem = 3;
	
	require 'Gcb.Artic/Articulo_Ver_index_vertodo_a.php';

	if(!$qb){
			print("<font color='#FF0000'>Consulte L.496: </font></br>".mysqli_error($db)."</br>");
			
	} else {
		if(mysqli_num_rows($qb)== 0){

	print ("<table align='center' style='border:none;'>
				<tr><td style='text-align:center'>
		<h4><a href='Gcb.Www/news.php'>NO HAY ENTRADAS EN ".$dyt1."<br>CONSULTAR NEWS</a></h4>
			</td></tr></table>");
	} else { 

    // INICIO DISEÑO PLANTILLA
	print ("<!-- Titulo -->
			<!-- <div class='projects-clean'> 
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
            $visual = "<video class='img-fluid' controls>
                            <source class'vdo' src='Gcb.Vdo.Art/".$rowb['myvdo']."' />
                        </video>";
        } else { global $visual;
                 $visual = "<img class='img-fluid' src='Gcb.Img.Art/".$rowb['myimg']."' alt=''>";
                 //$visual = "";
                    }
    
	require 'Gcb.Artic/Articulo_Ver_index_vertodo_d.php';

	print ("<div class='jcard tarecol-sm-6 col-lg-4 item'>
							".$visual."
                            <h3 class='name'>".$rowb['tit']."</h3>
							<h7>".$rowb['titsub']."<br>".$rowb['datein']."</h7>
                           	<h6 class='description'>".$conte."</h6>
		 	</div>");

	} // Fin While

	print(" </div> <!-- Fin class row-->");
			
						} 

	require 'Gcb.Artic/Articulo_Ver_index_vertodo_b.php';

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
