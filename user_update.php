<?php
// 関数ファイル読み込み
// var_dump($_POST);
// exit();
include('user_functions.php');

//入力チェック(受信確認処理追加)
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
$id = $_POST['id'];

// exit();
//DB接続します(エラー処理追加)
$pdo = connectToDb();


//データ登録SQL作成
// $sql = 'UPDATE user_table(id, name, lid, lpw, kanri_flg, life_flg, indate)
// VALUES(NULL, :a1, :a2, :a3, :a4, :a5, sysdate())';

$sql = 'UPDATE user_table SET name=:a1,lid=:a2,lpw=:a3,kanri_flg=:a4,life_flg=:a5 WHERE id= :id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $name, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a2', $lid, PDO::PARAM_STR);   //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a3', $lpw, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a4', $kanri_flg, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a5', $life_flg, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

var_dump($status);

//4．データ登録処理後
if ($status == false) {
  showSqlErrorMsg($stmt);
} else {
  header('Location: user_select.php');
  exit;
}
