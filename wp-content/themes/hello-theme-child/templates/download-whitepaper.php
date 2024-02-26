<?php 
/**
* Template Name: Download Whitepaper
*
*/
$filePath="/domains/mentoring.berlin/DEFAULT/wp-content/uploads/2023/07/WHITEPAPER-STRATEGIE.pdf";
$filename="WHITEPAPER-STRATEGIE.pdf";
header('Content-type:application/pdf');
header('Content-disposition: inline; filename="'.$filename.'"');
header('content-Transfer-Encoding:binary');
header('Accept-Ranges:bytes');
@ readfile($filePath);
?>