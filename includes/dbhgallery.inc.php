<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "loginsystem";

$conn2 = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn2) {
   die("Chyba spojenia s databázou: " . mysqli_connect_error());
}