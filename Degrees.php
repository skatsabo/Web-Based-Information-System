<!DOCTYPE html>
<html>

<link rel="stylesheet" type="text/css" href="style.css" />


<?php
	include("mydomain.php");
	include("database.php");
	
	session_start();
	$username = $_SESSION['username'];
	$class = $_SESSION['class'];
	
	$stmt = $conn->prepare("SELECT test_ID, degree
								FROM student_do_test
								WHERE student_username = '$username'"); 
	$stmt->execute();
	$i = 0;
	while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
		$test_ID[$i] = $row->test_ID;
		$degree[$i] = $row->degree;
		$i++;
	}
	
	$stmt = $conn->prepare("SELECT ID FROM test WHERE classroom = '$class'"); 
	$stmt->execute();
	
	$i = 0;
	while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
		$all_test[$i] = $row->ID;
		$i++;
		$right = $i;
	}
	
	if( count($degree) != 0){
		$arraylength = count($degree);
	}
	else{ 
		header("Location: $mydomain/webApp/not_degrees.php");
	}
	
	function search_position($x, $list){
		$position = 0;
		for ($i = 0; $i < count($list); $i++){
			if($x == $list[$i]){
				$position = $i;
			}
		}
		return $position;
	}
	
?>

<head>
	<title>MyPage</title>
	
	<style>
		table {
			width:100%;
		}
		table, th, td {
			border: 1px solid black;
			border-collapse: collapse;
		}
		th, td {
			padding: 5px;
			text-align: center;
		}
		table#t01 tr:nth-child(even) {
			background-color: #eee;
		}
		table#t01 tr:nth-child(odd) {
		   background-color:#fff;
		}
		table#t01 th {
			background-color: #123;
			color: white;
		}

</style>
</head>

<body>
	<div style = "background-color:#123; padding:95px;">
		<img src="dib.png" alt="dib" style="width:auto;height:auto;">
	</div>
          
    <div id="page">
	</div>
	<div id = "content" >
		<br><br>
		<table id="t01" >
		 
		  <tr>
			<th>Test</th>
			<th>Degree</th>
		  </tr>
		  <?php

			for($i = 0; $i < $arraylength; $i++){
				$position = search_position($test_ID[$i], $all_test);
				$position++;
				echo "<tr>";
				$position /= 2;
					echo "<td>$position</td>";
					echo "<td>$degree[$i]</td>";
				echo "</tr>";
			}
			  
		  ?>
		  
		</table>
		<br><br><br><br>
		
    <div id="footer"></div>
    </div>

</body>
</html>

