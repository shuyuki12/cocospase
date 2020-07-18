<?php
if(isset($_POST['comment'])){
  $comment = $_POST['comment'];
  $fp = fopen("kadai_1_6.txt", "a");
  fwrite($fp, $comment.PHP_EOL);
  fclose($fp);
  }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>kadai1.6</title>
</head>
<body>
  <h1>フォームデータの送信</h1>
  <form action="kadai_1_6.php" method="post">
    <input type="text" name="comment"><br>
    <input type="submit" value="送信">

  </form>
</body>
</html>



