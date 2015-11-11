<?php
	require_once("functions.php");
	require_once("interestsManager.class.php");
	
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
		
		// see  katkestab faili edasise lugemise
		exit();
	}
	
	if(isset($_GET["logout"])){
		
		session_destroy();
		
		header("Location: login.php");
	}
	$InterestsManager= new InterestsManager($mysqli, $_SESSION["logged_in_user_id"] );
	if(isset($_GET["new_interest"])){
		
		$add_new_response=$InterestsManager->addInterest($_GET["new_interest"]);
		
	}
	if(isset($_GET["new_dd_selection"])){
		
		$add_new_userinterest_response= $InterestsManager->addUserInterest($_GET["new_dd_selection"]);
		
	}
?>


<p>
	Tere, <?=$_SESSION["logged_in_user_email"];?> 
	<a href="?logout=1"> Logi välja <a> 
</p>

<h2> Lisa huviala </h2>
 <?php if(isset($add_new_response->error)): ?>
  
	<p style="color:red;">
		<?=$add_new_response->error->message;?>
	</p>
  
  <?php elseif(isset($add_new_response->success)): ?>
	
	<p style="color:green;" >
		<?=$add_new_response->success->message;?>
	</p>
	
  <?php endif; ?>
<form>
	<input name="new_interest">
	<input type="submit">
</form>

<h2>Minu huvialad</h2>
	<?php if(isset($add_new_response->error)): ?>
  
	<p style="color:red;">
		<?=$add_new_response->error->message;?>
	</p>
  
  <?php elseif(isset($add_new_response->success)): ?>
	
	<p style="color:green;" >
		<?=$add_new_response->success->message;?>
	</p>
	
  <?php endif; ?>
<form>
	<!-- siia järele tuleb rippmenüü -->
	<?=$InterestsManager->createDropdown();?>
	<input type="submit">
</form>
