<?php
function generateRandomData($pw, $username, $statement, $dbconn)
{
	//create a bunch of users for each domain
	pg_prepare($dbconn, "0", "INSERT INTO mailmissouriedu VALUES($1, $2, $3, $4)");
	pg_prepare($dbconn, "1", "INSERT INTO missouriedu VALUES($1, $2, $3, $4)");
	
	$saltData = makesalt();
	$hashData = hashing($pw, $saltData);
    pg_execute($dbconn,$statement, array($username, $hashData[0], $saltData[0], $hashData[1]));
} 
function makeSalt() {
	$randData = "asdfasdfasdf";
	$randOffset = mt_rand(0, 68);
	$salt = hash("sha512", $randData, FALSE);
	$salt = substr($salt, $randOffset, 60);
	$returnResults = array($salt, $randOffset);
	return $returnResults;
}

function hashing($pw, $saltData)
{
	$randOffset = mt_rand(0, 68);
	$pw = hash("sha512", $pw . $saltData[0], FALSE);
	$pw = substr($pw, $randOffset, 60);
	$returnResults = array($pw, $randOffset);
	return $returnResults;
}


