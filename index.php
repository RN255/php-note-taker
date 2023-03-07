<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP project</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>List</h2>
    <a href="create.php">Create a new entry</a>
    <p>the above href shoul work, if not add folder name</p>

    <h2>Table of entries</h2>

    <?php
    //database variables
    $servername = "localhost";
    $username = "userOne";
    $password = "sample123";
    $database = "database02032023";

    // connect to database
    $conn = mysqli_connect($servername, $username, $password, $database);

    //check connection
    if(!$conn) {
        echo 'Connection error: ' . mysqli_connect_error();
    }

    // query for table
    $sql = 'SELECT * FROM info';

    // make query and get result
    $result = mysqli_query($conn, $sql);

    //read data from each row
    while($row = $result->fetch_assoc()) {
        echo"
        <div class='infoHolder'>
            <p>$row[id]</p>
            <p>$row[name]</p>
            <p>$row[email]</p>
            <p>$row[phone]</p>
            <p>$row[address]</p>
            <p>$row[created_at]</p>
            <p>you could turn this into a table</p>
            <a href='delete.php?id=$row[id]'>Delete</a>
            <a href='/edit.php?id=$row[id]'>Edit</a>
        </div>
        ";
    }


    ?>

    

</body>
</html>