<?php
session_start();

if(!isset($_SESSION['username']) || $_SESSION['role'] != "admin") {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Menu for Admin</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <h2>Menu for Admin</h2>

<div class="menu-box">

    <p class="welcome-text">
       Welcome, <?php echo $_SESSION['username']; ?>
    </p>

    <!-- View User -->
    <form action="registrationList.php" method="post">
    <p><input type="submit" value="View User" name="cmdView"></p>
</form>

    <!-- View Court Information -->
    <form action="courtList.php" method="post">
    <p><input type="submit" value="View Court Information" name="cmdView"></p>
</form>

    <!-- Manage Court Reservation -->
    <form action="manageReservation.php" method="post">
    <p><input type="submit" value="Manage Court Reservation" name="cmdManage"></p>
</form>

</div>

<!-- Log out -->
  <a href ="login.html">
    <button class="back-button">Log Out</button>
  </a>

</body>
</html>