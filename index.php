<?php
  // connect to database
  $conn = mysqli_connect('localhost', 'robert', 'basic345', 'php_note_taker');

  //check connection
  if(!$conn) {
    echo 'Connection error: ' . mysqli_connect_error();
  }  

  // print existing notes to the page
  // query for table
  $sql = 'SELECT * FROM notes ORDER BY created_at DESC';

  // make query and get result
  $result = mysqli_query($conn, $sql);

  // fetch the resulting words as an array
  $note_info = mysqli_fetch_all($result, MYSQLI_ASSOC);

  // free result from memory - good practice
  mysqli_free_result($result);

  //close connection - good practice
  mysqli_close($conn);

  // add new notes to the database
  $title = $note_text = '';

  $error_msg = '';

  if(isset($_POST['submit'])){

    // open connection
    $conn = mysqli_connect('localhost', 'robert', 'basic345', 'php_note_taker');

    if((empty($_POST['title'])) && (empty($_POST['note_text']))) {
        $error_msg = 'Some data is required <br />';
        
    } else {
        $title = $_POST['title'];
        $note_text = $_POST['note_text'];  

        // protect us from attacks
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $note_text = mysqli_real_escape_string($conn, $_POST['note_text']);

        //create sql
        $sql = "INSERT INTO notes(title, note_text) VALUES('$title', '$note_text')";

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
    $conn = mysqli_connect('localhost', 'robert', 'basic345', 'php_note_taker');

    $note_delete = mysqli_real_escape_string($conn, $_POST['note_delete']);

    $sql = "DELETE FROM notes WHERE title = '$note_delete'";

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
  <link rel="stylesheet" href="styles.css">
</head>
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
                <label class="text-area-label">Text:</label>
                <textarea type="text" name="note_text"></textarea>
            </div>

            <div class="submit-btn">
                <input type="submit" name="submit" value="submit">
            </div>
        </form>
    </section>

    <section class="notes-list">
        <h2>NOTES</h2>
            <?php foreach($note_info as $note_info) { ?>
                <div class="card">
                    <h3><?php echo htmlspecialchars($note_info['title']); ?></h3> 
                    <p><?php echo htmlspecialchars($note_info['note_text']); ?></p>
                    <div id="delete-btn">
                        <form action="index.php" method="POST">
                        <input type="hidden" name="note_delete" value="<?php echo $note_info['title'] ?>">
                        <input type="submit" name="delete" value="Delete">
                    </div>
                    </form>
                </div>
            <?php } ?>
    </section>
</html>