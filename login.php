<?php
$errorMsg="";

if(isset($_GET['error'])) {
    $errorMsg="Wrong username or password.";
}
?>

<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="login-card">
        <h2>Login</h2>


    <form action="loginAuto.php" method="post">
        <div class="input-group">
            <label>Username/Email</label>
            <input type="text" name="myusername" required>
        </div>

        <div class="input-group">
            <label>Password</label>
            <input type="password" name="mypassword" required>
        </div>
            <?php if(isset($_GET['error'])) { ?>
                <div style="
                     color: red;
                     text-align: left;
                     width: 200px;
                     margin-left: 160px;
                     margin-top: -8px;
                     margin-bottom: 15px;
                     font-size: 14px;
                ">
                    Wrong username or password
                </div>
        <?php } ?>

         <div style="margin-bottom:15px;">
            <label>Login As</label><br>
            <select name="role" required>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
        </div>

        <input type="submit" value="Login">
    </form>
</div>

<div style="text-align:center; margin-top:20px;">
    <a href="homepage.php">
        <button type="button" class="back-button">Back to Homepage</button>
    </a>
</div>

</body>
</html>