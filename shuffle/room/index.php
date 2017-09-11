<html>
<head>
<title>性癖シャッフル/
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
$ary = unserialize(file_get_contents($id.".dat"));
echo $ary[0];
require('get_n.php');
?>
</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=800px,initial-scale=maximum-scale,user-scalable=no">
</head>
<body style="width :800px;margin-right: auto;margin-left : auto;background-image: url('../bg_tile.jpg')">
<div style="width :650px;padding-left:30;padding-right:30;padding-top:80;padding-bottom:30;background-color: #ACD6BD;margin-right: auto;margin-left : auto;">
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
<div style="width:90%;text-align:left;background-color: #D0F2E9;margin: 10 auto;padding:20px;border:double 10px #003B34;">
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
<div style="width:90%;text-align:left;background-color: #D0F2E9;margin: 10 auto;padding:20px;border:double 10px #003B34;">
<?php 
header("Content-type: text/html; charset=utf-8");
//参加済か否か
$attend = array_key_exists($_SESSION['screen_name'],$ary)||$ary[4][0]==$_SESSION['screen_name'];
//もうゲームが始まってるのに参加者ではない
if(!$attend and $ary[3]>0){
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: observe.php");
}
//不正アクセスにより部屋が存在していない
if(!file_exists($id.".dat")){
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: ../index.php");
}
//管理者か否か
if($_SESSION['screen_name']==$ary[4][0]){
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
';}elseif($ary[3]<2){
	echo '<br>あなたは参加しています<br><br>
	<form action="" method="post">
	    <input type="submit" name="exit" value="参加停止" />
    </form>
';}else{
	echo '<br>あなたは参加しています。性癖シャッフル後なので参加停止は出来ません。<br><br>
';}
//参加しました
if(isset($_POST['join'])&&$ary[3]<2) {
   $ary[$_SESSION['screen_name']] = array($_SESSION['screen_name'],"","","");
   $current_kakikomi=array(get_normal($_SESSION['screen_name'])["name"]."さんが参加しました。",date('Y/m/d H:i:s'));
   array_push($ary[999]["chatroom"],$current_kakikomi); 
   file_put_contents($id.".dat", serialize($ary));
   header("HTTP/1.1 301 Moved Permanently");
   header("Location: ../room");
}
//脱退しました
if(isset($_POST['exit'])&&$ary[3]<2) {
   unset($ary[$_SESSION['screen_name']]);
   $current_kakikomi=array(get_normal($_SESSION['screen_name'])["name"]."さんが抜けました。",date('Y/m/d H:i:s'));
   array_push($ary[999]["chatroom"],$current_kakikomi); 
   file_put_contents($id.".dat",serialize($ary));
   header("HTTP/1.1 301 Moved Permanently");
   header("Location: ../room");
}
//参加者リスト
$ninzuu = count($ary)-5;
echo "<br><b>参加者一覧(".$ninzuu."人)</b><br>";
//まず主催がトップ
	$screen_name = $ary[4][0];
	echo '<a href = "https://twitter.com/'.$screen_name.'"  Target="_blank">';
	echo "<img src='".get_normal($screen_name)["profile_image_url"]."' />";
	print_r(get_normal($screen_name)["name"]) ;
	echo "(@".$screen_name.")</a
	>　※主催<br>";
	//フェーズ1,2なら性癖/作品進捗公開
	if($ary[3]==1){
		if(!empty($ary[4][1])&&!empty($ary[4][2])&&!empty($ary[4][3])){
			echo "性癖送信済み<br>";
		}
	}
	if($ary[3]==2){
		if(!empty($ary[4][4])){
			echo "作品送信済み<br>";
		}
		if(!empty($ary[4][5])){
			echo "作品送信済み<br>";
		}
	}
//人間削除フォーム開始
echo '<form action="" method="post" onsubmit="return submitChk()">';
//それ以外の人を記す
foreach($ary as $screen_name => $value) {
	if(gettype($screen_name)=="string"){
		echo '<a href = "https://twitter.com/'.$screen_name.'"  Target="_blank">';
		echo "<img src='".get_normal($screen_name)["profile_image_url"]."' />";
		print_r(get_normal($screen_name)["name"]) ;
		echo "(@".$screen_name.")</a><br>";
		//フェーズ1,2なら性癖/作品進捗公開
		if($ary[3]==1){
			if(!empty($ary[$screen_name][1])&&!empty($ary[$screen_name][2])&&!empty($ary[$screen_name][3])){
				echo "性癖送信済み<br>";
			}
		}
		if($ary[3]==2){
			if(!empty($ary[$screen_name][4])){
				echo "作品送信済み<br>";
			}
			if(!empty($ary[$screen_name][5])){
				echo "作品送信済み<br>";
			}
		}
		//もし主催なら削除権限を与える
		if($_SESSION['screen_name']==$ary[4][0]&&$ary[3]<2){
			echo '<div align="right"><input type="checkbox" name="member[]" value="'.$screen_name.'"></div>';
		}
    }
}
if($_SESSION['screen_name']==$ary[4][0]&&$ary[3]<2){
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
//フェーズ進めるフォーム
if($_SESSION['screen_name']==$ary[4][0]&&$ary[3]!=4){
	echo '
	　　<form action="" method="post" onsubmit="return ahead1()">
		<input type="submit" name="ahead" value="段階を進める"';
	if($ninzuu<3){echo 'disabled';}
	echo'>
		</form>
		<script>
		/**
		 * 確認ダイアログの返り値によりフォーム送信
		*/
		function ahead1(){
			/* 確認ダイアログ表示 */
			var flag = confirm ( "段階を進めてもよろしいですか？");
			/* send_flg が TRUEなら送信、FALSEなら送信しない */
			return flag;
		}
		</script>
	';
	if($ninzuu<3){echo '参加者は3人以上欲しいですね';}}
//フェーズ戻すフォーム
if($_SESSION['screen_name']==$ary[4][0]&&$ary[3]!=0){
	echo '
	　　<form action="" method="post" onsubmit="return behind1()">
		<input type="submit" name="behind" value="段階を戻す">
		</form>
		<script>
		/**
		 * 確認ダイアログの返り値によりフォーム送信
		*/
		function behind1(){
			/* 確認ダイアログ表示 */
			var flag = confirm ( "段階を戻してもよろしいですか？\n※この操作は推奨されません");
			/* send_flg が TRUEなら送信、FALSEなら送信しない */
			return flag;
		}
		</script>
	';
	if($ninzuu<3){echo '参加者は3人以上欲しいですね';}}
//ディレクトリ削除関数の定義
function remove_directory($dir) {
	if ($handle = opendir("$dir")) {
		while (false !== ($item = readdir($handle))) {
			if ($item != "." && $item != "..") {
				if (is_dir("$dir/$item")) {
					remove_directory("$dir/$item");
				} else {
					unlink("$dir/$item");
					echo " removing $dir/$item<br>\n";
				}
			}
		}
	closedir($handle);
	rmdir($dir);
	echo "removing $dir<br>\n";
	}
}
//部屋の削除
if(isset($_POST['delete'])){
	unlink ($id.".dat");
	$links = file_get_contents ("../links.txt" ,"r+");
    $current = str_replace ('<li><a href="room/index.php?id='.$id.'">'.$ary[0].'</a></li>',"",$links);
    file_put_contents("../links.txt", $current);
    if(file_exists($id)){
      remove_directory($id);
    }
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: ../");
	exit();
}
//人間の削除
if(isset($_POST['member'])){
	//選ばれた人を順番にexitしていく
	$bye_list = $_POST['member'];
	for ($i = 0 ; $i < count($bye_list); $i++){
	   unset($ary[$bye_list[$i]]);
	   $current_kakikomi=array(get_normal($bye_list[$i])["name"]."さんが追い出されました。",date('Y/m/d H:i:s'));
       array_push($ary[999]["chatroom"],$current_kakikomi); 
	}
	file_put_contents($id.".dat",serialize($ary));
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: ../room");
	exit();
}
//進行管理
require_once "phase.php";
if(isset($_POST['ahead'])){
	ahead();
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: ../room");
	exit();
}
if(isset($_POST['behind'])){
	behind();
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: ../room");
	exit();
}
echo '</div>';
//進行箱関連
require_once "probox.php";
if($ary[3]==4){echo '<font color="red">この部屋は終了しました</font>';}
?>
<center><br>
<a href="../">トップに戻る</a>
</center>
</div>
</body>
</html>