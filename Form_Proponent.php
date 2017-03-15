<!DOCTYPE html>
<html>

<link rel="stylesheet" type="text/css" href="style.css" />

<?php
	include("mydomain.php");
	include("database.php");
	
	$questionErr = $choice1Err = $choice2Err = "";
	$error_css1 = $error_css2 = $error_css3 = $error_css4 = "";
	$Error = "";
	if(isset($_POST['submitType'])){
		if (empty($_POST["presentation"])){
			$error_css1 = 'background-color:#F08080';
		}

		if (empty($_POST["choice1"])){
			$error_css2 = 'background-color:#F08080';
		}
			
		if (empty($_POST["choice2"])){
			$error_css3 = 'background-color:#F08080';
		}
		if (empty($_POST["right_response1"])){
			$error_css4 = 'background-color:#F08080';
		}
		
		$question = $_POST['presentation'];
		$stmt = $conn->prepare("SELECT * 
								FROM question 
								WHERE presentation = '$question'"
								); 
		$stmt->execute();
		$rowcount = $stmt->rowCount();
		
		if ($rowcount == 0){
		
			$sql= "INSERT INTO question(presentation, difficalty)             
					
					VALUES ('"."$_POST[presentation]"."','"."$_POST[difficalty]"."' )";
										
			$conn->exec($sql);
			
			$stmt = $conn->prepare("SELECT * 
									FROM question 
									WHERE presentation = '$question'"
									); 
			$stmt->execute();

			while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
				$question_ID = $row->ID;
				$situation = $row->situation;
				$difficalty = $row->difficalty;
			}
			
			
			//=============================================================
			if ((isset($_POST['choice1'])) && $_POST['choice1'] != "" ){		
				$sql = "INSERT INTO question_choices(question_ID, choice, right_response)
													 
						VALUES ('"."$question_ID"."', '"."$_POST[choice1]"."', '"."$_POST[right_response1]"."' )";
								
				$conn->exec($sql);
			}
			if ((isset($_POST['choice2'])) && $_POST['choice2'] != "" ){		
				$sql = "INSERT INTO question_choices(question_ID, choice, right_response)
													 
						VALUES ('"."$question_ID"."', '"."$_POST[choice2]"."', '"."$_POST[right_response2]"."' )";
								
				$conn->exec($sql);
			}
			if ((isset($_POST['choice3'])) && $_POST['choice3'] != "" ){		
				$sql = "INSERT INTO question_choices(question_ID, choice, right_response)
													 
						VALUES ('"."$question_ID"."', '"."$_POST[choice3]"."', '"."$_POST[right_response3]"."' )";
								
				$conn->exec($sql);
			}
			if ((isset($_POST['choice4'])) && $_POST['choice4'] != "" ){		
				$sql = "INSERT INTO question_choices(question_ID, choice, right_response)
													 
						VALUES ('"."$question_ID"."', '"."$_POST[choice4]"."', '"."$_POST[right_response4]"."' )";
								
				$conn->exec($sql);
			}
			
			//=============================================================
			if ((isset($_POST['class1']))){		
				$sql = "INSERT INTO question_turnon(question_ID, classroom)
													 
						VALUES ('"."$question_ID"."', '"."$_POST[class1]"."' )";
								
				$conn->exec($sql);
			}
			if ((isset($_POST['class2']))){		
				$sql = "INSERT INTO question_turnon(question_ID, classroom)
													 
						VALUES ('"."$question_ID"."', '"."$_POST[class2]"."' )";
								
				$conn->exec($sql);
			}
			if ((isset($_POST['class3']))){		
				$sql = "INSERT INTO question_turnon(question_ID, classroom)
													 
						VALUES ('"."$question_ID"."', '"."$_POST[class3]"."' )";
								
				$conn->exec($sql);
			}
		}
		else{
			$Error = "<font size = "."4"."><b>You have a problem!<br>There is question which is the same and you should create another question</b></font><br>";	
		}
	}
		
?>

<head>
	<title>MyPage</title>
	<style>
		.error{
			color: #F08080;
		}
	</style>

<body>
	<div style = "background-color:#123; padding:95px;">
           <img src="dib.png" alt="dib" style="width:auto;height:auto;">
	</div>
          

        <div id="page"></div>
		<div id = "content" style = "text-align:center">

			<p>You can put in the below fields in order to create a new question or <a  href="Logout.php" style = "color:DodgerBlue">Log out</a> 
			</p>
			
			<span class="error"><?php echo $Error;?></span>
			
			<form action="" method = "POST" name = "login">
				<strong>Question</strong><br>
                 <textarea name="presentation" rows="7" cols="60" style="<?php echo $error_css1; ?>"></textarea>
                 <br><br>
				 <strong>Choice A</strong><br>
                 <textarea name="choice1" rows="1" cols="60" style="<?php echo $error_css2; ?>"></textarea><br>
				 <table align = "center">
					<tr><td align="right" style="<?php echo $error_css4;?>" >Right response</td><td align="center">
						<input type="radio" name="right_response1" value="yes" >Yes
						<input type="radio" name="right_response1" value="no" >No
					</td></tr>
				 </table>
				 <br><br>
				 <strong>Choice B</strong><br>
                 <textarea name="choice2" rows="1" cols="60" style="<?php echo $error_css3; ?>"></textarea><br>
				 <table align = "center">
					<tr><td align="right">Right response</td><td align="center">
						<input type="radio" name="right_response2" value="yes">Yes
						<input type="radio" name="right_response2" value="no">No
					</td></tr>
				 </table>
				 <br><br>
				 <strong>Choice C</strong><br>
                 <textarea name="choice3" rows="1" cols="60"></textarea><br>
				 <table align = "center">
					<tr><td align="right">Right response</td><td align="center">
						<input type="radio" name="right_response3" value="yes">Yes
						<input type="radio" name="right_response3" value="no">No
					</td></tr>
				 </table>
				 <br><br>
				 <strong>Choice D</strong><br>
                 <textarea name="choice4" rows="1" cols="60"></textarea><br>
				 <table align = "center">
					<tr><td align="right">Right response</td><td align="center">
						<input type="radio" name="right_response4" value="yes">Yes
						<input type="radio" name="right_response4" value="no">No
					</td></tr>
				 </table>
				 
				<br> 
				<tr><td colspan="2"><hr></td></tr>
				<br>You should define the kind of question<br><br>
				<tr><td align="right"><strong>Difficalty:</strong></td>
					<td align="left">
						<select name="difficalty">
							<option name="difficalty" value="easy" selected> Easy </option>
							<option name="difficalty" value="middle"> Middle </option>
							<option name="difficalty" value="difficult"> Difficult </option>
						</select>
					</td>
				</tr>
				<br><br>
                <tr><td colspan="2"><hr></td></tr>
				<br>
				<tr><td align="right" >You should define the class</td><td align="left"><br>
					<input type="checkbox" name="class1" value="A"> <strong>Class A</strong><br>
					<input type="checkbox" name="class2" value="B"> <strong>Class B</strong><br>
					<input type="checkbox" name="class3" value="C"> <strong>Class C</strong><br>
				</td></tr>
				<br>
				<tr><td colspan="2"><hr></td></tr>
				<br>
				 
				<input style = "margin:20px 5px 20px 90%;"  type="submit" name="submitType" value = "   Submit   ">
			</form>
 
           <div id="footer"></div>
        </div>

</body>


