<?php 
mb_language("japanese");
mb_internal_encoding("utf-8");
  
if(!empty($_POST['naiyou'])){
    $name=$_POST['name'];
    $mail=$_POST['mail'];
    $sub=$_POST['sub'];
    $naiyou=$_POST['naiyou'];

$success=mb_send_mail($sub,"���O�F".$name."�@�{���F".$naiyou);
}
?>
  
  
<?php 
if($success){
    echo('���M���܂���');
}else{
    echo('���M���s�I�I');
}
?>