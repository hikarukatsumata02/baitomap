<?php
inclde 'db_config.php';
session_start();

// signup.phpから来たことを証明するために、会員登録の手続き以外のアクセスを飛ばす 
if (!isset($_SESSION['join'])) {
    header('Location: signup.php');
    exit();
}

try
  {
     // connect
     $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
     $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // 「登録する」を押したとき
    if (!empty($_POST['check'])) {
        // パスワードを暗号化
        $hash = password_hash($_SESSION['join']['password'], PASSWORD_BCRYPT);
     
        // 入力情報をデータベースに登録
        $statement = $db->prepare("INSERT INTO users SET name=?, email=?, password=?");
        $statement->execute(array(
            $_SESSION['join']['name'],
            $_SESSION['join']['email'],
            $hash
        ));
     
        unset($_SESSION['join']);   // セッションを破棄
        header('Location: thanks.php');   // thanks.phpへ移動
        exit();
    }

     $db = null;
  }
  catch(PDOException $e)
  {
   echo $e->getMessage();
   exit;
  }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>確認画面</title>
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="https://unpkg.com/sanitize.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="content">
        <form action="" method="POST">
            <input type="hidden" name="check" value="checked">
            <h1>入力情報の確認</h1>
            <p>ご入力情報に変更が必要な場合、「変更する」ボタンを押して変更を行ってください。</p>
            <?php if (!empty($error) && $error === "error"): ?>
                <p class="error">＊会員登録に失敗しました。</p>
            <?php endif ?>
            <hr>
 
            <div class="control">
                <p>ユーザー名</p>
                <p><span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES); ?></span></p>
            </div>
 
            <div class="control">
                <p>メールアドレス</p>
                <p><span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES); ?></span></p>
            </div>
            
            <br>
            <a href="signup.php" class="back-btn">変更する</a>
            <button type="submit" class="btn next-btn">登録する</button>
            <div class="clear"></div>
        </form>
    </div>
</body>
</html>
