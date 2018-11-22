<?php 
	class BotApi{
		public
			$token,
			$proxy;
		
		public function __construct( $token = "", $proxy = "" )
		{
			$this->token = $token;
			$this->proxy = $proxy;
		}
		
		public function doRequest( $method, $params = array() ){
			$url = "https://api.telegram.org/bot".$this->token."/".$method;
			$url .= '?'.http_build_query( $params );
			return json_decode( $this->curl( $url ) );
		}
		
		public function getUpdates( $offset = 0, $limit = 100 ){
			return $this->doRequest( 
				"getUpdates", 
				array( 
					'offset' => $offset, 
					'limit' => $limit,
					'timeout' => TIMEOUT
				) 
			);			
		}	
		
		//offset of the first unconfirmed message
		protected function getLastOffset(){
			$off = file_get_contents( dirname(__DIR__)."/lastOffset.txt" );
			if( !$off || !is_numeric( $off ) ){	//bad offset
				$off = $this->getUpdates( 0, 1 )->result[0]->update_id;
				if( ! $off )
					$off = $this->getUpdates( -1, 1 )->result[0]->update_id;
			}
			return $off;
		}
		
		//get new updates and rewrite offset
		public function getCurrentUpdate(){			
			$off = $this->getLastOffset();
			$res = $this->getUpdates( $off );
			if( isset( $res->result[0]->update_id ) ){
				file_put_contents( dirname(__DIR__)."/lastOffset.txt", ++$off );
				return $res;
			}
			return false;
		}
		
		
		public function messageSend( $uid, $text ){
			return $this->doRequest(
				"sendMessage",
				array(
					'chat_id' => $uid,
					'text' => $text
				)
			);
		}
		
		private function curl($url)
		{
			//echo $url."<br/>";
			$ch = curl_init();
			$params = [
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => 10,
				CURLOPT_TIMEOUT => TIMEOUT + 5,
				CURLOPT_HEADER => 0,
				CURLOPT_SSL_VERIFYPEER => 0,
				CURLOPT_SSL_VERIFYHOST => 0,
				CURLOPT_PROXY => $this->proxy,		
			];
			curl_setopt_array($ch, $params); 		
			$resp = curl_exec($ch);
			if( curl_errno( $ch ) )
				echo "Ошибка курлыка!";
			curl_close($ch);
			return $resp;
		}			
	}
?>

