<?php 	
	require __DIR__ . "/classes/Api.php";
	require __DIR__ . "/config.php";
	
	$bot = new BotApi( TOKEN, PROXY );
	
	$update = $bot->getCurrentUpdate();	
	if( ! $update ) return 0;	
	
	@$uid = $update->result[0]->message->from->id;
	if( ! $uid ) 
		return 0;

	$command = strtolower( trim( $update->result[0]->message->text ) );
	str_replace( "/", "", $command ); 
	@$test = include_once __DIR__ . "/hookies/".$command.".php"; 
	if( ! $test )
		include_once __DIR__ . "/hookies/DEFAULT.php";
?>	

