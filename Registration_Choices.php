<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="style.css" />
<?php include("mydomain.php") ?>
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
		<p style = "text-align:center;">Which is category where you belong? 
		</p>
		<?php
			if (isset($_POST['submitType'])){
				header('Location:'.$_POST['choice']);
			}
		?>
		<form style = "margin-left:40%" method="POST" action="" > 
			<input style = "margin-left:25px" type="radio" id = "r1" name="choice" value="<?php $mydomain ?>/web/Registration_Proponent.php">Proponent<br><br>
			<input style = "margin-left:25px" type="radio" id = "r2" name="choice" value="<?php $mydomain ?>/web/Registration_Controller.php">Controller<br><br>
			<input style = "margin-left:25px" type="radio" id = "r3" name="choice" value="<?php $mydomain ?>/web/Registration_Teacher.php">Teacher<br><br>
			<input style = "margin-left:25px" type="radio" id = "r4" name="choice" value="<?php $mydomain ?>/web/Registration_Student.php">Student<br><br>
			<input style = "margin:20px 5px 20px 80%;"  type="submit" name = "submitType" value = "   Next >   ">
		</form> 
								
		<div id="footer">
		</div>
	</div>
</body>

