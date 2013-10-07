<html>
  <head>
    <title>Development Calendar</title>
		<!-- //
		Author: Ty Talmadge
		Contact: ty.talmadge@gmail.com
		Description: Open Source, PHP Development calendar that can be easily updated and or modified.
		// -->
	 <style>
      body, html {
      margin:0;
      padding:0;
      color:#c0c0c0;
      background:#333;
      font: bold 1.0em arial, verdana;
      }
      h2 {
      color:orange;
      text-align:center;
      font: bold 1.3em arial, verdana;
      }
      p {
      font: bold 1.0em arial, verdana;
      }
      table {
      text-align: center;
      padding-left: 25%; //align to center of page
      background: #110E0F;
      width: 75%;
      min-height: 75%;
      font: bold 1.0em arial, verdana;
      }
      table th, table td, table tr, table td  {
      margin: 0 auto;
      background: #777;
      text-align: center;
      font: bold;
      }
      .today {
      background: white;
      }
    </style>
  </head>
  <body>
 <?php
// To enable or disable: 0 (ZERO) is OFF. 1 (ONE) is ON.

// If you like the circa 1996 Geocities websites, enable the buttons and disable the textlinks.
$enable_buttons=0;
// This displays the day, today in every month; for example, if today is the 15th, then the 15th will be highlighted in every month.
// It sounds good on paper but can be very annoying in reality.
$show_today=1;

// Build some simple arrays to create calendar
// Until days, weeks, months and years change these are pretty much static across all calendars
$month_numbers=array(1,2,3,4,5,6,7,8,9,10,11,12);
$months_of_year=array("January","February","March","April","May","June","July","August","September","October","November","December");
$days_of_week=array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
$month=($_GET['m']) ? $_GET['m'] : date("n");
$current_month=date("n");
$year=($_GET['y']) ? $_GET['y'] : date("Y");
$current_year=date("Y");
$previous_month=$month-1;
$previous_year=$year-1;
$next_month=$month+1;
$next_year=$year+1;
if($month == 0)
{
  $month = 12;
  $year--;
}
if($month == 13)
{
  $month = 1;
  $year++;
}
if($previous_month == 0)
{
  $previous_month = 12;
  $previous_year--;
}
$month_name=$months_of_year[$month - 1];
$first_day=mktime(0,0,0,$month, 1, $year);
// Find day of week that first day of month falls on 
$day_of_week=date('D', $first_day) ; 
// If there are blank spaces or run-over days from last month, create them in the calendar.
 switch($day_of_week){ 
 case "Sun": $blank = 0; break; 
 case "Mon": $blank = 1; break; 
 case "Tue": $blank = 2; break; 
 case "Wed": $blank = 3; break; 
 case "Thu": $blank = 4; break; 
 case "Fri": $blank = 5; break; 
 case "Sat": $blank = 6; break; 
 }
// Determine how many days are in the current month
$days_in_month = cal_days_in_month(0, $month, $year);
// Today is
$day=date("d");
echo"<form name='formCalendar' id='formCalendar' action='dev_cal.php?' method='get'>\n";
echo"<table class=\"table\">\n";
echo"<tr><td colspan='7'><h2>$month_name $year</h2></td></tr>\n";
echo"<tr><td colspan='3'><input type='button' value='Today' onclick='location=\"dev_cal.php?m={$current_month}&y={$current_year}\"' /> &nbsp; | &nbsp; \n";
echo"<select name='m' id='selMonth'>\n";
for($a = 0; $a < count($months_of_year); $a++)
if ($month_numbers[$a] == $month){
  echo"<option value='$month_numbers[$a]' selected=selected>$months_of_year[$a]</option>\n";
} else {
  echo"<option value='$month_numbers[$a]'>$months_of_year[$a]</option>\n";
}
echo"</select> &nbsp; | &nbsp; \n";
echo"<select name='y' id='selYear'>\n";
// In the year dropdown, this displays 5 years in the future and in the past. If you want more or fewer, change the numbers.
for($b = ($current_year - 5); $b <= ($current_year + 5); $b++)
if ($year == $b){
  echo"<option value='$b' selected=selected>$b</option>\n";
} else {
  echo"<option value='$b'>$b</option>\n";
}
echo"</select> &nbsp; | &nbsp; \n";
echo"<input type='submit' name='dateChange' id='dateChange' value='Go'/></td>\n";
echo"<td colspan='4'>\n";

if($enable_buttons=='1'){
echo"<input type='button' name='prevy' value='Previous year' onclick='location=\"dev_cal.php?m={$month}&y={$previous_year}\"'/> &nbsp; | &nbsp; \n";
echo"<input type='button' name='prevm' value='Previous Month' onclick='location=\"dev_cal.php?m={$previous_month}&y={$year}\"'/> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
echo"<input type='button' name='nextm' value='Next Month' onclick='location=\"dev_cal.php?m={$next_month}&y={$year}\"'/> &nbsp; | &nbsp; \n";
echo"<input type='button' name='nexty' value='Next year' onclick='location=\"dev_cal.php?m={$month}&y={$next_year}\"'/>\n";
} else if($enable_buttons=='0'){
echo"<a href=\"dev_cal.php?m={$month}&y={$previous_year}\">Last year</a> &nbsp; | &nbsp; \n";
echo"<a href=\"dev_cal.php?m={$previous_month}&y={$year}\">Last month</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
echo"<a href=\"dev_cal.php?m={$next_month}&y={$year}\">Next month</a> &nbsp; | &nbsp; \n";
echo"<a href=\"dev_cal.php?m={$month}&y={$next_year}\">Next year</a>\n";
}
echo"</td></tr>\n";
echo"<tr>\n";
echo"<td width=\"14%\">Sun</td>\n";
echo"<td width=\"14%\">Mon</td>\n";
echo"<td width=\"14%\">Tue</td>\n";
echo"<td width=\"14%\">Wed</td>\n";
echo"<td width=\"14%\">Thu</td>\n";
echo"<td width=\"14%\">Fri</td>\n";
echo"<td width=\"14%\">Sat</td>\n";
echo"</tr>\n";
// A week can have a maximum of 7 days, so figure out where we are
$day_count=1;
 echo"<tr>\n";
// Populate the blank days
while ( $blank > 0 ) 
{ 
echo"<td align=\"center\"></td>\n"; 
$blank=$blank-1; 
$day_count++;
}
// Sets the first day of the month to 1 
$day_num=1;
// Count up the days, until we've done all of them in the month
while ( $day_num <= $days_in_month ) 
{
// The hyperlinks can do whatever you want, or nothing at all.
// Shows today in every month but can be changed easily

if($day_num == $day && $show_today=='1') {
echo"<td class=\"today\"><a href=\"#goose\"> $day_num </a></td>\n";
} else {
echo"<td><a href=\"#duck\"> $day_num </a></td>\n";
}
$day_num++; 
$day_count++;
// Every row denotes a new week, so after a maximum of 7 days start a new week.
if ($day_count > 7)
{
echo"</tr><tr>\n";
$day_count = 1;
}
} 
// Finally we finish out the table with some blank details ... if needed.
while ( $day_count >1 && $day_count <=7 ) 
{ 
echo "<td> </td>\n"; 
$day_count++; 
} 
echo "</tr></table>\n";
echo("<form>\n");
  
?>
</body></html>