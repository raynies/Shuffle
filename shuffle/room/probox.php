<center>
<?php
//フェーズが1以上なら箱を作る(開始)
if($ary[3] > 0){
	echo '<div style="width:90%;text-align:left;background-color: #AADDFF;margin:auto;padding:20px;border:double 10px #003B34;">';
}
//フェーズが1なら性癖受付
if($ary[3] == 1){
	if($_SESSION['screen_name']==$ary[4][0]){
		echo '
			性癖を入力して下さい。<br><br>
			<form action="" method="POST">
			性癖1：<br><input type="text" name="seiheki1" value='.$ary[4][1].'><br>
			性癖2：<br><input type="text" name="seiheki2" value='.$ary[4][2].'><br>
			性癖3：<br><input type="text" name="seiheki3" value='.$ary[4][3].'><br>
			<input type="submit">
			</form>
			';
		echo '
			性癖1：'.$ary[4][1].'<br>
			性癖2：'.$ary[4][2].'<br>
			性癖3：'.$ary[4][3].'<br>
		';
		if ($_SERVER['REQUEST_METHOD']==='POST'){
			$ary[4][1] = $_POST['seiheki1'];
			$ary[4][2] = $_POST['seiheki2'];
			$ary[4][3] = $_POST['seiheki3'];
			file_put_contents($id.".dat",serialize($ary));
			header("HTTP/1.1 301 Moved Permanently");
            header("Location: ../room");
		}
	}else{
		echo '
			性癖を入力して下さい。<br><br>
			<form action="" method="POST">
			性癖1：<br><input type="text" name="seiheki1" value='.$ary[$_SESSION['screen_name']][1].'><br>
			性癖2：<br><input type="text" name="seiheki2" value='.$ary[$_SESSION['screen_name']][2].'><br>
			性癖3：<br><input type="text" name="seiheki3" value='.$ary[$_SESSION['screen_name']][3].'><br>
			<input type="submit">
			</form>
			';
		echo '
		性癖1：'.$ary[$_SESSION['screen_name']][1].'<br>
		性癖2：'.$ary[$_SESSION['screen_name']][2].'<br>
		性癖3：'.$ary[$_SESSION['screen_name']][3].'<br>
		';
		if ($_SERVER['REQUEST_METHOD']==='POST'){
			$ary[$_SESSION['screen_name']][1] = $_POST['seiheki1'];
			$ary[$_SESSION['screen_name']][2] = $_POST['seiheki2'];
			$ary[$_SESSION['screen_name']][3] = $_POST['seiheki3'];
			file_put_contents($id.".dat",serialize($ary));
			header("HTTP/1.1 301 Moved Permanently");
            header("Location: ../room");
		}
	}
}
//フェーズが2になった瞬間性癖シャッフル
if($ary[3] == 2 && !isset($ary[999][0])){
	$shf = array();
	foreach($ary as $screen_name => $value) {
		if(gettype($screen_name)=="string"){
			$shf[] = $screen_name;
		}
	}
	$shf[] = $ary[4][0];
	shuffle($shf);
	$ary[999][0] = $shf;
	file_put_contents($id.".dat",serialize($ary));
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: ../room");
}
//フェーズが2なら性癖受け渡し
if($ary[3] == 2){
	$self_num = 0;
	for($i=0;$i<count($ary[999][0]);$i++){
		if($ary[999][0][$i]==$_SESSION['screen_name']){
			$self_num = $i;
		}
	}
	if($ary[999][0][($self_num+1)%count($ary[999][0])]==$ary[4][0]){
		echo 'あなたに割り振られた性癖<br>性癖1：'.$ary[4][1].'
		<br>性癖2：'.$ary[4][2].'
		<br>性癖3：'.$ary[4][3];
	}else{
		echo 'あなたに割り振られた性癖<br>性癖1：'.$ary[$ary[999][0][($self_num+1)%count($ary[999][0])]][1].'
		<br>性癖2：'.$ary[$ary[999][0][($self_num+1)%count($ary[999][0])]][2].'
		<br>性癖3：'.$ary[$ary[999][0][($self_num+1)%count($ary[999][0])]][3];
	}
	//性癖フォーム
	require_once "publish.php";
}
//フェーズが3なら作品公開
if($ary[3] == 3){
	echo "<b>作品一覧</b><br>";
	//まず主催がトップ
	$screen_name = $ary[4][0];
	echo '<hr><a href = "https://twitter.com/'.$screen_name.'"  Target="_blank">';
	echo "<img src='".get_normal($screen_name)["profile_image_url"]."' />";
	print_r(get_normal($screen_name)["name"]) ;
	echo "(@".$screen_name.")</a
	>";
	if($ary[2]=="word"){
		echo '
		<div id="'.$screen_name.'_1">
		<p><input type="button" value="表示する" style="WIDTH:150px"
		   onClick="document.getElementById(\''.$screen_name.'_2\').style.display=\'block\';
					document.getElementById(\''.$screen_name.'_1\').style.display=\'none\'"></p>
		</div>
		<div id="'.$screen_name.'_2" style="display:none">
		<p><input type="button" value="隠す" style="WIDTH:150px"
		   onClick="document.getElementById(\''.$screen_name.'_2\').style.display=\'none\';
					document.getElementById(\''.$screen_name.'_1\').style.display=\'block\'"></p>
		<div style="padding:8;background-color:#FFFFFF;border-style:groove;">
		'.$ary[4][4].'
		</div>
		</div>
		';
	}
	if($ary[2]=="paint"){
		list($width,$height) = getimagesize ($id."/".$ary[4][0].".".$ary[4][5]);
		$bairitu = 550/$width;
		echo '
		<div id="'.$screen_name.'_1">
		<p><input type="button" value="表示する" style="WIDTH:150px"
		   onClick="document.getElementById(\''.$screen_name.'_2\').style.display=\'block\';
					document.getElementById(\''.$screen_name.'_1\').style.display=\'none\'"></p>
		</div>
		<div id="'.$screen_name.'_2" style="display:none">
		<p><input type="button" value="隠す" style="WIDTH:150px"
		   onClick="document.getElementById(\''.$screen_name.'_2\').style.display=\'none\';
					document.getElementById(\''.$screen_name.'_1\').style.display=\'block\'"></p>
		<div style="padding:8;background-color:#FFFFFF;border-style:groove;">
		<img width="'.$width*$bairitu.'px" height="'.$height*$bairitu.'px" src="'.$id.'/'.$ary[4][0].'.'.$ary[4][5].'">
		</div>
		</div>
		';
	}
	//それ以外の人を記す
	foreach($ary as $screen_name => $value) {
		if(gettype($screen_name)=="string"){
			echo '<hr><a href = "https://twitter.com/'.$screen_name.'"  Target="_blank">';
			echo "<img src='".get_normal($screen_name)["profile_image_url"]."' />";
			print_r(get_normal($screen_name)["name"]) ;
			echo "(@".$screen_name.")</a>";
			if($ary[2]=="word"){
				echo '
				<div id="'.$screen_name.'_1">
				<p><input type="button" value="表示する" style="WIDTH:150px"
				   onClick="document.getElementById(\''.$screen_name.'_2\').style.display=\'block\';
							document.getElementById(\''.$screen_name.'_1\').style.display=\'none\'"></p>
				</div>
				<div id="'.$screen_name.'_2" style="display:none">
				<p><input type="button" value="隠す" style="WIDTH:150px"
				   onClick="document.getElementById(\''.$screen_name.'_2\').style.display=\'none\';
							document.getElementById(\''.$screen_name.'_1\').style.display=\'block\'"></p>
				<div style="padding:8;background-color:#FFFFFF;border-style:groove;">
				'.$ary[$screen_name][4].'
				</div>
				</div>
				';
			}
			if($ary[2]=="paint"){
				list($width,$height) = getimagesize ($id."/".$ary[$screen_name][0].".".$ary[$screen_name][5]);
				$bairitu = 550/$width;
				echo '
				<div id="'.$screen_name.'_1">
				<p><input type="button" value="表示する" style="WIDTH:150px"
				   onClick="document.getElementById(\''.$screen_name.'_2\').style.display=\'block\';
							document.getElementById(\''.$screen_name.'_1\').style.display=\'none\'"></p>
				</div>
				<div id="'.$screen_name.'_2" style="display:none">
				<p><input type="button" value="隠す" style="WIDTH:150px"
				   onClick="document.getElementById(\''.$screen_name.'_2\').style.display=\'none\';
							document.getElementById(\''.$screen_name.'_1\').style.display=\'block\'"></p>
				<div style="padding:8;background-color:#FFFFFF;border-style:groove;">
				<img width="'.$width*$bairitu.'px" height="'.$height*$bairitu.'px" src="'.$id.'/'.$ary[$screen_name][0].'.'.$ary[$screen_name][5].'">
				</div>
				</div>
				';
			}
		}
	}
}
//フェーズが4なら作品と性癖公開
if($ary[3] == 4){
	echo "<b>作品一覧</b><br>";
	//まず主催がトップ
	$screen_name = $ary[4][0];
	echo '<hr><a href = "https://twitter.com/'.$screen_name.'"  Target="_blank">';
	echo "<img src='".get_normal($screen_name)["profile_image_url"]."' />";
	print_r(get_normal($screen_name)["name"]) ;
	//性癖表示
	$self_num = 0;
	for($i=0;$i<count($ary[999][0]);$i++){
	if($ary[999][0][$i]==$screen_name){
		$self_num = $i;
		}
	}
	echo "(@".$screen_name.")</a
	>";
	if($ary[2]=="word"){
		echo '
		<div id="'.$screen_name.'_1">
		<p><input type="button" value="表示する" style="WIDTH:150px"
		   onClick="document.getElementById(\''.$screen_name.'_2\').style.display=\'block\';
					document.getElementById(\''.$screen_name.'_1\').style.display=\'none\'"></p>
		</div>
		<div id="'.$screen_name.'_2" style="display:none">
		<p><input type="button" value="隠す" style="WIDTH:150px"
		   onClick="document.getElementById(\''.$screen_name.'_2\').style.display=\'none\';
					document.getElementById(\''.$screen_name.'_1\').style.display=\'block\'"></p>
		<div style="padding:8;background-color:#FFFFFF;border-style:groove;">
		'.$ary[4][4].'
		</div>性癖1：'.$ary[$ary[999][0][($self_num+1)%count($ary[999][0])]][1].'
		<br>性癖2：'.$ary[$ary[999][0][($self_num+1)%count($ary[999][0])]][2].'
		<br>性癖3：'.$ary[$ary[999][0][($self_num+1)%count($ary[999][0])]][3].'
		<br>性癖主：'.get_normal($ary[$ary[999][0][($self_num+1)%count($ary[999][0])]][0])["name"].'('.$ary[$ary[999][0][($self_num+1)%count($ary[999][0])]][0].')</div>
		';
	}
	if($ary[2]=="paint"){
		list($width,$height) = getimagesize ($id."/".$ary[4][0].".".$ary[4][5]);
		$bairitu = 550/$width;
		echo '
		<div id="'.$screen_name.'_1">
		<p><input type="button" value="表示する" style="WIDTH:150px"
		   onClick="document.getElementById(\''.$screen_name.'_2\').style.display=\'block\';
					document.getElementById(\''.$screen_name.'_1\').style.display=\'none\'"></p>
		</div>
		<div id="'.$screen_name.'_2" style="display:none">
		<p><input type="button" value="隠す" style="WIDTH:150px"
		   onClick="document.getElementById(\''.$screen_name.'_2\').style.display=\'none\';
					document.getElementById(\''.$screen_name.'_1\').style.display=\'block\'"></p>
		<div style="padding:8;background-color:#FFFFFF;border-style:groove;">
		<img width="'.$width*$bairitu.'px" height="'.$height*$bairitu.'px" src="'.$id.'/'.$ary[4][0].'.'.$ary[4][5].'">
		</div>性癖1：'.$ary[$ary[999][0][($self_num+1)%count($ary[999][0])]][1].'
		<br>性癖2：'.$ary[$ary[999][0][($self_num+1)%count($ary[999][0])]][2].'
		<br>性癖3：'.$ary[$ary[999][0][($self_num+1)%count($ary[999][0])]][3].'
		<br>性癖主：'.get_normal($ary[$ary[999][0][($self_num+1)%count($ary[999][0])]][0])["name"].'('.$ary[$ary[999][0][($self_num+1)%count($ary[999][0])]][0].')</div>
		';
	}
	//それ以外の人を記す
	foreach($ary as $screen_name => $value) {
		if(gettype($screen_name)=="string"){
			echo '<hr><a href = "https://twitter.com/'.$screen_name.'"  Target="_blank">';
			echo "<img src='".get_normal($screen_name)["profile_image_url"]."' />";
			print_r(get_normal($screen_name)["name"]) ;
			//性癖表示
			$self_num = 0;
			for($i=0;$i<count($ary[999][0]);$i++){
			if($ary[999][0][$i]==$screen_name){
				$self_num = $i;
				}
			}
			if(isset($ary[$ary[999][0][($self_num+1)%count($ary[999][0])]][0])){
				$given_num = $ary[999][0][($self_num+1)%count($ary[999][0])];
			}else{
				$given_num = 4;
			}
			echo "(@".$screen_name.")</a>";
			if($ary[2]=="word"){
				echo '
				<div id="'.$screen_name.'_1">
				<p><input type="button" value="表示する" style="WIDTH:150px"
				   onClick="document.getElementById(\''.$screen_name.'_2\').style.display=\'block\';
							document.getElementById(\''.$screen_name.'_1\').style.display=\'none\'"></p>
				</div>
				<div id="'.$screen_name.'_2" style="display:none">
				<p><input type="button" value="隠す" style="WIDTH:150px"
				   onClick="document.getElementById(\''.$screen_name.'_2\').style.display=\'none\';
							document.getElementById(\''.$screen_name.'_1\').style.display=\'block\'"></p>
				<div style="padding:8;background-color:#FFFFFF;border-style:groove;">
				'.$ary[$screen_name][4].'
				</div>性癖1：'.$ary[$given_num][1].'
				<br>性癖2：'.$ary[$given_num][2].'
				<br>性癖3：'.$ary[$given_num][3].'
				<br>性癖主：'.get_normal($ary[999][0][($self_num+1)%count($ary[999][0])])["name"].'('.$ary[999][0][($self_num+1)%count($ary[999][0])].')</div>
				';
			}
			if($ary[2]=="paint"){
				list($width,$height) = getimagesize ($id."/".$ary[$screen_name][0].".".$ary[$screen_name][5]);
				$bairitu = 550/$width;
				echo '
				<div id="'.$screen_name.'_1">
				<p><input type="button" value="表示する" style="WIDTH:150px"
				   onClick="document.getElementById(\''.$screen_name.'_2\').style.display=\'block\';
							document.getElementById(\''.$screen_name.'_1\').style.display=\'none\'"></p>
				</div>
				<div id="'.$screen_name.'_2" style="display:none">
				<p><input type="button" value="隠す" style="WIDTH:150px"
				   onClick="document.getElementById(\''.$screen_name.'_2\').style.display=\'none\';
							document.getElementById(\''.$screen_name.'_1\').style.display=\'block\'"></p>
				<div style="padding:8;background-color:#FFFFFF;border-style:groove;">
				<img width="'.$width*$bairitu.'px" height="'.$height*$bairitu.'px" src="'.$id.'/'.$ary[$screen_name][0].'.'.$ary[$screen_name][5].'">
				</div>性癖1：'.$ary[$given_num][1].'
				<br>性癖2：'.$ary[$given_num][2].'
				<br>性癖3：'.$ary[$given_num][3].'
				<br>性癖主：'.get_normal($ary[999][0][($self_num+1)%count($ary[999][0])])["name"].'('.$ary[999][0][($self_num+1)%count($ary[999][0])].')</div>
				';
				
			}
		}
	}
}
//これは名前作るところに任せる
//フェーズが1以上なら箱を作る(開始)
if($ary[3] > 0){
	echo '</div>';
}
//フェーズが1以上なら箱を作る(終了)
//チャットルーム
echo '<br><div style="width:90%;text-align:left;background-color: #EEFFFF;margin:auto;padding:20px;border:double 10px #003B34;">';
echo '
<b>チャット</b>(30件表示)
<form action="" method="POST">
	<input type="text" style="font-size: 16;width:80%;" name="chat">
	<input type="submit">
</form>
';
require("chatroom.php");
echo '</div>';
?>
</center>