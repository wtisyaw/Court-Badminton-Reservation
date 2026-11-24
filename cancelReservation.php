<?php
session_start();

if (!isset($_SESSION['userID'])) {
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

$userID = $_SESSION['userID'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reservationID = $_POST['reservationID'];

    $sql = "UPDATE reservation
            SET reservationStatus = 'Cancelled',
                paymentStatus = 'Cancelled'
            WHERE reservationID = '$reservationID'
            AND userID = '$userID'";

    if ($conn->query($sql) === TRUE) {
        header("Location: cancelReservation.php?success=cancelled");
        exit();
    } else {
        header("Location: cancelReservation.php?error=1");
        exit();
    }
}
?>

<html>
<head>
    <title>Cancel Reservation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Cancel Reservation</h2>

<?php
if (isset($_GET['success']) && $_GET['success'] == 'cancelled') {
    echo "<div style='
        background:#d1e7dd;
        color:#0f5132;
        padding:10px;
        border-radius:8px;
        text-align:center;
        width:350px;
        margin:20px auto;
    '>
        Reservation cancelled successfully.
    </div>";
}

if (isset($_GET['error'])) {
    echo "<div style='
        background:#f8d7da;
        color:#842029;
        padding:10px;
        border-radius:8px;
        text-align:center;
        width:350px;
        margin:20px auto;
    '>
        Error cancelling reservation.
    </div>";
}
?>

<div class="form-box">

<form method="post" id="cancelForm">

<p>Select Reservation ID:
<select name="reservationID" id="reservationID" required>
    <option value="">-- Select --</option>

    <?php
    $result = $conn->query("SELECT reservationID 
                            FROM reservation 
                            WHERE userID = '$userID' 
                            AND reservationStatus != 'Cancelled'
                            ORDER BY reservationID ASC");

    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['reservationID'] . "'>" . $row['reservationID'] . "</option>";
    }
    ?>
</select>
</p>

<div id="errorMsg" style="color:red; display:none; margin-top:-10px;">
    Please select a Reservation ID first.
</div>

<p>
    <button type="button" onclick="openPopup()">Cancel Reservation</button>
</p>

</form>

</div>

<div style="text-align:center; margin-top:20px;">
    <a href="userMenu.php">
        <button type="button" class="back-button">Back to Menu</button>
    </a>
</div>

<div id="popupBox" class="popup">
    <div class="popup-content">
        <h3>Cancel Reservation</h3>
        <p>Are you sure want to cancel this reservation?</p>

        <button type="button" onclick="submitCancel()">Yes</button>
        <button type="button" onclick="closePopup()">No</button>
    </div>
</div>

<script>
function openPopup() {
    var reservation = document.getElementById("reservationID").value;

    if (reservation === "") {
        document.getElementById("errorMsg").style.display = "block";
        return;
    }

    document.getElementById("errorMsg").style.display = "none";
    document.getElementById("popupBox").style.display = "block";
}

function closePopup() {
    document.getElementById("popupBox").style.display = "none";
}

function submitCancel() {
    document.getElementById("cancelForm").submit();
}
</script>

</body>
</html>

<?php
$conn->close();
?>