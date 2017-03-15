<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="style.css" />
<?php 
	include("mydomain.php"); 
	include("database.php"); 
	
	$username = "";
	$password = "";
	$usernameErr = "";
	$passwordErr = "";
	$error_css1 = "";
	$error_css2 = "";
	$Error = "";
	
	if( isset($_POST['log']) && ($_POST['log'] = "Login")){
		if (empty($_POST["username"])) {
			$usernameErr = "required";
			$error_css1 = 'background-color:#F08080';
		} 
		else{
			$username = $_POST['username'];
		}
		if (empty($_POST["password"])) {
			$passwordErr = "required";
			$error_css2 = 'background-color:#F08080';
		} 
		else{
			$password = $_POST['password'];
		}	
				
		$stmt = $conn->prepare("SELECT username, password FROM proponent WHERE username= '$username' AND password= '$password'"); 
		$stmt->execute();
			
		$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		$rowcount = $stmt->rowCount();
			
		session_start();
		$_SESSION['username'] = $username;
			
		if( $rowcount != 0 ){
			header("Location: $mydomain/web/Interface_Proponent.php");
		}
			
		$stmt = $conn->prepare("SELECT username, password FROM controller WHERE username= '$username' AND password= '$password'"); 
		$stmt->execute();
		$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		$rowcount = $stmt->rowCount();
			
		if( $rowcount != 0 ){
			header("Location: $mydomain/webforGit/Interface_Controller.php");
		}
			
		$stmt = $conn->prepare("SELECT username, password FROM teacher WHERE username= '$username' AND password= '$password'"); 
		$stmt->execute();
		$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		$rowcount = $stmt->rowCount();
			
		if( $rowcount != 0 ){
			header("Location: $mydomain/webforGit/Interface_Teacher.php");
		}
			
		$stmt = $conn->prepare("SELECT username, password FROM student WHERE username= '$username' AND password= '$password'"); 
		$stmt->execute();
		$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		$rowcount = $stmt->rowCount();
			
		if( $rowcount != 0 ){
			header("Location: $mydomain/webforGit/Interface_Student.php");
		}
		$Error = "Username or password is wrong!";
	}
?>

<head>
	<title>MyPage</title>
	<style>
		.error{
			color: #F08080;
		}	
		input[type=submit] {
			background-color: 	#D3D3D3;
			border: 0.5;
			color: #123;
			padding: 10px 30px 25px;
			text-decoration: none;
			margin: 4px 2px 2px 4px;
			cursor: pointer;
}
	</style>
</head>

<body>
	<div style = "background-color:#123; padding:95px;">
           <img src="dib.png" alt="dib" style="width:auto;height:auto;">
	</div>
    <div id="page"></div>
	<div id = "content" style = "text-align:center">
    <p>You should do log in in order to enter in the system. 
	</p>
    <form action="" method = "POST" name = "login">
		<table align = "center" width = "350">
		<tr><td colspan="2"><hr></td></tr>
			<tr>
				<td align="left">User name:</td>
				<td align="left"><input type="text" name="username" style="<?php echo $error_css1; ?>"><span class="error">* <?php echo $usernameErr;?></td> 
			</tr>
		<tr>
			<td align="left">User password:</td>
			<td align="left"><input type="Password" name="password" style="<?php echo $error_css2; ?>"><span class="error">* <?php echo $passwordErr;?></td>
			<span class="error"><?php echo $Error;?>
		</tr>
		<tr><td colspan="2"><hr></td></tr>
		</table>
              
        <input style = " width: 13em;  height: 2em" type="submit" name = "log" value= "Log In">
    </form>
           
	<p>If you do not have an account, you should do registration in the system.
        <a href="<?php $mydomain ?>/web/Registration_Choices.php" style = "color:DodgerBlue">Registration</a>
	</p>
    <div id="footer"></div>
    </div>
</body>


