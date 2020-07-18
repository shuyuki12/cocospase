<?php
// テキストファイルがなければ新しく作成する
touch('kadai_2_5.txt');
$dataFile = 'kadai_2_5.txt';

// セッション(PHP実行後でもセットした情報を覚えている特性)スタート
session_start();

$name1 = "";
$comment1 = "";

// 二重投稿になっていないか確認
if((isset($_REQUEST["chkno"]) == true) && (isset($_SESSION["chkno"]) == true) && ($_REQUEST["chkno"] == $_SESSION["chkno"])){

  // 投稿ボタンが押されたとき
  if(isset($_POST['submit'])){
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
  // 削除ボタンが押されたとき
  elseif(isset($_POST['del_button'])){
    // 指定された削除番号を$deleteに代入する
    $delete = $_POST['delete'];
  
    // $deleteに数字が入力されている場合
    if(!empty($delete)){
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
        }
      }
      fclose($fp);
    }else{
      echo '<script type="text/javascript">alert("削除したい番号を入力してください。");</script>';
        // 投稿を押したときに削除番号が空欄であれば、未入力であることを知らせるアラート
    }
  }
  // 編集ボタンが押された場合
  elseif(isset($_POST["edit_button"])){
    // 指定された編集番号を$editに代入する
    $edit = $_POST["edit"];

    // editに数字が入力されている場合
    if(!empty($edit)){
      $post_list = file($dataFile);

      // fileをループさせる
      for($i = 0; $i < count($post_list); $i++){
        $new_post = explode("<>", $post_list[$i]);

        // 投稿番号と編集番号が同じとき
        if($new_post[0] == $edit){
          // イコール時の配列値を$edit_numに代入する
          $edit_num = $new_post[0];

          $name1 = $new_post[1];
          $comment1 = $new_post[2];

        }
      }
    }else{
      echo '<script type="text/javascript">alert("編集したい番号を入力してください。");</script>';
        // 投稿を押したときに編集番号が空欄であれば、未入力であることを知らせるアラート
    }
  }
}

// $post_listに$dataFileのテキストを配列として読み込む
$post_list = file($dataFile);
// 新しい投稿が上に更新されるように、$post_list内の配列を逆順にする
$post_list = array_reverse($post_list);

// 新しいトークンをセット
// mt_rand()関数はランダム数字発行
$_SESSION["chkno"] = $chkno = mt_rand();

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
  <form action="kadai_2_5.php" method="post">
  <!-- ブラウザからの送信時に照合番号が送られる -->
  <input name="chkno" type="hidden" value="<?php echo $chkno; ?>">

    <p>名前：<input type="text" name="name" value=<?= $name1 ?>><br></p> 
    <p>コメント：<input type="text" name="comment" value=<?= $comment1 ?>><br></p>
    <p><input type="submit" name="submit" value="投稿"></p>
    <p>
      削除したい番号：
      <input type="text" name="delete" size="3">　
      <input type="submit" name="del_button" value="削除">
    </p>
    <p>
      編集したい番号：
      <input type="text" name="edit" size="3">　
      <input type="submit" name="edit_button" value="編集">
      <input type="hidden" name="edit" va
    </p>
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