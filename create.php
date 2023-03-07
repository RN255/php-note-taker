<?php

    //database variables
    $servername = "localhost";
    $username = "userOne";
    $password = "sample123";
    $database = "database02032023";

    // connect to database
    $conn = mysqli_connect($servername, $username, $password, $database);

    $name = "";
    $email = "";
    $phone = "";
    $address = "";

    $errorMessage = "";
    $successMessage = "";

    if ( $_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        do {
            if ( empty($name) || empty($email) || empty($phone) || empty($address) ) {
                $errorMessage = "All fields are required";
                break;
            }

            // add entry to database
            //create sql
            $sql = "INSERT INTO info(name, email, phone, address) VALUES('$name', '$email', '$phone', '$address')";

            //save to database
            if(mysqli_query($conn, $sql)){
            // success
            header('location: index.php');
            } else {
            echo 'query error: ' . mysqli_error($conn);
            }

            $name = "";
            $email = "";
            $phone = "";
            $address = "";

            $successMessage = "entry added to database";

        } while (false);

        

        }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create entry</title>
</head>
<body>
    <h2>create new</h2>

    <?php
    if (!empty($errorMessage)) {
        echo " <p>$errorMessage</p>
        ";
    }
    ?>

    <?php
    if (!empty($successMessage)) {
        echo " <p>$successMessage</p>
        ";
    }
    ?>

    <form method="POST">
        <div>
            <label>Name</label>
            <input type="text" name="name" value="<?php echo $name; ?>">
        </div>

        <div>
            <label>email</label>
            <input type="text" name="email" value="<?php echo $email; ?>">
        </div>

        <div>
            <label>phone number</label>
            <input type="text" name="phone" value="<?php echo $phone; ?>">
        </div>

        <div>
            <label>address</label>
            <input type="text" name="address" value="<?php echo $address; ?>">
        </div>

        <div>
           <button type="submit">Submit</button>
        </div>
        <div>
           <a href="index.php">Cancel</a>
        </div>

    </form>
    
</body>
</html>