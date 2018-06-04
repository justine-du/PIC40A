#!/usr/local/bin/php -d display_errors=STDOUT 
<?php 
	$s = "<?xml version = '1.0' encoding='utf-8'?>";
	print $s;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Justine's Calendar!</title> 
	<link rel="stylesheet" type="text/css" href="calendar.css" />
</head>

<body>
	<div class="container">
		<?php 
			date_default_timezone_set('America/Los_Angeles'); 

			// format : Tue, May 22, 2018, 9:39 am

			$timestamp = time(); //current timestamp
			$weekday = date("D", $timestamp);
			$month = date("M", $timestamp);
			$day = date("d", $timestamp);
			$year = date("Y", $timestamp);
			$hour = date("h", $timestamp);
			$minute = date("i", $timestamp);
			$meridiem = date("a", $timestamp);

			echo "<h1>Don't be late! It's currently: $weekday, $month $day, $year, $hour:$minute $meridiem</h1>";

			?>

			<table id = "event_table">
		 		<tr>
		 			<th class = 'hr_td'> &#160; </th>
		 			<th class = 'table_header'>Spongebob</th>
		 			<th class = 'table_header'>Patrick</th>
		 			<th class = 'table_header'>Mr. Krabs</th>
		 		</tr>

		 	<?php // iterating each row of the calendar

				// number of hours we are printing
		 		$variables_to_show = 12;

		 		// getting all hours from column
		 		function get_hour_string($timestamp)
				{
					$hour = date("G", $timestamp); // hours from 0-23
					$meridiem = date("a", $timestamp);

					if ($hour >= 1 && $hour <= 11)
						$meridiem = "am";

					else if ($hour >= 13 && $hour <= 23)
					{
						$hour -= 12;
						$meridiem = "pm";
					}

					else if ($hour == 0)
					{
						$hour = 12;
						$meridiem = "am";
					}

					$hourString = "$hour:00$meridiem";
					return $hourString;
				}

				for ($i = 0; $i < $variables_to_show; $i++)
				{
					$currHour = get_hour_string($timestamp);
					if ($i % 2 == 0) // even rows
					{
						echo "<tr class = 'even_row'><td class = 'hr_td'>$currHour</td><td></td><td></td><td></td></tr>";
						$timestamp += 3600;
					}

					else // odd rows 
					{
						echo "<tr class = 'odd_row'><td class = 'hr_td'>$currHour</td><td></td><td></td><td></td></tr>";
						$timestamp += 3600;
					}
				}

		 	?>

	</table>
	</div>
</body>
</html>
	
