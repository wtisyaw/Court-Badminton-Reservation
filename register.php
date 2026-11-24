<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Register Page</h2>

<div class="form-box">

<?php
if(isset($_GET['error'])) {
    echo "<p class='error-msg'>Email already registered.</p>";
}

if(isset($_GET['success'])) {
    echo "<p class='success-msg'>Registration successful! You can login now.</p>";
}
?>

    <form action="registerAction.php" method="post">
        <p> 
            <label>Name:</label>
            <input type="text" name="name" required>
        </p>

        <p>
            <label>Email:</label>
            <input type="email" name="email" required>
        </p>

        <p>
            <label>Phone:</label>
            <input type="text" name="phone" required>
        </p>

        <p>
            <label>Password:</label>
            <input type="password" name="password" required>
        </p>

        <p>
            <input type="submit" value="Register">
        </p>
    </form>
</div>

    <div style="text-align:center; margin-top:20px;">
        <a href="login.html">
            <button type="button" class="back-button">Back to Login</button>
        </a>
    </div>

</body>
</html>