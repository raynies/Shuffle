<html>
<head>
	<title>性癖シャッフルゲーム/Top</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=800px,initial-scale=maximum-scale,user-scalable=no">
</head>
<body style="width :800px;margin-right: auto;margin-left : auto;">
<div align="center">
<?php 
session_start();
header("Content-type: text/html; charset=utf-8");
	//セッションを受け継ぐ
    require_once "profile.php";
if($fin){echo "</div>";}
mb_internal_encoding("UTF-8");
//初期値設定
$username = "";
$title = "";
$content = "";
$fin = false;
//初期値設定ここまで
$id = date('YnjHis').rand(00,99);
if ($_SERVER['REQUEST_METHOD']==='POST'){
	$err = false;
	$content = $_POST['content'];
	$title = $_POST['title'];
	$type = $_POST['type'];
	//変数最適化
	$content = nl2br(htmlspecialchars($content));
	//文字数は大丈夫か
	if(mb_strlen($content)>1000){
		$err = true;
		echo "<font color='red'>本文が長すぎます</font><br>";
	}
	if(mb_strlen($title)>20){
		$err = true;
		echo "<font color='red'>タイトルが長すぎます</font><br>";
	}
	if(mb_strlen($content)==0){
		$err = true;
		echo "<font color='red'>本文のNASA</font><br>";
	}
	if(mb_strlen($title)==0){
		$err = true;
		echo "<font color='red'>タイトルのNASA</font><br>";
	}
	//生成
	if($err === false){
		$fin = true;
		//完成文章
		echo '<br>部屋は<a href="room/index.php?id='.$id.'" TARGET="_blank">こちら</a>';
		//一覧への書き込み
		$links = file_get_contents ("links.txt" ,"r+");
		$current = $links.'<br><a href="room/index.php?id='.$id.'">'.$title.'</a>';
		file_put_contents("links.txt", $current);
		//csvへの書き込み
		$ary = array($title,$content,$type,0,$_SESSION['screen_name']);
		$file = fopen("room/".$id.".csv", "w");
		fputcsv($file, $ary);
		fclose($file);
	}
}
?>
<!-- フォームここから -->
<?php if($fin){echo "<div style='display:none;height:0;'>";} ?>
<form action="" method="POST">
	部屋の名前(20字以内)：<br><input type="text" name="title" value="<?php echo htmlspecialchars($title,ENT_QUOTES,'UTF-8'); ?>"><br>
	主催の名前：<br><b><?php echo $_SESSION['name']; ?></b><br>
	主催のID：<br><?php echo "<b>".$_SESSION['screen_name']."</b>"; ?><br>
	説明文(1000字以内)：<br>
	<textarea rows="30" cols="30" name="content"><?php echo str_replace('&lt;br /&gt;', '', htmlspecialchars($content ,ENT_QUOTES,"UTF-8") ); ?></textarea><br>
	創作の種類：<br>
	<input name="type" type="radio" value="word" checked="checked">文章
    <input name="type" type="radio" value="paint">絵<br>
	<input type="submit">
</form>
<?php if($fin){echo "</div>";} ?>
<!-- フォームここまで -->
<br><a href="index">トップに戻る</a>
<?php
    //ログアウトボタン
	echo "<p><a href='logout.php'>ログアウト</a></p>";

?>
</div>
</body>
</html>