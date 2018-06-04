#!/usr/local/bin/php
<?php print'<?xml version = "1.0" encoding="utf-8"?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>My Birthdays</title>
</head>
<body>
<p>

<!-- without table -->
<?php

date_default_timezone_set('America/Los_Angeles'); 

for($year = 1999; $year < 2018; $year++) 
{
	$currentDay = date("5/20/$year");
	$currentTS = mktime(0,0,0,5,20,$year);
    echo date($currentDay, $currentTS), " was a ", date('l', $currentTS), "<br/>";
}

?>

<br/><br/>

<!-- with table -->
<?php

date_default_timezone_set('America/Los_Angeles'); 

echo "<table border = 1>";

for($year = 1999; $year < 2018; $year++)
{
	$currentTS = mktime(0,0,0,5,20,$year);
	$currentDay = date("5/20/$year", $currentTS);

	
	echo "<tr>";
	echo "<td>".$currentDay."<td>";
	echo "<td>".date('l', $currentTS)."<td>";
	echo "</tr>";
	
}

echo "</table>";

?>


</p>
</body>
</html>