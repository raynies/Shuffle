<?php
//フェーズを進める
function ahead(){
	global $ary;
	global $id;
	$phase = $ary[3];
	$phase += 1;
	$ary[3] = $phase;
	//進んだらチャットに書き込み
	$current_kakikomi = array("段階が".$ary[3]."から".intval($ary[3]+1)."に進みました。",date('Y/m/d H:i:s'));
	if($ary[3]==0){
		$current_kakikomi[0]=$current_kakikomi[0]."性癖を送って下さい。";
	}
	if($ary[3]==1){
		$current_kakikomi[0]=$current_kakikomi[0]."性癖を確認し、作品を投稿して下さい。";
	}
	if($ary[3]==2){
		$current_kakikomi[0]=$current_kakikomi[0]."投稿された作品を確認することができます。"; 	
	}
	if($ary[3]==3){
		$current_kakikomi[0]=$current_kakikomi[0]."これにてゲームは終了となります。お疲れ様でした。"; 	
	}
	array_push($ary[999]["chatroom"],$current_kakikomi); 
	file_put_contents($id.".dat",serialize($ary));
}
//フェーズを戻す
function behind(){
	global $ary;
	global $id;
	$phase = $ary[3];
	$phase -= 1;
	$ary[3] = $phase;
	//進んだらチャットに書き込み
	$current_kakikomi = array("段階が".intval($ary[3]+2)."から".intval($ary[3]+1)."に戻りました(推奨されない動作です)",date('Y/m/d H:i:s'));
	array_push($ary[999]["chatroom"],$current_kakikomi); 
	file_put_contents($id.".dat",serialize($ary));
}
?>