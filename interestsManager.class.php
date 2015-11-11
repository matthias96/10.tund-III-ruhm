<?php
class InterestsManager{
	
	
		private $connection;
		private $user_id;
		
		function __construct($mysqli, $user_id_from_session){
			
			$this->connection=$mysqli;
			$this->user_id=$user_id_from_session;
			
			echo "Huvialade haldus käivitatud, kasutaja=".$this->user_id;
			
		}
	
		function addInterest($new_interest){
			
		
		$response = new StdClass();
		
		
		$stmt = $this->connection->prepare("SELECT id FROM interests1 WHERE name=?");
		$stmt->bind_param("s", $new_interest);
		$stmt->bind_result($id);
		$stmt->execute();
		
		if($stmt->fetch()){
			
			
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Huviala <strong>".$new_interest."</strong>on juba olemas!";
			
			$response->error = $error;
			
			return $response;
			
		}
		
		$stmt->close();
		
		$stmt = $this->connection->prepare("INSERT INTO interests1 (name) VALUES (?)");
		$stmt->bind_param("s", $new_interest);
		
		// sai edukalt salvestatud
		if($stmt->execute()){
			
			$success = new StdClass();
			$success->message = "Huviala on lisatud";
			
			$response->success = $success;
			
		}else{
			
			// midagi läks katki
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Midagi läks katki!";
			
			$response->error = $error;
			
		}
		
		$stmt->close();
		
		return $response;
			
		}
			
			
		
		function createDropdown(){
			
			$html= '';
			$html .='<select name="new_dd_selection">';
			
			//$html .='<option>1</option>';
			//$html .='<option>2</option>';
			//$html .='<option>3</option>';
			$stmt=$this->connection->prepare("SELECT id, name FROM interests1");
			$stmt->bind_result($id, $name);
			$stmt->execute();
			
			while($stmt->fetch()){
				$html .='<option>'.$name.'</option>';
			}
			
			$html .= '</select>';
			
			return $html;
		}
		function addUserInterest($new_interest_id){
			
		$response = new StdClass();
		
		
		$stmt = $this->connection->prepare("SELECT id FROM user_interests1 WHERE user_id=? AND interes_id=?");
		$stmt->bind_param("ii",$this->user_id, $new_interest_id);
		$stmt->bind_result($id);
		$stmt->execute();
		
		if($stmt->fetch()){
			
			
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Huviala on Sinul juba olemas!";
			
			$response->error = $error;
			
			return $response;
			
		}
		
		$stmt->close();
		
		$stmt = $this->connection->prepare("INSERT INTO user_interests1 (user_id, interes_id) VALUES (?,?)");
		$stmt->bind_param("ii", $this->user_id,$new_interest_id);
		
		// sai edukalt salvestatud
		if($stmt->execute()){
			
			$success = new StdClass();
			$success->message = "Huviala on lisatud";
			
			$response->success = $success;
			
		}else{
			
			// midagi läks katki
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Midagi läks katki!";
			
			$response->error = $error;
			
		}
		
		$stmt->close();
		
		return $response;
			
			
			
			
		}
		function getUserInterests(){
			
			$html = '';
			
			$stmt= $this->connection->prepare("SELECT interests1.name FROM user_interests1 INNER JOIN interests1 ON user_interests1.interes_id=interes.id WHERE user_interests1.user_id= ?");
			$stmt->bind_param("i", $this->user_id);
			$stmt->bind_result($name);
			$stmt->execute();
			
			while ($stmt->fetch()){
				
				$html .= '<p>'.$name.'<p>';
			}
			
			
		}
}

?>