#!/usr/local/bin/php -d display_errors=STDOUT
 <?php

  date_default_timezone_set('America/Los_Angeles');

  $database = "posts.db";

  try 
  {
    $db = new SQLite3($database);
  }

  catch (Exception $exception)
  {
    echo '<p>There was an error connecting to the database!</p>';

    if ($db)
    {
      echo $exception->getMessage();
    }
  }

  $table = "posts";
  $field1 = "person";
  $field2 = "topic";
  $field3 = "message";
  $field4 = "date";

  $table2 = "comments";
  $fieldA = "name";
  $fieldB = "comment";
  $fieldC = "time";
  $fieldD = "id";

  $comment = $_GET['comment'];
  $name = $_GET['name'];
  $time = time();
  $time = date("m/d/Y H:i:s",$time);

  $id = $_GET['id'];

  $sql = "INSERT INTO $table2 ($fieldA, $fieldB, $fieldC, $fieldD) VALUES ('$name', '$comment', '$time', '$id')";
  $result = $db->query($sql);


  $sql = "SELECT $fieldA, $fieldB, $fieldC FROM $table2 WHERE $fieldA = '$name' AND $fieldB = '$comment' AND $fieldD = '$id'";
  $result = $db->query($sql);

  $record=$result->fetchArray();
  $name=$record[$fieldA];
  $comment=$record[$fieldB];
  $time=$record[$fieldC];

  echo "
  <div class='comment_div'> 
    <p class='name'>Posted By:<br/>$name</p>
    <p class='comment'>$comment</p> 
    <p class='time'>$time</p>
  </div>";




 ?>


</body>
</html>