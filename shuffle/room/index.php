<html>
<head>
	<title>性癖シャッフルゲーム/
	<?php
	session_start();
	if($_GET['id']){
	$id = $_GET['id'];
	$_SESSION['room_id'] = $id;
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: ../room");
	}else{
		$id = $_SESSION['room_id'];
	}
	$file = fopen("$id.csv", "r");
	$ary = fgetcsv($file);
	fclose($file);
	echo $ary[0];
	?>
	</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=800px,initial-scale=maximum-scale,user-scalable=no">
</head>
<body style="width :800px;margin-right: auto;margin-left : auto;">
<?php
    echo '<center>';
		if($ary[3]==0){echo '<font color="red">参加者を募集しています</font>';}
		elseif($ary[3]==1){echo '<font color="red">性癖を送って下さい</font>';}
		elseif($ary[3]==2){echo '<font color="red">作品を提出して下さい</font>';}
		elseif($ary[3]==3){echo '<font color="red">作品を見ることができます</font>';}
		elseif($ary[3]==4){echo '<font color="red">性癖・作者を確認することができます</font>';}
	echo '</center>';
    //プロフィール
    require_once "../profile.php";
?>
<div style="width:90%;text-align:left;background-color: #FFAADD;margin: 10 auto;padding:10px;">
<b>部屋名：</b><br><?php echo $ary[0]; ?><br><br>
<b>説明文：</b><br><?php echo $ary[1]; ?><br><br>
<b>属性：</b><br><?php if($ary[2]=="word"){echo "文章";}else{echo "絵";} ?><br><br>
<b>進行状況：</b><br>
段階1：参加者募集<?php if($ary[3]==0){echo '<span style="font-weight: bold;"> <= 現在</span>';} ?><br>
段階2：性癖受付<?php if($ary[3]==1){echo '<span style="font-weight: bold;"> <= 現在</span>';} ?><br>
段階3：作品受付<?php if($ary[3]==2){echo '<span style="font-weight: bold;"> <= 現在</span>';} ?><br>
段階4：作品確認<?php if($ary[3]==3){echo '<span style="font-weight: bold;"> <= 現在</span>';} ?><br>
段階5：性癖・作者確認<?php if($ary[3]==4){echo '<span style="font-weight: bold;"> <= 現在</span>';} ?><br>
</div>
<div style="width:90%;text-align:left;background-color: #CCdd55;margin: 10 auto;padding:20px;">
<?php 
header("Content-type: text/html; charset=utf-8");
//参加済か否か
$attend = in_array($_SESSION['screen_name'],$ary);
//もうゲームが始まってるのに参加者ではない
if(!$attend and $ary[3]>0){
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: observe.php");
}
//管理者か否か
if($_SESSION['screen_name']==$ary[4]){
	echo '<br>あなたが主催者です<br><br>
	<form action="" method="post" onsubmit="return submitChk1()">
		<input type="submit" name="delete" value="部屋の削除"/>
	</form>
	<script>
    /**
     * 確認ダイアログの返り値によりフォーム送信
    */
    function submitChk1 () {
        /* 確認ダイアログ表示 */
        var flag = confirm ( "部屋を削除してもよろしいですか？");
        /* send_flg が TRUEなら送信、FALSEなら送信しない */
        return flag;
    }
	</script>
	';
}elseif(!$attend){
    echo '<br>あなたは参加していません<br><br>
    <form action="" method="post">
	    <input type="submit" name="join" value="参加" />
    </form>
';}else{
	echo '<br>あなたは参加しています<br><br>
	<form action="" method="post">
	    <input type="submit" name="exit" value="参加停止" />
    </form>
';}
//参加しました
if(isset($_POST['join'])) {
   $file = fopen("$id.csv", "w");
   array_push($ary, $_SESSION['screen_name']);
   fputcsv($file, $ary);
   fclose($file);
   header("HTTP/1.1 301 Moved Permanently");
   header("Location: ../room");
}
if(isset($_POST['exit'])) {
   $file = fopen("$id.csv", "w");
   $ary = array_diff($ary, array($_SESSION['screen_name']));
   fputcsv($file, $ary);
   fclose($file);
   header("HTTP/1.1 301 Moved Permanently");
   header("Location: ../room");
}
//参加者リスト
$ninzuu = count($ary)-4;
echo "<br><b>参加者一覧(".$ninzuu."人)</b><br>";
//まず主催がトップ
	$screen_name = $ary[4];
	echo '<a href = "https://twitter.com/'.$screen_name.'"  Target="_blank">';
	require "get.php";
	echo "(@".$ary[4].")</a
	>　※主催<br>";
//人間削除フォーム開始
echo '<form action="" method="post" onsubmit="return submitChk()">';
//それ以外の人を記す
for ($i = 5; $i < count($ary); $i++) {
	$screen_name = $ary[$i];
	echo '<a href = "https://twitter.com/'.$screen_name.'"  Target="_blank">';
    require "get.php";
    echo "(@".$ary[$i].")</a><br>";
    //もし主催なら削除権限を与える
    if($_SESSION['screen_name']==$ary[4]){
    	echo '<div align="right"><input type="checkbox" name="member[]" value="'.$screen_name.'"></div>';
    }
}
if($_SESSION['screen_name']==$ary[4]){
	echo '
		<br><input type="submit" value="選択した参加者の削除"/><br>
		<script>
	/**
	 * 確認ダイアログの返り値によりフォーム送信
	*/
	function submitChk () {
		/* 確認ダイアログ表示 */
		var flag = confirm ( "選択した参加者を削除してもよろしいですか？");
		/* send_flg が TRUEなら送信、FALSEなら送信しない */
		return flag;
	}
	</script>
';}
//人間削除フォーム終了
echo '</form>';
//フェーズ進行フォーム
if($_SESSION['screen_name']==$ary[4]){
	echo '
	　　<form action="" method="post" onsubmit="return submitChk2()">
		<input type="submit" name="ahead" value="段階を進める"/>
		</form>
		<script>
	/**
	 * 確認ダイアログの返り値によりフォーム送信
	*/
	function submitChk2 () {
		/* 確認ダイアログ表示 */
		var flag = confirm ( "段階を進めてもよろしいですか？");
		/* send_flg が TRUEなら送信、FALSEなら送信しない */
		return flag;
	}
	</script>
';}
//部屋の削除
if(isset($_POST['delete'])){
	unlink ("$id.csv");
	$links = file_get_contents ("../links.txt" ,"r+");
    $current = str_replace ('<br><a href="room/index.php?id='.$id.'">'.$ary[0].'</a>',"",$links);
    file_put_contents("../links.txt", $current);
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: ../");
}
//人間の削除
if(isset($_POST['member'])){
	//選ばれた人を順番にexitしていく
	$bye_list = $_POST['member'];
	for($i = 0; $i < count($bye_list); $i++){
	   $file = fopen("$id.csv", "w");
	   $ary = array_diff($ary, array($bye_list[$i]));
	   fputcsv($file, $ary);
	   fclose($file);
	   header("HTTP/1.1 301 Moved Permanently");
	   header("Location: ../room");
	}
}
//進行管理
require_once "phase.php";
if(isset($_POST['ahead'])){
	ahead();
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: ../room");
}
echo '</div>';
//進行箱関連
require_once "probox.php";
?>
<center>
<a href="../">トップに戻る</a>
</center>
</body>
</html>