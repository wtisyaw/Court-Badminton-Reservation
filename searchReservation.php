<html>
<head>
    <title>Search Reservation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Search Reservation</h2>

<div class="form-box">
<form method="post">
    <p>Enter User Name:
    <input type="text" name="keyword" required>
    </p>
    <p>
    <input type="submit" name="Search Reservation">
    </p>
</form>
</div>

<?php

$servername="localhost";
$username="root";
$password="";
$dbName="badminton";

$conn=new mysqli($servername, $username, $password, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $keyword=$_POST['keyword'];

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
          WHERE users.name LIKE '%$keyword%'
          ORDER BY reservation.reservationID ASC";

    $result=$conn->query($sql);

    echo "<div class='table-box'>";

    if ($result->num_rows>0) {
        echo "<table>";
        echo "<tr>";
        echo "<th>No</th>";
        echo "<th>Reservation ID</th>";
        echo "<th>Name</th>";
        echo "<th>Phone</th>";
        echo "<th>Court</th>";
        echo "<th>Start Time</th>";
        echo "<th>End Time</th>";
        echo "<th>Reservation Status</th>";
        echo "<th>Payment Status</th>";
        echo "</tr>";

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

        echo "</table>";
    } else {
        echo "<p>No reservation found.</p>";
    }

    echo "</div>";
}

$conn->close();

?>

<div style="text-align:center; margin-top:20px;">
    <a href="manageReservation.php">
        <button type="button">Back</button>
    </a>
</div>

</body>
</html>