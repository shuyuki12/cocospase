<?php
$dataFile = 'kadai_2_2.txt';

if(isset($_POST['comment'])){
  $name = $_POST['name'];
  $comment = $_POST['comment'];

  
  if(!empty($comment)){
    if(empty($name)){
      $name = "名無し";
    }
    
    $date = date("Y/m/d H:i:s");
    $fp = fopen($dataFile, "a");
    $cnt = count(file($dataFile)) + 1;

    $newdata = $cnt."<>".$name."<>".$comment."<>".$date."\n";    
    fwrite($fp, $newdata);
    fclose($fp);
  // }else{
  //   echo '<script type="text/javascript">alert("コメントが未入力です。");</script>';
  }
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
  <form action="kadai_2_2.php" method="post">
    <p>名前：<input type="text" name="name"><br></p>
    <p>コメント：<input type="text" name="comment"><br></p>
    <input type="submit" value="投稿">
  </form>

</body>
</html>