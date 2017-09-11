<html>
<head>
	<title>性癖シャッフルゲーム/Top</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=800px,initial-scale=maximum-scale">
<style type="text/css">
ul li a {
  position: relative;
  display: block;
  padding: 10px 25px 10px 10px;
  border: 1px solid #ccc;
  background-color:#D0F2E9;
}
ul li a::after {
  position: absolute;
  top: 50%;
  right: 10px;
  display: block;
  content: '';
  width: 8px;
  height: 8px;
  margin-top: -4px;
  border-top: 1px solid #888;
  border-right: 1px solid #888;
  -webkit-transform: rotate(45deg);
  transform: rotate(45deg);
}
</style>
</head>
<body style="width :800px;margin-right: auto;margin-left : auto;background-image: url('bg_tile.jpg')">
<div align="center" style="width :650px;padding-left:30;padding-right:30;padding-top:80;padding-bottom:30;background-color: #ACD6BD;margin-right: auto;margin-left : auto;">
<?php 
session_start();

header("Content-type: text/html; charset=utf-8");
 
if(!isset($_SESSION['access_token'])){
	echo "<a href='login.php'>Twitterでログイン</a>";
}else{
    require_once "profile.php";
	//部屋一覧表示
	echo "<b>部屋一覧</b>";
	echo "<ul style='list-style:none;'>";
    $links = file_get_contents ("links.txt" ,"r");
    echo $links;
    echo '</ul><hr><p><a href="howto.php">遊び方</a></p><p><a href="makeroom.php">部屋を作る</a></p><p><a href="" onclick="
  window.open(\'mail.html\', \'_blank\', \'width=500,height=300\');
  return false;">不具合報告</a></p>';
    //ログアウトボタン
	echo "<p><a href='logout.php'>ログアウト</a></p>";
}
?>
</div>
</body>
</html>