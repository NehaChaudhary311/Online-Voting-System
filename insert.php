<?php
$aadhar = $_POST['aadhar'];
$voter = $_POST['voter'];
$phone = $_POST['phone'];
$party = $_POST['party'];
//server-side validation
if((!empty($aadhar)) || (!empty($voter))|| (!empty($phone)) || (!empty($party) ))
{
	$host = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
	$dbname = "muskan";
	
	//create connection
	$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
	if(mysqli_connect_error())
	{
		die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_error());
	}
	else
	{
		$SELECT = "SELECT voter FROM voters where voter = ? Limit 1"; //atmost 1 it will select
		$INSERT = "INSERT INTO voters( aadhar, voter, phone, party) values(?,?,?, ?)";
		
		//Prepare statement
		$stmt = $conn->prepare($SELECT);
		$stmt->bind_param("i", $voter); //i represents integer
		$stmt->execute();
		$stmt->bind_result($voter);
		$stmt->store_result();
		$rnum = $stmt->num_rows;
		
		if($rnum == 0)
		{
			$stmt->close();
			
			$stmt = $conn->prepare($INSERT);
			$stmt->bind_param("iiis", $aadhar, $voter, $phone,$party);
			$stmt->execute();
			echo "New record inserted successfuly";
		}	
		else
		{
			echo "Someone already registered using this voter";
		}
		$stmt->close();
		$conn->close();
		
	}
}
else
{
	echo "All field are required";
	die();
}
?>