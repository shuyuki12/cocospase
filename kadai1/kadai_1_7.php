<?php
  $lines = file('kadai_1_6.txt');
  print_r($lines);
  echo "<br>";
  foreach($lines as $line_num => $line){
    echo "Line #<b>{$line_num}</b> : " .htmlspecialchars($line). "<br />\n";
  }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>kadai1.7</title>
</head>
<body>
  <!-- <h1>フォームデータの送信</h1>
  <form action="kadai_1_7.php" method="post">
    <input type="text" name="comment"><br>
    <input type="submit" value="送信"> -->

  </form>
</body>
</html>



