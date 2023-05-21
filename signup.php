<!--<link rel="" href="signup.php">
<div class="wrapper-main">
<section class="section-default">
    <link rel="stylesheet" href="signup.php">
    <h1>Signup</h1>
    <form class="form-signup" action="includes/signup.inc.php" method="post">
    <input type="text" name="uid" placeholder="Username">
    <input type="text" name="mail" placeholder="E-mail">
    <input type="password" name="pwd" placeholder="Password">
    <input type="password" name="pwd-repeat" placeholder="Repeat password">
    <button type="submit" name=”signup-submit">Signup</button>
    </form>

    </section>
</div>-->
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/signup.css">

</head>
<body>
<!-- Vaša HTML štruktúra -->
<div class="wrapper-main">
    <section class="section-default">
        <h1>Signup</h1>
        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "emptyfields") {
                echo '<p class="signuperror">Fill in all fields!</p>';
            } else if ($_GET['error'] == "invaliduidmail") {
                echo '<p class="signuperror">Invalid username and email!</p>';
            } else if ($_GET['error'] == "invaliduid") {
                echo '<p class="signuperror">Invalid username!</p>';
            } else if ($_GET['error'] == "invalidmail") {
                echo '<p class="signuperror">Invalid email!</p>';
            } else if ($_GET['error'] == "passwordcheck") {
                echo '<p class="signuperror">Your passwords do not match!</p>';
            } else if ($_GET['error'] == "usertaken") {
                echo '<p class="signuperror">Username is already taken!</p>';
            }
        }
        if (isset($_GET['signup']) && $_GET['signup'] == "success") {
            echo '<p class="signupsuccess">Signup successful! Login and continue!</p>';
        }
        ?>

        <form class="form-signup" action="includes/signup.inc.php" method="post">
            <input type="text" name="uid" placeholder="Username">
            <input type="text" name="mail" placeholder="E-mail">
            <input type="password" name="pwd" placeholder="Password">
            <input type="password" name="pwd-repeat" placeholder="Repeat password">
            <button type="submit" name="signup-submit">Signup</button>
        </form>
    </section>
</div>
<nav>
    <div>
        <link rel="stylesheet" href="css/login.css">
        <?php

        if (isset($_SESSION['userId'])) {

            echo '<form action="includes/logout.inc.php" method="post">
                  <button type="submit" name="login-submit">Logout</button>
                                                 </form>';
        } else {
            echo '<form action="includes/login.inc.php" method="post">
                                                  <input type="text" name="mailuid" placeholder="Username/E-mail...">
                                                  <input type="password" name="pwd"  placeholder="Password...">
                                                  <button type="submit" name="login-submit">Login</button>
                                                   </form>';
                                                  // <a href="signup.php">Signup</a>';

        }
        ?>


    </div>
</nav>

</body>
</html>

