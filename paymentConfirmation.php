<?php
session_start();

if(!isset($_SESSION['userID'])) {
    header("Location: login.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "badminton";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userID=$_SESSION['userID'];

if(!isset($_GET['reservationID'])) {
    header("Location: myReservation.php");
    exit();
}

$reservationID=$_GET['reservationID'];

$sql="SELECT reservation.reservationID, court.courtName, court.courtPrice, reservation.startTime, reservation.endTime, reservation.reservationStatus, reservation.paymentStatus
      FROM reservation reservation
      JOIN court court ON reservation.courtID=court.courtID
      WHERE reservation.reservationID='$reservationID'
      AND reservation.userID='$userID'";

$result=$conn->query($sql);

if($result->num_rows == 0) {
    echo "Reservation not found.";
    exit();
}

$row=$result->fetch_assoc();

$startTimestamp=strtotime($row['startTime']);
$endTimestamp=strtotime($row['endTime']);

$durationHours=($endTimestamp-$startTimestamp) / 3600;

$ratePerHour=$row['courtPrice'];

$totalPayment=$durationHours * $ratePerHour;

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $updateSql="UPDATE reservation
                SET paymentStatus='Paid',
                    reservationStatus='Confirmed'
                WHERE reservationID='$reservationID'
                AND userID='$userID'";

    if($conn->query($updateSql) == TRUE) {
        header("Location: myReservation.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<html>
<head>
    <title>Payment Confirmation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Payment Confirmation</h2>

<div class="form-box">
<div style="text-align:center;">

    <p style="display:block; text-align:center; font-weight:bold;">
        Reservation ID: <?php echo $row['reservationID']; ?>
    </p>

    <p style="display:block; text-align:center;">
        Court: <?php echo $row['courtName']; ?>
    </p>

    <p style="font-size:14px; color:#666;">
        Rate: RM <?php echo number_format($row['courtPrice'], 2); ?>/hr
    </p>

    <p style="display:block; text-align:center;">
        Start Time: <?php echo $row['startTime']; ?>
    </p>

    <p style="display:block; text-align:center;">
        End Time: <?php echo $row['endTime']; ?>
    </p>

    <p style="font-weight:bold; color:#6a5acd;">
        Total Payment: RM <?php echo number_format($totalPayment, 2); ?>
    </p>

    <p style="display:block; text-align:center;">
        Reservation Status:
        <span style="
            font-weight:bold;
            color:
            <?php
            if($row['reservationStatus'] == 'Pending') echo 'orange';
            else if($row['reservationStatus'] == 'Confirmed') echo 'green';
            else if($row['reservationStatus'] == 'Cancelled') echo 'red';
            ?>
        ">
            <?php echo $row['reservationStatus']; ?>
        </span>
    </p>

    <p style="display:block; text-align:center;">
        Payment Status: 
        <span style="
            font-weight: bold;
            color:
            <?php
            if($row['paymentStatus'] == 'Pending') echo 'orange';
            else if($row['paymentStatus'] == 'Paid') echo 'green';
            ?>
        ">
            <?php echo $row['paymentStatus']; ?>
        </span>
    </p>
    
    <div style="
        background:#fff3cd;
        color:#856404;
        padding:10px;
        border-radius:8px;
        margin-top:15px;
        text-align:15px;
    ">
        Please make your payment at the counter before confirming.
    </div>
    
    <form method="post">
        <p>
            <input type="submit" value="Confirm Payment">     
         </p>
    </form> 
</div>

<div style="text-align:center; margin-top:20px;">
    <a href="myReservation.php">
        <button type="button" class="back-button">
            Back to<br>My Reservation
        </button>
    </a>
</div>

</body>
</html>

<?php
$conn->close();
?>