<?php 	
	$last = file_get_contents( __DIR__ . "/lastIP.txt" );				//last ip adress
	$cur = file_get_contents( "http://icanhazip.com/" );	//current ip adress
	$cur = preg_replace("/[\t\r\n]+/",'',$cur);
	
	$port = "20200";
		
	if( $last != $cur && $cur ){
		require __DIR__ . "/classes/Api.php";
		require __DIR__ . "/config.php";
		$bot = new BotApi( TOKEN, PROXY );		
		$users = explode( "\n", file_get_contents( __DIR__ . "/mailing.txt" ) );		
		$text = "IP adress has just been changed. Now: $cur:$port";
		
		foreach( $users as $uid )
			$bot->messageSend( $uid, $text );
		
		file_put_contents( __DIR__ . "/lastIP.txt", $cur );
	}
?>
