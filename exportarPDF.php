<?php
	require_once 'dompdf/autoload.inc.php';
	use Dompdf\Dompdf;
	$nome = $_GET['nome'];
	$arquivo = fopen ("C://xampp/htdocs//ReportsFiles//". $nome, 'r');
	$html = fread ( $arquivo ,filesize ("C://xampp/htdocs//ReportsFiles//". $nome)) ;


 
	if ( get_magic_quotes_gpc() )
    $html = stripslashes($html);
 
	 
	// abertura de novo documento
	$dompdf = new DOMPDF();
	 
	// carregar o HTML
	$dompdf->load_html($html);
	 
	// dados do documento destino
	$dompdf->set_paper("A3", "landscape");
	 
	// gerar documento destino
	$dompdf->render();
	 
	// enviar documento destino para download
	$dompdf->stream($nome."pdf");
	 
	exit();
	fclose($arquivo);
