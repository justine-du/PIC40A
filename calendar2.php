#!/usr/local/bin/php -d display_errors=STDOUT
<?php print '<?xml version="1.0" encoding="utf-8" ?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Calendar</title>
<link rel="stylesheet" type="text/css" href="calendar.css" />
</head>
<body>
<?php
date_default_timezone_set('America/Los_Angeles');

$database = "dbjustinedu.db";

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


function get_hour_string($time_stamp){
$hour = date("g", $time_stamp);
$am_or_pm = date("a",$time_stamp);
return "$hour.00$am_or_pm";
}

function get_events($person, $timestamp)
{
	$table = "event_table";
	$field1 = "time";
	$field2 = "person";
	$field3 = "event_title";
	$field4 = "event_message";

	// getting next hour bc the timestamp will be in the middle of 2 whole number hours
	$nextHour = $timestamp + 3600;

	$sql = "SELECT $field3, $field4 FROM $table WHERE $field2='$person' AND $field1<$nextHour AND $field1>=$timestamp";

	global $db;
	$result = $db->query($sql);

	// use fetch array bc we're using SELECT to retrieve data from DB
	// we might have multiple events for same person and timestamps in same time frame
	// inputting the string into an array
	$strArr = array();
	while($record = $result->fetchArray())
	{
		$eventStr = "$record[$field3]: $record[$field4]</br>";
		array_push($strArr,$eventStr);
	}
	//returns a string of all events w/ same person and time frame into one box
	$finalEventStr = implode("",$strArr);
	return $finalEventStr;
}

$time_stamp = time();
$today = date("D, F j, Y, g:i a",$time_stamp);
$start_hour_offset = -3;
$end_hour = 12; // How many hours to show total

echo "<div class='container'>";
echo "<h1>Don't be late! It's currently: $today </h1>";
echo "<table id='event_table'>";

// print the header

print "	<tr> \n";

print "		<th class='hr_td_'> &nbsp; </th> <th class='table_header'>Spongebob</th><th class='table_header'>Patrick</th><th class='table_header'>Mr. Krabs</th> \n";
print "	</tr> \n";

$time_stamp = (isset($_GET['time_stamp']))?$_GET['time_stamp']:time();

for ($i=0; $i<=$end_hour;++$i)
{
	// multiply $i * 3600 bc each iteration you increase row by 1 hr
	$hour_string = get_hour_string($time_stamp + $i*3600);

	$eventTime = ($time_stamp + $i*3600) - (($time_stamp + $i*3600) % 3600);
	
	if ($i%2 == 0)
	{
		print "<tr class='even_row'> \n";
		print "<td class='hr_td'>$hour_string</td> <td>" . get_events('Spongebob',$eventTime) . "</td> <td>" . get_events('Patrick',$eventTime) .  "</td> <td>" . get_events('Mr. Krabs',$eventTime) . "</td>\n";
		print "	</tr> \n";
	}

	else if ($i%2 !=0)
	{

		print "<tr class='odd_row'>\n";
		print "<td class='hr_td'>$hour_string</td> <td>" . get_events('Spongebob',$eventTime) . "</td> <td>" . get_events('Patrick',$eventTime) .  "</td> <td>" . get_events('Mr. Krabs',$eventTime) . "</td>\n";		
		print "</tr>\n";
	}
}

echo "</table>";

$past = $time_stamp - (12 * 3600);
$future = $time_stamp + (12 * 3600);

echo "<div>
<form id = 'prev' action = 'calendar2.php' method = 'get'>
	<p>
		<input type = 'hidden' name = 'time_stamp' value = '$past'/>
		<input type = 'submit' value = 'Past 12 Hours'/>
	</p>
</form>

<form id = 'today' action = 'calendar2.php' method = 'get'>
	<p>
	<input type = 'submit' value = 'Today'/>
	</p>
</form>

<form id = 'next' action = 'calendar2.php' method = 'get'>
	<p>
		<input type = 'hidden' name = 'time_stamp' value = '$future'/>
		<input type = 'submit' value = 'Next 12 Hours'/>
	</p>
</form>
</div>";

echo "</div>";
?>
</body>
</html>