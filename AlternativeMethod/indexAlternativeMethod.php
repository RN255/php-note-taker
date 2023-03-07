<?php
  // connect to database
  $conn = mysqli_connect('localhost', 'userOne', 'sample123', 'database02032023');

  //check connection
  if(!$conn) {
    echo 'Connection error: ' . mysqli_connect_error();
  }

  // print existing notes to the page
  // query for table
  $sql = 'SELECT title, ingredients, id FROM info ORDER BY created_at DESC';

  // make query and get result
  $result = mysqli_query($conn, $sql);

  // fetch the resulting words as an array
  $table_info = mysqli_fetch_all($result, MYSQLI_ASSOC);

  // free result from memory - good practice
  mysqli_free_result($result);

  //close connection - good practice
  mysqli_close($conn);

  // add new notes to the database
  $title = $ingredients = '';

  $error_msg = '';

  if(isset($_POST['submit'])){

    // open connection
    $conn = mysqli_connect('localhost', 'userOne', 'sample123', 'database02032023');

    if((empty($_POST['title'])) && (empty($_POST['ingredients']))) {
        $error_msg = 'Some data is required <br />';

    } else {
        $title = $_POST['title'];
        $ingredients = $_POST['ingredients'];

        // protect us from attacks
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);

        //create sql
        $sql = "INSERT INTO info(title, ingredients) VALUES('$title', '$ingredients')";

        //save to database
        if(mysqli_query($conn, $sql)){
            // success
            header('location: index.php');
        } else {
            echo 'query error: ' . mysqli_error($conn);
        }
    }
   // close connection
    mysqli_close($conn);
  }

  // delete
  if(isset($_POST['delete'])){

    // open connection
    $conn = mysqli_connect('localhost', 'userOne', 'sample123', 'database02032023');

    $info_delete = mysqli_real_escape_string($conn, $_POST['info_delete']);

    $sql = "DELETE FROM info WHERE title = '$info_delete'";

    if(mysqli_query($conn, $sql)){
        header('location: index.php');
    } else {
        echo 'query error:' . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!-- title -->
        <title>PHP project</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <nav>
            <a href="#"><img src="assets\database.png" alt="logo" id="navImg"></a>
            <button onclick="showMenu()"><img src="assets\burger-menu.png" alt="menu icon" id="menuImg"><p>Menu</p></button>

            <div id="menu">
                <button onclick="hideMenu()">Close</button>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
                <div id="menuSocialLinks">
                    <a href="#"><img src="assets\facebook.png" alt="facebook icon"></a>
                    <a href="#"><img src="assets\instagram.png" alt="instagram icon"></a>
                    <a href="#"><img src="assets\linkedin.png" alt="linkedin icon"></a>
                </div>
            </div>

        </nav>
        <div class=title-section>
        <h1>NOTES</h1>
        </div>

        <section class=container>
            <h2>ADD A NEW NOTE</h2>
            <div><?php echo $error_msg; ?></div>

            <form action="index.php" method="POST">
                <div class="input">
                    <label>Title:</label>
                    <input type="text" name="title">
                </div>
                <div class="input">
                    <label class="text-area-label">Ingredients:</label>
                    <textarea type="text" name="ingredients"></textarea>
                </div>

                <div class="submit-btn">
                    <input type="submit" name="submit" value="submit">
                </div>
            </form>
        </section>

        <section class="notes-list">
            <h2>NOTES</h2>
                <?php foreach($table_info as $table_info) { ?>
                    <div class="card">
                        <h3><?php echo htmlspecialchars($table_info['title']); ?></h3>
                        <p><?php echo htmlspecialchars($table_info['ingredients']); ?></p>
                        <div id="delete-btn">
                            <form action="index.php" method="POST">
                            <input type="hidden" name="info_delete" value="<?php echo $table_info['title'] ?>">
                            <input type="submit" name="delete" value="Delete">
                        </div>
                        </form>
                    </div>
                <?php } ?>
        </section>
        <script src="script.js"></script>
    </body>
</html>