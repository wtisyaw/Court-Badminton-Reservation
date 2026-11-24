<html>
<head>
    <title>Manage Reservation</title>
    <link rel="stylesheet" href="style.css">
</head>

<body style="text-align:center;">

<h2>Manage Court Reservation</h2>

<!-- Add reservation -->
<form action="addReservation.php" style="margin:10px;">
<p><input type="submit" value="Add Reservation"></p>
</form>

<!-- View Reservation -->
<form action="viewReservation.php" style="margin:10px;">
<p><input type="submit" value="View Reservation"></p>
</form>

<!-- Update Reservation -->
<form action="updateReservation.php" style="margin:10px;">
<p><input type="submit" value="Update Reservation"></p>
</form>

<!-- Delete Reservation -->
<form action="deleteReservation.php" style="margin:10px;">
<p><input type="submit" value="Delete Reservation"></p>
</form>

<!-- Search Reservation -->
<form action="searchReservation.php" style="margin:10px;">
<p><input type="submit" value="Search Reservation"></p>
</form>

<a href ="adminMenu.php">
    <button class="back-button">Back to Menu</button>
</a>

</body>
</html>