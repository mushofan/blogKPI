<?php
error_reporting(E_ALL);
ini_set('display_errors','On');
require_once 'db_config.php';

function createPost($judul, $tanggal, $konten)
{
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
	if (!$statement = $mysqli->prepare("SELECT * FROM `posts` WHERE `id`= ?")){
		echo "Error connecting to mysql database";
		die();
	}
	if (!$statement->bind_param('i', $id)){
		header("Location: 404.php");
		die();
	}

	if ($statement->execute()){
        header("Location: 404.php");
        die();
	}
    $results = $statement->get_result();
//	$results = $mysqli->query("SELECT * FROM `posts` WHERE `id`=".$id);

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

function createImagePost($title, $imageUrl){
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
    $statement = $mysqli->prepare("INSERT INTO `images`(`judul`, `gambar`) VALUES(?, ?)");
    if (!$statement){
        echo "Failed to create query";
        die();
    }

    if (!$statement->bind_param('ss', $title, $imageUrl)){
        echo 'Failed to bind parameter';
        die();
    };

    if (!$statement->execute()){
        echo 'Failed to execute query';
        die();
    }

    $statement->close();

}

function loadImagePosts()
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
	$results = $mysqli->query("SELECT * FROM `images`");

	if (!$results)
	{
		echo "Failed to fetch posts";
		exit(0);
	}

	$mysqli->close();
	return $results;
}

function loadImagePost($id)
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
	if (!$statement = $mysqli->prepare("SELECT * FROM `images` WHERE `id`= ?")){
		echo "Error connecting to mysql database";
		die();
	}
	if (!$statement->bind_param('i', $id)){
		header("Location: 404.php");
		die();
	}

	$statement->execute();
	$results = $statement->get_result();
//	$results = $mysqli->query("SELECT * FROM `posts` WHERE `id`=".$id);

	if (!$results)
	{
		echo "Failed to fetch posts";
		exit(0);
	}

	$mysqli->close();
	return $results->fetch_assoc();
}