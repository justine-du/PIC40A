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

<script type="text/javascript">
<!-- 

  function post()
  {
    var commentNode = document.getElementById("comment").value;
    var nameNode = document.getElementById("username").value;
    var tableIDNode = document.getElementById("tableID").value;

    // name=justine&comment=hello
    var query_string = "name=" + nameNode + "&comment=" + commentNode + "&id=" + tableIDNode;

    do_ajax_stuff(query_string);
  }

  function do_ajax_stuff(query_string) 
    {
      var xhr = new XMLHttpRequest();

      xhr.onreadystatechange = function () 
      {

        if (xhr.readyState == 4 && xhr.status == 200) 
        {
          var result = xhr.responseText;
          display_result(result); 
          
        }
      } 
      xhr.open("GET", "http://pic.ucla.edu/~justinedu/final_project/update_comments.php?" + query_string,true); 
      xhr.send(null);
    }

  function display_result(result)
  {
    commentDiv = document.getElementById("comment_div");
    littleDiv = document.createElement("div");
    littleDiv.innerHTML = result;
    littleDiv.style.border = "1px solid #20624C";
    comment_div.appendChild(littleDiv);
  }

//-->
</script>

</head>
<body> 

  <h1>Post Your Reply</h1>
  <p>Refresh to see the oldest reply on top!</p>

  <fieldset id = 'none'>

    <textarea name = 'comment' rows=10 cols=30 id='comment' placeholder='Write Your Comment Here!'></textarea>

    <br/>

    <input type='text' name = 'name' id='username' placeholder='Your Name'>

    <br/>

    <input type='button' value = 'Post comment!' onclick = "post();">

    <div id = "comment_div"></div>

</fieldset>

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

  // forum table
  $table = "posts";
  $field1 = "person";
  $field2 = "topic";
  $field3 = "message";
  $field4 = "date";

  // comments table
  $table2 = "comments";
  $fieldA = "name";
  $fieldB = "comment";
  $fieldC = "time";
  $fieldD = "id";

  $sql = "CREATE TABLE IF NOT EXISTS $table2 (
  $fieldA varchar(30),
  $fieldB varchar(30),
  $fieldC varchar(30),
  $fieldD varchar(30)
  )";

  $result = $db->query($sql);

  $id = $_GET['date'];

  $sql = "SELECT * FROM $table2 WHERE $fieldD = '$id'";
  $result = $db->query($sql);

  echo "<div id='all_comments'>";

  while ($record=$result->fetchArray())
  {
    $name=$record[$fieldA];
    $comment=$record[$fieldB];
    $time=$record[$fieldC];

    echo "  <div class='comment_div'>";
    echo "    <p id='name'>
                <span id = 'posted_by'>Posted By:<span><br/>$name
              </p>
              <p class='comment'>$comment</p> 
              <p class='time'>$time</p>";
    echo "  </div>";
  }

  echo "</div>";

  echo "<input type = 'hidden' id = 'tableID' value = '$id'/>";

  echo "<p>If you'd like to add another topic to the forum, <a href = 'create_post.html'>Click Here!</a></p>";
 ?>

</body>
</html>