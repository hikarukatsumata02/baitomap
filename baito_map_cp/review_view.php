<?php
	include 'db_config.php';

	if(!empty($_POST))
	{

		try
		{
		 // connect
		 $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
		 $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		 
		 $stmt = $db->query("SELECT * FROM review WHERE baito_id={$_POST['baito_id']}");
		 $review = $stmt->fetch(PDO::FETCH_ASSOC);
		 
		 $stmt2 = $db->query("SELECT * FROM review WHERE baito_id={$_POST['baito_id']}");
		 $review2 = $stmt->fetch(PDO::FETCH_ASSOC);
		 // 口コミをDBに保存する
		//  $date =  date("Y-m-d H:i:s", time());
		//  $db->exec("INSERT INTO review(baito_id, user, content, wrote_date) VALUES({$product_id}, {$order_quantity}, '{$date}')");
		 }
		 $db = null;
		}
		catch(PDOException $e)
		{
	    	$error = $e->getMessage();
	    	exit;
		}
	}


?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>Sample_GoogleMap</title>
    </head>


    <body>

      <h1>バイトマップ</h1>
	  <a href="main.php">トップページに戻る</a>
	  	<?php
			//  echo "<form method='post' action='insert_review.php'>
			// 	  <textarea name='comment' rows='3' cols='50'></textarea>
			// 	  <input name='baito_id' type='hidden' value='{$id}'>
			// 	  <input name='author' type='hidden' value='{$id}'>
			// 	  <input name='wrote_date' type='hidden' value='{$id}'>
			// 	  <input name='comment' type='hidden' value='{$id}'>
			// 	  <input type='submit' value='送信'>
			// 	  </form>"
				  
			//  echo "<hr>"
			
			
			
			//  echo "<h2>{$baito_name}のみんなの口コミ</h2>";
			 echo "<hr>"
			   
	         foreach ($review as $r)
	         {
	           $id = $r['baito_id'];
	           $author = $r['author'];
	           $comment = $r['comment'];
	           $wrote_date = $r['wrote_date'];
	          
	           echo "<div><h3>{$author}</h3><p>{$wrote_date}</p><p>{$comment}</p>";
	           echo "</p></div>";
	           echo "<p style='text-align:right;'><a href='delete.php?id={$id}'>削除</a></p><hr>";
		     }
		 ?>
		<br><br>
		
	</body>
</html>
