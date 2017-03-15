<!DOCTYPE html>
<html>

<link rel="stylesheet" type="text/css" href="style.css" />

<?php
	include("mydomain.php");
	include("database.php");
	
	session_start();
	$username = $_SESSION['username'];
	$test_ID = $_SESSION['test_ID'];
	
	$stmt = $conn->prepare("SELECT ID, presentation
							FROM question
							WHERE EXISTS (SELECT question_ID 
							FROM test_has_question 
							WHERE test_has_question.question_ID = question.ID AND  test_ID = '"."$test_ID"."' ) 	
							"); 
	$stmt->execute();
	
	$i = 0;
	while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
		$presentation_array[$i] = $row->presentation;
		$question_ID[$i] = $row->ID;
		$i++;
	}
	
	$stmt = $conn->prepare("SELECT negative_rating
							FROM test
							WHERE ID = '"."$test_ID"."'
							"); 
	$stmt->execute();
	
	$i = 0;
	while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
		$negative_rating = $row->negative_rating; //yes/no
		$i++;
	}
	
	
//********************************************************************************************	
	if(isset($_POST['submitType'])){
		$check_choice = $_POST['choice'];
		$submit_length = count($check_choice); 
		
		
		$arrlength_question = count($presentation_array);
		for($i = 0; $i < $arrlength_question; $i++){
			$stmt = $conn->prepare("SELECT *
									FROM question_choices
									WHERE question_ID ='"."$question_ID[$i]"."'	
									"); 
			$stmt->execute();
	
			$k = 0;
			while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
				$choice_array[$k] = $row->choice;
				$right_response[$k] = $row->right_response;
				for($j = 0; $j < $submit_length; $j++){
					if ($check_choice[$j] == "$question_ID[$i],$k"){ 
						$sql= "INSERT INTO student_response_question(student_username, 
											question_ID, 
											response)             
						VALUES ('$username',
								'$question_ID[$i]',
								'$choice_array[$k]')";
						$conn->exec($sql);
					}
				}
				$k++;
			}
			
		}
	
		$score = 0;
		for($i = 0; $i < $arrlength_question; $i++){
			
			$stmt = $conn->prepare("SELECT question_ID, choice
									FROM question_choices
									WHERE right_response = 'yes' AND question_ID ='"."$question_ID[$i]"."' "); 
			$stmt->execute();				
			$j = 0;
			while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
				$right_choices[$j] = "$row->question_ID".", "."$row->choice";
				$j++;
			}
			
			$stmt = $conn->prepare("SELECT question_ID, response
									FROM student_response_question
									WHERE question_ID ='"."$question_ID[$i]"."' "); 
			$stmt->execute();
			$j = 0;
			while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
				$responses[$j] = "$row->question_ID".", "."$row->response";
				$j++;
			}
			
			$arrlength_right_choice = count($right_choices);
			$arrlength_responses = count($responses);
			$found = 0;
			
			if( $arrlength_right_choice == $arrlength_responses){ 
				for($k = 0; $k < $arrlength_right_choice; $k++){
					if($right_choices[$k] == $responses[$k]){
						$found = 1; 
					}
					else{
						$found = 0; 
					}
				}
			}
			if($negative_rating == 'yes'){
				if ($found == 0){
					$score -= (20/$arrlength_question) / 2;
				}
				else{
					$score += 20/$arrlength_question;
				}
			}
			else{
				if($found == 1){
					$score += 20/$arrlength_question;
				}
			}
			unset($right_choices);
			unset($responses);
		}
	
		$sql= "INSERT INTO student_do_test(student_username, test_ID, degree)             
					VALUES ('$username',
							'$test_ID',
							'$score')";
		$conn->exec($sql);
		
		$stmt = $conn->prepare("DELETE FROM student_response_question"); 
		$stmt->execute();
		
		//Submit and go Interface
		header("Location: $mydomain/webApp/Interface_Student.php");
	}
?>

<head>
	<title>MyPage</title>
</head>

<body>
	<div style = "background-color:#123; padding:95px;">
		<img src="dib.png" alt="dib" style="width:auto;height:auto;">
	</div>
          
    <div id="page">
	</div>
	<div id = "content">
	
		<form action="" method = "POST" style = "margin:0px 20px;">
			
			<br>
			<?php
				if($negative_rating == 'yes'){
					echo "	<p style = "."text-align:center; color:red".">Be careful! Test with <u>negative rating</u>. 
							</p>";
				}
				$arrlength_question = count($presentation_array);
				for($i = 0; $i < $arrlength_question; $i++){
					$stmt = $conn->prepare("SELECT *
							FROM question_choices
							WHERE question_ID ='"."$question_ID[$i]"."'	
							"); 
					$stmt->execute();
				
					$j = 0;
					while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
						$choice_array[$j] = $row->choice;
						$right_response[$j] = $row->right_response;
						$j++;
					}
				   
					echo $presentation_array[$i];
					$arrlength_choice = count($choice_array);
					for($j = 0; $j < $arrlength_choice; $j++){
						echo "<br>";
						echo "<input style = '"."margin-left:25px"."' type= '"."checkbox"."' name = '"."choice[]"."' value = '"."$question_ID[$i],$j"."' >$choice_array[$j]" ;
					}
					echo "<br><br><br>";
				}
			?> 
			<input style = "margin:20px 5px 20px 90%;"  type="submit" name = "submitType" value = "   Submit   ">
		</form> 
           
		<div id="footer">
		</div>
	</div>

</body>


