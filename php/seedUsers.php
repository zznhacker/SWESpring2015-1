<?php
include 'insertUsers.php';
include 'functions.php';

$pw = 'test';
$username = 'dep456';
$statement = 0;
$dbconn = db_connect();

generateRandomData($pw, $username, $statement, $dbconn);
?>