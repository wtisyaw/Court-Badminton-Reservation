<?php
$message="";
$msgColor="";

$servername="localhost";
$username="root";
$password="";
$dbname="badminton";

$conn=new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $reservationID=$_POST['reservationID'];
    $userID=$_POST['userID'];
    $courtID=$_POST['courtID'];
    $reservationDate=$_POST['reservationDate'];
    $startTime=$_POST['startTime'];
    $endTime=$_POST['endTime'];
    $reservationStatus=$_POST['reservationStatus'];
    $paymentStatus=$_POST['paymentStatus'];

    $newStartTime=$reservationDate . " " . $startTime;
    $newEndTime=$reservationDate . " " . $endTime;

    $sql="UPDATE reservation SET 
          userID='$userID',
          courtID='$courtID',
          startTime='$newStartTime',
          endTime='$newEndTime',
          reservationStatus='$reservationStatus',
          paymentStatus='$paymentStatus'
          WHERE reservationID='$reservationID'";

    if ($conn->query($sql) === TRUE) {
        $message="Update successful.";
        $msgColor="green";
    } else {
        $message="Error: " . $conn->error;
        $msgColor="red";
    }
}
?>

<html>
<head>
    <title>Update Reservation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Update Reservation</h2>

<div class="form-box">
<?php if(!empty($message)) { ?>
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

<form method="get">
        <p>Select Reservation ID:
            <select name="reservationID" onchange="this.form.submit()">
                <option value="">-- Select --</option>
                <?php
                $result=$conn->query("SELECT reservationID FROM reservation ORDER BY reservationID ASC");
                
                while ($row=$result->fetch_assoc()) {
                    $selected="";
                    if(!empty($_GET['reservationID']) && $_GET['reservationID'] == $row['reservationID']) {
                        $selected="selected";
                    }
                    echo "<option value='" . $row['reservationID'] . "' $selected>" . $row['reservationID'] . "</option>";
                }
                ?>
            </select>
        </p>
    </form>
</div>

<?php
if (!empty($_GET['reservationID'])) {

    $reservationID = $_GET['reservationID'];
    $data = $conn->query("SELECT * FROM reservation WHERE reservationID='$reservationID'");
    $row = $data->fetch_assoc();

    $date=explode(" ", $row['startTime'])[0];
    $start=explode(" ", $row['startTime'])[1];
    $end=explode(" ", $row['endTime'])[1];
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
        <input type="hidden" name="reservationID" value="<?php echo $row['reservationID']; ?>">

        <p>User
           <select name="userID">
            <?php
            $userResult = $conn->query("SELECT userID, name FROM users");
            while ($user = $userResult->fetch_assoc()) {
                $selected=($user['userID'] == $row['userID']) ? "selected" : "";
                echo "<option value='" . $user['userID'] . "' selected>" . $user['name'] . "</option>";
        } 
        ?>
    </select>
</p>

<p>Court:
    <select name="courtID">
        <?php
        $courtResult = $conn->query("SELECT courtID, courtName FROM court");
        while ($court = $courtResult->fetch_assoc()) {
            $selected = ($court['courtID'] == $row['courtID']) ? "selected" : "";
            echo "<option value='" . $court['courtID'] . "' $selected>" . $court['courtName'] . "</option>";
        }
        ?>
    </select>
</p>

        <p>Reservation Date:
            <input type="date" name="reservationDate" value="<?php echo $date; ?>" required>
        </p>

        <p>Start Time:
            <input type="time" name="startTime" value="<?php echo $start; ?>" required>
        </p>

        <p>End Time:
            <input type="time" name="endTime" value="<?php echo $end; ?>" required>
        </p>

        <p>Reservation Status:
            <select name="reservationStatus">
                <option value="Pending" <?php if ($row['reservationStatus'] == 'Pending') echo 'selected'; ?>>Pending</option>
                <option value="Confirmed" <?php if ($row['reservationStatus'] == 'Confirmed') echo 'selected'; ?>>Confirmed</option>
                <option value="Cancelled" <?php if ($row['reservationStatus'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
            </select>
        </p>

        <p>Payment Status:
            <select name="paymentStatus">
                <option value="Pending" <?php if ($row['paymentStatus'] == 'Pending') echo 'selected'; ?>>Pending</option>
                <option value="Paid" <?php if ($row['paymentStatus'] == 'Paid') echo 'selected'; ?>>Paid</option>
                <option value="Cancelled" <?php if ($row['paymentStatus'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
            </select>
        </p>

        <p>
            <input type="submit" value="Update Reservation">
        </p>
    </form>
</div>

<?php } ?>

<div style="text-align:center; margin-top:20px;">
    <a href="manageReservation.php">
        <button type="button" class="back-button">Back</button>
    </a>
</div>

</body>
</html>

<?php
$conn->close();
?>