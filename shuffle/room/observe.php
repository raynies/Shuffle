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
//不正アクセスにより部屋が存在していない
if(!file_exists($id.".dat")){
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: ../index.php");
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
    }
}
echo '</div>';
//進行箱関連
require_once "probox_o.php";
if($ary[3]==4){echo '<font color="red">この部屋は終了しました</font>';}
?>
<center><br>
<a href="../">トップに戻る</a>
</center>
</div>
</body>
</html>