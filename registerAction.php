<?php

$servername="localhost";
$username="root";
$password="";
$dbName="badminton";

$conn=new mysqli($servername, $username, $password, $dbName);

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

$name=$_POST['name'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$userPassword=$_POST['password'];

$checkSql="SELECT * FROM users WHERE email='$email'";
$checkResult=$conn->query($checkSql);

if($checkResult->num_rows > 0) {
   header("Location: register.php?error=email");
   exit();
} else {
    $sql="INSERT INTO users(name, email, phone, password) VALUES ('$name', '$email', '$phone', '$userPassword')";

    if($conn->query($sql) === TRUE) {
        header("Location: register.php?success=1");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>