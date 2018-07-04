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

	// creating new table called event_table
	$sql = "CREATE TABLE IF NOT EXISTS $table (
	$field1 varchar(30),
	$field2 varchar(30),
	$field3 varchar(500),
	$field4 varchar(20)
	)";

	$result = $db->query($sql);

	// use $_POST to get all info from form
	$person = $_POST['person'];
	$topic = $_POST['topic'];
	$message = $_POST['message'];

	$ts = time();
	$date = date("m/d/Y,H:i:s",$ts);

	// insert info into table
	$sql = "INSERT INTO $table ($field1, $field2, $field3, $field4) VALUES ('$person', '$topic', '$message', '$date')";

	$result = $db->query($sql);

	print "<div class = 'text'>";
	print "<h1>Congrats, you have successfully added your post to your forum!</h1>";
	print "<p><a href = 'list_posts.php'>Click here to see updated forum</a></p>";
	print "</div>";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
 "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<link rel="stylesheet" type="text/css" href="create_post.css" />
<!-- Style guide: https://dribbble.com/shots/4662037-Hello-Dribbble -->

<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=PT Serif' rel='stylesheet'>




</head>


<body>




</body>
</html>



