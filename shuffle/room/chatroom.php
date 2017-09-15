<html>
<head>
<meta charset="UTF-8">
<script type="text/javascript"> 
function koshin(){
  location.reload();
}

</script>
</head>
<body>
<?php
session_start();
require "get_n.php";
$id = $_GET['id'];
if(isset($_GET['nn'])){
$nn = $_GET['nn'];
}else{
$nn = 30;
}
$ary = unserialize(file_get_contents($id.".dat"));
if(!isset($ary[999]["chatroom"])){$ary[999]["chatroom"]=array();}
if($_SERVER['REQUEST_METHOD']==='POST'&&mb_strlen($_POST['chat'])>0&&$_POST['chat']!==$ary[999]["chatroom"][intval(count($ary[999]["chatroom"])-1)][1]){
	$current_kakikomi = array($_SESSION['screen_name'],$_POST['chat'],date('Y/m/d H:i:s'));
	array_push($ary[999]["chatroom"],$current_kakikomi); 
	file_put_contents($id.".dat", serialize($ary));
}
$attend = array_key_exists($_SESSION['screen_name'],$ary)||$ary[4][0]==$_SESSION['screen_name'];
if($attend or !$ary[3]>0){
	echo '
	<div style="width:90%;text-align:left;background-color: #EEFFFF;margin:auto;padding:20px;border:double 10px #003B34;">
	<b>チャット</b><br>表示件数 <a href="?id='.$id.'&nn=10">10件</a> <a href="?id='.$id.'&nn=30">30件</a> <a href="?id='.$id.'&nn=50">50件</a>
	<form action="" method="POST" autocomplete="on">
		<input type="text" style="font-size: 16;width:80%;" name="chat" >
		<input type="submit">
        <input type="button"  value="更新" onclick="koshin()">
	</form>
	';
}
for($i=count($ary[999]["chatroom"])-$nn;$i<count($ary[999]["chatroom"]);$i++){
	if(isset($ary[999]["chatroom"][$i][2])){
		echo '<div style="width:100%;border-top: 1px solid #888888;padding:3;">'.str_replace("&lt;br /&gt;", "", htmlspecialchars(get_normal($ary[999]["chatroom"][$i][0])["name"] ,ENT_QUOTES,"UTF-8")).'('.$ary[999]["chatroom"][$i][0].')：'.url_henkan(str_replace('&lt;br /&gt;', '', htmlspecialchars($ary[999]["chatroom"][$i][1] ,ENT_QUOTES,"UTF-8"))).'<br><font size="-2" color="#888888">'.$ary[999]["chatroom"][$i][2].'</font></div>';
	}elseif($i>=0){
		echo '<div style="width:100%;border-top: 1px solid #888888;padding:3;"><b>System：'.$ary[999]["chatroom"][$i][0].'</b><br><font size="-2" color="#888888">'.$ary[999]["chatroom"][$i][1].'</font></div>';
	}
}
function url_henkan($mojiretu){
	$mojiretu = htmlspecialchars($mojiretu,ENT_QUOTES);
	$mojiretu = nl2br($mojiretu);
	//文字列にURLが混じっている場合のみ下のスクリプト発動
		if(preg_match("/(http|https):\/\/[-\w\.]+(:\d+)?(\/[^\s]*)?/",$mojiretu)){
			preg_match_all("/(http|https):\/\/[-\w\.]+(:\d+)?(\/[^\s]*)?/",$mojiretu,$pattarn);
				foreach ($pattarn[0] as $key=>$val){
					$replace[] = '<a href="'.$val.'" target="_blank">'.$val.'</a>';
				}
		$mojiretu = str_replace($pattarn[0],$replace,$mojiretu);
		}
	return $mojiretu;
}
?>
</div>
</body>
</html>