<?php
session_start();
?>

<html>
<head>
    <title>My Reservation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>My Reservation</h2>

<div class="table-box">

<?php

$servername="localhost";
$username="root";
$password="";
$dbname="badminton";

$conn=new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userID = $_SESSION['userID'];

$sql = "SELECT reservation.reservationID,
               court.courtName,
               reservation.startTime,
               reservation.endTime,
               reservation.reservationStatus,
               reservation.paymentStatus
        FROM reservation
        JOIN court ON reservation.courtID=court.courtID
        WHERE reservation.userID='$userID'
        ORDER BY reservation.reservationID ASC";

$result=$conn->query($sql);

if ($result->num_rows>0) {
    echo '<table>';
    echo '<tr>
            <th>No</th>
            <th>Reservation ID</th>
            <th>Court</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Reservation Status</th>
            <th>Payment Status</th>
            <th>Action</th>
          </tr>';

$no=1;

    while ($row=$result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>'.$no.'</td>';
        echo '<td>'.$row["reservationID"].'</td>';
        echo '<td>'.$row["courtName"].'</td>';
        echo '<td>'.$row["startTime"].'</td>';
        echo '<td>'.$row["endTime"].'</td>';
        echo "<td style='font-weight:bold; color:";
        if ($row['reservationStatus'] == 'Pending') echo "orange";
        else if ($row['reservationStatus'] == 'Confirmed') echo "green";
        else if ($row['reservationStatus'] == 'Cancelled') echo "red";
        echo ";'>" . $row["reservationStatus"] . "</td>";
        echo "<td style='font-weight:bold; color:";
        if ($row['paymentStatus'] == 'Pending') echo "orange";
        else if ($row['paymentStatus'] == 'Paid') echo "green";
        else if ($row['paymentStatus'] == 'Cancelled') echo "red";
        echo ";'>" . $row["paymentStatus"] . "</td>";

        echo "<td>";
        if ($row['paymentStatus'] == 'Pending' && $row['reservationStatus'] != 'Cancelled') {
            echo "<a href='paymentConfirmation.php?reservationID=" . $row['reservationID'] . "'>
                    <button type='button'>Payment Confirmation</button>
                  </a>";
        } else {
            echo "-";
        }
        echo "</td>";
        echo '</tr>';
        $no++;
    }

    echo '</table>';
} else {
    echo "<p>No reservations found.</p>";
}

$conn->close();

?>

</div>

<div style="text-align:center; margin-top:20px;">
    <a href="userMenu.php">
        <button type="button">Back to Menu</button>
    </a>
</div>

</body>
</html>