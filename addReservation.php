<html>
<head>
    <title>Add Reservation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2 style="text-align:center;">Add Reservation</h2>

<?php

$servername="localhost";
$username="root";
$password="";
$dbname="badminton";

$conn=new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $userID=$_POST['userID'];
    $courtID=$_POST['courtID'];
    $reservationDate=$_POST['reservationDate'];
    $start=$_POST['startTime'];
    $end=$_POST['endTime'];
    $reservationStatus=$_POST['reservationStatus'];
    $paymentStatus=$_POST['paymentStatus'];

    $startTime=$reservationDate . " " . $start;
    $endTime=$reservationDate . " " . $end;

    $sql="INSERT INTO reservation (userID, courtID, startTime, endTime, reservationStatus, paymentStatus)
        VALUES ('$userID', '$courtID', '$startTime', '$endTime', '$reservationStatus', '$paymentStatus')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='text-align:center;color:green;'>Reservation added successfully.</p>";
    } else {
        echo "<p style='text-align:center;color:red;'>Error: " . $conn->error . "</p>";
    }
}

?>

<div class="form-box">
<form method="post" style="text-align:center;">

<p>User:
<select name="userID" required>
<option value="">-- Select User --</option>
<?php
$result = $conn->query("SELECT userID, name FROM users");
while($row = $result->fetch_assoc()) {
    echo "<option value='".$row['userID']."'>".$row['name']."</option>";
}
?>
</select>
</p>

<p>Court:
<select name="courtID" required>
<option value="">-- Select Court --</option>
<?php
$result = $conn->query("SELECT courtID, courtName FROM court");
while($row = $result->fetch_assoc()) {
    echo "<option value='".$row['courtID']."'>".$row['courtName']."</option>";
}
?>
</select>
</p>

<p>Reservation Date:
<input type="date" name="reservationDate" required>
</p>

<p>Start Time:
<input type="time" name="startTime" required>
</p>

<p>End Time:
<input type="time" name="endTime" required>
</p>

<p>Reservation Status:
<select name="reservationStatus">
<option value="Pending">Pending</option>
<option value="Confirmed">Confirmed</option>
<option value="Cancelled">Cancelled</option>
</select>
</p>

<p>Payment Status:
<select name="paymentStatus">
<option value="Pending">Pending</option>
<option value="Paid">Paid</option>
</select>
</p>

<p><input type="submit" value="Add Reservation"></p>

</form>
</div>

<div style="text-align:center; margin-top:20px;">
    <a href="manageReservation.php">
        <button type="button">Back</button>
    </a>
</div>

</body>
</html>