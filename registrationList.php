<html>
<head>
    <title>Registered Users</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
      <h2>Registered Users</h2>

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

$sql="SELECT * FROM users";
$result=$conn->query($sql);

if ($result->num_rows>0) {
    echo "<table>";
    echo "<tr>
            <th>No</th>
            <th>User ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
          </tr>";

$no=1;

    while($row=$result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$no.'</td>';
        echo "<td>".$row["userID"].'</td>';
        echo "<td>".$row["name"].'</td>';
        echo "<td>".$row["email"].'</td>';
        echo "<td>".$row["phone"].'</td>';
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