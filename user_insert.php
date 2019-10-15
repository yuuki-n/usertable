<?php

// 入力チェック
if (
  !isset($_POST['name']) || $_POST['name'] == '' ||
  !isset($_POST['lid']) || $_POST['lid'] == '' ||
  !isset($_POST['lpw']) || $_POST['lpw'] == '' ||
  !isset($_POST['kanri_flg']) || $_POST['kanri_flg'] == '' ||
  !isset($_POST['life_flg']) || $_POST['life_flg'] == ''
) {
  exit('ParamError');
}

//POSTデータ取得
$name = $_POST['name'];
$lid = $_POST['lid'];
$lpw = $_POST['lpw'];
$kanri_flg = $_POST['kanri_flg'];
$life_flg = $_POST['life_flg'];


//DB接続
include('user_functions.php');
$pdo = connectToDb();


// $dbn = 'mysql:dbname=YOUR_DB_NAME;charset=utf8;port=3306;host=localhost';
// $user = 'root';
// $pwd = '';

// try {
//   $pdo = new PDO($dbn, $user, $pwd);
// } catch (PDOException $e) {
//   exit('dbError:' . $e->getMessage());
// }

//データ登録SQL作成
$sql = 'INSERT INTO user_table(id, name, lid, lpw, kanri_flg, life_flg, indate)
VALUES (NULL, :a1, :a2, :a3,:a4,:a5, sysdate())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $name, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a2', $lid, PDO::PARAM_STR);   //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a3', $lpw, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a4', $kanri_flg, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a5', $life_flg, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//データ登録処理後
if ($status == false) {
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit('sqlError:' . $error[2]);
} else {
  //index.phpへリダイレクト
  header('Location: user_index.php');
}
