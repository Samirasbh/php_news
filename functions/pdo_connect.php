<?php
$servername="localhost";
$dbname = "news";
$username = "root";
$password = "123";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "connected successfully";
} catch (PDOException $e) {
    echo "connection failed: " . $e->getMessage();
}

?>