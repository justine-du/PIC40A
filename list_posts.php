#!/usr/local/bin/php -d display_errors=STDOUT
<?php
  // begin this XHTML page
  print('<?xml version="1.0" encoding="utf-8"?>');
  print("\n");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
 "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:v="urn:schemas-microsoft-com:vml">
<head>
<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=PT Serif' rel='stylesheet'>
<link rel="stylesheet" type="text/css" href="list_posts.css" />

<meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />
<title>Forum</title> 
</head>
<body>

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

    $sql = "SELECT $field1, $field2, $field3, $field4 FROM $table";
    $result = $db->query($sql);

    echo "<h1>All Current Topics</h1>";

    echo "<div class = 'container'>";
    echo "<table id = 'posts' cellpadding=6 cellspacing=2 border=1>";

    echo "  <tr>";
    echo "    <th>All Topics</th>";
    echo "  </tr>";

    //only prints out first record
    while ($record = $result->fetchArray())
    {
      $person = $record[$field1];
      $topic = $record[$field2];
      $time = $record[$field4];

      // print out table
      echo "  <tr>";
      echo "    <td><a href = http://pic.ucla.edu/~justinedu/final_project/show_messages.php?$field1=$person&$field2=$topic><strong>$topic</strong></a><br/>Posted by $person on $time</td>";
      echo "  </tr>";
    }

    echo "</table>";
    echo "</div>";

    echo "<p>If you'd like to add another topic to the forum, <a href = 'create_post.html'>Click Here!</a></p>";

 ?>


</body>
</html>