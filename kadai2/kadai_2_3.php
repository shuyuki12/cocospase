<?php
$dataFile = 'kadai_2_3.txt';

// function h($s){
//   return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
// }

// コメントがポストされた場合
if(isset($_POST['comment'])){
  $name = $_POST['name'];
  $comment = $_POST['comment'];

  
  if(!empty($comment)){
    if(empty($name)){
      $name = "名無し";
    }
    
    $date = date("Y/m/d(D) H:i:s");
    $fp = fopen($dataFile, "a");
    $cnt = count(file($dataFile)) + 1;

    $newdata = $cnt."<>".$name."<>".$comment."<>".$date."\n";    
    fwrite($fp, $newdata);
    fclose($fp);
  // }else{
  //   echo '<script type="text/javascript">alert("コメントが未入力です。");</script>';
  }
}
$post_list = file($dataFile, FILE_IGNORE_NEW_LINES);
$post_list = array_reverse($post_list);
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
  <form action="kadai_2_3.php" method="post">
    <p>名前：<input type="text" name="name"><br></p>
    <p>コメント：<input type="text" name="comment"><br></p>
    <input type="submit" value="投稿">
  </form>

  <h2>投稿一覧</h2>
  
  <?php 
  if(!empty($post_list)){ 
    foreach($post_list as $post){ 
    $new_post = explode("<>", $post); 
    echo '<p>',$new_post[0],".",$new_post[1],"：(",$new_post[3],")",'</p>';
    echo '<p>',$new_post[2],'</p>';
    echo "<br>";
    }
  }else { 
    echo '<p>',"まだ投稿はありません。",'</p>';
  } 
  ?>   
  
</body>
</html>