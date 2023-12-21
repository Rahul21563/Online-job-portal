<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
session_start();

function logError($message) {
    // Log the error message to the local error log file
    error_log($message, 3, "error_log.txt");
}

$UserName = $_POST['txtUser'];
$Password = $_POST['txtPass'];
$HashedPassword = hash('sha256', $Password);
$UserType = $_POST['cmbUser'];

if ($UserType == "Administrator") {
    $con = mysqli_connect("localhost", "root", "", "job");

    $sql = "SELECT * FROM user_master WHERE UserName=? AND Password=?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $UserName, $HashedPassword);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $records = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);

    if ($records == 0) {
        // Log the error
        logError("Wrong UserName or Password for Administrator: $UserName");
        echo '<script type="text/javascript">alert("Wrong UserName or Password");window.location=\'index.php\';</script>';
    } else {
        $_SESSION['$UserName'] = $UserName;
        header("location:Admin/index.php");
    }

    mysqli_close($con);
} elseif ($UserType == "JobSeeker") {
    $con = mysqli_connect("localhost", "root", "", "job");
    $sql = "SELECT * FROM jobseeker_reg WHERE UserName=? AND Password=? AND Status='Confirm'";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $UserName, $HashedPassword);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $records = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);

    if ($records == 0) {
        // Log the error
        logError("Wrong UserName or Password for JobSeeker: $UserName");
        echo '<script type="text/javascript">alert("Wrong UserName or Password");window.location=\'index.php\';</script>';
    } else {
        $_SESSION['ID'] = $row['JobSeekId'];
        $_SESSION['Name'] = $row['JobSeekerName'];
        $_SESSION['$UserName_job'] = $UserName;
        header("location:JobSeeker/index.php");
    }

    mysqli_close($con);
} else {
    $con = mysqli_connect("localhost", "root", "", "job");
    $sql = "SELECT * FROM employer_reg WHERE UserName=? AND Password=? AND Status='Confirm'";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $UserName, $HashedPassword);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $records = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);

    if ($records == 0) {
        // Log the error
        logError("Wrong UserName or Password for Employer: $UserName");
        echo '<script type="text/javascript">alert("Wrong UserName or Password");window.location=\'index.php\';</script>';
    } else {
        $_SESSION['ID'] = $row['EmployerId'];
        $_SESSION['Name'] = $row['CompanyName'];
        $_SESSION['$UserName_emp'] = $UserName;
        header("location:Employer/index.php");
    }

    mysqli_close($con);
}
?>

</body>
</html>
