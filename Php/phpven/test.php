<?php
//Connect To Database
$hostname='67.210.98.150';
$username='caata0_ttwait';
$password='TTwait846266';
$dbname='caata0_scock';
$usertable='hw';
$yourfield = 'hw_sn';
print_r($hostname);

$link = mysql_connect($hostname,$username, $password) or DIE ('Unable to connect to database! Please try again later.');
print_r($link);
mysql_select_db($dbname, $link);

$query = "SELECT * FROM $usertable limit 1";
$result = mysql_query($query, $link);
print_r($result);
if($result) {
    while($row = mysql_fetch_array($result)){
        $name = $row["$yourfield"];
        echo 'Name: '.$name;
    }
}
?> 