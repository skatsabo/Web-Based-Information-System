
<?php
$servername = "localhost";
$username = "root";
$password = "no_password";

try {
		$conn = new PDO("mysql:host=$servername;dbname=school_exams", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e){
		echo "Connection failed: " . $e->getMessage();
    }
?>

