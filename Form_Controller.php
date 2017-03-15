<!DOCTYPE html>
<html>

<link rel="stylesheet" type="text/css" href="style.css" />

<?php
	include("mydomain.php");
	include("database.php");
	
	$stmt = $conn->prepare("SELECT presentation, ID
							FROM question"
							); 
	$stmt->execute();
	$i = 0;
	while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
		$presentation_array[$i] = $row->presentation;
		$question_ID[$i] = $row->ID;
		$i++;
	}
	$rowcount = $stmt->rowCount();
	
	if ($rowcount == 0){
		header("Location: $mydomain/webApp/empty_questions.php");
	}
	
	//for situation!
	if (isset($_POST['choice'])){
		$choice = $_POST['choice'];
		$arrlength = count($choice);
		
		for($i = 0; $i < $arrlength; $i++){
			$sql = "UPDATE question SET situation = '$choice[$i]' WHERE presentation = '$presentation_array[$i]'"; 
			$stmt = $conn->prepare($sql);
			$stmt->execute();
		}
		header("Location: $mydomain/web/Interface_Controller.php");
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
	<div id = "content" style = "text-align:center;">

		<p>You can check the questions. 
	    </p>
		
        <form action="" method = "POST">     
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
					$rowcount = $stmt->rowCount();
						
					echo $presentation_array[$i];
					for($j = 0; $j < $rowcount; $j++){
						$k = $j+1; //gia na exei to sosto arithmo h apantish
						if ( $right_response[$j] == 'yes'){
							echo "<br> <strong>$k . $choice_array[$j] </strong>" ;
						}
						else{
							echo "<br >$k . $choice_array[$j]" ;
						}
					}
					
					echo 	"<br>
							<table align = "."center".">
								<tr><td align="."right"."></td><td align="."center"."><br>
									<input type= '"."checkbox"."' name = '"."choice[]"."' value = '"."inactive"."'>Reject 
									<input type= '"."checkbox"."' name = '"."choice[]"."' value = '"."active"."'>Confirm
								</td></tr>
							</table>
							<br>
							<tr><td colspan="."2"."><hr></td></tr>
							<br>";
				}
			?> 
			
			<input style = "margin:20px 5px 20px 90%;"  type="submit" name = "submitType" value = "   Submit   ">
		</form>
          
        <div id="footer">
		</div>
	</div>
</body>


