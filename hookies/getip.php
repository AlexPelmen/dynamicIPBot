<?php 
	$ip = file_get_contents( "http://icanhazip.com/" );
	$ip = preg_replace("/[\t\r\n]+/",'',$ip); 
	$port = "20200";
	$bot->messageSend( $uid, "http://$ip:$port" );
?>	