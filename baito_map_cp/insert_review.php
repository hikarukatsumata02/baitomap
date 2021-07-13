<?php
	include 'db_config.php';
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
	    $baito_id = $_POST["baito_id"];
		$author = $_POST["author"];
		$wrote_date = $_POST["wrote_date"];
		$comment = $_POST["comment"];

		try
		{
		 // connect
		 $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
		 $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		 // DBに保存する
		 $db->exec("INSERT INTO review(baito_id, author, wrote_date, comment) 
			       VALUES({$baito_id}, '{$author}', '{$wrote_date}', '{comment}')");
		 $db = null;
		}
		catch(PDOException $e)
		{
	    	$error = $e->getMessage();
	    	exit;
		}
	}
?>

