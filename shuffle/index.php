﻿<html>
<head>
	<title>性癖シャッフルゲーム/Top</title>
	<meta charset="UTF-8">
</head>
<body style="width :800px;margin-right: auto;margin-left : auto;">
<div align="center">
<?php 
session_start();

header("Content-type: text/html; charset=utf-8");
 
if(!isset($_SESSION['access_token'])){
	echo "<a href='login.php'>Twitterでログイン</a>";
}else{
    require_once "profile.php";
	//部屋一覧表示
	echo "性癖部屋";
    $links = file_get_contents ("links.txt" ,"r");
    echo "<br>".$links;
    echo '<br><br><a href="makeroom.php">部屋を作る</a>';
    //ログアウトボタン
	echo "<p><a href='logout.php'>ログアウト</a></p>";
}
?>
</div>
</body>
</html>