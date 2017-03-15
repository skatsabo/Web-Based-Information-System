<html>

<link rel="stylesheet" type="text/css" href="style.css" />

<?php
	include("mydomain.php");
	include("database.php");
	
	session_start();
	$username = $_SESSION['username'];
	
	$stmt = $conn->prepare("SELECT ID FROM question"); 
	$stmt->execute();
	$i = 0;
	while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
		$question_ID[$i] = $row->ID;
		$i++;
	}
	$rowcount = $stmt->rowCount();
	
	if ($rowcount == 0){
		header("Location: $mydomain/webApp/empty_questions.php");
	}
		
	if(isset($_POST['submitType'])){
		
		$class = $_POST['class_choice'];
		$rating = $_POST['rating_choice'];
		$difficulty = $_POST['difficulty_choice'];
		
		$_SESSION['class'] = $class;
		$_SESSION['rating'] = $rating;
		$_SESSION['difficalty'] = $difficulty;

		header("Location: $mydomain/webApp/Form_Teacher.php");
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
	<div id = "content" style = "text-align:center">

	<p>You can put in the below fields the subject. 
	</p>
           
		<form action="" method = "POST">
			<table align = "center">
				<br><font size = "4">From which category do you want to create test?</font>
				<tr><td align="right">Category:</td>
					<td align="left">
						<select name="difficulty_choice">
							<option name="difficulty_choice" value="list" selected> All Categories </option>
							<option name="difficulty_choice" value="easy" > Easy </option>
							<option name="difficulty_choice" value="middle"> Middle </option>
							<option name="difficulty_choice" value="difficult"> Difficult </option>
						</select>
					</td>
				</tr>
				<br><br>
			</table>
			<br><br>
			<table align = "center">
				<br><font size = "4">In which class do you want to assign the test?</font>
				<tr><td align="right">Class:</td>
					<td align="left">
						<select name = "class_choice">
							<option name="class_choice" value="A" selected> Class A </option>
							<option name="class_choice" value="B"> Class B </option>
							<option name="class_choice" value="C"> Class C </option>
						</select>
					</td>
				</tr>
				<br><br>
			</table>
			<br><br>
			<table align = "center">
				<tr><td colspan="2"><hr></td></tr>
				<tr><td align="right"><font size = "4">Test with negative rating:</td><td align="left"></font>
					<input type="radio" name="rating_choice" value="yes">Yes
					<input type="radio" name="rating_choice" value="no">No
				</td></tr>
				<tr><td colspan="2"><hr></td></tr>
			</table>
			
			<input style = "margin:20px 5px 20px 90%;"  type="submit" name = "submitType" value = "   Submit   ">
		</form> 
 
        <div id="footer">
		</div>
	</div>

</body>
</html>
