<?php
session_start();
?>

<html>
<head>
    <title>Make Reservation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Make Court Reservation</h2>

<?php

$servername="localhost";
$username="root";
$password="";
$dbname="badminton";

$conn=new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message="";
$msgColor="";

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['courtID'])) { 

    $userID=$_SESSION['userID'];
    $courtID=$_POST['courtID'];
    $reservationDate=$_POST['reservationDate'];
    $startTime=$_POST['startTime'];
    $endTime=$_POST['endTime'];

    $fullStartTime=$reservationDate .  " " . $startTime;
    $fullEndTime=$reservationDate . " " . $endTime;

    $reservationStatus="Pending";
    $paymentStatus="Pending";

    $sql="INSERT INTO reservation (userID, courtID, startTime, endTime, reservationStatus, paymentStatus)
          VALUES ('$userID', '$courtID', '$fullStartTime', '$fullEndTime', '$reservationStatus', '$paymentStatus')";

    if ($conn->query($sql) === TRUE) {
        $message="Reservation added successfully.";
        $msgColor="green";
    } else {
        $message="Error: " . $conn->error;
        $msgColor="red";
    }
}

?>

<div class="form-box">

    <?php if (!empty($message)) { ?>
        <div style="
            background: <?php echo ($msgColor == 'green') ? '#d1e7dd' : '#f8d7da'; ?>;
            color: <?php echo ($msgColor == 'green') ? '#0f5132' : '#842029'; ?>;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 15px;
        ">
            <?php echo $message; ?>
        </div>
    <?php } ?>

<form method="post">

<p>Court:
<select name="courtID" required>
    <option value="">--Select Court --</option>
    <?php
    $result=$conn->query("SELECT courtID, courtName FROM court WHERE courtStatus='Available' ORDER BY courtID ASC");

    while ($row=$result->fetch_assoc()) {
        echo "<option value='" . $row['courtID'] . "'>" . $row['courtName'] . "</option>";
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

<p> 
<input type="submit" value="Make Reservation">
</p>

</form>

</div>

<div style="text-align:center; margin-top:20px;">
    <a href="userMenu.php">
        <button type="button" class="back-button">Back to Menu</button>
    </a>
</div>

</body>
</html>