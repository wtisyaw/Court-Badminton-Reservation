<html>
<head>
    <title>Court Information</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <h2>Court Information</h2>

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

$sql="SELECT * FROM court";
$result=$conn->query($sql);

if ($result->num_rows>0) {
    echo "<table>";
    echo "<tr>
            <th>No</th>
            <th>Court ID</th>
            <th>Court Name</th>
            <th>Court Type</th>
            <th>Court Price</th>
            <th>Court Status</th>
          </tr>";

$no=1;

    while ($row=$result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$no.'</td>';
        echo "<td>".$row["courtID"].'</td>';
        echo "<td>".$row["courtName"].'</td>';
        echo "<td>".$row["courtType"].'</td>';
        echo "<td>".$row["courtPrice"].'</td>';
        echo "<td>".$row["courtStatus"].'</td>';
        echo "</tr>";
        $no++;

    }

    echo "</table>";
}
else {
    echo "<p>0 results</p>";
}

$conn->close();

?>

</div>

<div style="text-align:center; margin-top:20px;">
    <a href="adminMenu.php">
        <button type="button">Back to Menu</button>
    </a>
</div>

</body>
</html>