<html>
<head>
	<title>性癖シャッフルゲーム/Top</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=800px,initial-scale=maximum-scale,user-scalable=no">
</head>
<body style="width :800px;margin-right: auto;margin-left : auto;background-image: url('bg_tile.jpg')">
<div align="center" style="width :650px;padding-left:30;padding-right:30;padding-top:80;padding-bottom:30;background-color: #ACD6BD;margin-right: auto;margin-left : auto;">
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
	if(mb_strlen($title)>30){
		$err = true;
		echo "<font color='red'>タイトルが長すぎます</font><br>";
	}
	if(mb_strlen($content)==0){
		$err = true;
		echo "<font color='red'>本文がありません</font><br>";
	}
	if(mb_strlen($title)==0){
		$err = true;
		echo "<font color='red'>タイトルがありません</font><br>";
	}
	//生成
	if($err === false){
		$fin = true;
		//完成文章
		echo '<br>部屋は<a href="room/index.php?id='.$id.'" TARGET="_blank">こちら</a>';
		//一覧への書き込み
		$links = file_get_contents ("links.txt" ,"r+");
		$current = $links.'<li><a href="room/index.php?id='.$id.'">'.$title.'</a></li>';
		file_put_contents("links.txt", $current);
		//datへの書き込み
		$currentchat=array("部屋が生成されました",date('Y/m/d H:i:s'));
		$ary = array($title,$content,$type,0,array($_SESSION['screen_name'],"","",""),999=>array("chatroom"=>array(0=>$currentchat)));
		file_put_contents("room/".$id.".dat", serialize($ary));
	}
}
?>
<!-- フォームここから -->
<?php if($fin){echo "<div style='display:none;height:0;'>";} ?>
<form action="" method="POST">
	部屋の名前(30字以内)：<br><input type="text" style="font-size: 16;" name="title" value="<?php echo htmlspecialchars($title,ENT_QUOTES,'UTF-8'); ?>"><br>
	主催の名前：<br><b><?php echo $_SESSION['name']; ?></b><br>
	主催のID：<br><?php echo "<b>".$_SESSION['screen_name']."</b>"; ?><br>
	説明文(1000字以内)：<br>
	<textarea style="width:90%;height:800;" name="content" style="font-size: 16;"><?php echo str_replace('&lt;br /&gt;', '', htmlspecialchars($content ,ENT_QUOTES,"UTF-8") ); ?></textarea><br>
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