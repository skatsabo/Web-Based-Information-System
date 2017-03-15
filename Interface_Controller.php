<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="style.css" />
<?php
	include("mydomain.php");
	include("database.php");
	
	session_start();
	$username = $_SESSION['username'];
	$stmt = $conn->prepare("SELECT * FROM controller WHERE username = '$username'"); 
    $stmt->execute();
	while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
        $name = $row->name;
		$surname = $row->surname;
		$address = $row->address;
		$city = $row->city;
		$country = $row->country;
		$telephone = $row->telephone;
		$email = $row->email;
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
		<p style = "text-align:center">Welcome <?php echo "$name" . " " . "$surname" . "!" ?>  </p>
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
			Telephone: <?php echo "$telephone" ?>
			<br>
			E-mail: <?php echo "$email" ?>
			<br>
			<br>
			<div style = "text-align:center">
				If you want to control questions press the link:<a href="Form_Controller.php" style = "color:DodgerBlue">Controll questions</a>
			</div>
	        <br> <br>   
		<div id="footer">
		</div>
	</div>
</body>
</html>
