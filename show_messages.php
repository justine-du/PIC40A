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
<title>Current Messages</title> 
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

    // forum posts table
    $table = "posts";
    $field1 = "person";
    $field2 = "topic";
    $field3 = "message";
    $field4 = "date";

    // get topic from unique time
    $name = $_GET['person'];
    $currTopic = $_GET['topic'];

    $sql = "SELECT $field2 FROM $table WHERE $field1 = '$name' AND $field2 = '$currTopic'";
    $result = $db->query($sql);

    // get messages from that topic 
    $message = $_GET['message'];
    $sql = "SELECT $field1, $field3, $field4 FROM $table WHERE $field1 = '$name' AND $field2 = '$currTopic'";
    $result = $db->query($sql);

    echo "<h2 id = 'curr'><span>Current posts for $currTopic topic:<br/></span>";
    echo "<table width=100% cellpadding=4 cellspacing=1 border=1>";
    echo "  <tr>";
    echo "    <th>AUTHOR</th>";
    echo "    <th>MESSAGES</th>";
    echo "  </tr>";

    // html output the table of messages
    while ($record = $result->fetchArray())
    {
      $person = $record[$field1];
      $message = $record[$field3];
      $time = $record[$field4];

      echo "  <tr>";
      echo "    <td width=35% valign=top>$person<br/>[$time]</td>";
      // echo "    <td width=65% valign=top>$message<br/><br/><a href = http://pic.ucla.edu/~justinedu/post_replies.php?$field1=$person&$field2=$currTopic>Reply to Post</a></td>";

      echo "    <td width=65% valign=top>$message<br/><br/><a href = http://pic.ucla.edu/~justinedu/final_project/comments.php?$field4=$time>Reply to Post</a></td>";

      echo "  </tr>";
    }

    echo "</table>";

 ?>


</body>
</html>