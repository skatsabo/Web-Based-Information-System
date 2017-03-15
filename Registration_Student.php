<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="style.css" />
<?php
	include("database.php");
	include("mydomain.php");
	
	$usernameErr = $passwordErr = $confirm_passwordErr = $nameErr = $surnameErr = $addressErr = $cityErr = $districtErr = "";
	$countryErr = $phoneErr = $emailErr = $schoolErr = $departmentErr = "";
	
	$error_css1 = $error_css2 = $error_css3 = $error_css4 = $error_css5 = $error_css6 = "";
	$error_css7 = $error_css8 = $error_css9 = $error_css10 = $error_css11 = $error_css12 = $error_css13 ="";
	$Error = $Error2 = "";
	
	if (isset($_POST['submitType'])){
		if (empty($_POST["username"])){
			$usernameErr = "required";
			$error_css1 = 'background-color:#F08080';
		}
		else $username = $_POST['username'];

		if (empty($_POST["password"])){
			$passwordErr = "required";
			$error_css2 = 'background-color:#F08080';
		}
		else $password = $_POST['password'];
		if (empty($_POST["confirm_password"])){
			$confirm_passwordErr = "required";
			$error_css13 = 'background-color:#F08080';
		}
				
		if (empty($_POST["name"])){
			$nameErr = "required";
			$error_css3 = 'background-color:#F08080';
		}
		else $name = $_POST['name'];
		
		if (empty($_POST["surname"])){
			$surnameErr = "required";
			$error_css4 = 'background-color:#F08080';
		}
		else
			$surname = $_POST['surname'];
		
		if (empty($_POST["address"])){
			$addressErr = "required";
			$error_css5 = 'background-color:#F08080';
		}
		else $address = $_POST['address'];
			
		if (empty($_POST["city"])){ 
			$cityErr = "required";
			$error_css6 = 'background-color:#F08080';
		}
		else $city = $_POST['city'];
			
		if (empty($_POST["district"])){ 
			$districtErr = "required";
			$error_css7 = 'background-color:#F08080';
		}
		else $district = $_POST['city'];
			
		if (empty($_POST["country"])){
			$countryErr = "required";
			$error_css8 = 'background-color:#F08080';
		}
		else $country = $_POST['country'];
			
		if (empty($_POST["telephone"])){
			$phoneErr = "required";
			$error_css9 = 'background-color:#F08080';
		}
		else $phone = $_POST['telephone'];
			
		if (empty($_POST["email"])){
			$emailErr = "required";
			$error_css10 = 'background-color:#F08080';
		}
		else $email = $_POST['email'];
			
		if (empty($_POST["school"])){
			$schoolErr = "required";
			$error_css11 = 'background-color:#F08080';
		}
		else $email = $_POST['school'];
			
		if (empty($_POST["department"])){
			$departmentErr = "required";
			$error_css12 = 'background-color:#F08080';
		}
		else $email = $_POST['department'];
			
		$username = $_POST['username'];
			
		$stmt1 = $conn->prepare("SELECT username FROM proponent WHERE username = '$username'");
		$stmt2 = $conn->prepare("SELECT username FROM controller WHERE username = '$username'");
		$stmt3 = $conn->prepare("SELECT username FROM teacher WHERE username = '$username'");
		$stmt4 = $conn->prepare("SELECT username FROM student WHERE username = '$username'");		
		$stmt1->execute();
		$stmt2->execute();
		$stmt3->execute();
		$stmt4->execute();

		$rowcount = $stmt1->rowCount() + $stmt2->rowCount() + $stmt3->rowCount() + $stmt4->rowCount();
				
		if( $rowcount == 0 && $_POST["password"] == $_POST["confirm_password"]){ //If there isn't such a username
				$sql= "INSERT INTO student(username, password, name, surname, address, city, district, country, telephone, email, school, classroom, department)             
						VALUES ('"."$_POST[username]"."', '"."$_POST[password]"."', '"."$_POST[name]"."', '"."$_POST[surname]"."', '"."$_POST[address]"."',  '"."$_POST[city]"."', 
								'"."$_POST[district]"."', '"."$_POST[country]"."', '"."$_POST[telephone]"."', '"."$_POST[email]"."', '"."$_POST[school]"."', '"."$_POST[class_choice]"."', '"."$_POST[department]"."'
								)";
									   
				if(	"$_POST[username]" == "" || "$_POST[password]" == "" ||	"$_POST[name]" == "" || "$_POST[surname]" == "" ||
					"$_POST[address]" == "" || "$_POST[city]" == "" || "$_POST[country]" == "" || "$_POST[telephone]" == "" || "$_POST[email]" == "" ) {
					$Error = "You should complete all required fields!";
				}
				else {
					$conn->exec($sql);
					header("Location: $mydomain/webApp/LogIn.php");
				}
			}
			else{
				if($rowcount != 0)
				$Error = "You should use another username!";
				else{
					$Error = "Wrong Password!";
					$error_css2 = 'background-color:#F08080';
					$error_css13 = 'background-color:#F08080';
				}
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
</head>

<body>
	<div style = "background-color:#123; padding:95px;">
           <img src="dib.png" alt="dib" style="width:auto;height:auto;">
	</div>
          
        <div id="page"></div>
	    <div id = "content" style = "text-align:center">

            <p>If you want to create an account you should complete the below fields. 
			</p>
           
			<form action="" method = "POST">
			<table align = "center" style="width:300">
			  <tr>
				<td align="left">User name:</td>
				<td align="left"><input type="text" name="username" style="<?php echo $error_css1; ?>"><span class="error">* <?php echo $usernameErr;?></span></td>		
			  </tr>
			  <tr>
				<td align="left">User password:</td>
				<td align="left"><input type="Password" name="password" style="<?php echo $error_css2; ?>"><span class="error">* <?php echo $passwordErr;?></span></td>
			  </tr>
			   <tr>
				<td align="left">Confirm password:</td>
				<td align="left"><input type="Password" name="confirm_password" style="<?php echo $error_css13; ?>"><span class="error">* <?php echo $confirm_passwordErr;?></span></td>
			  </tr>
			  <tr>
				<td align="left">Name:</td>
				<td align="left"><input type="text" name="name" style="<?php echo $error_css3; ?>"><span class="error">* <?php echo $nameErr;?></span></td>
			  </tr>
			  <tr>
				<td align="left">Surname:</td>
				<td align="left"><input type="text" name="surname" style="<?php echo $error_css4; ?>"><span class="error">* <?php echo $surnameErr;?></span></td>		
			  </tr>
			  <tr>
				<td align="left">Address:</td>
				<td align="left"><input type="text" name="address" style="<?php echo $error_css5; ?>"><span class="error">* <?php echo $addressErr;?></span></td>
			  </tr>
			  <tr>
				<td align="left">City:</td>
				<td align="left"><input type="text" name="city" style="<?php echo $error_css6; ?>"><span class="error">* <?php echo $cityErr;?></span></td>
			  </tr>
			  <tr>
				<td align="left">District:</td>
				<td align="left"><input type="text" name="district" style="<?php echo $error_css7; ?>"><span class="error">* <?php echo $districtErr;?></span></td>
			  </tr>
			  <tr>
				<td align="left">Country:</td>
				<td align="left"><input type="text" name="country" style="<?php echo $error_css8; ?>"><span class="error">* <?php echo $countryErr;?></span></td>		
			  </tr>
			  <tr>
				<td align="left">Phone Number:</td>
				<td align="left"><input type="text" name="telephone" style="<?php echo $error_css9; ?>"><span class="error">* <?php echo $phoneErr;?></span></td>
			  </tr>
			  <tr>
				<td align="left">E-mail:</td>
				<td align="left"><input type="text" name="email" style="<?php echo $error_css10; ?>"><span class="error">* <?php echo $emailErr;?></span></td>
			  </tr>
			  <tr>
				<td align="left">School:</td>
				<td align="left"><input type="text" name="school" style="<?php echo $error_css11; ?>"><span class="error">* <?php echo $schoolErr;?></span></td>
			  </tr>
			  <tr><td align="left">Class:</td>
				<td align="left">
					<select name="class_choice">
						<option name="class_choice" value="A" selected> Class A </option>
						<option name="class_choice" value="B"> Class B </option>
						<option name="class_choice" value="C"> Class C </option>
					</select>
				</td></tr>
			   <tr>
				<td align="left">Department:</td>
				<td align="left"><input type="text" name="department" style="<?php echo $error_css12; ?>"><span class="error">* <?php echo $departmentErr;?></span></td>
				
				<span class="error"><?php echo $Error;?></span>
				<br>
				<span class="error"><?php echo $Error2;?></span>
			  </tr>
			</table>

			<br><br>
			<input style = "margin:20px 5px 20px 90%;"  type="submit" name="submitType" value = "   Submit   ">
		</form>
		
    <div id="footer"></div>
    </div>
</body>

