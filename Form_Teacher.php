<!DOCTYPE html>
<html>

<link rel="stylesheet" type="text/css" href="style.css" />

<?php
	include("mydomain.php");
	include("database.php");
	
	session_start();
		
		$username = $_SESSION['username'];
		$class_choice = $_SESSION['class'];
		$rating_choice = $_SESSION['rating'];
		$difficalty = $_SESSION['difficalty'];
		
		$sql= "INSERT INTO test(teacher_username, classroom, negative_rating)             
					VALUES ('$username', '$class_choice', '$rating_choice')";
												
		$conn->exec($sql);	
		
		$stmt = $conn->prepare("SELECT ID
								FROM test 
								ORDER BY ID DESC"); 
		$stmt->execute();
		$i = 0;
		while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
			$test_ID[$i] = $row->ID;
			$i++;
		}
		$_SESSION['test_ID'] = $test_ID[0];
					
		if($difficalty == 'list'){ //CHOICE FROM LIST
			$stmt = $conn->prepare("SELECT ID, presentation
									FROM question
									WHERE EXISTS (SELECT ID 
												FROM question_turnon 
												WHERE question_turnon.question_ID = question.ID AND 
														question.situation = 'active' 
														AND classroom = (SELECT classroom 
																		 FROM test 
																		 WHERE test.ID = '"."$test_ID[0]"."'
																		 )
												)
									");
					
			$stmt->execute();
		}
		else{ //CHOICE FROM CATEGORY
			$stmt = $conn->prepare("SELECT ID, presentation 
									FROM question
									WHERE EXISTS (SELECT ID 
												  FROM question_turnon 
												  WHERE question_turnon.question_ID = question.ID AND 
														question.situation = 'active' AND 
														difficalty = '$difficalty' 
														AND classroom = (SELECT classroom 
																		 FROM test 
																		 WHERE test.ID = '"."$test_ID[0]"."'
																		 )
												)
									");
				
			$stmt->execute();
		}
					
		$i = 0;
		while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
			$question_ID[$i] = $row->ID;
			$presentation_array[$i] = $row->presentation;
			$i++;
		}
					
		if ($i == 0){
			header("Location: $mydomain/webApp/empty_questions.php");
		}
	

	if(isset($_POST['submitType'])){
		$x = $_SESSION['test_ID'];
		$choice = $_POST['choice'];
		
		for($i = 0; $i < count($choice); $i++){
			$position = $choice[$i];
			$sql= "INSERT INTO test_has_question(test_ID, question_ID)             
				   VALUES ('$x', '"."$question_ID[$position]"."')";/////////
			$conn->exec($sql);
		}
		header("Location: $mydomain/webApp/Interface_Teacher.php");
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
	<p style = "text-align:center;">You can select questions in order to define a new test.  
	</p>
		<form action="" method = "POST" style = "margin:0px 20px;">
			<br>
			<?php
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
						$k = $j+1; //gia na exei to sosto arithmo h apantish
						if ( $right_response[$j] == 'yes'){
							echo "<br> <strong>$k . $choice_array[$j] </strong>" ;
						}
						else{
							echo "<br >$k . $choice_array[$j]" ;
						}
					}
				
					echo "<table align = "."center".">
								<tr><td align="."right"."></td><td align="."center"."><br>
									<input type= '"."checkbox"."' name = '"."choice[]"."' value = '"."$i"."'>Select
								</td></tr>
								
							</table>
							<tr><td colspan="."2"."><hr></td></tr>";
				}
				
			?> 
			<input style = "margin:20px 5px 20px 90%;"  type="submit" name = "submitType" value = "   Submit   ">
		</form> 
   
		<div id="footer">
		</div>
	</div>

</body>


