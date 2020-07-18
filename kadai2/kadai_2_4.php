<?php
// テキストファイルがなければ新しく作成する
touch('kadai_2_4.txt');
$dataFile = 'kadai_2_4.txt';

// 投稿ボタンが押されたとき
if(isset($_POST['submit'])){
  // コメントが投稿された場合
  if(isset($_POST['comment'])){
    // 名前を変数$nameに代入する
    $name = $_POST['name'];
    // コメントを変数$commentに代入する
    $comment = $_POST['comment'];
      
    // コメントがあるとき
    if(!empty($comment)){
      // 名前が入力されなければ”名無し”を出力
      if(empty($name)){
        $name = "名無し";
      }
        
    // 日付を変数$dateに代入
      $date = date("Y/m/d(D) H:i:s");
  
      // テキストファイルを追加書き込みをするために開かせる命令
      $fp = fopen($dataFile, "a");
  
      // テキストファイルの行数をカウントした数に1を足して変数$cntに代入する
      $cnt = count(file($dataFile)) + 1;
  
      // $newdataに数、名前、コメント、日付を代入する。このとき、<>で区切る。
      $newdata = $cnt."<>".$name."<>".$comment."<>".$date."\n";
      // テキストファイルに変数$newdataを書き込む。    
      fwrite($fp, $newdata);
      // テキストファイルを閉じる
      fclose($fp);
    }else{
      echo '<script type="text/javascript">alert("コメントが未入力です。");</script>';
      // 投稿を押したときにコメントが空欄であれば、コメントが未入力であることを知らせるアラート
    }
  }
}elseif(isset($_POST['del_button'])){

  // 指定された削除番号を$deleteに代入する
  $delete = $_POST['delete'];
  
  $post_list = file($dataFile);

  // テキストファイルに上書き保存する
  $fp = fopen($dataFile, "w");
  for($i = 0; $i < count($post_list); $i++){
    
    $new_post = explode("<>", $post_list[$i]);
    
    // 投稿番号と削除番号が同じときに表示されないようにする
    if($new_post[0] != $delete){

      if($delete < $new_post[0]){
        $new_post[0] = $new_post[0] - 1;
      }
      $text = $new_post[0]."<>".$new_post[1]."<>".$new_post[2]."<>".$new_post[3];
      fwrite($fp, $text);
    // }else{
    //   fwrite($fp, "消去しました。\n");
    }
  }
  fclose($fp);
}
// $post_listに$dataFileのテキストを配列として読み込む
$post_list = file($dataFile);
// 新しい投稿が上に更新されるように、$post_list内の配列を逆順にする
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

  <!-- formでhtmlからphpにデータを送る -->
  <form action="kadai_2_4.php" method="post">
    <p>名前：<input type="text" name="name"><br></p>
    <p>コメント：<input type="text" name="comment"><br></p>
    <p><input type="submit" name="submit" value="投稿"></p>
    <p>削除したい番号：<input type="text" name="delete" size="3">　<input type="submit" name="del_button" value="削除"></p>
  </form>

  <h2>投稿一覧</h2>
  
</body>
</html>

<?php 
// コメントが入力されているとき
  if(!empty($post_list)){ 
    // $post_listを$postとして反復処理を行う
    foreach($post_list as $post){ 
      // 配列を<>で分割して$new_postで値を取得する
      $new_post = explode("<>", $post); 
      // いい感じに表示する
      echo $new_post[0],".",$new_post[1],"：(",$new_post[3],")","<br>",$new_post[2],"<br><br>";
    }
// コメントが入力されていないとき
  }else { 
    echo "まだ投稿はありません。";
  } 
?>