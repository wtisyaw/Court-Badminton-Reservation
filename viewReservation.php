<html>
<head>
    <title>Reservation List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Reservation List</h2>

<div class="table-box">

<?php

$servername="localhost";
$username="root";
$password="";
$dbName="badminton";

$conn=new mysqli($servername, $username, $password, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql="SELECT reservation.reservationID,
            users.name,
            users.phone,
            court.courtName,
            reservation.startTime,
            reservation.endTime,
            reservation.reservationStatus,
            reservation.paymentStatus
        FROM reservation
        JOIN users ON reservation.userID=users.userID
        JOIN court ON reservation.courtID=court.courtID
        ORDER BY reservation.reservationID ASC";

$result=$conn->query($sql);

if(!$result) {
    die("Query failed: " . $conn->error);
}

if ($result->num_rows>0) {
    echo '<table>';
    echo '<tr>
            <th>No</th>
            <th>Reservation ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Court</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Reservation Status</th>
            <th>Payment Status</th>
          </tr>';

$no=1;

    while ($row=$result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>'.$no.'</td>';
        echo '<td>'.$row["reservationID"].'</td>';
        echo '<td>'.$row["name"].'</td>';
        echo '<td>'.$row["phone"].'</td>';
        echo '<td>'.$row["courtName"].'</td>';
        echo '<td>'.$row["startTime"].'</td>';
        echo '<td>'.$row["endTime"].'</td>';
        echo '<td>'.$row["reservationStatus"].'</td>';
        echo '<td>'.$row["paymentStatus"].'</td>';
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
    <a href="manageReservation.php">
        <button type="button">Back</button>
    </a>
</div>

</body>
</html>