<?php
$message="";
$msgColor="";

$servername="localhost";
$username="root";
$password="";
$dbName="badminton";

$conn=new mysqli($servername, $username, $password, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reservationID=$_POST['reservationID'];

    $sql="DELETE FROM reservation
          WHERE reservationID='$reservationID'";

    if($conn->query($sql) === TRUE) {
        $message="Delete successful.";
        $msgColor="green";
    } else {
        $message="Error: " . $conn->error;
        $msgColor="red";
    }
}
?>

<html>
<head>
    <title>Delete Reservation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Delete Reservation</h2>

<div class="form-box">

    <?php if(!empty($message)) { ?>
        <div style="
            background: <?php echo ($msgColor == 'green') ? '#d1e7dd' : '#f8d7da'; ?>;
            color: <?php echo ($msgColor == 'green') ? '#0f5132' : '#842029'; ?>;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 15px'
        ">
            <?php echo $message; ?>
        </div>
    <?php } ?>

<form method="post" id="deleteForm">

<p>Select Reservation ID:
<select name="reservationID" id="reservationID" required>
<option value="">-- Select --</option>

<?php
$result=$conn->query("SELECT reservationID FROM reservation ORDER BY reservationID ASC");

while ($row=$result->fetch_assoc()) {
    echo "<option value='" . $row['reservationID'] . "'>" . $row['reservationID'] . "</option>";
}
?>

</select>
</p>

<div id="errorMsg" style="color:red; display:none; margin-top:-10px;">
    Please select a Reservation ID first.
</div>

<p>
<button type="button" onclick="openPopup()">Delete Reservation</button>
</p>

</form>

</div>

<div style="text-align:center; margin-top:20px;">
    <a href="manageReservation.php">
        <button type="button">Back</button>
    </a>
</div>

<div id="popupBox" class="popup">
    <div class="popup-content">
        <h3>Delete Reservation</h3>
        <p>Are you sure want to delete this reservation?</p>
        <button type="button" onclick="submitDelete()">Yes</button>
        <button type="button" onclick="closePopup()">No</button>
    </div>
</div>

<script>
function openPopup() {
    var reservation=document.getElementById("reservationID").value;

    if (reservation == "") {
        document.getElementById("errorMsg").style.display="block";
        return;
    }

    document.getElementById("errorMsg").style.display = "none";
    document.getElementById("popupBox").style.display="block";
}

function closePopup() {
    document.getElementById("popupBox").style.display ="none";
}

function submitDelete() {
    document.getElementById("deleteForm").submit();
}
</script>

</body>
</html>

<?php
$conn->close();
?>