<?php
//require 'dbh.inc.php';
if (empty($conn)){
    $conn = new stdClass();
}
/**if (isset ($_POST[ 'signup-submit'])) {}**/
    include_once 'dbh.inc.php';
    echo "nepripojene";
   /** $username = $_POST['uid'] ;
    $email = $_POST['mail'];
    $password = $_POST['pwd'];
    $passwordRepeat = $_POST['pwd-repeat'];



    /* zachytenie chyb pri vytvavrani uctu */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['uid'] ;
    $email = $_POST['mail'];
    $password = $_POST['pwd'];
    $passwordRepeat = $_POST['pwd-repeat'];
    if (empty ($username) || empty ($email) || empty($password) || empty($passwordRepeat)) {
        $message = "Doplň všetky údaje";
        echo '<p class="login-status">' . $message . '</p>';
        header("Location: ../signup.php?error=emptyfields&uid=".$username."&mail=".$email);


// PHP kód pre výpis stránky s obsahom správy
        echo '<p class="login-status">' . $message . '</p>';
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../signup.php?error-invalidmailuid");
        exit();
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../signup.php?error-invalidmail&uid=".$username);
        exit();
    } else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../signup.php?error-invaliduid&mail=".$email);
        exit();
    } else if ($password !== $passwordRepeat) {
        header("Location: ../signup.php?error=passwordcheck&uid=".$username."&email=".$email);
        exit();
    } else {
        $sql = "SELECT uidUsers FROM users WHERE uidUsers=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../signup.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
            if ($resultCheck > 0) {
                header("Location: ../signup.php?errors=usertaken&mail=" . $email);
                exit();
            } else {
                $sql = "INSERT INTO users (uidUsers, emailUsers, pwdUsers) VALUES (?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    exit();}
                 else {
                    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../signup.php?signup=success");
                    exit();


                }
            }


        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

}





else{
    header("Location: ../signup.php");
    exit();
}
