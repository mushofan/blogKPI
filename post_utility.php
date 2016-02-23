<?php
error_reporting(E_ALL);
ini_set('display_errors','On');
require_once 'db_config.php';

function createPost($csrf, $session, $judul, $tanggal, $konten)
{
    if ($csrf == $session) {
        global $dbHost;
        global $dbUsername;
        global $dbPassword;
        global $dbName;
        $mysqli = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
        if ($mysqli->connect_errno) {
            echo "Failed to connect to mysql database " . $mysqli->connect_errno;
            exit(0);
        }


        //Prepare statement
        $statement = $mysqli->prepare("INSERT INTO `posts`(`judul`, `tanggal`, `konten`) VALUES(?, ?, ?)");

        //Bind param
        if (!$statement->bind_param("sss", $judul, $tanggal, $konten)) {
            echo "Failed to bind parameter judul: " . $statement->error_no;
            exit(0);
        }

        //Execute
        if (!$statement->execute()) {
            echo "Failed to execute sql statement";
            exit(0);
        }

        $statement->close();
    }
}

function loadPosts()
{
	global $dbHost;
	global $dbUsername;
	global $dbPassword;
	global $dbName;
	$mysqli = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
	if ($mysqli->connect_errno)
	{
		echo "Failed to connect to mysql database " .$mysqli->connect_errno;
		exit(0);
	}

	//Prepare statement
	$results = $mysqli->query("SELECT * FROM `posts`");	

	if (!$results)
	{
		echo "Failed to fetch posts";
		exit(0);
	}

	$mysqli->close();
	return $results;
}

function loadPost($id)
{
	global $dbHost;
	global $dbUsername;
	global $dbPassword;
	global $dbName;
	$mysqli = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
	if ($mysqli->connect_errno)
	{
		echo "Failed to connect to mysql database " .$mysqli->connect_errno;
		exit(0);
	}

	//Prepare statement
	$results = $mysqli->query("SELECT * FROM `posts` WHERE `id`=".$id);	

	if (!$results)
	{
		echo "Failed to fetch posts";
		exit(0);
	}

	$mysqli->close();
	return $results->fetch_assoc();
}

function updatePost($id, $judul, $tanggal, $konten)
{
	global $dbHost;
	global $dbUsername;
	global $dbPassword;
	global $dbName;
	$mysqli = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
	if ($mysqli->connect_errno)
	{
		echo "Failed to connect to mysql database " .$mysqli->connect_errno;
		exit(0);
	}

	//Prepare statement
	$statement = $mysqli->prepare("UPDATE `posts` SET `judul`=?,`tanggal`=?, `konten`=? WHERE `id`=?");

	//Bind param
	if (!$statement->bind_param("sssi", $judul, $tanggal, $konten, $id))
	{
		echo "Failed to bind parameter judul: ";
		exit(0);
	}

	//Execute
	if(!$statement->execute())
	{
		echo "Failed to execute sql statement:".$statement->error;
		exit(0);
	}

	$statement->close();

}
?>