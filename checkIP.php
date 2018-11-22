<?php 	
	$last = file_get_contents( "lastIP.txt" );				//last ip adress
	$cur = file_get_contents( "http://icanhazip.com/" );	//current ip adress
	$cur = preg_replace("/[\t\r\n]+/",'',$cur);
	
	$port = "20200";
	
	var_dump( $last );
	var_dump( $cur );
	
	if( $last != $cur ){
		require __DIR__ . "/classes/Api.php";
		require __DIR__ . "/config.php";
		$bot = new BotApi( TOKEN, PROXY );		
		$users = explode( "\n", file_get_contents( "mailing.txt" ) );		
		$text = "IP adress has just been changed. Now: $cur:$port";
		
		foreach( $users as $uid )
			$bot->messageSend( $uid, $text );
		
		file_put_contents( "lastIP.txt", $cur );
	}
?>	

