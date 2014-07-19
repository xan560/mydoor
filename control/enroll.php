<?php
session_start();
ob_start();

$first_name = ($_POST['first']);
$last_name = ($_POST['last']);
$days = (implode("",$_POST['day']));
$start_hour = ($_POST['start_hour']);
$start_min = ($_POST['start_min']);
$end_hour = ($_POST['end_hour']);
$end_min = ($_POST['end_min']);

echo "first: ".$first_name." last: ".$last_name;
echo "   ".$start_hour.":".$start_min." to ".$end_hour.":".$end_min;

$fingerprint_table=fingerprint;
$conn = mysql_connect('localhost', 'root', 'maseeh4060');
mysql_select_db('login', $conn);

if (true) { mysql_query("drop table $fingerprint_table;"); }

//create the table (if it doesnt exist)
$create = "CREATE TABLE IF NOT EXISTS `$fingerprint_table` (
`first` varchar(255) NOT NULL default '',
`last` varchar(255) NOT NULL default '',
`days` int(11) signed NOT NULL default '-1',
`sh` int(10) signed NOT NULL default '-1',
`sm` int(10) signed NOT NULL default '-1',
`eh` int(10) signed NOT NULL default '-1',
`em` int(10) signed NOT NULL default '-1',
`fp_size` int(10) signed NOT NULL default '-1',
`fp_data` blob not null,
`image` blob not null
);";
mysql_query($create);


//remove user if already exist!
$first_name = mysql_real_escape_string($first_name);
$last_name = mysql_real_escape_string($last_name);
$remove_dup = "DELETE FROM fingerprint 
WHERE first = '$first_name' AND last = '$last_name';";
mysql_query($remove_dup);

$files = array();
$fp_size="";
$fp_data="";
foreach (glob("../.tmp/*.fp") as $file) {
    $fp_size=substr($file, 8, 4 );
    $fp_data=mysql_escape_string(file_get_contents($file));
}


$insert = "INSERT INTO $fingerprint_table( first, last, days, sh,sm, eh,em, fp_size, fp_data, image ) VALUES(
        '$first_name', 
        '$last_name',
        '$days',
        '$start_hour',
        '$start_min',
        '$end_hour',
        '$end_min',
        '$fp_size',
        '$fp_data',
        '" . mysql_escape_string(file_get_contents('../.tmp/enrolled.pgm')) . "')";

mysql_query($insert);
session_write_close();
header('location: ./manage.html');
mysql_close();

?>
