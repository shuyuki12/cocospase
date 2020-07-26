<?php
// テキストファイルがなければ新しく作成する
touch('kadai_2_6.txt');
$dataFile = 'kadai_2_6.txt';

// セッション(PHP実行後でもセットした情報を覚えている特性)スタート
session_start();

$name = "";
$comment = "";
$name1 = "";
$comment1 = "";
$id = "";
$edit = "";

// 二重投稿になっていないか確認
if((isset($_REQUEST["chkno"]) == true) && (isset($_SESSION["chkno"]) == true) && ($_REQUEST["chkno"] == $_SESSION["chkno"])){

  // 投稿ボタンが押されたとき
  if(isset($_POST['sub_button'])){
    // 名前を変数$nameに代入する
    $name = $_POST['name'];
    // コメントを変数$commentに代入する
    $comment = $_POST['comment'];

    if(!empty($_POST["password"]) && !empty($comment)){

      $password = $_POST["password"];
      
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
      $newdata = $cnt."<>".$name."<>".$comment."<>".$date."<>".$password."\n";
      // テキストファイルに変数$newdataを書き込む。    
      fwrite($fp, $newdata);
      // テキストファイルを閉じる
      fclose($fp);
    }elseif(empty($comment)){
      echo '<script type="text/javascript">alert("コメントが未入力です。");</script>';
      // 投稿を押したときにコメントが空欄であれば、コメントが未入力であることを知らせるアラート
    }else{
      echo '<script type="text/javascript">alert("パスワードを設定してください。");</script>';
      // パスワードが未設定であることを知らせるアラート
    }
  }
  // 削除ボタンが押されたとき
  elseif(isset($_POST['del_button'])){
    // 指定された削除番号を$deleteに代入する
    
    if(!empty($_POST["password"])){
      $password = $_POST["password"];
      
      if(!empty($_POST["delete"])){
        $delete = $_POST["delete"];
        $post_list = file($dataFile);

        for($i = 0; $i < count($post_list); $i++){
          $list = explode("<>", trim($post_list[$i]));

          if($list[0] == $delete && strcmp($list[4], $password) == 0){

            // テキストファイルに上書き保存する
            $fp = fopen($dataFile, "w");
            for($i = 0; $i < count($post_list); $i++){
        
              $new_post = explode("<>", trim($post_list[$i]));
        
              // 投稿番号と削除番号が同じときに表示されないようにする
              if($new_post[0] != $delete){
        
                if($delete < $new_post[0]){
                  $new_post[0] = $new_post[0] - 1;
                }
                $text = $new_post[0]."<>".$new_post[1]."<>".$new_post[2]."<>".$new_post[3]."<>".$new_post[4]."\n";
                fwrite($fp, $text);
              }
            }
            fclose($fp);
          }elseif($list[0] == $delete && strcmp($list[4], $password) != 0){
              echo '<script type="text/javascript">alert("パスワードが間違っています。");</script>';
            // パスワードが一致しないことを知らせるアラート
          } 
        }

      }else{
        echo '<script type="text/javascript">alert("削除したい番号を入力してください。");</script>';
          // 投稿を押したときに削除番号が空欄であれば、未入力であることを知らせるアラート
      }
        
    }else{
      echo '<script type="text/javascript">alert("パスワードを入力してください。");</script>';
      // パスワードが未入力であることを知らせるアラート
    }

    // $deleteに数字が入力されている場合
  }
  // 編集ボタンが押された場合
  elseif(isset($_POST["edit_button"])){

    if(!empty($_POST["password"])){
      $password = $_POST["password"];
      
      // editに数字が入力されている場合
      if(!empty($_POST["edit"])){
        // 指定された編集番号を$editに代入する
        $edit = $_POST["edit"];
        $post_list = file($dataFile);

        for($i = 0; $i < count($post_list); $i++){
          $list = explode("<>", trim($post_list[$i]));

          if($list[0] == $edit && strcmp($list[4], $password) == 0){
            // fileをループさせる
            for($i = 0; $i < count($post_list); $i++){
              $new_post = explode("<>", $post_list[$i]);
      
              // 投稿番号と編集番号が同じとき
              if($new_post[0] == $edit){
      
                $name1 = $new_post[1];
                $comment1 = $new_post[2];
              }
            }
          }elseif($list[0] == $edit && strcmp($list[4], $password) != 0){
            echo '<script type="text/javascript">alert("パスワードが間違っています。");</script>';
          // パスワードが一致しないことを知らせるアラート
          }
        }
      }else{
        echo '<script type="text/javascript">alert("編集したい番号を入力してください。");</script>';
          // 投稿を押したときに編集番号が空欄であれば、未入力であることを知らせるアラート
      }
    }else{
      echo '<script type="text/javascript">alert("パスワードを入力してください。");</script>';
      // パスワードが未入力であることを知らせるアラート
    }
  }
  // 編集を反映させる。
  elseif(isset($_POST["edi_button"]) && !empty($_POST["comment"])){
    $post_list = file($dataFile);
    $id = $_POST["id"];

    $fp = fopen($dataFile, "w");
    for($i = 0; $i < count($post_list); $i++){
      $new_post = explode("<>", $post_list[$i]);

      // 投稿番号と編集番号が同じとき
      if($new_post[0] == $id){
        $new_post[1] = $_POST["name"]."(編集済み)";
        $new_post[2] = $_POST['comment'];
        $new_post[3] = date("Y/m/d(D) H:i:s")."\n";
      }
      $text = $new_post[0]."<>".$new_post[1]."<>".$new_post[2]."<>".$new_post[3];
      fwrite($fp, $text);
    }
    fclose($fp);
  }else{
    echo '<script type="text/javascript">alert("編集したい番号の項目で番号を入力してください。");</script>';
      // 空白で編集するボタンを押したときに知らせるアラート
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
  <p>　※注意※　投稿時にはパスワードを設定してください！
  <br>　　　　　　削除、編集の番号を指定するためには投稿時に設定したパスワードを入力してください！</p>

  <!-- formでhtmlからphpにデータを送る -->
  <form action="kadai_2_6.php" method="post">
    <!-- ブラウザからの送信時に照合番号が送られる -->
    <input name="chkno" type="hidden" value="<?php echo $chkno; ?>">

    <p>名前<br><input type="text" name="name" value=<?= $name1 ?>><br></p> 
    <p>コメント
    <br><input type="text" name="comment" value=<?= $comment1 ?>><br>
    </p>
      削除したい番号 : 
      <input type="text" name="delete" size="3">　
      <input type="submit" name="del_button" value="削除">
    </p>
    <p>
      編集したい番号 :
      <input type="text" name="edit" size="3">　
      <input type="hidden" name="id" value=<?= $edit ?>>
      <input type="submit" name="edit_button" value="編集対象を表示">
    </p>
    <p>
      パスワード : <input type="password" name="password">
    </p>
    <p><input type="submit" name="sub_button" value="投稿">　<input type="submit" name="edi_button" value="編集"></p>
    <p>
  </form>

  <h2>投稿一覧</h2>
  <hr>

</body>
</html>

<?php 
// 投稿があるとき
  if(!empty($post_list)){ 
    // $post_listを$postとして反復処理を行う
    foreach($post_list as $post){ 
      // 配列を<>で分割して$new_postで値を取得する
      $new_post = explode("<>", trim($post)); 
      // いい感じに表示する
      echo $new_post[0],".",$new_post[1]," ( ",$new_post[3],")","<br>",$new_post[2],"<br><br>";
    }
// 投稿がないとき
  }else { 
    echo "まだ投稿はありません。";
  } 
?>