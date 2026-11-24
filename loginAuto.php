<?php
session_start();

$servername="localhost";
$username="root";
$password="";
$dbName="badminton";

$conn=new mysqli($servername, $username, $password, $dbName);

if ($conn->connect_error) {
    die("Connection failed:". $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loginUsername=$_POST['myusername'];
    $loginPassword=$_POST['mypassword'];
    $role=$_POST['role'];

if ($role == "admin") {
    $sql="SELECT username, password FROM admin WHERE username='$loginUsername' AND password='$loginPassword'";
    $result=$conn->query($sql);

    if ($result->num_rows>0) {
        $row=$result->fetch_assoc();

        $_SESSION['username']=$row['username'];
        $_SESSION['role']="admin";

        header("location:adminMenu.php");
        exit();
    } else {
       header("Location: login.php?error=1");
       exit();
    }
}

else if ($role == "user") {
    $sql="SELECT * FROM users WHERE email='$loginUsername' AND password='$loginPassword'";
    $result=$conn->query($sql);

    if ($result->num_rows>0) {
        $row=$result->fetch_assoc();

        $_SESSION['userID']=$row['userID'];
        $_SESSION['name']=$row['name'];
        $_SESSION['role']="user";

        header("location:userMenu.php");
        exit();
    } else {
       header("Location: login.php?error=1");
       exit();
    }
  }
}

$conn->close();

?>