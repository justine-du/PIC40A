#!/usr/local/bin/php -d display_errors=STDOUT
<?php

	$database = "ajax.db";

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

	$table = "votes";
	$field1 = "yes";
	$field2 = "no";

	// creating new table called votes with 2 fields yes and no
	$sql = "CREATE TABLE IF NOT EXISTS $table (
	$field1 int(10),
	$field2 int(10)
	)";

	$result = $db->query($sql);

	// extracting number of votes from each field yes or no
	// the key inside the $_GET is the 'name' part of the input type 
	$answer = $_GET['vote'];

	// inserting a record with yes=0 and no=0
	$sql = "INSERT INTO $table ($field1, $field2) VALUES (0,0)";
	$result = $db->query($sql);

	// selecting everything from votes table
	$sql = "SELECT * FROM $table";
	$result = $db->query($sql);

	// create $record array where yes and no are the keys
	$record = $result->fetchArray();
	$yes = $record[$field1];
	$no = $record[$field2];

	// count the votes
	if ($answer == "yes")
	{
		$yes++;
	}

	else // $answer == "no"
	{
		$no++;
	}

	// update table using sql commands
	$sql = "UPDATE $table SET $field1=$yes, $field2=$no";
	$result = $db->query($sql);

	// string output 
	print "$yes,$no";

?>