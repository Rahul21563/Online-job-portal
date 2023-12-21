<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php

	$CompnayName=$_POST['txtName'];
	$ContactPerson=$_POST['txtPerson'];
	$Address=$_POST['txtAddress'];
	$City=$_POST['txtCity'];
	$Email=$_POST['txtEmail'];
	$Mobile=$_POST['txtMobile'];
	$Area=$_POST['txtAreaWork'];
	$Status="Pending";
	$UserName=$_POST['txtUserName'];
	$Password = hash('sha256', $_POST['txtPassword']);
	$UserType="Employer";
	$Question=$_POST['cmbQue'];
	$Answer=$_POST['txtAnswer'];
	if (!validatePasswordComplexity($_POST['txtPassword'])) {
		echo '<script type="text/javascript">alert("Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.");window.location=\'EmployerReg.php\';</script>';
		exit;
	}
	// Establish Connection with MYSQL
	$con = mysqli_connect ("localhost","root","","job");

	// Specify the query to Insert Record
	$sql = "insert into Employer_Reg(CompanyName,ContactPerson,Address,City,Email,Mobile,Area_Work,Status,UserName,Password,Question,Answer) values('".$CompnayName."','".$ContactPerson."','".$Address."','".$City."','".$Email."',".$Mobile.",'".$Area."','".$Status."','".$UserName."','".$Password."','".$Question."','".$Answer."')";
	// execute query
      
	mysqli_query ($con,$sql);
	// Close The Connection
	mysqli_close ($con);
	
	echo '<script type="text/javascript">alert("Registration Completed Succesfully");window.location=\'index.php\';</script>';

	function validatePasswordComplexity($password) {
		// Password must be at least 8 characters long
		// and contain at least one uppercase letter, one lowercase letter, one number, and one special character
	
		if (strlen($password) < 8) {
			return false;
		}
	
		$uppercaseRegex = '/[A-Z]/';
		$lowercaseRegex = '/[a-z]/';
		$numberRegex = '/[0-9]/';
		$specialCharRegex = '/[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]/';
	
		if (!preg_match($uppercaseRegex, $password) ||
			!preg_match($lowercaseRegex, $password) ||
			!preg_match($numberRegex, $password) ||
			!preg_match($specialCharRegex, $password)) {
			return false;
		}
	
		return true;
	}
?>
</body>
</html>
