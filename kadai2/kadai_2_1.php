<?php
if(isset($_POST['name']) && isset($_POST['comment'])){
  $name = $_POST['name'];
  $comment = $_POST['comment'];
  echo $name ."<br>". $comment;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>掲示板</title>
</head>
<body>
  <h1>掲示板</h1>
  <form action="kadai_2_1.php" method="post">
    <p>名前：<input type="text" name="name"><br></p>
    <p>コメント：<input type="text" name="comment"><br></p>
    <input type="submit" value="投稿">
  </form>
</body>
</html>