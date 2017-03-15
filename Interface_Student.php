<!DOCTYPE html>
<html>

<link rel="stylesheet" type="text/css" href="style.css" />

<?php
	include("mydomain.php");
	include("database.php");
	
	session_start();
	$username = $_SESSION['username'];
	
	$stmt = $conn->prepare("SELECT * FROM student WHERE username = '$username'"); 
    $stmt->execute();
	while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
        $name = $row->name;
		$surname = $row->surname;
		$address = $row->address;
		$city = $row->city;
		$country = $row->country;
		$district = $row->district;
		$telephone = $row->telephone;
		$email = $row->email;
		$school = $row->school;
		$class = $row->classroom;
		$department = $row->department;
    }
	
	$_SESSION['class'] = $class;
	
	$stmt = $conn->prepare("SELECT ID FROM test WHERE classroom = '$class' AND EXISTS (SELECT test_ID 
																					   FROM test_has_question 
																					   WHERE test_has_question.test_ID = test.ID) "); 
	$stmt->execute();
	
	$i = 0;
	while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
		$test_array[$i] = $row->ID;
		$i++;
	}
	$rowcount = $stmt->rowCount();
	
	if(isset($_POST['test'])){
		$test = $_POST['test'];
		$position = $test - 1;
		$_SESSION['test_ID'] = "$test_array[$position]"; 
		
		$stmt = $conn->prepare("SELECT test_ID
								FROM student_do_test
								WHERE student_username = '$username'"); 
		$stmt->execute();
	
		$i = 0;
		$found =0;
		echo "$test_array[$position]";
		while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
			echo "<br>";
			echo "$row->test_ID";
			if ($test_array[$position] == $row->test_ID){
				$found = 1;
			}
			$i++;
		}
		if ($found == 1){
			header("Location: $mydomain/webApp/Completed_Test.php");
		}
		else{
			header("Location: $mydomain/webApp/Form_Student.php");
		}
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
	<div id = "content" >

        <p style = "text-align:center">Welcome <?php echo "$name" . " " . "$surname" . "!" ?> </p> 
		<div id = "logout" style = "text-align:right">
			<a  href="Logout.php" style = "color:DodgerBlue">Log out</a>
		</div>
		<b>Personal Details</b>
		<br><br>  
	   	Name: <?php echo "$name" ?>
		<br>
		Surname: <?php echo "$surname" ?>
		<br>
		Address: <?php echo "$address" ?>
		<br>
		City: <?php echo "$city" ?>
		<br>
		Country: <?php echo "$country" ?>
		<br>
		District: <?php echo "$district" ?>
		<br>
		Telephone: <?php echo "$telephone" ?>
		<br>
		E-mail: <?php echo "$email" ?>
		<br>
		School: <?php echo "$school" ?>
		<br>
		Class: <?php echo "$class" ?>
		<br>
		Department: <?php echo "$department" ?>
		<br>
        <br>
		<div style = "text-align:center">
		<font size = "4">You can see your degrees:<a  href="Degrees.php" style = "color:DodgerBlue">Degrees</a></font>
		</div>
		<br>
        <br>
	
		<form method = "POST">
	    <?php	
			if ($rowcount == 0){
				echo "<div style = "."text-align:center"."><font size = "."4".">There are not tests to do at the moment</font></div>";
			}
			else{
				echo "<font size = "."4".">You are in examination period and must take part in exams: Test  </font>";
				$arrlength = count($test_array);
				for($i = 1; $i <= $arrlength; $i++){
					echo "<input type = "."submit"." name = "."test"." value = "."$i"."  style = "."color:DodgerBlue"."> ";
				}
				echo "<br><br><br>";
			}
		?>
		</form>
        <div id="footer"></div>
        </div>	
	</div>
</body>
</html>

