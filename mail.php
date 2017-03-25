<?php 
mb_language("japanese");
mb_internal_encoding("utf-8");
  
if(!empty($_POST['naiyou'])){
    $name=$_POST['name'];
    $mail=$_POST['mail'];
    $sub=$_POST['sub'];
    $naiyou=$_POST['naiyou'];

$success=mb_send_mail($sub,"名前：".$name."　本文：".$naiyou);
}
?>
  
  
<?php 
if($success){
    echo('送信しました');
}else{
    echo('送信失敗！！');
}
?>