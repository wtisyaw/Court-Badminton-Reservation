<?php
session_start();

if(!isset($_SESSION['userID'])) {
    header("Location: login.html");
    exit();
}

$servername="localhost";
$username="root";
$password="";
$dbname="badminton";

$conn=new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<html>
<head>
    <title>View Time Slot</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>View Time Slot</h2>

<div class="form-box">
    <form method="get">
        <p>
            <label>Court:</label>
            <select name="courtID" required>
                <option value="">-- Select Court --</option>
                <?php
                $courtResult=$conn->query("SELECT courtID, courtName FROM court ORDER BY courtName ASC");
                while($courtRow=$courtResult->fetch_assoc()) {
                    $selected="";
                    if(isset($_GET['courtID']) && $_GET['courtID'] == $courtRow['courtID']) {
                        $selected="selected";
                    }
                    echo "<option value='" . $courtRow['courtID'] . "' $selected>" . $courtRow['courtName'] . "</option>";
                }
                ?>
            </select>
        </p>

        <p>
            <label>Date:</label>
            <input type="date" name="selectedDate" value="<?php echo isset($_GET['selectedDate']) ? $_GET['selectedDate'] : ''; ?>" required>
        </p>

        <p>
            <input type="submit" value="View Time Slot">
        </p>
    </form>
</div>

<?php
if(isset($_GET['courtID']) && isset($_GET['selectedDate']) && $_GET['courtID'] != "" && $_GET['selectedDate'] != "") {
    $courtID=$_GET['courtID'];
    $selectedDate=$_GET['selectedDate'];

     $sql = "SELECT court.courtName,
                    reservation.startTime,
                    reservation.endTime,
                    reservation.reservationStatus
            FROM reservation
            JOIN court ON reservation.courtID = court.courtID
            WHERE reservation.courtID = '$courtID'
            AND DATE(reservation.startTime) = '$selectedDate'
            ORDER BY reservation.startTime ASC";

    $result = $conn->query($sql);

    echo "<div class='table-box'>";

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr>
                <th>No</th>
                <th>Court</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Status</th>
              </tr>";

        $no = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $no . "</td>";
            echo "<td>" . $row['courtName'] . "</td>";
            list($date, $startTime) = explode(" ", $row['startTime']);
            $endTime = explode(" ", $row['endTime'])[1];

            echo "<td>$date</td>";
            echo "<td>$startTime</td>";
            echo "<td>$endTime</td>";

            echo "<td style='font-weight:bold; color:";
            if ($row['reservationStatus'] == 'Pending') echo "orange";
            else if ($row['reservationStatus'] == 'Confirmed') echo "green";
            else if ($row['reservationStatus'] == 'Cancelled') echo "red";
            echo ";'>" . $row['reservationStatus'] . "</td>";

            echo "</tr>";
            $no++;
        }

        echo "</table>";
    } else {
        echo "<p style='text-align:center; color:green; font-weight:bold;'>
                No reservations found. All slots are available.
              </p>";
    }

    echo "</div>";
}
?>

<div style="text-align:center; margin-top:20px;">
    <a href="userMenu.php">
        <button type="button" class="back-button">Back to Menu</button>
    </a>
</div>

</body>
</html>

<?php
$conn->close();
?>