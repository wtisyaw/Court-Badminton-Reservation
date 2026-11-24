<?php
session_start();

if(!isset($_SESSION['userID'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Menu for User</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <h2>Menu for User</h2>

<div class="menu-box">

    <p class="welcome-text">
        Welcome, <?php echo $_SESSION['name']; ?>
    </p>

    <!-- View Court -->
    <form action="userCourt.php" method="post">
    <p><input type="submit" value="View Court" name="cmdView"></p>
</form>

    <!-- View Time Slot -->
    <form action="viewTimeSlot.php" method="get">
    <p><input type="submit" value="View Time Slot"></p>
</form>

    <!-- Make Reservation -->
    <form action="makeReservation.php" method="post">
    <p><input type="submit" value="Make Reservation" name="cmdMake"></p>
</form>

    <!-- View My Reservation -->
    <form action="myReservation.php" method="post">
    <p><input type="submit" value="My Reservation" name="cmdView"></p>
</form>

    <!-- Cancel Reservation -->
    <form action="cancelReservation.php">
    <p><input type="submit" value="Cancel Reservation">
</form>

</div>

<!-- Log out -->
  <a href ="logout.php">
    <button class="back-button">Log Out</button>
  </a>

</body>
</html>