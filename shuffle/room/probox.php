<?php
//フェーズが1以上なら箱を作る(開始)
if($ary[3] > 0){
	echo '<div style="width:90%;text-align:left;background-color: #88AAFF;margin: 10 auto;padding:20px;">';
}
//フェーズが1なら性癖受付
if($ary[3] == 1){
	echo '
	性癖を入力して下さい。<br><br>
	<form action="" method="POST">
		性癖1：<br><input type="text" name="seiheki1" value="'.htmlspecialchars($title,ENT_QUOTES,"UTF-8").'"><br>
	<form action="" method="POST">
	性癖2：<br><input type="text" name="seiheki2" value="'.htmlspecialchars($title,ENT_QUOTES,"UTF-8").'"><br>
	<form action="" method="POST">
	性癖3：<br><input type="text" name="seiheki3" value="'.htmlspecialchars($title,ENT_QUOTES,"UTF-8").'"><br>
	<input type="submit">
	</form>
	';
}
//フェーズが1以上なら箱を作る(終了)
//フェーズが1以上なら箱を作る(開始)
if($ary[3] > 0){
	echo '</div>';
}
?>