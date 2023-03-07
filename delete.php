<?php
    if ( isset($_GET["id"])) {
        $id = $_GET["id"];

        //database variables
        $servername = "localhost";
        $username = "userOne";
        $password = "sample123";
        $database = "database02032023";

        // connect to database
        $conn = mysqli_connect($servername, $username, $password, $database);

        $sql = "DELETE FROM info WHERE id=$id";
        $conn->query($sql);

    }

    header('location: index.php');
    exit;




?>