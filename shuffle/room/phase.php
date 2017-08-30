<?php
//フェーズを進める
function ahead(){
	global $ary;
	global $id;
	$phase = $ary[3];
	$phase += 1;
	$ary = array_replace($ary,array(3 => $phase));
	$file = fopen("$id.csv", "w");
	fputcsv($file, $ary);
	fclose($file);
}
?>