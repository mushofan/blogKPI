<?php
require_once "session.php";
SessionManager::sessionStart();
if (isset($_POST['id']) && isset($_POST['csrf']))
{
	require_once "db_config.php";
	global $dbHost;
	global $dbUsername;
	global $dbPassword;
	global $dbName;
	if($_POST['csrf']=== $_SESSION['csrf_salt2']) {
		$mysqli = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
		if ($mysqli->connect_errno) {
			echo "Failed to connect to mysql database " . $mysqli->connect_errno;
			exit(0);
		}

		//Prepare statement
		$statement = $mysqli->prepare("DELETE FROM `posts` WHERE id=?");

		//Bind param
		if (!$statement->bind_param("i", $_POST['id'])) {
			echo "Failed to bind parameter judul: " . $statement->error;
			exit(0);
		}

		//Execute
		if (!$statement->execute()) {
			echo "Failed to execute sql statement:" . $statement->error;
			exit(0);
		}

		$statement->close();
		echo "Success delete post with id :" . $_POST['id'];
	}
}


?>